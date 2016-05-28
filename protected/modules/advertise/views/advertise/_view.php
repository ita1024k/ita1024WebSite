<?php
/* @var $this AdvertiseController */
/* @var $data Advertise */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('advertise_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->advertise_id), array('view', 'id'=>$data->advertise_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position_id')); ?>:</b>
	<?php echo CHtml::encode($data->position_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('advertise_name')); ?>:</b>
	<?php echo CHtml::encode($data->advertise_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('target_url')); ?>:</b>
	<?php echo CHtml::encode($data->target_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />


</div>