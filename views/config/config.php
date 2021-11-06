<?php

use humhub\modules\ui\form\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $model \humhub\modules\mostactiveusers\models\ConfigureForm
 */


?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('MostactiveusersModule.base', 'Most Active Users Module Configuration'); ?>
    </div>
    <div class="panel-body">
        <p>
            <?= Yii::t('MostactiveusersModule.base', 'You may configure the number users to be shown.'); ?>
        </p>
        <br/>

        <?php $form = ActiveForm::begin(); ?>

        <div class="form-group">
            <?= $form->field($model, 'noUsers')->textInput(); ?>
        </div>

        <hr>

        <?= Html::submitButton(Yii::t('MostactiveusersModule.base', 'Save'), ['class' => 'btn btn-primary']); ?>

        <a class="btn btn-default" href="<?= Url::to(['/admin/module']); ?>">
            <?= Yii::t('MostactiveusersModule.base', 'Back to modules'); ?>
        </a>

        <?php $form::end(); ?>
    </div>
</div>
