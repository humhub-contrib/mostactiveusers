<?php

namespace humhub\modules\mostactiveusers\controllers;

/**
 * Most Active Users Controller defines actions for statistics of users activity.
 *
 * @package humhub.modules.mostactiveusers.controllers
 * @author Marjana Pesic
 */
class ListController extends \humhub\components\Controller
{

    public $pageSize = 10;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \humhub\components\behaviors\AccessControl::className(),
                'guestAllowedActions' => ['list']
            ]
        ];
    }

    /**
     * Shows list of most active users with statistic.
     */
    public function actionList()
    {
        $query = \humhub\modules\mostactiveusers\models\ActiveUser::find();

        $countQuery = clone $query;
        $pagination = new \yii\data\Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $this->pageSize]);
        $query->offset($pagination->offset)->limit($pagination->limit);

        return $this->renderAjax('list', [
                    'users' => $query->all(),
                    'pagination' => $pagination
        ]);
    }

}

?>
