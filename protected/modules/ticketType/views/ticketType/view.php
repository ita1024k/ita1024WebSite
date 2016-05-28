<?php
/* @var $this TicketTypeController */
/* @var $model TicketType */

$this->breadcrumbs=array(
	'Ticket Types'=>array('index'),
	$model->ticket_id,
);

$this->menu=array(
	array('label'=>'List TicketType', 'url'=>array('index')),
	array('label'=>'Create TicketType', 'url'=>array('create')),
	array('label'=>'Update TicketType', 'url'=>array('update', 'id'=>$model->ticket_id)),
	array('label'=>'Delete TicketType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ticket_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TicketType', 'url'=>array('admin')),
);
?>

<h1>View TicketType #<?php echo $model->ticket_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ticket_id',
		'ticket_title',
		'article_id',
		'user_id',
		'quantity',
		'price',
		'status',
		'description',
		'needapply',
		'is_use',
		'SN',
		'SoldNumber',
		'IsSeriesTicket',
		'PriceStr',
	),
)); ?>
