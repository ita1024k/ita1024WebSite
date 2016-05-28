<?php
/* @var $this EventController */
/* @var $model Event */
/* @var $form CActiveForm */
?>
<!--return false测试使用，用后删除-->
<div class="container">
	<div class="creat_body">
		<div class="creat_label">填写基本信息</div>
		<?php 
			$form=$this->beginWidget('CActiveForm', array(
                            'id' => 'record_base_form',
                            'enableAjaxValidation' => false,
                            'enableClientValidation' => true,
                            'clientOptions' => array('validateOnSubmit' => true),
                            'htmlOptions'=>array('enctype'=>'multipart/form-data','class'=>'record_creat_form','novalidate'=>'novalidate',),
			));
		?>
                <?php echo $form->errorSummary($model); ?>
                    <div class="form_group clearfix">
                            <label class="name_label record_label">广告名称<em class='icon need_icon'></em></label>
                            <?php echo $form->textField($model,'advertise_name',array("id"=>"record_name","class"=>'form_control',"placeholder"=>'请在这里输入标题',"maxlength"=>'100',"required"=>'required')); ?>
                    </div>
                    <div class="form_group clearfix">
                            <label class="name_label record_label">广告位ID<em class='icon need_icon'></em></label>
                            <?php echo $form->dropDownList($model, 'position_id', array(100011=>'文章右侧广告位',100012=>'首页Banner'),array('class'=>'ac_time form_control selectpicker','style'=>'margin-left: 15px; padding-left: 0px;')); ?>
                    </div>
                    <div class="form_group clearfix">
                            <label for="record_name" class="name_label record_label">跳转链接<em class='icon need_icon'></em></label>
                            <?php echo $form->textField($model,'target_url',array("id"=>"record_name","class"=>'form_control',"placeholder"=>'请在这里输入URL',"maxlength"=>'100',"required"=>'required')); ?>
                    </div>
                    <div class="form_group clearfix">
                            <label for="" class='record_label'>广告图片</label>
                            <div id="record_poster" class='record_poster clearfix'>
                                    <div class="left poster_preview" id='poster_preview'>
                                            <img src="<?php if($model->logo) echo Yii::app()->request->baseUrl.'/'.$model->logo; else echo Yii::app()->request->baseUrl."/images/upLoad_img.jpg";  ?>" alt="" id="logo_image" class="logo_image" alt='海报' />
                                    </div>
                                    <div class="left media_body">
                                            <div class="tips">一张漂亮的图片，能让你的广告锦上添花，带来更多用户及增加传播效果</div>
                                            <div id='poster_error_msg' class='alert alert_error'></div>
                                            <div class="btn_upload">
                                                    <i class="icon upload_icon"></i>
                                                    <span>上传</span>
                                                    <?php
                                                            echo CHtml::activeFileField($model,'logo',array("id"=>"poster_input",'accept'=>"image/*"));
                                                    ?>
                                                    <input type="hidden" name="hidLogo" value="<?php echo $model->logo; ?>">
                                            </div>
                                    </div>
                            </div>
                    </div>
		<?php $this->endWidget(); ?>
	</div>
	<div class="submit_btn">
		<button class="btn btn_primary" id='creat_submit_btn'><i class="icon icon_success"></i>发布</button>
	</div>
</div>
<!--弹窗错误提示，提交按钮时请用这个错误提示-->
<div class='popBox hide' id='popBox_warning'>
	<div class="popBox_content">
		<h4 class="popBox_title"><i class="icon warning_icon"></i><span id='pop_message_content'></span></h4>
	</div>
</div>
<!--发布成功提示-->
<div class="popBox hide" id="popBox_tips">
	<div class="shadeBox"></div>
	<div class="popBox_content">
		<a href="javascript:void(0)" class="close_btn icon">关闭</a>
		<h4 class="popBox_title"><i class="icon success_icon"></i><span id='tips_msg'></span></h4>
	</div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.0.min.js"></script>
<script  type="text/javascript" src='<?php echo Yii::app()->request->baseUrl; ?>/js/common.js'></script>
<script type="text/javascript" src='<?php echo Yii::app()->request->baseUrl; ?>/js/creat.js'></script>