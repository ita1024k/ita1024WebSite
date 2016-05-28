<style>html {background:#ccc;}</style>
<div style="background:#ccc;">
<div id="forgetmains" style="padding:30px">
<div class="form forgetemail-form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">找回密码</p>
    <p class="p-solid"></p>
    
	<?php echo $form->errorSummary($model); ?>

	<div class="user-list-div1 forgetemail user-style">
		<?php echo $form->labelEx($model,"用户邮箱",array('class'=>'user-i')); ?>
		<div class="input-group">
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>100,'class'=>'form-control'));?>
		<?php echo $form->error($model,'email'); ?>
		</div>
	</div>
	<div class="clear"></div>
	
	<p class="p-solid"></p>
	<div class="row user-buttons" style="">
		<?php echo CHtml::Button($model->isNewRecord ? "下一步" : "下一步",array('class'=>'btn btn-primary user-btn')); ?>
	</div>

	
<?php $this->endWidget(); ?>
</div><!-- form -->
</div>
</div>
<?php $homeUrl = Yii::app()->request->hostInfo.Yii::app()->homeUrl."/site/login"; ?>
<script>

$('.user-btn').click(function(){

     var email = $('#User_email').val();
     
     $.getJSON("<?php echo Yii::app()->createUrl('site/EmailAjax') ?>",{email:email},function(json){

  		if(json==1)
		{
			alert("邮件发送成功");
			window.location.href="<?php echo $homeUrl; ?>";
		}
  		else
  		{
  			alert(json);
  	  	}
		
	}); 
});

</script>