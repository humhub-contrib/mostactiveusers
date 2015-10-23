<?php

use yii\helpers\Html;

humhub\modules\mostactiveusers\Assets::register($this);
?>
<div class="panel panel-default" id="mostactiveusers-panel">

    <!-- Display panel menu widget -->
    <?php humhub\widgets\PanelMenu::widget(array('id' => 'mostactiveusers-panel')); ?>

    <div class="panel-heading">
        <?php echo Yii::t('MostactiveusersModule.base', '<strong>Most</strong> active people'); ?>
    </div>
    <div class="panel-body">
        <?php
        // run through the array of users
        foreach ($users as $user) {
            ?>

            <a href="<?php echo $user->getUrl(); ?>"> 
                <img src="<?php echo $user->getProfileImage()->getUrl(); ?>"  class="img-rounded tt img_margin" height="40" 
                     width="40" alt="40x40" data-src="holder.js/40x40" style="width: 40px; height: 40px;" data-toggle="tooltip"
                     data-placement="top" title="" 
                     data-original-title="<?php echo Html::encode($user->displayName); ?>">
            </a>

            <?php
        }

        echo "<hr />";

        // Button Get a list of most active users
        echo Html::a(Yii::t('MostactiveusersModule.base', 'Get a list'), ['/mostactiveusers/list/list'], array(
            'class' => 'btn btn-info',
            'data-target' => '#globalModal'
        ));
        ?>
    </div>
</div>

