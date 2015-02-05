<?php

Yii::app()->moduleManager->register(array(
    'id' => 'mostactiveusers',
    'class' => 'application.modules.mostactiveusers.MostActiveUsersModule',
    'import' => array(
        'application.modules.mostactiveusers.*',
    ),
    // Events to Catch 
    'events' => array(
        array('class' => 'DashboardSidebarWidget', 'event' => 'onInit', 'callback' => array('MostActiveUsersModule', 'onSidebarInit')),
    ),
));
?>
