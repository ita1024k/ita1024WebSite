<?php
/* @var $this TicketTypeController */
/* @var $model TicketType */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ticket-type-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ticket_title'); ?>
		<?php echo $form->textField($model,'ticket_title',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'ticket_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'article_id'); ?>
		<?php echo $form->textField($model,'article_id'); ?>
		<?php echo $form->error($model,'article_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'needapply'); ?>
		<?php echo $form->textField($model,'needapply'); ?>
		<?php echo $form->error($model,'needapply'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_use'); ?>
		<?php echo $form->textField($model,'is_use'); ?>
		<?php echo $form->error($model,'is_use'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SN'); ?>
		<?php echo $form->textField($model,'SN',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'SN'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SoldNumber'); ?>
		<?php echo $form->textField($model,'SoldNumber'); ?>
		<?php echo $form->error($model,'SoldNumber'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'IsSeriesTicket'); ?>
		<?php echo $form->textField($model,'IsSeriesTicket'); ?>
		<?php echo $form->error($model,'IsSeriesTicket'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PriceStr'); ?>
		<?php echo $form->textField($model,'PriceStr',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'PriceStr'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->