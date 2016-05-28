<?php
/* @var $this AdvertiseController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Advertises',
);

$this->menu=array(
	array('label'=>'Create Advertise', 'url'=>array('create')),
	array('label'=>'Manage Advertise', 'url'=>array('admin')),
);
?>

<h1>Advertises</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
