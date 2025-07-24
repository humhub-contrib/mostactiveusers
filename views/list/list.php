<?php

use humhub\modules\mostactiveusers\models\ActiveUser;
use humhub\modules\user\widgets\Image;
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

<?php Modal::endDialog() ?>
