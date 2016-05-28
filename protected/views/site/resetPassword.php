<style>html {background:#ccc;}</style>
<div style="background:#ccc;">
<div id="forgetmains">
<div class="form reset-password-form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="note">重置密码</p>
    <p class="p-solid"></p>
	<?php echo $form->errorSummary($model); ?>
        <div class="controls form_valid_error_msg">
            <div class="alert alert_error" id="form_valid_error_msg" style="display: none;">请输入您的姓名</div>
        </div>
	<div id="resetpass">
	<div class="user-list-div1 pass user-style">
		<?php echo $form->labelEx($model,"新密码",array('class'=>'user-i')); ?>
		<div class="input-group">
		<?php echo $form->passwordField($model,'password',array('size'=>50,'maxlength'=>100,'class'=>'form-control'));?>
		<?php echo $form->error($model,'password'); ?>
		</div>
	</div>
	<div class="clear"></div>
	<div class="user-list-div1 check-pass user-style">
		<?php echo $form->labelEx($model,"重复密码：",array('class'=>'user-i')); ?>
		<div class="input-group">
		<?php echo $form->passwordField($model,'confirm_password',array('size'=>50,'maxlength'=>100,'class'=>'form-control'));?>
		<?php echo $form->error($model,'confirm_password'); ?>
		</div>
	</div>
	<div class="clear"></div>
		<p class="p-solid"></p>
		<div class="row user-buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? "保存" : "保存",array('class'=>'btn btn-primary user-btn')); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
</div>
</div>
<?php
if($state)
{
    $reset_name = "密码重置成功！";
    echo "<script>";
    echo "$(function(){
        $('#resetpass').html('');
        $('#resetpass').html('$reset_name');
        $('#resetpass').addClass('style');
        Load('login');         
        })
		var secs = 3; //倒计时的秒数
		var URL ;
		var times;
		function Load(url){
		URL = url;
		for(var i=secs;i>=0;i--)
		{
		   if(i==4)
		   {times=10}
		   if(i==3)
		   {times=30}
		   if(i==2)
		   {times=60}
		   if(i==1)
		   {times=100}
		   window.setTimeout('doUpdate(' + times + ')', (secs-i) * 2000);
		} 
		}
		function doUpdate(num)
		{ 
			if(num == 100) { window.location = URL; }
		}
	";
	echo "</script>";
} 
else
{
	echo "<script>";
	echo " $('#resetpass').removeClass('style');";
	echo "</script>";
}

?>
<script>
$(function(){
   $(".user-buttons").click(function(){
            //alert(123123);
            var pass = $("#User_password").val();
            var pass2 = $("#User_confirm_password").val();
            var pattern=/[0-9|A-Z|a-z]{6,16}/;
            if(pass=="")
            {
                //$(".pass .errorMessage").html("密码不能为空");
                $('#form_valid_error_msg').fadeIn().text('密码不能为空');
                $('#contact_phone').focus().css('border-color','#2d6ac8');
                return false;
            }
            else if(!pattern.test(pass))
            {
                //$(".pass .errorMessage").html("密码格式错误");
                $('#form_valid_error_msg').fadeIn().text('密码格式错误');
                $('#contact_phone').focus().css('border-color','#2d6ac8');
                return false;
             }
            else
            {
                //$(".pass .errorMessage").html("");
                $('#form_valid_error_msg').fadeIn().text('');
                $('#contact_phone').focus().css('border-color','');
	   }
	   
            if(pass !== pass2)
            {
                 //$(".check-pass .errorMessage").html("两次密码不同");
                 $('#form_valid_error_msg').fadeIn().text('两次密码不同');
                $('#contact_phone').focus().css('border-color','#2d6ac8');
                 return false;
            }
            else if(!pattern.test(pass2))
            {
                //$(".check-pass .errorMessage").html("密码格式错误");
                $('#form_valid_error_msg').fadeIn().text('密码格式错误');
                $('#contact_phone').focus().css('border-color','#2d6ac8');
                return false;
            }
            else
            {
                $('#form_valid_error_msg').fadeIn().text('');
                $('#contact_phone').focus().css('border-color','');
                //$(".check-pass .errorMessage").html(" ");
            }
            
  });
})

</script>