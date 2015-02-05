<?php

/**
 * Most Active Users Controller defines actions for statistics of users activity.
 *
 * @package humhub.modules.mostactiveusers.controllers
 * @author Marjana Pesic
 */
class MostActiveUsersController extends Controller
{

    /**
     *
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl'
        ); // perform access control for CRUD operations
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     *
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'expression' => 'Yii::app()->user->isAdmin()'
            ),
            array(
                'deny', // deny all users
                'users' => array(
                    '*'
                )
            )
        );
    }

    /**
     * Shows list of most active users with statistic.
     */
    public function actionList()
    {
        
        // query that selects ordered profile information, posts count, comments count and likes count
        $query = "SELECT profile.*, coalesce (post.cnt, 0) as posts,  coalesce(comment.cnt, 0) as comments,
				coalesce(l.cnt, 0) as likes
				FROM profile
				LEFT JOIN (SELECT created_by, count(*) as cnt FROM post GROUP BY created_by) post
				ON post.created_by = profile.user_id
				LEFT JOIN (SELECT created_by, count(*) as cnt FROM comment GROUP BY created_by) comment
				ON comment.created_by = profile.user_id
				LEFT JOIN (SELECT created_by, count(*) as cnt FROM `like` GROUP BY created_by) l
				ON l.created_by = profile.user_id
				ORDER BY post.cnt DESC, comment.cnt DESC, l.cnt DESC";
        
        $users = Yii::app()->db->createCommand($query)->queryAll();
        $dataProvider = new CArrayDataProvider($users, array(
            'id' => 'user_id',
            'pagination' => array(
                'pageSize' => 5
            )
        ));
        
        $users = $dataProvider->getData();
        $pages = $dataProvider->getPagination();
        
        $output = $this->renderPartial('list', array(
            'pages' => $pages,
            'users' => $users
        ));
        echo $output;
        Yii::app()->end();
    }
}

?>
