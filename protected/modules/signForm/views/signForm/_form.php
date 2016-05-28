<?php
/* @var $this SignFormController */
/* @var $model SignFormType */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sign-form-type-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'article_id'); ?>
		<?php echo $form->textField($model,'article_id'); ?>
		<?php echo $form->error($model,'article_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'form_type'); ?>
		<?php echo $form->textField($model,'form_type'); ?>
		<?php echo $form->error($model,'form_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'form_name'); ?>
		<?php echo $form->textField($model,'form_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'form_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'other_data'); ?>
		<?php echo $form->textArea($model,'other_data',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'other_data'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->