<?php

namespace humhub\modules\mostactiveusers\controllers;

use humhub\components\behaviors\AccessControl;
use humhub\modules\mostactiveusers\models\ActiveUser;
use yii\data\Pagination;

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
                'class' => AccessControl::class,
                'guestAllowedActions' => ['list'],
            ],
        ];
    }

    /**
     * Shows list of most active users with statistic.
     */
    public function actionList()
    {
        $query = ActiveUser::find();

        $countQuery = clone $query;
        $pagination = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $this->pageSize]);
        $query->offset($pagination->offset)->limit($pagination->limit);

        return $this->renderAjax('list', [
            'users' => $query->all(),
            'pagination' => $pagination,
        ]);
    }

}
