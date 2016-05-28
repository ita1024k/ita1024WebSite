<?php
/* @var $this SignFormController */
/* @var $model SignFormType */

$this->breadcrumbs=array(
	'Sign Form Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SignFormType', 'url'=>array('index')),
	array('label'=>'Manage SignFormType', 'url'=>array('admin')),
);
?>

<h1>Create SignFormType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>