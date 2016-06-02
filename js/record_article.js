//回到顶部
$(function(){
        $('.article_content').find('img').removeAttr('style').removeAttr('width').removeAttr('height').css({'height':'auto','width':'100%'});
        $('.article_content').find('table').removeAttr('style').removeAttr('width').removeAttr('height').removeAttr('cellpadding').removeAttr('cellspacing').find('tr').removeAttr('width').removeAttr('height').removeAttr('style').end().find('td').removeAttr('width').removeAttr('height').removeAttr('nowrap').css({'word-wrap':'break-word','word-break': 'break-all','padding': '0 5px','box-sizing':'border-box'}).end().find('th').removeAttr('width').removeAttr('height').removeAttr('nowrap').css({'word-wrap':'break-word','word-break': 'break-all','padding': '0 5px','box-sizing':'border-box'});

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
 //下拉加载
  //分页加载
//    if(window.pageInfo.totalPage == 0){
//        $('.loading').hide();
//    };
//    var url = window.location.href,
//        url_common = url,
//        num = (window.pageInfo.currentPage+1),
//        outTime = 1;
       
     //以下为滚动时分页加载请修改相关代码
    /*$(window).on('scroll',function(){
        var scrolltop = $(document).scrollTop(),
            body_h = $('body').height(),
            window_h = window.screen.height,
            max_h = window_h+scrolltop;
    
        if(body_h-30 <= max_h && num <= window.pageInfo.totalPage && outTime == 1){
            if(url_common.indexOf('?') > 0){//如果网址中有第几页
                url_common += "&page="+num+"&callback=?";
            }else{
                url_common += "?page="+num+"&callback=?";
            }
            info(num);
            outTime = 0;
            url_common = url;
            num++;
        };
        if(eval(num-1) == window.pageInfo.totalPage){
            $('.loading').hide();
        };
    });
    function info(i){
        $.ajax({
            type: "get",
            url: url_common,
            dataType: 'jsonp',
            data:'',
            success: function (res) {
                $('#hot_recom_list').append(res.html);
                return outTime=1;
            }
        });
    };*/

});




	