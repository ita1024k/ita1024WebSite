<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/creat_ac.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/dist/js/bootstrap-select_all.min.js"></script>
<?php $this->renderPartial('_form', array('model'=>$model,'id'=>$id,'ar_province'=>$ar_province,'tag_arrs'=>$tag_arrs)); ?>