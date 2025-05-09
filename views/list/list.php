<?php

use humhub\modules\mostactiveusers\models\ActiveUser;
use humhub\widgets\AjaxLinkPager;
use humhub\widgets\modal\Modal;
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
    'footer' => Html::tag('div', AjaxLinkPager::widget(['pagination' => $pagination]), ['class' => 'pagination-container']),
]) ?>

    <div class="row hh-list">
        <?php
        $i = 0;
        foreach ($users as $user) :
        ?>
            <div>
                <a href="<?php echo $user->getUrl(); ?>">
                    <div class="d-flex">
                        <span class="circle">
                            <?= $pagination->page * $pagination->pageSize + (++$i) ?>
                        </span>

                        <img
                            src="<?= $user->getProfileImage()->getUrl() ?>"
                            class="rounded tt img_margin mx-3" height="50" width="50"
                            alt="50x50" style="width: 50px; height: 50px;"
                            data-src="holder.js/50x50">

                        <div class="flex-grow-1">
                            <h4 class="mt-0">
                                <strong><?= Html::encode($user->displayName) ?></strong>
                            </h4>
                            <div class="mostactiveusers">
                                <div class="entry float-start">
                                    <span class="count text-info"><?= $user['count_posts'] ?>
                                    </span> <br> <span
                                        class="title"><?= Yii::t('MostactiveusersModule.base', 'Posts created') ?>
                                    </span>
                                </div>
                                <div class="entry float-start">
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

<?php Modal::endDialog() ?>
