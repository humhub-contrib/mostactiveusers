<?php

use humhub\modules\admin\models\forms\UserEditForm;
use humhub\modules\mostactiveusers\models\ConfigureForm;
use humhub\modules\ui\form\widgets\MultiSelect;
use humhub\widgets\bootstrap\Button;
use humhub\widgets\form\ActiveForm;

/* @var $model ConfigureForm */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('MostactiveusersModule.base', 'Most Active Users Module Configuration'); ?>
    </div>
    <div class="panel-body">
        <p>
            <?= Yii::t('MostactiveusersModule.base', 'You may configure the number of users to be shown and hide users from specific groups.'); ?>
        </p>
        <br/>

        <?php $form = ActiveForm::begin(); ?>

        <div class="mb-3">
            <?= $form->field($model, 'noUsers')->textInput(); ?>
        </div>
        <div class="mb-3">
            <?= $form->field($model, 'hiddenGroups')->widget(MultiSelect::class, [
                'items' => UserEditForm::getGroupItems(),
                'options' => ['data-tags' => 'false'],
            ]) ?>
        </div>

        <hr>

        <?= Button::save()->submit() ?>

        <?= Button::light(Yii::t('MostactiveusersModule.base', 'Back to modules'))
            ->link(['/admin/module']) ?>

        <?php $form::end(); ?>
    </div>
</div>
