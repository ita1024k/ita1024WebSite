
$(function(){
	$('.article_content').find('img').removeAttr('style').removeAttr('width').removeAttr('height').css({'height':'auto','width':'100%'});
        $('.article_content').find('table').removeAttr('style').removeAttr('width').removeAttr('height').removeAttr('cellpadding').removeAttr('cellspacing')
            .find('tr').removeAttr('width').removeAttr('height').removeAttr('style')
            .end().find('td').removeAttr('width').removeAttr('height').removeAttr('nowrap').css({'word-wrap':'break-word','word-break': 'break-all','padding': '0 5px','box-sizing':'border-box'})
            .end().find('th').removeAttr('width').removeAttr('height').removeAttr('nowrap').css({'word-wrap':'break-word','word-break': 'break-all','padding': '0 5px','box-sizing':'border-box'});
	$(window).on('scroll',function(){ 
		if( $(window).scrollTop()>100 ){    
		$("#toTop").fadeIn(400);     
		}else{      
			$("#toTop").stop().fadeOut(400); 
		}
	});
	$('#toTop').on('click',function(){
		$("html,body").animate({scrollTop:"0px"},200);
	})
	$('#touch_host').on('click',function(){

	})
	/*$('#share_btn').on('click',function() {
		$('#shareBox').show();
	})
	$('#shareBox').on('click','a',function(e){
		var _this = $(e.target).parent();
		var url=window.location.href;//获取当前的网页
        var imgsrc=$('.details_banner').attr('src');//获取轮播图的第一个图片
        var title = $('h2.event_title').text();
        var desc = '我在|爱它就分享|发现了一个不错的活动:';
        if(_this.is('#weibo')){
            var desc='我在|爱它就分享|发现了一个不错的活动:'+title;
            var href = 'http://service.weibo.com/share/share.php?url='+url+'&title='+desc+'&pic='+imgsrc;
            _this.attr('href',href);
        }
	})*/
	$('.close_btn').on('click',function(){
		$(this).parents('.popBox').hide();
	})
	$('.shadeBox').on('click',function(){
		$(this).parent().hide();
	})
	$('.default_btn').on('click',function(){
		$(this).parents('.popBox').hide();
	})
	$('#join_btn').on('click',function(){
		$('#ticketBox').show();
	})
	$('#tickets_list li').on('click',function(){
		var _this = $(this);
                var ticket_id = _this.find('.tickets_list_item #item_ticket_id').val();
                $("#Information_ticket_id").val(ticket_id);
		_this.addClass('checked').find('i.checked_triangle_icon').show().end().siblings().removeClass('checked').find('i.checked_triangle_icon').hide();
	})

	//控制多选框按钮
        $('.checkbox_list').on('click','input[type=checkbox]',function(){
		var _this = $(this);
                if(_this.is(':checked')){
                    _this.removeClass('square_icon_check').addClass('square_icon_checked');
                }else{
                    _this.removeClass('square_icon_checked').addClass('square_icon_check');
                }
	})
//	$('.checkbox_list').on('click','label',function(){
//		var _this = $(this).find('input');
//		if(_this.hasClass('square_icon_checked')){
//			_this.removeClass('square_icon_checked').addClass('square_icon_check');
//		}else{
//			_this.removeClass('square_icon_check').addClass('square_icon_checked');
//		}
//	})
	var Tips = {
        clearTips: function(){
            $("#tips").remove();
        },
        showTips: function(tipsMsg){
            this.clearTips();
            //创建显示框并且让其居中
            $("body").append("<div id='tips'><span class='words'>"+tipsMsg+"</span></div>");

        }
    }
    //联系主办方
    $('#touch_host').on('click',function(){
    	$('#contact_host').show();
    })
    //验证给举办方发送信息
    $('#contact_host').on('click',function(e){
    	var $target = $(e.target);
    	if($target.is('a.short_btn')){
    		var msg_val = $('#suggest_content').val();
    		if(msg_val==''){
    			Tips.showTips('请输入信息！');
    			return false;
    		}
    		if(msg_val.length<10){
    			Tips.showTips('输入字符不能少于10个!');
    			return false;
    		}
    		//提交信息
    		ajaxSendEmail();
    	}
    })
   	//点击我要参加弹出框 2016-1-15日改写
	$('#join_ok_btn').on('click',function(){
		if($('#tickets_list').find('li.checked').length==0){
			Tips.showTips('请先选择票种！');
			return false;
		}
		$('#join_form').show().prevAll().hide();
	})
	//2016-1-15 新增加
	$('#join_form').on('click','.join_form_header a.back,#form_actions .default_btn',function(){
		$('#join_form').hide()
		$('#ticketBox').prevAll().show();
	})
	//填写资料验证
	//判断电话号码
	function userTel(){
		var ph_var = $('#contact_phone').val();
		var telreg = /^1[3|4|5|6|7|8][0-9]\d{8}$/;  
		if(ph_var==''){
			Tips.showTips('请输入手机号');
			$('#contact_phone').css('border-color','#2d6ac8');
			return false;
		}
		if (!telreg.exec(ph_var)){
			Tips.showTips('请输入正确的手机号码');
			$('#contact_phone').css('border-color','#2d6ac8');
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
				Tips.showTips('请输入邮箱');
				$('#contact_email').css('border-color','#2d6ac8');
				return false;
		}
		if(!contact_email.match(emailreg)) { //用户名邮箱不符合
			Tips.showTips('请输入正确的邮箱地址');
			$('#contact_email').css('border-color','#2d6ac8');
			return false;
		}
		$('#contact_email').css('border-color','#eee');
		return true;
	}
	 //去掉提示红框
    $('input.required').on('focus',function(){
        $(this).css('border-color','#eee');
    });
	$('#join_submit_btn').on('click',function(){
		//验证
			if($('#contact_name').val()==''){
				Tips.showTips('请输入您的姓名');
				$('#contact_name').css('border-color','#2d6ac8');
				return false;
			}else{
				$('#contact_name').css('border-color','#eee');
			}
			
			if(!userTel()||!userEmail()){
				return false;
			}
			if($('#contact_company').val()==''){
				Tips.showTips('请输入您所在的公司');
				$('#contact_company').css('border-color','#2d6ac8');
				return false;
			}else{
				$('#contact_company').css('border-color','#eee');
			}
			
			if($('#contact_duties').val()==''){
				Tips.showTips('请输入您所在的职务');
				$('#contact_duties').css('border-color','#2d6ac8');
				return false;
			}else{
				$('#contact_duties').css('border-color','#eee');
			}
			if($('input:radio[name="Information[workinglife]"]:checked').length==0){
				Tips.showTips('请选择您的工作年限');
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
							Tips.showTips(_this_value+'不能为空');
                                                        //form_error_msg.fadeIn().text(_this_value+'不能为空');
							input_box.css('border-color','#2d6ac8');
							return false;
						}else{
							input_box.css('border-color','#eee');
						}
					}
					//如果是单选
					if(_this_controls.hasClass('radio_list')){
						//判断是否有选中的选项
						var checked_radio = _this_controls.find('input[type="radio"]').filter(function(index){return $(this).is(":checked") == true});
						if(checked_radio.length==0){
							//提示
							Tips.showTips('请选择'+_this_value);
                                                        //form_error_msg.fadeIn().text('请选择'+_this_value);
							return false;
						}
					}
					//如果是多选
					if(_this_controls.hasClass('checkbox_list')){
						//判断是否有选中的选项
						var checked_radio = _this_controls.find('input[type="checkbox"]').filter(function(index){return $(this).hasClass("square_icon_checked")});
						if(checked_radio.length==0){
							//提示
							Tips.showTips('请选择'+_this_value);
                                                        //form_error_msg.fadeIn().text('请选择'+_this_value);
							return false;
						}
					}
				}
			}
			$('#contact_duties').css('border-color','#eee');
			$("#contact_valid_form").submit();
	})
})