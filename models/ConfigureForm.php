<?php

namespace humhub\modules\mostactiveusers\models;

use Yii;

class ConfigureForm extends \yii\base\Model
{
    public $noUsers;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->noUsers = Yii::$app->getModule('mostactiveusers')->settings->get('noUsers');
    }

    public function rules()
    {
        return [
            ['noUsers', 'required'],
            ['noUsers', 'integer', 'min' => 0, 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'noUsers' => Yii::t('MostactiveusersModule.base', 'The number of most active users that will be shown.'),
        ];
    }

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        Yii::$app->getModule('mostactiveusers')->settings->set('noUsers', $this->noUsers);

        return true;
    }

}
