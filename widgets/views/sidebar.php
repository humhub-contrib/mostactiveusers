<?php

use humhub\modules\mostactiveusers\assets\Assets;
use humhub\modules\mostactiveusers\models\ActiveUser;
use humhub\widgets\modal\ModalButton;
use humhub\widgets\PanelMenu;
use yii\helpers\Html;

/**
 * @var $users ActiveUser[]
 */

Assets::register($this);
?>
<div class="panel panel-default" id="mostactiveusers-panel">

    <!-- Display panel menu widget -->
    <?php PanelMenu::widget(['id' => 'mostactiveusers-panel']); ?>

    <div class="panel-heading">
        <?php echo Yii::t('MostactiveusersModule.base', '<strong>Most</strong> active people'); ?>
    </div>
    <div class="panel-body">
        <?php foreach ($users as $user) : ?>

            <a href="<?php echo $user->getUrl(); ?>">
                <img src="<?php echo $user->getProfileImage()->getUrl(); ?>" class="rounded tt img_margin"
                     height="40"
                     width="40" alt="40x40" data-src="holder.js/40x40" style="width: 40px; height: 40px;"
                     data-bs-toggle="tooltip"
                     data-placement="top" title=""
                     data-bs-title="<?php echo Html::encode($user->displayName); ?>">
            </a>

        <?php endforeach; ?>

        <div>
            <br>
            <?= ModalButton::info(Yii::t('MostactiveusersModule.base', 'Get a list'))
                ->load(['/mostactiveusers/list/list']) ?>
        </div>
    </div>
</div>
