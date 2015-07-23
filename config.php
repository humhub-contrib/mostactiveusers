<?php

use humhub\modules\dashboard\widgets\Sidebar;

return [
    'id' => 'mostactiveusers',
    'class' => 'humhub\modules\mostactiveusers\Module',
    'namespace' => 'humhub\modules\mostactiveusers',
    'events' => [
        ['class' => Sidebar::className(), 'event' => Sidebar::EVENT_INIT, 'callback' => ['humhub\modules\mostactiveusers\Module', 'onSidebarInit']],
    ],
];
?>
