
<div class="panel panel-default">
    <div class="panel-heading"><?php echo Yii::t('MostActiveUsersModule.base', 'Most Active Users Module Configuration'); ?></div>
    <div class="panel-body">


        <p><?php echo Yii::t('MostActiveUsersModule.base', 'You may configure the number users to be shown.'); ?></p>
        <br/>

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'most-active-users-configure-form',
            'enableAjaxValidation' => false,
        ));
        ?>

        <?php echo $form->errorSummary($model); ?>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'noUsers'); ?>
            <?php echo $form->numberField($model, 'noUsers', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'noUsers'); ?>
        </div>

        <hr>
        <?php echo CHtml::submitButton(Yii::t('MostActiveUsersModule.base', 'Save'), array('class' => 'btn btn-primary')); ?>
        <a class="btn btn-default" href="<?php echo $this->createUrl('//admin/module'); ?>"><?php echo Yii::t('MostActiveUsersModule.base', 'Back to modules'); ?></a>

        <?php $this->endWidget(); ?>
    </div>
</div>