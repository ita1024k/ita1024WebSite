$(function(){

	$('#aside_tab_nav').on('click','li',function(){
		var _this = $(this);
		var _index = _this.index();
		_this.addClass('current').siblings().removeClass('current');
		 _this.parent().next().children('ul').eq(_index).show().siblings().hide();
	})
	var is_odd = true;
	$('#toggle_btn').on('click',function(){
		if(is_odd==true){
			$(this).html('<i class="icon icon_down"></i>展开');
			$(this).parent().next().slideUp();
			is_odd=false;
		}else{
			$(this).html('<i class="icon icon_up"></i>收起');
			$(this).parent().next().slideDown();
			is_odd=true;
		}
	})
	$('.popBox').on('click','.btn_right .quick_btn,.close_btn',function(){
                var string = window.location.href;
                var urls = string.split('?')[0];
		window.location = urls;
		$(this).parents('.popBox').hide();
	})

	$('#popBox_host').on('click','.send_btn',function(){
		var text_length = $('#suggest_content').val().length;
		if(text_length<0){
			$('#popBox_host').find(".warning").text('输入信息不能为空').fadeIn();
			setTimeout('$("#popBox_host").find(".warning").fadeOut()',3000);
			return false;
		}
                if(text_length<10){
			$('#popBox_host').find(".warning").text('输入字符不能少于10个！').fadeIn();
			setTimeout('$("#popBox_host").find(".warning").fadeOut()',3000);
			return false;
		}
                viewAajaxSendEmail();
                return false;
	})
	//点击微博分享
    function share_wb(){
        var _this= $(this);
        var url=window.location.href;//获取当前的网页
        var imgsrc=$('.ac_msg_img').attr('src');//获取轮播图的第一个图片
        var title = $('.ac_msg_in').find('h2.tit').text();
        var desc = '我在@xxx 发现了一个不错的活动'+title;
        var _this_href = 'http://service.weibo.com/share/share.php?url='+url+'&title='+desc+'&pic='+imgsrc;
        _this.attr('href',_this_href);
	}
	share_wb();

	//微信点击弹窗
	$('#share_wx').on('click',function(event){
		event.preventDefault();
		$('#popBox_share').show();
	})
	//联系主办方
	$('#touch_host').on('click',function(event){
		event.preventDefault();
		$('#popBox_host').show();
	})
	//我要报名
	$('#join_btn').on('click',function(event){
		event.preventDefault();
		//如果下面票种没有选中的
		if($('#tickets_list').find('li.checked').length<=0){
			$('#ticket_select_tips').show();
		}else{//如果票种已选择
			var ac_join_form = $('#ac_join_form');
			if(ac_join_form.css('display')=='none'){
				ac_join_form.show();
			}else{
				ac_join_form.hide();
			}
		}
	})

	$("#tickets_list").on("mouseover mouseout",function(event){
		event.preventDefault();
		if(event.type == "mouseover"){
			if($(this).hasClass('checked')){
				return;
			}
		}else if(event.type == "mouseout"){
			if($(this).hasClass('checked')){
				return;
			}
		}
	})
	funPlaceholder(document.getElementById("suggest_content"));
	//选票
	//$('#tickets_list').on('click','li.left',function(){
                if($('#tickets_list').find('li.left').length>3){
                    $('#tickets_list').find('li.left:nth-child(4n)').css('clear','left');
                }
                $('#tickets_list').on('click','li.left',function(){
                        var _this = $(this);
                        if( _this.siblings().length<=0){ //如果只有一个请初始化页面的时候给唯一的一个加上选中的样式,下面的解释也要出现
                                return false;
                        }else{
                                //控制样式
                                _this.addClass('checked').siblings().removeClass('checked');
                                var ticket_id = _this.find('.tickets_list_item #item_ticket_id').val();
                                $("#Information_ticket_id").val(ticket_id);
                                _this.find('.explain').show().parent().siblings().find('.explain').hide();
                                $('#ticket_select_tips').hide();
                        }
                })
//		var _this = $(this);
//		if( _this.siblings().length<=0){ //如果只有一个请初始化页面的时候给唯一的一个加上选中的样式
//			return false;
//		}else{
//			//控制样式
//			_this.addClass('checked').siblings().removeClass('checked');
//			var ticket_id = _this.find('.tickets_list_item #item_ticket_id').val();
//			$("#Information_ticket_id").val(ticket_id);
//			$('#ticket_select_tips').hide();
//		}

	//})
		//判断电话号码
	function userTel(){
		var ph_var = $('#contact_phone').val();
		var telreg = /^1[3|4|5|6|7|8][0-9]\d{8}$/;  
		if(ph_var==''){
			$('#form_valid_error_msg').fadeIn().text('请输入手机号');
			$('#contact_phone').focus().css('border-color','#2d6ac8');
			return false;
		}
		if (!telreg.exec(ph_var)){
			$('#form_valid_error_msg').fadeIn().text('请输入正确的手机号码');
			$('#contact_phone').focus().css('border-color','#2d6ac8');
			return false;
		}
		$('#contact_phone').css('border-color','#eee');
		return true;
	}
	 //邮箱
	function userEmail(){
		var emailreg = /^(\w)+(\.\w+)*@(\w)+((\.\w{2,3}){1,3})$/;///^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
		var contact_email = $('#contact_email').val();
		if (contact_email == '') { //用户名为空
				$('#form_valid_error_msg').fadeIn().text('请输入邮箱');
				$('#contact_email').focus().css('border-color','#2d6ac8');
				return false;
		}
		if(!contact_email.match(emailreg)) { //用户名邮箱不符合
			$('#form_valid_error_msg').fadeIn().text('请输入正确的邮箱地址');
			$('#contact_email').focus().css('border-color','#2d6ac8');
			return false;
		}
		$('#contact_email').css('border-color','#eee');
		return true;
	}
	 //去掉提示红框
    $('input.required').on('focus',function(){
        $(this).css('border-color','#eee')
    });
	//填写资料提交与取消
	$('#form_actions').on('click',function(event){
		event.preventDefault();
		var $target = $(event.target);
		if($target.is('#join_submit_btn')||$target.is('.icon_success')){
			var form_error_msg = $('#form_valid_error_msg');
                        
                        if($('#contact_name').val()==''){
				form_error_msg.fadeIn().text('请输入您的姓名');
				$('#contact_name').focus().css('border-color','#2d6ac8');
				return false;
			}else{
				$('#contact_name').css('border-color','#eee');
			}
			
			if(!userTel()||!userEmail()){
				return false;
			}
			if($('#contact_company').val()==''){
				form_error_msg.fadeIn().text('请输入您所在的公司');
				$('#contact_company').focus().css('border-color','#2d6ac8');
				return false;
			}else{
				$('#contact_company').css('border-color','#eee');
			}
			
			if($('#contact_duties').val()==''){
				form_error_msg.fadeIn().text('请输入您所在的职务');
				$('#contact_duties').focus().css('border-color','#2d6ac8');
				return false;
			}else{
				$('#contact_duties').css('border-color','#eee');
			}
			if($('input:radio[name="Information[workinglife]"]:checked').length==0){
				form_error_msg.fadeIn().text('请选择您的工作年限');
				return false;
			}
                        //用户自定义验证
			var must_check_other = $('.must_check_other');
			
			if(must_check_other.length>0){
				//循环必填项
				for(var i = 0;i<must_check_other.length;i++){
					var _this = must_check_other.eq(i);//当前循环到的执行项
					//找到它里面name为other_data[][]的input
					var _this_input = _this.children('input').filter(function(){
						return $(this).attr("name")
					});
					//获取上步中input的value值
					var _this_value =  _this_input.attr('value');
					//找到包含input输入框以及多选单选框的div
					var _this_controls = _this.find('div.controls');

					//如果是输入框
					//如果是输入框都含有这个class名
					var input_box =_this_controls.find('.join_form_input');
					if(input_box){
						//获取input框中的value值
						var input_box_value = input_box.val();
						if(input_box_value==''){
							//提示
							//Tips.showTips(_this_value+'不能为空');
                                                        form_error_msg.fadeIn().text(_this_value+'不能为空');
							input_box.focus().css('border-color','#2d6ac8');
							return false;
						}else{
							input_box.focus().css('border-color','#eee');
						}
					}
					//如果是单选
					if(_this_controls.hasClass('radio_list')){
						//判断是否有选中的选项
						var checked_radio = _this_controls.find('input[type="radio"]').filter(function(index){return $(this).is(":checked") == true});
						if(checked_radio.length==0){
							//提示
							//Tips.showTips('请选择'+_this_value);
                                                        form_error_msg.fadeIn().text('请选择'+_this_value);
							return false;
						}
					}
					//如果是多选
					if(_this_controls.hasClass('checkbox_list')){
						//判断是否有选中的选项
						var checked_radio = _this_controls.find('input[type="checkbox"]').filter(function(index){return $(this).hasClass("square_icon_checked")});
						if(checked_radio.length==0){
							//提示
							//Tips.showTips('请选择'+_this_value);
                                                        form_error_msg.fadeIn().text('请选择'+_this_value);
							return false;
						}
					}
				}
			}
//                       if($(".control_group.must_check_other #is_type[value='input']").length){
//                            var title_val = $(".control_group.must_check_other .single_input_box input").val();
//                            var _this = $(".control_group.must_check_other #is_type[value='input']").parent();
//                            if(!title_val){
//                                var title_show = _this.find("#title_show").val()+'不能为空';
//                                form_error_msg.fadeIn().text(title_show);
//                                return false;
//                            }
//                        }
//                        
//                        if($(".control_group.must_check_other #is_type[value='textarea']").length){
//                            var title_val = $(".control_group.must_check_other .textarea_input_box textarea").val();
//                            var _this = $(".control_group.must_check_other #is_type[value='textarea']").parent();
//                            if(!title_val){
//                                var title_show = _this.find("#title_show").val()+'不能为空';
//                                form_error_msg.fadeIn().text(title_show);
//                                return false;
//                            }
//                        }
//                       
//                        if($(".control_group.must_check_other #is_type[value='radio']").length){
//                            var title_val = $(".control_group.must_check_other .radio_list input[type='radio']:checked").length;
//                            var _this = $(".control_group.must_check_other #is_type[value='radio']").parent();
//                            if(!title_val){
//                                var title_show = _this.find("#title_show").val()+'不能为空';
//                                form_error_msg.fadeIn().text(title_show);
//                                return false;
//                            }
//                        }
//                        
//                        if($(".control_group.must_check_other #is_type[value='checkbox']").length){
//                            var chk_value = new Array();
//                            $(".control_group.must_check_other .checkbox_list input[type='checkbox']:checked").each(function(){ 
//                                chk_value.push($(this).val()); 
//                            });
//                            var _this = $(".control_group.must_check_other #is_type[value='checkbox']").parent();
//                            if(!chk_value.length){
//                                var title_show = _this.find("#title_show").val()+'不能为空';
//                                form_error_msg.fadeIn().text(title_show);
//                                return false;
//                            }
//                        }
                        
			form_error_msg.fadeOut().text('');
			$('#contact_duties').css('border-color','#eee');
			$('#contact_valid_form').submit();
//			$("#join_submit_btn").click(function(){
//				ajaxCreate();
//			})
			//$('#ac_join_form').hide();
			//$('#popBox_tips').show();//测试使用用后删除
		}
		if($target.is('a.btn_default')){
			$('#ac_join_form').hide();
		}
	})
        var div = $('div.bottom');
	var offset = div.offset().top;
	var footer_offset = $('.footer').offset().top;
	$(window).on('scroll',function(){
		var scroll_top = $(window).scrollTop();
		if(scroll_top>=offset-20){
			if($('.footer').offset().top-scroll_top-20-div.height()<=50){
				var top = footer_offset-50-div.height()-$('div.map').offset().top-$('div.map').height()-30;
				div.removeClass('fixed').addClass('relative').css('top',top)
			}else{
				div.removeClass('relative').addClass('fixed').css('top','20px');
			}
		}else{
			div.removeClass('fixed');
		}
	})
})
//活动管理
$(function(){
	$('.user_tab').on('click','li',function(){
		var _this = $(this);
		var _index= _this.index();
		$('li.last').css('border-right-color','#ededed');
		_this.addClass('current').siblings().removeClass('current');
		if(_this.hasClass('last')){
			_this.css('border-right-color','#fff');
		}else{
			_this.css('border-right-color','#ededed');
		}
		_this.parent().next().children().eq(_index).show().siblings().hide();
		//控制ul位置
	})
})
//名单管理
$(function(){
   	funPlaceholder(document.getElementById("attendees_search_key"));
	$('#search_key_primary').on('click',function(){
		//判断是否为空
		if($('#attendees_search_key').val().length==0){
        	//'输入信息不能为空'
      	}
		//是否提示页面正在加载中
		$('#attendees_error_msg').show();
        setTimeout('$("#attendees_error_msg").hide()',3000);
		/*
		$.ajax({
            type: "get",
            url: ,
            dataType: 'jsonp',
            data:,
            success: function (res) {
            	//如果成功
            	if(){

            	}esle{//如果失败
            		$('#attendees_search_key').show();
            		setTimeout('$('#attendees_search_key').hide()',3000);
            	}
                
            }
        });*/
		
	})
	$('.checkbox_list').on('click','input[type=checkbox]',function(){
            var _this = $(this);
            if(_this.is(':checked')){
                _this.removeClass('square_icon_check').addClass('square_icon_checked');
            }else{
                _this.removeClass('square_icon_checked').addClass('square_icon_check');
            }
	});
        
})
window.onload= function(){
	//地图
	$('#map').find('.anchorBL').hide();
}
