<?php

use humhub\modules\dashboard\widgets\Sidebar;
use humhub\modules\comment\models\Comment;
use humhub\modules\content\models\Content;
use humhub\modules\like\models\Like;
use yii\db\ActiveRecord;

return [
    'id' => 'mostactiveusers',
    'class' => 'humhub\modules\mostactiveusers\Module',
    'namespace' => 'humhub\modules\mostactiveusers',
    'events' => [
        ['class' => Sidebar::className(), 'event' => Sidebar::EVENT_INIT, 'callback' => ['humhub\modules\mostactiveusers\Module', 'onSidebarInit']],
        ['class' => Content::class, 'event' => ActiveRecord::EVENT_AFTER_INSERT, 'callback' => ['humhub\modules\mostactiveusers\Module', 'onActivityChanged']],
        ['class' => Content::class, 'event' => ActiveRecord::EVENT_AFTER_DELETE, 'callback' => ['humhub\modules\mostactiveusers\Module', 'onActivityChanged']],
        ['class' => Comment::class, 'event' => ActiveRecord::EVENT_AFTER_INSERT, 'callback' => ['humhub\modules\mostactiveusers\Module', 'onActivityChanged']],
        ['class' => Comment::class, 'event' => ActiveRecord::EVENT_AFTER_DELETE, 'callback' => ['humhub\modules\mostactiveusers\Module', 'onActivityChanged']],
        ['class' => Like::class, 'event' => ActiveRecord::EVENT_AFTER_INSERT, 'callback' => ['humhub\modules\mostactiveusers\Module', 'onActivityChanged']],
        ['class' => Like::class, 'event' => ActiveRecord::EVENT_AFTER_DELETE, 'callback' => ['humhub\modules\mostactiveusers\Module', 'onActivityChanged']],
    ],
];
