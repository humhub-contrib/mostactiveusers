<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\mostactiveusers\models;

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

    public static function find()
    {
        $query = parent::find();
        $query->addSelect(['*',
            '(SELECT count(*) FROM `like` WHERE like.created_by=user.id) as count_likes',
            '(SELECT count(*) FROM `comment` WHERE comment.created_by=user.id) as count_comments',
            '(SELECT count(*) FROM `content` WHERE content.user_id=user.id  AND content.object_model=\'humhub\\\modules\\\post\\\models\\\Post\') as count_posts',
        ]);
        return $query;
    }

}
