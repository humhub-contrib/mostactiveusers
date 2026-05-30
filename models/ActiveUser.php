<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\mostactiveusers\models;

use humhub\modules\user\models\GroupUser;
use Yii;
use yii\caching\TagDependency;

/**
 * Description of StatUser
 *
 * @author luke
 */
class ActiveUser extends \humhub\modules\user\models\User
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
        ];

        return Yii::$app->cache->getOrSet($cacheKey, static fn() => static::find()->limit($limit)->all(), 0, new TagDependency(['tags' => self::class]));
    }

    public static function find()
    {
        $selectLikes = 'SELECT count(*) FROM `like` WHERE like.created_by=user.id';
        $selectComments = 'SELECT count(*) FROM `comment` WHERE comment.created_by=user.id';
        $selectPosts = 'SELECT count(*) FROM `content` WHERE content.created_by=user.id  AND content.object_model=\'humhub\\\modules\\\post\\\models\\\Post\'';
        $selectTotal = '(' . $selectLikes . ')+(' . $selectComments . ')+(' . $selectPosts . ')';


        $query = parent::find();
        $query->andWhere(['user.status' => parent::STATUS_ENABLED]);
        $query->addSelect(['user.*',
            '(' . $selectLikes . ') as count_likes',
            '(' . $selectComments . ') as count_comments',
            '(' . $selectPosts . ') as count_posts',
            $selectTotal . ' as count_total',
        ]);

        $hiddenGroupIds = static::getHiddenGroupIds();
        if (!empty($hiddenGroupIds)) {
            $query->andWhere(['NOT IN', 'user.id', GroupUser::find()
                ->select('user_id')
                ->where(['group_id' => $hiddenGroupIds])]);
        }

        $query->orderBy([$selectTotal => SORT_DESC]);

        return $query;
    }

    private static function getHiddenGroupIds(): array
    {
        $hiddenGroupIds = Yii::$app->getModule('mostactiveusers')->settings->getSerialized('hiddenGroups', []);

        return is_array($hiddenGroupIds) ? array_filter(array_map('intval', $hiddenGroupIds)) : [];
    }

}
