//回到顶部
$(function(){
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
  $("#timings-demo-btn").toggle(
    function(){
      $(this).next("div#timings-demo").addClass("timings-demo-hover");
    },function(){
      $(this).next("div#timings-demo").removeClass("timings-demo-hover");
  });
  $('.popBox').on('click','.close_btn',function(){
    $(this).parents('.popBox').hide();
	$('body').css('overflow','');
  })
  //浏览器兼容Placeholder
  var funPlaceholder = function(element) {
  //检测是否需要模拟placeholder
  var placeholder = '';
  if (element && !("placeholder" in document.createElement("input")) && (placeholder = element.getAttribute("placeholder"))) {
      //当前文本控件是否有id, 没有则创建
      var idLabel = element.id ;
      if (!idLabel) {
          idLabel = "placeholder_" + new Date().getTime();
          element.id = idLabel;
      }

      //创建label元素
      var eleLabel = document.createElement("label");
      eleLabel.htmlFor = idLabel;
      eleLabel.style.position = "absolute";
      //根据文本框实际尺寸修改这里的margin值
      eleLabel.style.margin = "15px 0 0 3px";
      eleLabel.style.color = "#999";//颜色需要修改
      eleLabel.style.cursor = "text";
      //插入创建的label元素节点
      element.parentNode.insertBefore(eleLabel, element);
      //事件
      element.onfocus = function() {
          eleLabel.innerHTML = "";
      };
      element.onblur = function() {
          if (this.value === "") {
              eleLabel.innerHTML = placeholder;  
          }
      };

      //样式初始化
      if (element.value === "") {
          eleLabel.innerHTML = placeholder;   
      }
    } 
  };
  window.funPlaceholder = funPlaceholder;
  var popBoxMiddle = {
    clearWaring: function(){
      $("#popBox_warning").fadeOut();
    },
    showWaring:function(msg){
        $("#popBox_warning").fadeIn();
        var popBox_content = $("#popBox_warning").find('.popBox_content');
        popBox_content.find('#pop_message_content').text(msg);
        var w = popBox_content.width();
        var h = popBox_content.height();
        popBox_content.css('margin-left',-1*popBox_content.width()/2).css('margin-top',-1*popBox_content.height()/2)
    },
    showTips:function(tips){
      $('#popBox_tips').fadeIn();
      var popBox_content = $("#popBox_tips").find('.popBox_content');
      popBox_content.find('#tips_msg').text(tips);
      var w = popBox_content.width();
      var h = popBox_content.height();
      popBox_content.css('margin-left',-1*popBox_content.width()/2).css('margin-top',-1*popBox_content.height()/2)
    }
  } 
  window.popBoxMiddle = popBoxMiddle;

});




	