<?php
/* @var $this TicketTypeController */
/* @var $model TicketType */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ticket_id'); ?>
		<?php echo $form->textField($model,'ticket_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ticket_title'); ?>
		<?php echo $form->textField($model,'ticket_title',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'article_id'); ?>
		<?php echo $form->textField($model,'article_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'needapply'); ?>
		<?php echo $form->textField($model,'needapply'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_use'); ?>
		<?php echo $form->textField($model,'is_use'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SN'); ?>
		<?php echo $form->textField($model,'SN',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SoldNumber'); ?>
		<?php echo $form->textField($model,'SoldNumber'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'IsSeriesTicket'); ?>
		<?php echo $form->textField($model,'IsSeriesTicket'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PriceStr'); ?>
		<?php echo $form->textField($model,'PriceStr',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->