<?php
/* @var $this TicketTypeController */
/* @var $model TicketType */

$this->breadcrumbs=array(
	'Ticket Types'=>array('index'),
	$model->ticket_id=>array('view','id'=>$model->ticket_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TicketType', 'url'=>array('index')),
	array('label'=>'Create TicketType', 'url'=>array('create')),
	array('label'=>'View TicketType', 'url'=>array('view', 'id'=>$model->ticket_id)),
	array('label'=>'Manage TicketType', 'url'=>array('admin')),
);
?>

<h1>Update TicketType <?php echo $model->ticket_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>