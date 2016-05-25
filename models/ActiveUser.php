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
        $selectLikes = 'SELECT count(*) FROM `like` WHERE like.created_by=user.id';
        $selectComments = 'SELECT count(*) FROM `comment` WHERE comment.created_by=user.id';
        $selectPosts = 'SELECT count(*) FROM `content` WHERE content.created_by=user.id  AND content.object_model=\'humhub\\\modules\\\post\\\models\\\Post\'';


        $query = parent::find();
        $query->addSelect(['*',
            '(' . $selectLikes . ') as count_likes',
            '(' . $selectComments . ') as count_comments',
            '(' . $selectPosts . ') as count_posts',
        ]);
        $query->orderBy('(' . $selectLikes . ')+(' . $selectComments . ')+(' . $selectPosts . ') DESC');
        return $query;
    }

}
