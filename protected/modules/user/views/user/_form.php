<?php
/* @var $this EventController */
/* @var $model Event */
/* @var $form CActiveForm */
?>
<!--return false测试使用，用后删除-->
<div class="container clearfix">
        <?php
                if(!Yii::app()->user->isGuest){ 
                        $user_id = Yii::app()->user->id;
                        $sql = "SELECT logo,company FROM act_user WHERE user_id = $user_id";
                        $datas = Yii::app()->db->createCommand($sql)->queryAll();
                        if(empty($datas[0]['logo'])) $datas[0]['logo'] = 'images/com_logo.jpg';
                }
        ?>
        <h2 class="title"><img class="com_logo" alt='<?php echo $datas[0]['company']; ?>' width="32" height="32" src='<?php echo Yii::app()->request->baseUrl.'/'.$datas[0]['logo'];?>' /><?php echo $datas[0]['company']; ?></img></h2>
        <div class="crumbs">
            <a class='crumbs_nav_item' href='' target="_blank">权限管理</a><!--跳转到权限管理页面-->
            <span class='seperate_line'>|</span>
            <a class='crumbs_nav_item  blue'><em class='blue'>新建发布者</em></a>
        </div>
        <div class="content">
            <!--表单部分-->
            <div id="publisher_form">
		<?php 
			$form=$this->beginWidget('CActiveForm', array(
                            'id' => 'publisher_valid_form',
                            'enableAjaxValidation' => false,
                            'enableClientValidation' => true,
                            'clientOptions' => array('validateOnSubmit' => true),
                            'htmlOptions'=>array('enctype'=>'multipart/form-data','class'=>'record_creat_form','novalidate'=>'novalidate',),
			));
		?>
                <?php echo $form->errorSummary($model); ?>
                <div class="forms form_valid_error_msg"><div class="alert alert_error" id="form_valid_error_msg"></div></div>
                <div class="form_group">
                        <label class="form_label">账号名</label>
                        <?php echo $form->textField($model,'user_name',array("class"=>'form_input required',"required"=>'required')); ?>
                </div>
                <?php if($model->isNewRecord){ ?>
                <div class="form_group">
                        <label class="form_label">登录密码</label>
                        <?php echo $form->passwordField($model,'password',array("class"=>'form_input required',"required"=>'required')); ?>
                </div>
                <div class="form_group">
                        <label class="form_label">重复密码</label>
                        <?php echo $form->passwordField($model,'confirm_password',array("class"=>'form_input required',"required"=>'required')); ?>
                </div>
                <?php } ?>
                <div class="form_group">
                        <label class="form_label">联系邮箱</label>
                        <?php echo $form->textField($model,'email',array("class"=>'form_input required',"required"=>'required')); ?>
                </div>
                <div class="form_group">
                        <label class="form_label">联系电话</label>
                        <?php echo $form->textField($model,'phone',array("class"=>'form_input required',"required"=>'required')); ?>
                </div>
                <div class="form_group">
                        <label class="form_label">联系地址</label>
                        <?php echo $form->textField($model,'adrss',array("class"=>'form_input required',"required"=>'required')); ?>
                </div>
                <div class="form_group">
                        <label class="form_label">所在公司</label>
                        <?php echo $form->textField($model,'company',array("class"=>'form_input required',"required"=>'required')); ?>
                </div>
                <div class="form_group">
                        <label class="form_label">所在职位</label>
                        <?php echo $form->textField($model,'connect',array("class"=>'form_input required',"required"=>'required')); ?>
                </div>
                <div class="form_group">
                    <label class="form_label">用户头像</label>
                    <div class='avatar_upload'>
                            <img src="<?php if($model->logo) echo Yii::app()->request->baseUrl.'/'.$model->logo; else echo Yii::app()->request->baseUrl."/images/publish_upload.jpg";  ?>" alt="" id="publisher_avatar" class="publisher_avatar" alt='头像' />
                            <div class="upload_btn">
                                    上传
                                <?php
                                        echo CHtml::activeFileField($model,'logo',array("id"=>"avatar_input",'accept'=>"image/*"));
                                ?>
                                <input type="hidden" id='avatar_img_data' name="hidLogo" value="<?php echo $model->logo; ?>" />
                            </div>
                    </div>
                </div>
                <div class="form_actions" id="form_actions">
                        <button type="button" class="btn btn_primary"><i class="icon icon_success"></i>保存</button>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/user/user/index" class="btn btn_default">取消</a>
                </div>
		<?php $this->endWidget(); ?>
	</div>
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
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.1.min.js"></script>
<script  type="text/javascript" src='<?php echo Yii::app()->request->baseUrl; ?>/js/common.js'></script>
<script type="text/javascript" src='<?php echo Yii::app()->request->baseUrl; ?>/js/publisher.js'></script>
<!--以下script为编辑器相关js，如需修改请自行修改-->