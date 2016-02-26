<?php

namespace humhub\modules\mostactiveusers\models;

use Yii;

class ConfigureForm extends \yii\base\Model
{

    public $noUsers;

    public function rules()
    {
        return array(
            array('noUsers', 'required'),
            array('noUsers', 'integer', 'min' => 0, 'max' => 50),
        );
    }

    public function attributeLabels()
    {
        return array(
            'noUsers' => Yii::t('MostactiveusersModule.base', 'The number of most active users that will be shown.'),
        );
    }

}
