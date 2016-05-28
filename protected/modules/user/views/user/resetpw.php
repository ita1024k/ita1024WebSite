<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/publisher.css" />
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
                        <?php echo $form->textField($model,'user_name',array("class"=>'form_input required',"required"=>'required','disabled'=>'disabled')); ?>
                </div>
                <div class="form_group">
                        <label class="form_label">新密码</label>
                        <?php echo $form->passwordField($model,'password',array("class"=>'form_input required',"required"=>'required')); ?>
                </div>
                <div class="form_group">
                        <label class="form_label">重复密码</label>
                        <?php echo $form->passwordField($model,'confirm_password',array("class"=>'form_input required',"required"=>'required')); ?>
                </div>
                <div class="form_actions" id="form_actions">
                        <button type="button" class="btn btn_primary"><i class="icon icon_success"></i>保存</button>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/user/user/index" class="btn btn_default">取消</a>
                </div>
		<?php $this->endWidget(); ?>
	</div>
    </div>
</div>
<script>
$(function(){
    $('#form_actions').on('click','.btn_primary',function(){
        popBoxMiddle.clearWaring();
        var item = $('#publisher_valid_form').find('input.required');
        var item = $('#publisher_valid_form').find('input.required');
        var name = $('input[name="User[user_name]"]'),
        passWord = $('input[name="User[password]"]'),
        rePassWord = $('input[name="User[confirm_password]"]');
        if(passWord.val()==''){
                popBoxMiddle.showWaring('登录密码不能为空');
                setTimeout("popBoxMiddle.clearWaring()",2000);
                passWord.focus().css('border-color','#2d6ac8');
                return false;
        }
        if(passWord.val().length<6){
                popBoxMiddle.showWaring('登录密码不能少于6位数');
                setTimeout("popBoxMiddle.clearWaring()",2000);
                passWord.focus().css('border-color','#2d6ac8');
                return false;
        }
        if(rePassWord.val()==''){
                popBoxMiddle.showWaring('重复密码不能为空');
                setTimeout("popBoxMiddle.clearWaring()",2000);
                rePassWord.focus().css('border-color','#2d6ac8');
                return false;
        }
        if(passWord.val() != rePassWord.val()){
                popBoxMiddle.showWaring('两次输入密码不一致，请重新输入');
                setTimeout("popBoxMiddle.clearWaring()",2000);
                rePassWord.focus().css('border-color','#2d6ac8');
                return false;
        }
        $("#publisher_valid_form").submit();
    });
    //$('#publisher_valid_form')..submit();
})
</script>
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