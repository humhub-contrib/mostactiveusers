<?php
class MostActiveUsersConfigureForm extends CFormModel {

    public $noUsers;

    public function rules() {
        return array(
            array('noUsers', 'required'),
        	array('noUsers', 'compare', 'compareValue'=>'0', 'operator'=>'>=', 'message'=> Yii::t('MostActiveUsersModule.base', 'The number of users must not be negative.')),
        	array('noUsers', 'compare', 'compareValue'=>'7', 'operator'=>'<=', 'message'=> Yii::t('MostActiveUsersModule.base', 'The number of users must not be greater than a 7.')),
        );
    }

    public function attributeLabels() {
        return array(
            'noUsers' => Yii::t('MostActiveUsersModule.base', 'The number of most actice users that will be shown.'),
        );
    }

}