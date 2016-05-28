<?php
/* @var $this AdvertiseController */
/* @var $model Advertise */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'advertise_id'); ?>
		<?php echo $form->textField($model,'advertise_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'position_id'); ?>
		<?php echo $form->textField($model,'position_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'advertise_name'); ?>
		<?php echo $form->textField($model,'advertise_name',array('size'=>60,'maxlength'=>80)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'target_url'); ?>
		<?php echo $form->textField($model,'target_url',array('size'=>60,'maxlength'=>90)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->