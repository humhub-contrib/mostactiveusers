<?php

namespace humhub\modules\mostactiveusers\controllers;

use humhub\components\export\SpreadsheetExport;
use humhub\components\behaviors\AccessControl;
use humhub\modules\admin\permissions\ManageUsers;
use humhub\modules\mostactiveusers\models\ActiveUser;
use Yii;
use yii\data\Pagination;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\data\ActiveDataProvider;

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

    /**
     * Export most active users as csv/xlsx.
     */
    public function actionExport(string $format): Response
    {
        if (!Yii::$app->user->can(ManageUsers::class)) {
            throw new ForbiddenHttpException();
        }

        if (!in_array($format, ['csv', 'xlsx'])) {
            throw new BadRequestHttpException('Wrong format "' . $format . '"');
        }

        $exporter = new SpreadsheetExport([
            'dataProvider' => new ActiveDataProvider([
                'query' => ActiveUser::find()->joinWith('profile')->limit(1000),
                'pagination' => false,
            ]),
            'columns' => [
                'username',
                'email',
                'profile.firstname',
                'profile.lastname',
                [
                    'label' => Yii::t('MostactiveusersModule.base', 'Posts'),
                    'attribute' => 'count_posts',
                ],
                [
                    'label' => Yii::t('MostactiveusersModule.base', 'Comments'),
                    'attribute' => 'count_comments',
                ],
                [
                    'label' => Yii::t('MostactiveusersModule.base', 'Likes'),
                    'attribute' => 'count_likes',
                ],
                [
                    'label' => Yii::t('MostactiveusersModule.base', 'Total activity'),
                    'attribute' => 'count_total',
                ],
            ],
            'resultConfig' => [
                'fileBaseName' => 'most_active_users',
                'writerType' => $format,
            ],
        ]);

        return $exporter->export()->send();
    }

}
