<?php
/* @var $this SignFormController */
/* @var $model SignFormType */

$this->breadcrumbs=array(
	'Sign Form Types'=>array('index'),
	$model->form_id=>array('view','id'=>$model->form_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SignFormType', 'url'=>array('index')),
	array('label'=>'Create SignFormType', 'url'=>array('create')),
	array('label'=>'View SignFormType', 'url'=>array('view', 'id'=>$model->form_id)),
	array('label'=>'Manage SignFormType', 'url'=>array('admin')),
);
?>

<h1>Update SignFormType <?php echo $model->form_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>