<?php

namespace humhub\modules\mostactiveusers;

use humhub\modules\mostactiveusers\models\ActiveUser;
use Yii;
use yii\db\AfterSaveEvent;

class Events
{
    /**
     * On build of the dashboard sidebar widget, add the mostactiveusers widget if module is enabled.
     *
     * @param \yii\base\Event $event
     */
    public static function onSidebarInit($event)
    {
        if (Yii::$app->hasModule('mostactiveusers')) {
            $event->sender->addWidget(widgets\Sidebar::class, [], [
                'sortOrder' => 400,
            ]);
        }
    }

    /**
     * Invalidates the cached ranking when a record that affects it is added or deleted
     * (Content, Comment, Like, GroupUser or User).
     */
    public static function onActiveRecordAddedDeleted(): void
    {
        ActiveUser::invalidateCache();
    }

    /**
     * Invalidates the cached ranking when a Content or User record is updated
     * and its `status`, `visibility` or `state` attribute was changed.
     */
    public static function onActiveRecordUpdated(AfterSaveEvent $event): void
    {
        if (array_intersect(array_keys($event->changedAttributes), ['status', 'visibility', 'state'])) {
            ActiveUser::invalidateCache();
        }
    }

}
