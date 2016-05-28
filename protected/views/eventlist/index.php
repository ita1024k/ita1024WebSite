<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/details.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/details.js"></script>
<script>
$(function(){
    $("#eventlist_ac").addClass("current");
})
</script>
<div class="container clearfix record_list ">
		<div class="article">
			<div class="record_list_content">
				<?php $this->widget('zii.widgets.CListView', array(
					//'id'=>'hot_recom_list',
					'dataProvider'=>$dataProvider,
					'itemView'=>'_view',
					'htmlOptions'=>array("class"=>"record_list_content"),
					//'enablePagination'=>false,
					'summaryCssClass'=>'hide',
					'tagName'=>'div',
					'pager'=>array(
						'class'=>'CLinkPager',//定义要调用的分页器类，默认是CLinkPager，需要完全自定义，还可以重写一个，参考我的另一篇博文：http://blog.sina.com.cn/s/blog_71d4414d0100yu6k.html
						'cssFile'=>false,//定义分页器的要调用的css文件，false为不调用，不调用则需要亲自己css文件里写这些样式
						'header'=>'',//定义的文字将显示在pager的最前面
						//'footer'=>'',//定义的文字将显示在pager的最后面
						'firstPageLabel'=>'首页',//定义首页按钮的显示文字
						'lastPageLabel'=>'尾页',//定义末页按钮的显示文字
						'nextPageLabel'=>'下一页',//定义下一页按钮的显示文字
						'prevPageLabel'=>'前一页',//定义上一页按钮的显示文字
						//关于分页器这个array，具体还有很多属性，可参考CLinkPager的API
					),
					//'template'=>'{items}<ul class="page clearfix">{summary}{pager}</ul>',
				)); ?>
			</div>
			
		</div>
                
		<div class="aside">
			<?php if(!empty($advertise_arrs)){ ?>
                            <a target="_blank" href="<?php echo $advertise_arrs[0]['target_url']; ?>" class="aside_top_ac">
                                <img width="370" height="224" src="<?php echo Yii::app()->request->baseUrl.'/'.$advertise_arrs[0]['logo']; ?>" alt="" title="" />
                            </a>
                        <?php }else{ ?>
                            <a  target="_blank" href="<?php echo Yii::app()->request->baseUrl; ?>" class="aside_top_ac">
                                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/detail_img_07.jpg" alt="" title="" />
                            </a>
                        <?php } ?>
                            <div class="map">
                            </div>
				<div class="bottom">
				<div class="aside_middle_ac" style="width:370px;height:199px;background-image:url('<?php echo Yii::app()->request->baseUrl; ?>/images/detail_img_10.jpg');">
                                        <div id="wx_ewm" onclick="showEwm();" style="width:186px;height:190px; float:right; margin-top:5px;">
                                                <img src="<?php echo Yii::app()->request->baseUrl.$img_wx; ?>" width="185px" height="190px" />
                                        </div>
                                </div>
								
				<div class="aside_tab">
					<ul class="aside_tab_nav clearfix" id='aside_tab_nav'>
						<li><a href="javascript:void(0)">热门活动</a></li>
						<li class='current'><a href="javascript:void(0)">精彩实录</a></li>
					</ul>
					<div class="aside_tab_in">
						<ul class="aside_tab_content hide">
							<?php foreach($hot_arrs as $key=>$val){ ?>
								<li class="clearfix item">
									<a href="<?php echo Yii::app()->request->baseUrl.'/activity/view/id/'.$val[id]; ?>" class="left" target="_blank"><img width="145" height="88" src="<?php echo Yii::app()->request->baseUrl.$val[picture]; ?>" alt="<?php echo $val[title]; ?>" /></a>
									<div class="left">
									<a href="<?php echo Yii::app()->request->baseUrl.'/activity/view/id/'.$val[id]; ?>" target="_blank"><?php echo $val[title]; ?></a>
									<span class='time'><i class="icon"></i><?php echo $val[start_date]; ?></span>
									</div>
								</li>
							<?php } ?>
						</ul>
						<ul class="aside_tab_content">
							<?php foreach($event_arrs as $key=>$val){ ?>
								<li class="clearfix item">
									<a href="<?php echo Yii::app()->request->baseUrl.'/eventlist/view/id/'.$val[event_id]; ?>" class="left" target="_blank"><img width="145" height="88" src="<?php echo Yii::app()->request->baseUrl.$val[logo]; ?>" alt="<?php echo $val[event_title]; ?>" /></a>
									<div class="left">
									<a href="<?php echo Yii::app()->request->baseUrl.'/eventlist/view/id/'.$val[event_id]; ?>" target="_blank"><?php echo $val[event_title]; ?></a>
									<span class='time'><i class="icon"></i><?php echo $val[create_time]; ?></span>
									</div>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class="calendar">
					
				</div>
                            
			</div>
		</div>
                    
</div>