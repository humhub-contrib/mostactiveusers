<?php

use humhub\compat\CActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?php echo Yii::t('MostactiveusersModule.base', 'Most Active Users Module Configuration'); ?></div>
    <div class="panel-body">


        <p><?php echo Yii::t('MostactiveusersModule.base', 'You may configure the number users to be shown.'); ?></p>
        <br/>

        <?php $form = CActiveForm::begin(); ?>

        <?php echo $form->errorSummary($model); ?>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'noUsers'); ?>
            <?php echo $form->textField($model, 'noUsers', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'noUsers'); ?>
        </div>

        <hr>
        <?php echo Html::submitButton(Yii::t('MostactiveusersModule.base', 'Save'), array('class' => 'btn btn-primary')); ?>
        <a class="btn btn-default" href="<?php echo Url::to(['/admin/module']); ?>"><?php echo Yii::t('MostactiveusersModule.base', 'Back to modules'); ?></a>

        <?php CActiveForm::end(); ?>
    </div>
</div>