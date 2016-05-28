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
                    <div class="form_group record_name clearfix">
                            <label for="record_name" class="name_label record_label">填写标题<em class='icon need_icon'></em></label>
                            <?php echo $form->textField($model,'event_title',array("id"=>"record_name","class"=>'form_control',"placeholder"=>'请在这里输入标题',"maxlength"=>'100',"required"=>'required')); ?>
                    </div>
                    <div class="form_group record_author clearfix">
                            <label for="record_author" class="author_label record_label">文章作者<em class='icon need_icon'></em></label>
                            <?php echo $form->textField($model,'event_author',array("id"=>"record_author","class"=>'form_control',"placeholder"=>'请在这里输入作者',"maxlength"=>'100',"required"=>'required')); ?>
                    </div>
                    <!--文本编辑器部分开始-->
                    <div class='form_group clearfix'>
                            <label for="" class='details_label record_label'>详细内容<em class='icon need_icon'></em></label>
                            <div class='form_control editor_box'>
                                    <!--此处放置文本编辑器,此处我下载的utf-8版本，如果需修改，请重新下载-->
                                    <?php echo $form->textarea($model,'contdata',array("id"=>"EventBaseDescription","placeholder"=>"请填写活动内容","style"=>"height:400px;width:1040px;z-index；1","required"=>'required'));?>
                            </div>
                    </div>
                    <div class="form_group clearfix">
                            <label for="" class='record_label'>上传封面</label>
                            <div id="record_poster" class='record_poster clearfix'>
                                    <div class="left poster_preview" id='poster_preview'>
                                            <img src="<?php if($model->logo) echo Yii::app()->request->baseUrl.'/'.$model->logo; else echo Yii::app()->request->baseUrl."/images/upLoad_img.jpg";  ?>" alt="" id="logo_image" class="logo_image" alt='海报' />
                                    </div>
                                    <div class="left media_body">
                                            <div class="tips">一张漂亮的封面，能让你的文章锦上添花，带来更多用户报名 
及增加传播效果</div>
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
					<input type="hidden" name="Event[status]" id="Event_status" value="<?php echo $model->status; ?>">
		<?php $this->endWidget(); ?>
	</div>
	<div class="submit_btn">
		<button class="btn btn_primary" id='creat_submit_btn'><i class="icon icon_success"></i>发布</button>
		<!--<a class="btn btn_default" href='details.html' target="_blank">预览</a>-->
		<a class="btn btn_default" id='creat_submit_btn_1'>保存草稿</a>
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
<!--以下script为编辑器相关js，如需修改请自行修改-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/utf8-php/ueditor.config.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/utf8-php/ueditor.all.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/utf8-php/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
	var descEditor;
	var onSaveEventTagPageSuccess;
	descEditor = new UE.ui.Editor();
	descEditor.render("EventBaseDescription");
	var hasDescChanged = false;
	var canedit = true;
	var autoSaveFlag = true;
	function setContent(isAppendTo) {
		UE.getEditor('EventBaseDescription').setContent('欢迎使用ueditor', isAppendTo);
	}
	//UE.getEditor('EventBaseDescription').ready(function() {
		//UE.getEditor('EventBaseDescription').setContent('');
	//});
	//想要改变编辑器内字体，请在config.js中设置  ,initialStyle:'
	//上传
</script>
