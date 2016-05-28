<?php
/* @var $this TicketTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ticket Types',
);

$this->menu=array(
	array('label'=>'Create TicketType', 'url'=>array('create')),
	array('label'=>'Manage TicketType', 'url'=>array('admin')),
);
?>

<h1>Ticket Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
