<?php

use yii\helpers\Html;

use humhub\modules\mostactiveusers\models\ActiveUser;
use humhub\modules\user\widgets\Image;
use humhub\widgets\modal\ModalButton;
use humhub\widgets\PanelMenu;

/**
 * @var $users ActiveUser[]
 */

humhub\modules\mostactiveusers\assets\Assets::register($this);
?>
<div class="panel panel-default" id="mostactiveusers-panel">

    <!-- Display panel menu widget -->
    <?php PanelMenu::widget(['id' => 'mostactiveusers-panel']); ?>

    <div class="panel-heading">
        <?php echo Yii::t('MostactiveusersModule.base', '<strong>Most</strong> active people'); ?>
    </div>
    <div class="panel-body">
        <?php foreach ($users as $user) : ?>

            <?= Image::widget([
                'user' => $user,
                'width' => 40,
                'showTooltip' => true,
                'showSelfOnlineStatus' => true,
            ]) ?>

        <?php endforeach; ?>

        <div>
            <br>
            <?= ModalButton::light(Yii::t('MostactiveusersModule.base', 'Get a list'))
                ->load(['/mostactiveusers/list/list']) ?>
        </div>
    </div>
</div>
