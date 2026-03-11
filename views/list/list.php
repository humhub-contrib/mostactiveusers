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
            $rank = $pagination->page * $pagination->pageSize + (++$i);
            $fontSize = $rank <= 3 ? 18 : 14;
            $paddingTop = $rank <= 3 ? 11 : 13;
            ?>
            <div>
                <a href="<?php echo $user->getUrl(); ?>">
                    <div class="d-flex">
                        <span
                            class="fs-2 badge rounded-pill text-bg-light"
                            style="width: 40px; height: 40px; font-size: <?= $fontSize ?>px !important; padding-top: <?= $paddingTop ?>px;">
                            <?= $rank ?>
                        </span>

                        <div class="mx-3">
                            <?= Image::widget([
                                'user' => $user,
                                'width' => 40,
                            ]) ?>
                        </div>

                        <div class="d-flex flex-column justify-content-between">
                            <h4 class="mb-0">
                                <strong><?= Html::encode($user->displayName) ?></strong>
                            </h4>
                            <div class="mostactiveusers d-flex justify-content-between gap-3">
                                <div class="entry">
                                    <span class="title"><?= Yii::t('MostactiveusersModule.base', 'Posts:') ?></span>
                                    <span class="count text-info fw-bold"><?= $user['count_posts'] ?></span>
                                </div>
                                <div class="entry">
                                    <span class="title"><?= Yii::t('MostactiveusersModule.base', 'Comments:') ?></span>
                                    <span class="count text-info fw-bold"><?= $user['count_comments'] ?></span>
                                </div>
                                <div class="entry">
                                    <span class="title"><?= Yii::t('MostactiveusersModule.base', 'Likes:') ?></span>
                                    <span class="count text-info fw-bold"><?= $user['count_likes'] ?></span>
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
