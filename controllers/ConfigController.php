<?php

/**
 * Defines the configure actions.
 *
 * @package humhub.modules.mostactiveusers.controllers
 * @author Marjana Pesic
 */
class ConfigController extends Controller
{

    public $subLayout = "application.modules_core.admin.views._layout";

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
     * Configuration Action for Super Admins
     */
    public function actionConfig()
    {
        Yii::import('mostactiveusers.forms.*');
        
        $form = new MostActiveUsersConfigureForm();
        
        if (isset($_POST['MostActiveUsersConfigureForm'])) {
            $_POST['MostActiveUsersConfigureForm'] = Yii::app()->input->stripClean($_POST['MostActiveUsersConfigureForm']);
            $form->attributes = $_POST['MostActiveUsersConfigureForm'];
            
            if ($form->validate()) {
                $form->noUsers = HSetting::Set('noUsers', $form->noUsers, 'mostactiveusers');
                $this->redirect(Yii::app()->createUrl('mostactiveusers/config/config'));
            }
        } else {
            $form->noUsers = HSetting::Get('noUsers', 'mostactiveusers');
        }
        
        $this->render('config', array(
            'model' => $form
        ));
    }
}

?>
