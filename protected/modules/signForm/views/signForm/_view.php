<?php
/* @var $this SignFormController */
/* @var $data SignFormType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('form_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->form_id), array('view', 'id'=>$data->form_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_id')); ?>:</b>
	<?php echo CHtml::encode($data->article_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('form_type')); ?>:</b>
	<?php echo CHtml::encode($data->form_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('form_name')); ?>:</b>
	<?php echo CHtml::encode($data->form_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('other_data')); ?>:</b>
	<?php echo CHtml::encode($data->other_data); ?>
	<br />


</div>