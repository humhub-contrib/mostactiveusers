<?php

class MostActiveUsersSidebarWidget extends HWidget
{

    public function run()
    {
        $assetPrefix = Yii::app()->assetManager->publish(dirname(__FILE__) . '/../resources', true, 0, defined('YII_DEBUG'));
        Yii::app()->clientScript->registerCssFile($assetPrefix . '/mostactiveusers.css');
        
        $noUsers = HSetting::Get('noUsers', 'mostactiveusers');
        $noUsers = $noUsers == '' || $noUsers == null ? 0 : $noUsers;
        $users = $this->getMostActiveUsers($noUsers);
        if (! empty($users)) {
            $this->render('mostActiveUsersPanel', array(
                'users' => $users
            ));
        }
    }

    /**
     * Select $range number of most active users.
     * Select profile information ordered by number of posts,comments and likes
     *
     * @return array of User objects
     */
    private function getMostActiveUsers($range = 5)
    {
        $users = array();

        $criteria1 = new CDbCriteria();
        $criteria1->select = "created_by, count(*) cnt";
        $criteria1->group = 'created_by';
        
        // building subqueries
        $post = Post::model();
        $postSql = $post->getCommandBuilder()
            ->createFindCommand($post->getTableSchema(), $criteria1)
            ->getText();
        
        $comment = Comment::model();
        $commentSql = $comment->getCommandBuilder()
            ->createFindCommand($comment->getTableSchema(), $criteria1)
            ->getText();
        
        $like = Like::model();
        $likeSql = $like->getCommandBuilder()
            ->createFindCommand($like->getTableSchema(), $criteria1)
            ->getText();
        
        //query
        $criteria = new CDbCriteria();
        $criteria->join = "LEFT JOIN (" . $postSql . ") post ON post.created_by = t.id 
    		LEFT JOIN (" . $commentSql . ") comment ON comment.created_by = t.id
    		LEFT JOIN (" . $likeSql . ") l ON l.created_by = t.id";
        $criteria->order = 'post.cnt DESC, comment.cnt DESC, l.cnt DESC';
        $criteria->limit = $range;
        
        $users = User::model()->findAll($criteria);
        
        return $users;
    }
}
?>
