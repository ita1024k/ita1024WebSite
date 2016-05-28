<?php
/* @var $this InformationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Informations',
);

$this->menu=array(
	array('label'=>'Create Information', 'url'=>array('create')),
	array('label'=>'Manage Information', 'url'=>array('admin')),
);
?>

<h1>Informations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
