<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/creat_ac.css" />
<div class="container">
    <div class="creat_body">
        <div class="creat_label">填写基本信息</div>
		<?php 
		$form=$this->beginWidget('CActiveForm', array(
				'id' => 'ac_base_form',
				'enableAjaxValidation' => false,
				'enableClientValidation' => true,
				'clientOptions' => array('validateOnSubmit' => true),
				'htmlOptions'=>array('enctype'=>'multipart/form-data','class'=>'ac_creat_form', 'novalidate'=>'novalidate'),
		));
			?>
			<!--隐私设置-->
			<div class="form_group">
				<label for="ac_privacy" class="control_label ac_label ac_privacy_label">首页显示</label>
				<div class="ac_radio ac_privacy_radio">
					<label><?php echo $form->checkBox($model,'is_position',array("class"=>'radio_icon icon')); ?>设为首页Banner活动</label>
				</div>
			</div>
			<div class="form_group clearfix">
				<label for="" class='record_label'>上传Banner</label>
				<div id="record_poster" class='record_poster clearfix'>
						<div class="left poster_preview" id='poster_preview'>
						<img src="<?php if($model->homepic) echo Yii::app()->request->baseUrl.'/'.$model->homepic; else echo Yii::app()->request->baseUrl."/images/upLoad_img.jpg";  ?>" alt="" id="logo_image" class="logo_image" alt='海报' />
						</div>
						<div class="left media_body">
								<div class="tips">一张漂亮的封面，能让你的文章锦上添花，带来更多用户报名 
	及增加传播效果</div>
								<div id='poster_error_msg' class='alert alert_error'></div>
								<div class="btn_upload">
										<i class="icon upload_icon"></i>
										<span>上传</span>
										<?php
											echo CHtml::activeFileField($model,'homepic',array("id"=>"poster_input",'accept'=>""));
										?>
										<input type="hidden" name="hidHomepic" value="<?php echo $model->homepic; ?>">
								</div>
						</div>
				</div>
				<input type="hidden" name="Article[woqu]" value="123123123">
			</div>
		<?php $this->endWidget(); ?>
		<div class="submit_btn">
			<button class="btn btn_primary" id='creat_submit_btn_ac'><i class="icon icon_success"></i>保存图片</button>
		</div>
	</div>
</div>
<script type="text/javascript" src='<?php echo Yii::app()->request->baseUrl; ?>/js/creat.js'></script>