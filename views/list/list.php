<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="modal-dialog modal-dialog-normal animated fadeIn">
    <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"
                    aria-hidden="true">&times;</button>
            <h4 class="modal-title">
                <?php
                echo Yii::t('MostactiveusersModule.views_mostActiveUsers_list', '<strong>Most</strong> active people');
                ?>
            </h4>
        </div>
        <br>

        <ul class="media-list">
            <?php
            $i = 0;
            foreach ($users as $user) {
                ?>
                <li>
                    <a href="<?php echo $user->getUrl(); ?>">
                        <div class="media">
                            <span class="pull-left circle"><?php
                                echo $pagination->page * $pagination->pageSize + ( ++$i);
                                ?>
                            </span>

                            <img
                                src="<?php echo $user->getProfileImage()->getUrl(); ?>"
                                class="img-rounded tt img_margin pull-left" height="50" width="50"
                                alt="50x50" style="width: 50px; height: 50px;"
                                data-src="holder.js/50x50">


                            <div class="media-body">
                                <h4 class="media-heading">
                                    <strong><?php echo Html::encode($user->displayName); ?></strong>
                                </h4>
                                <div class="mostactiveusers">
                                    <div class="entry pull-left">
                                        <span class="count colorInfo"><?php echo $user['count_posts']; ?>
                                        </span> <br> <span
                                            class="title"><?php echo Yii::t('MostactiveusersModule.views_mostActiveUsers_list', 'Posts created'); ?>
                                        </span>
                                    </div>
                                    <div class="entry pull-left">
                                        <span class="count colorInfo"><?php echo $user['count_comments']; ?>
                                        </span> <br> <span
                                            class="title"><?php echo Yii::t('MostactiveusersModule.views_mostActiveUsers_list', 'Comments created'); ?>
                                        </span>
                                    </div>
                                    <div class="entry pull-left">
                                        <span class="count colorInfo"><?php echo $user['count_likes']; ?>
                                        </span> <br> <span
                                            class="title"><?php echo Yii::t('MostactiveusersModule.views_mostActiveUsers_list', 'Likes given'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>


        <div class="modal-footer" style="padding: 5px">
            <div class="pagination-container">
                <?= \humhub\widgets\AjaxLinkPager::widget(['pagination' => $pagination]); ?>
            </div>
        </div>

    </div>
</div>
