<?php

namespace humhub\modules\mostactiveusers\controllers;

use Yii;
use humhub\modules\mostactiveusers\models\ConfigureForm;
use humhub\models\Setting;

/**
 * Defines the configure actions.
 *
 * @package humhub.modules.mostactiveusers.controllers
 * @author Marjana Pesic
 */
class ConfigController extends \humhub\modules\admin\components\Controller
{

    /**
     * Configuration Action for Super Admins
     */
    public function actionConfig()
    {
        $form = new ConfigureForm();
        $form->noUsers = Setting::Get('noUsers', 'mostactiveusers');
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->noUsers = Setting::Set('noUsers', $form->noUsers, 'mostactiveusers');
            return $this->redirect(['/mostactiveusers/config/config']);
        }

        return $this->render('config', array(
                    'model' => $form
        ));
    }

}

?>
