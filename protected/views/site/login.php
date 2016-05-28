<div class="login_blue">
	<a><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/login_logo.png" alt="logo" class="logo"></a>
</div>
<div class="login_box">
	<div class="left form_box">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'login_form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                ),
            )); ?>
            <?php echo $form->errorSummary($model); ?>
			<div class="form_group">
				<label for="txtName"></label>
                                <?php echo $form->textField($model,'username',array("id"=>"txtName","class"=>"form_control","placeholder"=>"请输入已验证邮箱")); ?>
			</div>
			<div class="form_group">
				<label for="txtPwd"></label>
                                <?php echo $form->passwordField($model,'password',array("id"=>"txtPwd","class"=>"form_control","placeholder"=>"请输入密码")); ?>
			</div>
			<a href="http://www.ita1024.com/site/forgetEmail" class="blue">忘记密码</a>
			<button id='login_btn' class='btn_primary' type='submit'>登录</button>
            <?php $this->endWidget(); ?>
	</div>
	<div class="login_line left"></div>
	<div class="right apply_way">
		<span class='tit'>ita权限申请</span>
		<p class="des">
			邮件内容需包括：活动介绍文档 、
			申请企业、申请人、手机、申请邮箱。
		</p>
		<p class="con_mail">申请接收邮箱：</br><em class='blue'>openday@ita1024.com</em></p>
	</div>
</div>
