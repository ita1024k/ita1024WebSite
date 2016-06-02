$(function(){
	funPlaceholder(document.getElementById("txtName"));
	funPlaceholder(document.getElementById("txtPwd"));
	//姓名密码验证码验证开始
	var user_name = $("#txtName");
	var user_pass = $("#txtPwd");
	
    //去掉提示红框
    $('input').focus(function(){
    	clearTips();
        $(this).css('box-shadow','none');
    });
	//判断密码
	function userPass(){
		var pass_var  = user_pass.val();
		if(pass_var==''){
			showTips('请输入密码');
			//j_pass.focus();
            user_pass.css('box-shadow','0 0 0 1px #facd89');
			return false;
		}
		return true;
	}
	
	  //用户名
	function userName(){
		var name_var = user_name.val();
		var emailreg = /^(\w)+(\.\w+)*@(\w)+((\.\w{2,3}){1,3})$/;
		if (name_var == '' || name_var == '请输入已验证邮箱') { //用户名为空
				showTips('请输入已验证邮箱');
				//j_name.focus;
                user_name.css('box-shadow','0 0 0 1px #facd89');
				return false;
		}
		if(name_var.indexOf('@') < 0||(name_var.indexOf('@') >= 0 && !name_var.match(emailreg))) { //用户名邮箱不符合
			showTips('邮箱地址不正确');
			//j_name.focus;
            user_name.css('box-shadow','0 0 0 1px #facd89');
			return false;
		}
		return true;
	}
	//登陆
	 $('#login_btn').on('click',function(){
	 	clearTips();
		if(!userName() || !userPass()){
			return false;
		}
		login_submit();
	})
	function clearTips(){
		$("#error_tips").fadeOut();
	}

	function showTips(tipsMsg){
		//创建显示框并且让其居中
		$("#error_tips").fadeIn().html(tipsMsg);
						 
	}
	//登陆
	function login_submit(){
		/*$.ajax({
			type: "post",
			url: ,
			dataType: 'jsonp',
			data:{'userName':$("#txtName").val(),'password':$("#txtPwd").val()},
			success: function (msg) {
				if(msg.code == 0 ){
					showTips(msg.data);
					return false;
				}else{
					//跳转之前的页面或者进入首页
					return true;
				}
			}
		});*/
	}

})