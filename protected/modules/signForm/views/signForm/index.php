<?php
/* @var $this SignFormController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sign Form Types',
);

$this->menu=array(
	array('label'=>'Create SignFormType', 'url'=>array('create')),
	array('label'=>'Manage SignFormType', 'url'=>array('admin')),
);
?>

<h1>Sign Form Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
