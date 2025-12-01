<?php

namespace humhub\modules\mostactiveusers\controllers;

use humhub\modules\admin\components\Controller;
use humhub\modules\mostactiveusers\models\ConfigureForm;
use Yii;

/**
 * Defines the configure actions.
 *
 * @package humhub.modules.mostactiveusers.controllers
 * @author Marjana Pesic
 */
class ConfigController extends Controller
{
    /**
     * Configuration Action for Super Admins
     */
    public function actionConfig()
    {
        $form = new ConfigureForm();

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            $this->view->saved();
            return $this->redirect(['/mostactiveusers/config/config']);
        }

        return $this->render('config', [
            'model' => $form,
        ]);
    }

}
