<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/details.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/details.js"></script>
<script>
$(function(){
    $("#eventlist_ac").addClass("current");
})
</script>
<div class="container clearfix record_artical_container">
		<div class="crumbs record_artical_crumbs"><a class='crumbs_nav_item' href='javascript:viod(0)'>活动实录</a> | <em class='blue'>正文</em></div>
		<div class="article">
			<!--详细内容-->
			<div class="article_title">
				<h2 class="title"><?php echo $model->event_title; ?></h2>
				<div class="article_meta clearfix" >
					<div class="left">
						作者: <em><?php echo $model->event_author; ?></em>
					</div>
					<div class="right">
					<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
					</div>
					<div class="right" style="margin-right:50px;">
						<i class="icon grey_clock_icon"></i><?php echo $model->create_time; ?>
					</div>
					
				</div>
			</div>
			<div class="article_content">
					<?php echo $model->contdata; ?>
			</div><!--ac_content结束-->
		</div><!--article结束-->
                
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
									<a href="<?php echo Yii::app()->request->baseUrl.'/activity/view/id/'.$val[id]; ?>" class="left" target="_blank"><img width="145" height="88" src="<?php echo Yii::app()->request->baseUrl.'/'.$val[picture]; ?>" alt="<?php echo $val[title]; ?>" /></a>
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
									<a href="<?php echo Yii::app()->request->baseUrl.'/eventlist/view/id/'.$val[event_id]; ?>" class="left" target="_blank"><img width="145" height="88" src="<?php echo Yii::app()->request->baseUrl.'/'.$val[logo]; ?>" alt="<?php echo $val[event_title]; ?>" /></a>
									<div class="left">
									<a href="<?php echo Yii::app()->request->baseUrl.'/eventlist/view/id/'.$val[event_id]; ?>" target="_blank"><?php echo $val[event_title]; ?></a>
									<span class='time'><i class="icon"></i><?php echo $val[create_time]; ?></span>
									</div>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
                    </div>
	</div>