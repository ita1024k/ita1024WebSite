

$(function(){
    funPlaceholder(document.getElementById("record_name"));
    funPlaceholder(document.getElementById("record_author"));
    funPlaceholder(document.getElementById('ac_name'));
    funPlaceholder(document.getElementById('Address'));
    funPlaceholder(document.getElementById('form_control_name'));
    funPlaceholder(document.getElementById('form_control_phone'));
    funPlaceholder(document.getElementById('form_control_email'));
    funPlaceholder(document.getElementById('form_control_time'));

    window.onload = function(){
        $('.record_name').find('label').eq(1).css('padding-left','20px');
        $('.record_author').find('label').eq(1).css('padding-left','20px');
        FuckInternetExplorer();
    }

    function FuckInternetExplorer() {
        var browser = navigator.appName;
        var b_version = navigator.appVersion;
        var version = b_version.split(";");
      if (version.length > 1) {
             var trim_Version = parseInt(version[1].replace(/[ ]/g, "").replace(/MSIE/g, ""));
            if (trim_Version < 9) {
                 $('.ac_name ').find('label').eq(1).css('padding-left','20px');
                $('#Address').prev().css('padding-left','20px');
                return false;
            }
         }
    
         return true;
     }
    //上传图片 ie9及以下不支持
    var txt;
    $('#poster_input').on('change',function(){
        //判断ie9以下
       
        var file = this.files[0];
        var fileReader = new FileReader();
        fileReader.readAsDataURL(file);
        if(file.size>2000000){
            $('#poster_error_msg').show.text('图片不能超过2M');
            return false;
        }
        fileReader.onload = function (e) {
            txt = this.result;
            document.getElementById('logo_image').src = txt; 
            var img = new Image(),
            	imgWidth,
            	imgHeight;
            img.onload = function(){
            	imgWidth = img.width,
            	imgHeight = img.height; //图片实际宽
            }
            if(imgWidth<1080||imgHeight<640){
                 $('#poster_error_msg').show.text('图片尺寸不合要求');
                return;
            }
            var mTop = ($('#poster_preview').height()-$('#logo_image').height())/2;
            $('#logo_image').css({'margin-top':mTop});
        }
    });
    //弹窗错误提示
    //发布
	$('#creat_submit_btn_ac').on('click',function(){
            if($('#Article_ticket_status').val()==''){
                    popBoxMiddle.showTips('至少添加一种票种');
                    return false;
            }
            if($('#Article_title').val()==''){
                    popBoxMiddle.showTips('请填写名称');
                    return false;
            }
            if($('#Article_address').val()==''){
                    popBoxMiddle.showTips('地址不能为空');
                    return false;
            }
           if($('#select_province').val()==''){
                    popBoxMiddle.showTips('请选择省份');
                    return false;
            }
            if($('#select_province').val()=='省份/直辖市'){
                    popBoxMiddle.showTips('请选择省份');
                    return false;
            }
            if($('#select_city').val()=='请先选择省份/直辖市'){
                    popBoxMiddle.showTips('请选择地区');
                    return false;
            }
            if($('#Article_nums').val()==''){
                    //form_error_msg.fadeIn().text('请填写名称');
                    popBoxMiddle.showTips('请填写人数限制');
                    //$('#Article_title').focus().css('border-color','#2d6ac8');
                    return false;
            }
            if($('.editor_box textarea').val()==''){
                    //form_error_msg.fadeIn().text('请填写名称');
                    popBoxMiddle.showTips('内容不能为空');
                    //$('#Article_title').focus().css('border-color','#2d6ac8');
                    return false;
            }
            //
            $('#ac_base_form').submit();
        //成功
        //popBoxMiddle.showTips('发布成功');
        //否则
        //popBoxMiddle.showWaring('警告出错啦');//showWaring中填入错误信息
        //setTimeout("popBoxMiddle.clearWaring()",2000);
    })
	$('#creat_submit_btn_ac_1').on('click',function(){
            if($('#Article_ticket_status').val()==''){
                    popBoxMiddle.showTips('至少添加一种票种');
                    return false;
            }
            if($('#Article_title').val()==''){
                    popBoxMiddle.showTips('请填写名称');
                    return false;
            }
            if($('#Article_address').val()==''){
                    popBoxMiddle.showTips('地址不能为空');
                    return false;
            }
           if($('#select_province').val()==''){
                    popBoxMiddle.showTips('请选择省份');
                    return false;
            }
            if($('#select_province').val()=='省份/直辖市'){
                    popBoxMiddle.showTips('请选择省份');
                    return false;
            }
            if($('#select_city').val()=='请先选择省份/直辖市'){
                    popBoxMiddle.showTips('请选择地区');
                    return false;
            }
            if($('#Article_nums').val()==''){
                    //form_error_msg.fadeIn().text('请填写名称');
                    popBoxMiddle.showTips('请填写人数限制');
                    //$('#Article_title').focus().css('border-color','#2d6ac8');
                    return false;
            }
            if($('.editor_box textarea').val()==''){
                    //form_error_msg.fadeIn().text('请填写名称');
                    popBoxMiddle.showTips('内容不能为空');
                    //$('#Article_title').focus().css('border-color','#2d6ac8');
                    return false;
            }
            $("#Article_status").val(1);
            $('#ac_base_form').submit();
        //成功
        //popBoxMiddle.showTips('发布成功');
        //否则
        //popBoxMiddle.showWaring('警告出错啦');//showWaring中填入错误信息
        //setTimeout("popBoxMiddle.clearWaring()",2000);
    })
    $('#creat_submit_btn').on('click',function(){
        $('#record_base_form').submit();
        //成功
        //popBoxMiddle.showTips('发布成功');
        //否则
        //popBoxMiddle.showWaring('警告出错啦');//showWaring中填入错误信息
        //setTimeout("popBoxMiddle.clearWaring()",2000);
    })
	$('#creat_submit_btn_1').on('click',function(){
		$("#Event_status").val(1);
        $('#record_base_form').submit();
        //成功
        //popBoxMiddle.showTips('发布成功');
        //否则
        //popBoxMiddle.showWaring('警告出错啦');//showWaring中填入错误信息
        //setTimeout("popBoxMiddle.clearWaring()",2000);
    })
})
//活动添加
$(function(){
   
    //报名表单
    $('.ac_add_item_short').on('click',function(){
        $(this).hide().next().show();
    })
    //收起
    $('#ac_toggle').on('click',function(){
        $(this).parents('.ac_add_item').hide().prev().show();
    })
    //选中与否
    $('.ac_create_checkbox').on('click', 'input[type="checkbox"]',function(){
        var _this = $(this);
        if(_this.is(':checked')){
            _this.removeClass('square_icon_check').addClass('square_icon_checked');
        }else{
            _this.removeClass('square_icon_checked').addClass('square_icon_check');
        }
    })

    /* $('#ac_add_label_btn').on('click',function(){
            $(this).next().next().toggle();
            if($('.ac_add_label_list').find('ul').find('li').length<=5){
               $('.ac_add_label_list').find('ul').next().hide();
            }
    }) */
	$('#ac_add_label_btn').on('click',function(){
        $(".ac_add_label_modal").toggleClass("hide");
        return false;//阻止冒泡
    });
	$(".ac_add_label_modal").click(function(){
		return false;
	})
    $(document).click(function(){
        $(".ac_add_label_modal").addClass("hide");
		$(".dropdown-menu.open").css('display','none')
    });
	
	$(".ac_add_label_modal ul li").each(function(index){
        $(this).click(function(){
            addIndexLabel($(this).html(),$(this).attr("rel"));
        });
    });
	
   /*  $('.ac_add_label_modal').on('click','li',function(){
        var _this = $(this);
        var label_text = _this.text();
		var label_id = _this.attr("rel");
		//console.log(label_id);
        var top_ul = $('.ac_add_label_list').find('ul');
        if(top_ul.find('li').length>=5){
            top_ul.next().show();
            return;
        }else{
            top_ul.next().hide();
        }
        var add_li = $('<li>'+label_text+'<i class="icon icon_close"></i></li>');
        top_ul.append(add_li);
    }) */
    /* $('.ac_add_label_list').on('click','i.icon_close',function(){
        $(this).parent().remove();
        if($('.ac_add_label_list').find('ul').find('li').length<=5){
           $('.ac_add_label_list').find('ul').next().hide();
        }
    }) */
    //添加自定义栏位
     $('#ac_template_form_items').on('click', 'input[type="checkbox"]',function(){
        var _this = $(this);
        if(_this.is(':checked')){$
            _this.removeClass('square_icon_check').addClass('square_icon_checked');
        }else{
            _this.removeClass('square_icon_checked').addClass('square_icon_check');
        }
    })
     $('#popBox_Userview').on('click', 'input[type="checkbox"]',function(){
        var _this = $(this);
        if(_this.is(':checked')){$
            _this.removeClass('square_icon_check').addClass('square_icon_checked');
        }else{
            _this.removeClass('square_icon_checked').addClass('square_icon_check');
        }
    })
     //预览
    $('#ac_template_form_items').on('focus','.help_inline',function(){
       
        if($(this).val().length>0){
            $(this).removeClass('help_inline');
            $('body').css('position','inherit');
            $('span.blackShadeWarning').remove();
        }else{
            var x_w = $(this).offset().left+43;
            var y_h = $(this).offset().top-30;
            $(this).addClass('help_inline');
            $('body').css('position','relative').append('<span class="blackShadeWarning icon" style="top:'+y_h+'px;left:'+x_w+'px;">这是必填项</span>');
        }
    }).on('blur','.help_inline',function(){
         if($(this).val().length>0){
            $(this).removeClass('help_inline');
             $('body').css('position','inherit');
            $('span.blackShadeWarning').remove();
        }else{
            var x_w = $(this).offset().left+43;
            var y_h = $(this).offset().top-30;
            $(this).addClass('help_inline');
            $('body').css('position','relative').append('<span class="blackShadeWarning icon" style="top:'+y_h+'px;left:'+x_w+'px;">这是必填项</span>');
        }
    })
    //预览滚动条
    $('#popBox_Userview').find('.popBox_body').on('scroll',function(){
        $('body').css('overflow','hidden');
    })

})
