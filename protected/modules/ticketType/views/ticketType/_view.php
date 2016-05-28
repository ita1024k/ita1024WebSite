<?php
/* @var $this TicketTypeController */
/* @var $data TicketType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ticket_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ticket_id), array('view', 'id'=>$data->ticket_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ticket_title')); ?>:</b>
	<?php echo CHtml::encode($data->ticket_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_id')); ?>:</b>
	<?php echo CHtml::encode($data->article_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('needapply')); ?>:</b>
	<?php echo CHtml::encode($data->needapply); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_use')); ?>:</b>
	<?php echo CHtml::encode($data->is_use); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SN')); ?>:</b>
	<?php echo CHtml::encode($data->SN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SoldNumber')); ?>:</b>
	<?php echo CHtml::encode($data->SoldNumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('IsSeriesTicket')); ?>:</b>
	<?php echo CHtml::encode($data->IsSeriesTicket); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PriceStr')); ?>:</b>
	<?php echo CHtml::encode($data->PriceStr); ?>
	<br />

	*/ ?>

</div>