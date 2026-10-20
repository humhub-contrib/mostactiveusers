<?php

use humhub\modules\comment\models\Comment;
use humhub\modules\content\models\Content;
use humhub\modules\dashboard\widgets\Sidebar;
use humhub\modules\like\models\Like;
use humhub\modules\mostactiveusers\Events;
use humhub\modules\mostactiveusers\Module;
use humhub\modules\user\models\GroupUser;
use humhub\modules\user\models\User;
use yii\db\ActiveRecord;

return [
    'id' => 'mostactiveusers',
    'class' => Module::class,
    'namespace' => 'humhub\modules\mostactiveusers',
    'events' => [
        ['class' => Sidebar::class, 'event' => Sidebar::EVENT_INIT, 'callback' => [Events::class, 'onSidebarInit']],
        ['class' => Content::class, 'event' => ActiveRecord::EVENT_AFTER_INSERT, 'callback' => [Events::class, 'onActiveRecordAddedDeleted']],
        ['class' => Content::class, 'event' => ActiveRecord::EVENT_AFTER_DELETE, 'callback' => [Events::class, 'onActiveRecordAddedDeleted']],
        ['class' => Content::class, 'event' => ActiveRecord::EVENT_AFTER_UPDATE, 'callback' => [Events::class, 'onActiveRecordUpdated']],
        ['class' => Comment::class, 'event' => ActiveRecord::EVENT_AFTER_INSERT, 'callback' => [Events::class, 'onActiveRecordAddedDeleted']],
        ['class' => Comment::class, 'event' => ActiveRecord::EVENT_AFTER_DELETE, 'callback' => [Events::class, 'onActiveRecordAddedDeleted']],
        ['class' => Like::class, 'event' => ActiveRecord::EVENT_AFTER_INSERT, 'callback' => [Events::class, 'onActiveRecordAddedDeleted']],
        ['class' => Like::class, 'event' => ActiveRecord::EVENT_AFTER_DELETE, 'callback' => [Events::class, 'onActiveRecordAddedDeleted']],
        ['class' => User::class, 'event' => ActiveRecord::EVENT_AFTER_UPDATE, 'callback' => [Events::class, 'onActiveRecordUpdated']],
        ['class' => User::class, 'event' => ActiveRecord::EVENT_AFTER_DELETE, 'callback' => [Events::class, 'onActiveRecordAddedDeleted']],
        ['class' => GroupUser::class, 'event' => ActiveRecord::EVENT_AFTER_INSERT, 'callback' => [Events::class, 'onActiveRecordAddedDeleted']],
        ['class' => GroupUser::class, 'event' => ActiveRecord::EVENT_AFTER_DELETE, 'callback' => [Events::class, 'onActiveRecordAddedDeleted']],
    ],
];
