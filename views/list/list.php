<?php

use humhub\modules\mostactiveusers\models\ActiveUser;
use humhub\modules\user\widgets\Image;
use humhub\widgets\AjaxLinkPager;
use humhub\widgets\modal\Modal;
use humhub\widgets\modal\ModalButton;
use yii\data\Pagination;
use yii\helpers\Html;

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
                    <div class="d-flex align-items-center">
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

                        <div>
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
