<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/index.js"></script>
<div class="banner">
	<!--顶部轮播图部分！--> 
	<div class="top_slider">
		 <ul class="clearfix iBannerList" id="iBannerList">
			<!--<li class="show"><a href="/activity/view/id/1450887705915"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/banner1.jpg" width="1200" height="390" alt="中国互联网技术联盟（ITA）成立，粉丝持续招募" /></a></li>-->
			<?php
				foreach($position_arrs as $key=>$val){
					if($key == 0){
						echo '<li class="show"><a href="'.$val["target_url"].'"><img src="'.Yii::app()->request->baseUrl.'/'.$val[logo].'" width="1200" height="390" alt="banner-img2" /></a></li>';
					}else{
						echo '<li><a href="'.$val["target_url"].'"><img src="'.Yii::app()->request->baseUrl.'/'.$val[logo].'" width="1200" height="390" alt="banner-img2" /></a></li>';
					}
				}
			?>
		</ul>
		<div id="iPrevBtn"></div>
		<div id="iNextBtn"></div>
		<ul id="iControlBtn" class="iControlBtn clearfix">
			<!--<li class="active" ></li>-->
			<?php
				foreach($position_arrs as $key=>$val){
					if($key == 0){
						echo '<li class="active" ></li>';
					}else{
						echo '<li ></li>';
					}
				}
			?>
		</ul>
	</div>
</div>
<style>
    ul li.d_over {border:#2d6ac8 1px solid}
    .d_over .apply .name{color:#2d6ac8}
    .d_over .apply .join{display: block}
</style>
<div class="hot_recom">
		<div class="container">
		<?php $this->widget('zii.widgets.CListView', array(
			'id'=>'hot_recom_list',
			'dataProvider'=>$dataProvider,
			'itemView'=>'_view',
			'htmlOptions'=>array("class"=>"hot_recom_list clearfix"),
			'enablePagination'=>false,
			'summaryCssClass'=>'hide',
			'tagName'=>'ul',
			//'itemsCssClass'=>'',
                        //'summaryText'=>'共{count}条，当前页显示第{start}-{end}条',
		)); ?>
		</div>
</div>
<script>
$(function(){
  var winH = $(window).height(); //页面可视区域高度
  var totalCount = <?php echo $totalCount; ?>;
  var pageSize_first = <?php echo $pageSize_first; ?>;
  var i = 1; //设置当前页数 
  $(window).scroll(function () { 
    var pageH = $(document.body).height();
    var scrollT = $(window).scrollTop();//滚动条top
    var aa = (pageH-winH-scrollT)/winH;
    var totalCount_num = pageSize_first*i;
    if(aa<0.02 && totalCount_num <= totalCount && totalCount_num>0){
        var params = {
            'page':i,
        };
        $.fn.yiiListView.update('hot_recom_list', {
            'data':params
        });
        i++;
//      $.getJSON("",{page:i},function(json){
//        if(json){ 
//          var str = ""; 
//          $.each(json,function(index,array){
//            var str = "<div class=\"single_item\"><div class=\"element_head\">";
//            var str += "<div class=\"date\">"+array['date']+"</div>";
//            var str += "<div class=\"author\">"+array['author']+"</div>";
//            var str += "</div><div class=\"content\">"+array['content']+"</div></div>";
//            $("#container").append(str);
//          });
//          i++;
//        }else{
//          $(".nodata").show().html("别滚动了，已经到底了。。。");
//          return false;
//        }
//      });
    } 
  }); 
});
</script>