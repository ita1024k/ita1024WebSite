$(document).ready(function(){
       
	//轮播图
	var sliderBox = $(".top_slider");
	
	var iBannerList = $("#iBannerList");
	var iPrevBtn = $("#iPrevBtn");
	var iNextBtn = $("#iNextBtn");
	var iControlBtn = $("#iControlBtn");
	var imgNum = 0;
	var iTimer = null;
	
	iPrevBtn.click(function(){
		imgNum --;
		if(imgNum < 0){
			imgNum = iBannerList.children("li").length-1;
		}
		roll();
	});
	
	iNextBtn.click(function(){
		imgNum ++;
		if(imgNum > iBannerList.children("li").length - 1){
			imgNum = 0;
		}
		roll();
	});
	
	iControlBtn.on("mouseover","li",function(){
		
		imgNum = $(this).index();
		roll();
	});
	sliderBox.on("mouseover",function(){
		clearInterval(iTimer);
		iPrevBtn.show();
		iNextBtn.show();
		});
	sliderBox.on("mouseout",function(){
		imgRoll();
		iPrevBtn.hide();
		iNextBtn.hide();
		});
	
	//图片滚动代码
	function imgRoll(){
		iTimer = setInterval(function(){
			imgNum++;
			if(imgNum > iBannerList.find("li").length - 1){
				imgNum = 0;
			}
			roll();
		},3000);
		
	}
	imgRoll();
	
	function roll(){
		iBannerList.find("li").eq(imgNum).stop(true,true).fadeIn(500).siblings().hide();
		iControlBtn.find("li").eq(imgNum).addClass("active").siblings().removeClass("active");
	}
	//悬停
	/* $('.hot_recom_list').find('li').on('mouseenter',function(){
	        $(this).css({'border':'#2d6ac8 1px solid'});
	        $(this).find('.name').css({'color':'#2d6ac8'})
	        $(this).find('.join').show();
	}).on('mouseleave',function(){
	        $(this).css({'border':'#ededed 1px solid'});
	        $(this).find('.name').css({'color':'#999999'})
	        $(this).find('.join').hide();
	}) */
	//$('.hot_recom li:nth-child(4n)').css({'margin-right':'0'});
        
});