$(function(){
	//上传图片 ie9及以下不支持
    var txt;
    $('#avatar_input').on('change',function(){
        var file = this.files[0];
        var fileReader = new FileReader();
        fileReader.readAsDataURL(file);
        if(file.size>2000000){
        	popBoxMiddle.showWaring('图片不能超过2M');
            setTimeout("popBoxMiddle.clearWaring()",2000);
            return false;
        }
        fileReader.onload = function (e) {
            txt = this.result;
            document.getElementById('publisher_avatar').src = txt;
            $('#avatar_img_data').val(txt);
        }
    });
	
	//保存取消
	$('#form_actions').on('click','.btn_primary',function(){
		popBoxMiddle.clearWaring();
		var item = $('#publisher_valid_form').find('input.required');
		var name = $('input[name="User[user_name]"]'),
			passWord = $('input[name="User[password]"]'),
			rePassWord = $('input[name="User[confirm_password]"]'),
			///userType = $('input[name="User[userType]"]'),
			email = $('input[name="User[email]"]'),
			phone = $('input[name="User[phone]"]'),
			address = $('input[name="User[adrss]"]'),
			company = $('input[name="User[company]"]'),
			duty = $('input[name="User[connect]"]') ,
			avatar_img_data = $('#avatar_img_data');
		if(name.val()==''){
			popBoxMiddle.showWaring('账号名不能为空');
			setTimeout("popBoxMiddle.clearWaring()",2000);
			name.focus().css('border-color','#2d6ac8');
			return false;
		}
		if(passWord.val()==''){
			popBoxMiddle.showWaring('登录密码不能为空');
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
//		if(userType.val()==''){
//			popBoxMiddle.showWaring('用户类型不能为空');
//			setTimeout("popBoxMiddle.clearWaring()",2000);
//			userType.focus().css('border-color','#2d6ac8');
//			return false;
//		}
		if(email.val()==''){
			popBoxMiddle.showWaring('联系邮箱不能为空');
			setTimeout("popBoxMiddle.clearWaring()",2000);
			email.focus().css('border-color','#2d6ac8');
			return false;
		}
		var emailreg = /^(\w)+(\.\w+)*@(\w)+((\.\w{2,3}){1,3})$/;
		if(!email.val().match(emailreg)) { //用户名邮箱不符合
			popBoxMiddle.showWaring('邮箱地址不正确');
			setTimeout("popBoxMiddle.clearWaring()",2000);
			email.focus().css('border-color','#2d6ac8');
			return false;
		}
		if(phone.val()==''){
			popBoxMiddle.showWaring('联系电话不能为空');
			setTimeout("popBoxMiddle.clearWaring()",2000);
			phone.focus().css('border-color','#2d6ac8');
			return false;
		}
		var telreg = /^1[3|4|5|6|7|8][0-9]\d{8}$/;
		if (!telreg.exec(phone.val())){
			popBoxMiddle.showWaring('手机号码格式不正确');
			setTimeout("popBoxMiddle.clearWaring()",2000);
			phone.focus().css('border-color','#2d6ac8');
			return false;
		}
		if(address.val()==''){
			popBoxMiddle.showWaring('联系地址不能为空');
			setTimeout("popBoxMiddle.clearWaring()",2000);
			address.focus().css('border-color','#2d6ac8');
			return false;
		}
		if(company.val()==''){
			popBoxMiddle.showWaring('所在公司不能为空');
			setTimeout("popBoxMiddle.clearWaring()",2000);
			company.focus().css('border-color','#2d6ac8');
			return false;
		}
		if(duty.val()==''){
			popBoxMiddle.showWaring('所在职位不能为空');
			setTimeout("popBoxMiddle.clearWaring()",2000);
			duty.focus().css('border-color','#2d6ac8');
			return false;
		}
		if($('#avatar_img_data').val()==''){
			popBoxMiddle.showWaring('用户头像不能为空');
			setTimeout("popBoxMiddle.clearWaring()",2000);
			return false;
		}
		$('#publisher_valid_form').submit();
	})
	 //去掉提示红框
    $('input.required').on('focus',function(){
        $(this).css('border-color','#ededed')
    });
	$('#form_actions').on('click','.btn_default',function(){
		$('#publisher_valid_form').find('input.form_input').val('');
		$('.avatar_upload').find('img').attr('src','images/publish_upload.jpg');//如果此处链接有更改，请更改src属性
		$('#avatar_img_data').val('');
		$('input.required').css('border-color','#ededed');
    });
	
})