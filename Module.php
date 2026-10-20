<?php

namespace humhub\modules\mostactiveusers;

use yii\helpers\Url;

class Module extends \humhub\components\Module
{
    public function getConfigUrl()
    {
        return Url::to(['/mostactiveusers/config/config']);
    }

    /**
     * Enables this module
     */
    public function enable()
    {
        parent::enable();

        if (!$this->settings->get('noUsers')) {
            $this->settings->set('noUsers', 5);
        }

        if (!$this->settings->get('hiddenGroups')) {
            $this->settings->setSerialized('hiddenGroups', []);
        }
    }

}
