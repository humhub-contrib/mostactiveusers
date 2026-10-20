<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\mostactiveusers\models;

use humhub\modules\admin\permissions\ManageUsers;
use humhub\modules\content\models\Content;
use humhub\modules\post\models\Post;
use humhub\modules\user\models\GroupUser;
use humhub\modules\user\models\User;
use Yii;
use yii\caching\TagDependency;
use yii\db\Expression;
use yii\db\Query;

/**
 * Description of ActiveUser
 *
 * @author luke
 */
class ActiveUser extends User
{
    public $count_posts;
    public $count_likes;
    public $count_comments;
    public $count_total;

    public static function invalidateCache(): void
    {
        TagDependency::invalidate(Yii::$app->cache, self::class);
    }

    public static function getMostActiveUsers(int $limit): array
    {
        $limit = max(0, $limit);
        $cacheKey = [
            __METHOD__,
            'limit' => $limit,
            'hiddenGroups' => static::getHiddenGroupIds(),
            'visibilities' => static::getAllowedVisibilities(),
        ];

        return Yii::$app->cache->getOrSet(
            $cacheKey,
            static fn() => static::find()->limit($limit)->all(),
            0,
            new TagDependency(['tags' => self::class]),
        );
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        $likes = static::getCountQuery('like');
        $comments = static::getCountQuery('comment');
        $posts = static::getCountQuery('content')->andWhere(['content.object_model' => Post::class]);

        $countLikes = 'IFNULL(ac_likes.n, 0)';
        $countComments = 'IFNULL(ac_comments.n, 0)';
        $countPosts = 'IFNULL(ac_posts.n, 0)';
        $countTotal = $countLikes . '+' . $countComments . '+' . $countPosts;

        $query = parent::find();
        $query->andWhere(['user.status' => parent::STATUS_ENABLED]);
        $query->andWhere(['IN', 'user.visibility', static::getAllowedVisibilities()]);
        $query->leftJoin(['ac_likes' => $likes], 'ac_likes.uid = user.id');
        $query->leftJoin(['ac_comments' => $comments], 'ac_comments.uid = user.id');
        $query->leftJoin(['ac_posts' => $posts], 'ac_posts.uid = user.id');
        $query->addSelect(['user.*',
            $countLikes . ' AS count_likes',
            $countComments . ' AS count_comments',
            $countPosts . ' AS count_posts',
            $countTotal . ' AS count_total',
        ]);

        // Skip users without any activity
        $query->andWhere(['OR', 'ac_likes.n IS NOT NULL', 'ac_comments.n IS NOT NULL', 'ac_posts.n IS NOT NULL']);

        $hiddenGroupIds = static::getHiddenGroupIds();
        if (!empty($hiddenGroupIds)) {
            $query->andWhere(['NOT IN', 'user.id', GroupUser::find()
                ->select('user_id')
                ->where(['group_id' => $hiddenGroupIds])]);
        }

        $query->orderBy([new Expression($countTotal . ' DESC'), 'user.id' => SORT_ASC]);

        return $query;
    }

    /**
     * Counts the activities of each user (grouped by the creator) on public and published content.
     * The `content` table itself is counted directly, other tables (e.g. `like`, `comment`) are joined by `content_id`.
     */
    private static function getCountQuery(string $table): Query
    {
        $query = (new Query())
            ->select(['uid' => $table . '.created_by', 'n' => 'COUNT(*)'])
            ->from($table)
            ->groupBy($table . '.created_by');

        if ($table !== 'content') {
            $query->innerJoin('content', 'content.id = ' . $table . '.content_id');
        }

        return $query->where([
            'content.state' => Content::STATE_PUBLISHED,
            'content.visibility' => Content::VISIBILITY_PUBLIC,
        ]);
    }

    /**
     * User visibilities the current viewer is allowed to see (same rules as {@see \humhub\modules\user\components\ActiveQueryUser::visible()})
     */
    private static function getAllowedVisibilities(): array
    {
        if (Yii::$app->user->isGuest) {
            return [User::VISIBILITY_ALL];
        }

        if (Yii::$app->user->can(ManageUsers::class)) {
            return [User::VISIBILITY_ALL, User::VISIBILITY_REGISTERED_ONLY, User::VISIBILITY_HIDDEN];
        }

        return [User::VISIBILITY_ALL, User::VISIBILITY_REGISTERED_ONLY];
    }

    private static function getHiddenGroupIds(): array
    {
        $hiddenGroupIds = Yii::$app->getModule('mostactiveusers')->settings->getSerialized('hiddenGroups', []);

        return is_array($hiddenGroupIds) ? array_filter(array_map('intval', $hiddenGroupIds)) : [];
    }

}
