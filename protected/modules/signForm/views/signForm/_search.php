<?php
/* @var $this SignFormController */
/* @var $model SignFormType */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'form_id'); ?>
		<?php echo $form->textField($model,'form_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_id'); ?>
		<?php echo $form->textField($model,'article_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'form_type'); ?>
		<?php echo $form->textField($model,'form_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'form_name'); ?>
		<?php echo $form->textField($model,'form_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'other_data'); ?>
		<?php echo $form->textArea($model,'other_data',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->