<?php

class MostActiveUsersModule extends HWebModule
{

    private $assetsUrl;

    public function getAssetsUrl()
    {
        if ($this->assetsUrl === null)
            $this->assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('mostactiveusers.assets'));
        return $this->assetsUrl;
    }

    public function init()
    {}

    /**
     * On build of the dashboard sidebar widget, add the mostactiveusers widget if module is enabled.
     *
     * @param type $event            
     */
    public static function onSidebarInit($event)
    {
        if (Yii::app()->moduleManager->isEnabled('mostactiveusers')) {
            
            $event->sender->addWidget('application.modules.mostactiveusers.widgets.MostActiveUsersSidebarWidget', array(), array(
                'sortOrder' => 0
            ));
        }
    }

    public function getConfigUrl()
    {
        return Yii::app()->createUrl('//mostactiveusers/config/config');
    }

    /**
     * Enables this module
     */
    public function enable()
    {
        if (! $this->isEnabled()) {
            // set default config values
            HSetting::Set('noUsers', 5, 'mostactiveusers');
        }
        parent::enable();
    }
}
?>
