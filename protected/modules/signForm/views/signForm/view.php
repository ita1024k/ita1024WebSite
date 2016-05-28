<?php
/* @var $this SignFormController */
/* @var $model SignFormType */

$this->breadcrumbs=array(
	'Sign Form Types'=>array('index'),
	$model->form_id,
);

$this->menu=array(
	array('label'=>'List SignFormType', 'url'=>array('index')),
	array('label'=>'Create SignFormType', 'url'=>array('create')),
	array('label'=>'Update SignFormType', 'url'=>array('update', 'id'=>$model->form_id)),
	array('label'=>'Delete SignFormType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->form_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SignFormType', 'url'=>array('admin')),
);
?>

<h1>View SignFormType #<?php echo $model->form_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'form_id',
		'article_id',
		'form_type',
		'form_name',
		'other_data',
	),
)); ?>
