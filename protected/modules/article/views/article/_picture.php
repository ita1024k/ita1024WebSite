<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/dist/css/dropify.css" />
<div class="container_pic">
	<div class="row">
		<div class="col-sm-6">
			<?php
				echo CHtml::activeFileField($model,'picture',array("id"=>"input-file-now-custom","class"=>"dropify","data-height"=>"250"));
			?>
		</div>
	</div>
	<input type="hidden" name="hidPicture" value="<?php echo $model->picture?>">
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/dist/js/dropify.js"></script>
<script>
	$(document).ready(function(){
		// Basic
		$('.dropify').dropify();
		// Translated
		$('.dropify-fr').dropify({
			messages: {
                        'default': '点击或拖拽文件到这里',
			'replace': '点击或拖拽文件到这里来替换文件',
			'remove':  '移除文件',
			'error':   '对不起，你上传的文件太大了'
			}
		});
	});
	function saveEvent(){
		$("#event_base_form").submit();
	}
</script>