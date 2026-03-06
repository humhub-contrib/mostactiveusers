<?php

use humhub\modules\mostactiveusers\models\ActiveUser;
use humhub\modules\admin\permissions\ManageUsers;
use humhub\modules\user\widgets\Image;
use humhub\widgets\AjaxLinkPager;
use humhub\widgets\bootstrap\Button;
use humhub\widgets\modal\Modal;
use humhub\widgets\modal\ModalButton;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $users ActiveUser[]
 * @var $pagination Pagination
 */
?>

<?php Modal::beginDialog([
    'id' => 'mostactiveusers-modal',
    'title' => Yii::t('MostactiveusersModule.base', '<strong>Most</strong> active people'),
    'footer' => ModalButton::cancel(Yii::t('base', 'Close')),
]) ?>

    <?php if (Yii::$app->user->can(ManageUsers::class)) : ?>
        <?php $buttons = [
            Button::none(Yii::t('MostactiveusersModule.base', 'Export as {type}', ['type' => 'csv']))
                ->link(Url::to(['/mostactiveusers/list/export', 'format' => 'csv']))
                ->icon('file-code-o'),
            Button::none(Yii::t('MostactiveusersModule.base', 'Export as {type}', ['type' => 'xlsx']))
                ->link(Url::to(['/mostactiveusers/list/export', 'format' => 'xlsx']))
                ->icon('file-excel-o'),
        ]; ?>
        <div class="btn-group dropdown float-end mb-3">
            <?= Button::accent()->icon('download')->sm()
                    ->link($buttons[0]->getHref())
                    ->pjax(false)->loader(false) ?>
            <?= Button::accent('')->sm()
                    ->cssClass('dropdown-toggle')
                    ->options(['data-bs-toggle' => 'dropdown'])
                    ->loader(false) ?>
            <ul class="dropdown-menu">
                <?php foreach ($buttons as $button) : ?>
                    <li><?= $button->pjax(false)->sm()->cssClass('dropdown-item') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="clearfix"></div>
    <?php endif; ?>

    <div class="row hh-list">
        <?php
        $i = 0;
        foreach ($users as $user) :
        ?>
            <div>
                <a href="<?php echo $user->getUrl(); ?>">
                    <div class="d-flex align-items-center">
                        <span
                            class="fs-2 badge rounded-pill text-bg-secondary"
                            style="width: 40px; height: 40px; font-size: 20px !important; padding-top: 10px;">
                            <?= $pagination->page * $pagination->pageSize + (++$i) ?>
                        </span>

                        <?= Image::widget([
                            'user' => $user,
                            'width' => 50,
                            'imageOptions' => ['class' => 'mx-3'],
                        ]) ?>

                        <div class="flex-grow-1">
                            <h4 class="mb-0">
                                <strong><?= Html::encode($user->displayName) ?></strong>
                            </h4>
                            <div class="mostactiveusers">
                                <div class="entry float-start me-4">
                                    <span class="count text-info"><?= $user['count_posts'] ?>
                                    </span> <br> <span
                                        class="title"><?= Yii::t('MostactiveusersModule.base', 'Posts created') ?>
                                    </span>
                                </div>
                                <div class="entry float-start me-4">
                                    <span class="count text-info"><?= $user['count_comments'] ?>
                                    </span> <br> <span
                                        class="title"><?= Yii::t('MostactiveusersModule.base', 'Comments created') ?>
                                    </span>
                                </div>
                                <div class="entry float-start">
                                    <span class="count text-info"><?= $user['count_likes'] ?>
                                    </span> <br> <span
                                        class="title"><?= Yii::t('MostactiveusersModule.base', 'Likes given') ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="pagination-container">
        <?= AjaxLinkPager::widget(['pagination' => $pagination]) ?>
    </div>

<?php Modal::endDialog() ?>
