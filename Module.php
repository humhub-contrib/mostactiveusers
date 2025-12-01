<?php

namespace humhub\modules\mostactiveusers;

use Yii;
use yii\helpers\Url;

class Module extends \humhub\components\Module
{
    /**
     * On build of the dashboard sidebar widget, add the mostactiveusers widget if module is enabled.
     *
     * @param type $event
     */
    public static function onSidebarInit($event)
    {
        if (Yii::$app->hasModule('mostactiveusers')) {

            $event->sender->addWidget(widgets\Sidebar::class, [], [
                'sortOrder' => 400,
            ]);
        }
    }

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
    }

}
