<?php

namespace humhub\modules\mostactiveusers\models;

use humhub\modules\user\models\Group;
use Yii;
use yii\helpers\ArrayHelper;

class ConfigureForm extends \yii\base\Model
{
    public $noUsers;
    public $hiddenGroups = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->noUsers = Yii::$app->getModule('mostactiveusers')->settings->get('noUsers');
        $hiddenGroups = Yii::$app->getModule('mostactiveusers')->settings->getSerialized('hiddenGroups', []);
        $this->hiddenGroups = is_array($hiddenGroups) ? $hiddenGroups : [];
    }

    public function rules()
    {
        return [
            ['noUsers', 'required'],
            ['noUsers', 'integer', 'min' => 0, 'max' => 50],
            ['hiddenGroups', 'default', 'value' => []],
            ['hiddenGroups', 'each', 'rule' => ['integer']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'noUsers' => Yii::t('MostactiveusersModule.base', 'The number of most active users that will be shown.'),
            'hiddenGroups' => Yii::t('MostactiveusersModule.base', 'Hide users from these groups'),
        ];
    }

    public function getGroupOptions(): array
    {
        return ArrayHelper::map(Group::find()->select(['id', 'name'])->orderBy('name')->all(), 'id', 'name');
    }

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        Yii::$app->getModule('mostactiveusers')->settings->set('noUsers', $this->noUsers);
        Yii::$app->getModule('mostactiveusers')->settings->setSerialized('hiddenGroups', is_array($this->hiddenGroups) ? $this->hiddenGroups : []);
        ActiveUser::invalidateCache();

        return true;
    }

}
