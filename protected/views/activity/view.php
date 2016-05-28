<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/details.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/details.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=TUEdsN3xKIIcXV2WPIy8UG1G"></script><!--该接口为私人接口，请修改-->
<script>
$(function(){
    var bm = <?php if($_GET['bm']) echo $_GET['bm']; else echo 0;  ?>;
    if(bm){
        $('#popBox_tips').show();
    }
    $("#aclist_ab").addClass("current");
})
function ajaxCreate(){
        //$("#contact_valid_form").submit();
        return false;
	name = $("#contact_name").val();
	phone = $("#contact_phone").val();
	email = $("#contact_email").val();
	company = $("#contact_company").val();
	business = $("#contact_duties").val();
	workinglife = $('input:radio[name="Information[workinglife]"]:checked').val();//$("#workingLifeTime").val();
	article_id = $("#Information_article_id").val();
	ticket_id = $("#Information_ticket_id").val();
	if(name){
		$.ajax({
            url:'<?php echo $this->createUrl('/informate/ajaxCreate') ?>',
            data: {
                    'Information[article_id]':article_id,
                    'Information[ticket_id]':ticket_id,
                    'Information[name]':name,
                    'Information[phone]':phone,
                    'Information[email]':email,
                    'Information[company]':company,
                    'Information[business]':business,
                    'Information[workinglife]':workinglife,
            },
            type:"POST",
            dataType:'json',
            success:function(data){
                if(data.message){
                    $('#ac_join_form').hide();
                    $('#popBox_tips').show();
               	}
            }
        });
	}
}
function viewAajaxSendEmail(){
    var email_text = $("#suggest_content").val();
    var article_id = $("#Information_article_id").val();
    $.ajax({
        'type':'POST',
        'data':{
            'article_id':article_id,
            'email_text':email_text,
        },
        'dataType':'json',
        'url':'<?php echo $this->createUrl("/informate/ajaxSendEmail") ?>',
        success:function(data){
            if(data.message){
                alert("发送成功");
                location.reload();
            }
        }
    });
}

</script>
<?php
if($model->user_id){ 
	$user_id = $model->user_id;
	$sql = "SELECT logo,company FROM act_user WHERE user_id = $user_id";
	$datas = Yii::app()->db->createCommand($sql)->queryAll();
	if(empty($datas[0]['logo'])) $datas[0]['logo'] = 'images/com_logo.jpg';
}
?>
<div class="ac_msg clearfix">
		<img src="<?php echo Yii::app()->request->baseUrl.'/'.$model->picture; ?>" alt='<?php echo $model->title; ?>' class='ac_msg_img'>
		<div class="ac_msg_in">
			<h2 class="tit"><?php echo $model->title; ?></h2>
			<div class="ac_time">
                                <i class="icon"></i><?php if($model->delay_date) echo "待定"; else echo $model->start_date.' '.$model->start_time.'～'.$model->end_date.' '.$model->end_time; //2016年3月19日 13:00 ～ 2016年3月19日 18:00?>
			</div>
			<div class="ac_address blue">
				<i class="icon"></i>(<?php echo $model->province.$model->city; ?>)<?php echo $model->address; ?>
			</div>
			<div class="ac_num">
				<i class="icon"></i>限额<?php echo $model->nums; ?>人
			</div>
			<div class="ac_host blue">
                            <i class="icon"></i><img class="apply_logo" alt='<?php echo $model->title; ?>' src="<?php echo Yii::app()->request->baseUrl.'/'.$datas[0]['logo']; ?>" /><?php echo $datas[0]['company']; ?>
			</div>
			<div class="ac_link clearfix">
                                <a href="javascript:void(0)" class='join_btn' <?php $date = date("Y-m-d H:i:s",time()); if( $date < $model->end_date.' '.$model->end_time || $model->delay_date==1){ echo "id='join_btn'"; } else { echo "id='join_btn_non'";} ?> >我要报名</a>
				<div class="ticket-tips hide" id="ticket_select_tips">请选择您要订购的票种。</div>
				<a href="javascript:void(0)" class='touch_host' id='touch_host'>联系主办方</a>
				<div class="share">
					<span class="tit">分享：</span>
					<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
				</div>
			</div>
		</div>
	</div>
	<div class="container clearfix">
		<div class="article">
			<!--活动票种-->
			<div class="ac_tickets">
				<h2 class="tickets_title">活动票种</h2>
				<ul class="tickets_list clearfix" id='tickets_list'>
					<!--如果只有一个，需要默认被选中，请为li添加checked的class-->
					<?php
						//var_dump($model->ticketType->);exit;
                                                $count = count($model->ticketType);
						foreach($model->ticketType as $key=>$val){
					?>
                                        <li class="left <?php if($count == 1){ echo 'checked'; $ticket_id = $val['ticket_id']; } ?>">
						<div class="tickets_list_item">
                                                    <div>
							<?php echo CHtml::hiddenField('item_ticket_id',$val['ticket_id']);?>
							<h4><i class="icon lock_icon"></i>免费</h4>
							<p><?php echo $val['ticket_title'];?></p>
                                                        <i class="icon checked_triangle hide"></i>
                                                    </div>
						</div>
						
                                                <?php if($val['description']){ ?><p class='explain' style='<?php if($count == 1) echo 'display:block'; ?>'>说明：<?php echo $val['description'];?></p><?php } ?>
					</li>
					<?php
						}
					?>
				</ul>
			</div>
			<div class='ac_join_form hide' id='ac_join_form'>
				<h2 class="join_form_title">请填写报名表单</h2>
				<div id="home_join_form">
					<form class="form" id="contact_valid_form" action="<?php echo Yii::app()->request->baseUrl; ?>/informate/ajaxCreate" method="POST">
						<?php echo CHtml::hiddenField('Information[ticket_id]',$ticket_id);?>
						<?php echo CHtml::hiddenField('Information[article_id]',$model->id);?>
						<div class='controls form_valid_error_msg'><div class="alert alert_error" id="form_valid_error_msg"></div></div>
					    <div class="control_group">
						    <label class="control_label">姓名<em class='icon need_icon'></em></label>
						    <div class="controls">
								<input type="text" name="Information[name]" id="contact_name" class="join_form_input required" required='required' >
						    </div>
					    </div>
	                    <div class="control_group">
	                        <label class="control_label">手机号码<em class='icon need_icon'></em></label>
	                        <div class="controls">
	                            <input type="text" name="Information[phone]" minlength='6' maxlength="11" id="contact_phone" class="join_form_input required" required='required'>
	                        </div>
	                    </div>
	                    <div class="control_group">
	                        <label class="control_label">电子邮箱<em class='icon need_icon'></em></label>
	                        <div class="controls">
	                            <input type="text" name="Information[email]" id="contact_email" class="join_form_input required" required='required'>
	                        </div>
	                    </div>
	                    <div class="control_group">
	                        <label class="control_label">所在公司<em class='icon need_icon'></em></label>
	                        <div class="controls">
	                            <input type="text" name="Information[company]" id="contact_company" class="join_form_input required" required='required'>
	                        </div>
	                    </div>
	                    <div class="control_group">
	                        <label class="control_label">所在职务<em class='icon need_icon'></em></label>
	                        <div class="controls">
	                            <input type="text" name="Information[business]" id="contact_duties" class="join_form_input required" required='required'>
	                        </div>
	                    </div>
	                    <div class="control_group block_group radio_list">
	                        <span class="control_label">工作年限<em class='icon need_icon'></em></span>
	                        <div class="controls workingLifeTime radio_list">
	                            <label for="workingLifeTime0"><input type="radio" name="Information[workinglife]" value="无工作年限" id='workingLifeTime' class="icon radio_icon">无工作年限</label>
	                            <label for="workingTime_less3"><input type="radio" name="Information[workinglife]" value="1~3年" id='workingLifeTime' class="icon radio_icon">1~3年</label>
	                            <label for="workingTime_less5"><input type="radio" name="Information[workinglife]" value="3~5年" id='workingLifeTime'class="icon radio_icon">3~5年</label>
	                            <label for="workingTime_less10"><input type="radio" name="Information[workinglife]" value="5~10年" id='workingLifeTime' class="icon radio_icon">5~10年</label>
	                            <label for="workingTime_more10"><input type="radio" name="Information[workinglife]" value="10年以上" id='workingLifeTime' class="icon radio_icon">10年以上</label>
	                        </div>
	                    </div>
                            <?php
                                $string_formItems = SignFormType::model()->getViewSignForm($model->id);
                                if(!empty($string_formItems)) echo $string_formItems;
                            ?>              
	                	
						<div class="form_actions" id='form_actions'>
							<button id="join_submit_btn" type="button" class="btn btn_primary"><i class="icon icon_success"></i>提交</button>
							<a href="javascript:void(0)" class="btn btn_default">取消</a>
						</div>
					</form>
				</div>
			</div>
			<!--活动详细内容-->
			<div class="ac_content">
				<h2 class="content_title">活动内容<a class='toggle_btn' id='toggle_btn' href="javascript:void(0)"><i class='icon icon_up'></i>收起</a></h2>
				<div class="content_in">
					<?php echo $model->contdata?>
				</div><!--content_in结束-->
			</div><!--ac_content结束-->
			<div class="ac_tags">
				<h2 class="ac_tags_tit">活动标签</h2>
				<div class="ac_tags_list">
				<?php foreach($label_arrs as $key=>$val){ ?>
					<a href="<?php echo Yii::app()->request->baseUrl.'/?tag_id='.$val[tag_id]; ?>" class="item" target="_blank"><?php echo $val[tag_name]; ?></a>
				<?php } ?>
				</div>
			</div>
			<div class="ac_recommend">
				<h2 class="ac_recommend_tit">更多推荐</h2>
				<ul class="ac_recommend_list" style="width:810px;">
					<?php foreach($position_arrs as $key=>$val){ ?>
						<li class="item"><a href="<?php echo Yii::app()->request->baseUrl.'/activity/view/id/'.$val[id]; ?>" target="_blank"><img width="248" height="150" src="<?php echo Yii::app()->request->baseUrl.'/'.$val[picture]; ?>" alt="<?php echo $val[title]; ?>" /><h3><?php echo $val[title]; ?></h3></a></li>
					<?php } ?>
				</ul>
			</div>
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
<!--							<li><a href="javascript:void(0)">活跃主办方</a></li>-->
						</ul>
						<div class="aside_tab_in">
							<!--第一个默认显示外其余的隐藏-->
							<ul class="aside_tab_content hide">
								<?php foreach($hot_arrs as $key=>$val){ ?>
									<li class="clearfix item">
										<a href="<?php echo Yii::app()->request->baseUrl.'/activity/view/id/'.$val[id] ?>" class="left" target="_blank"><img width="145" height="88" src="<?php echo Yii::app()->request->baseUrl.'/'.$val[picture]; ?>" alt="<?php echo $val[title]; ?>" /></a>
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
<!--							<ul class="aside_tab_content hide">
								<?php foreach($company_arrs as $key=>$val){ ?>
									<li class="clearfix item">
										<a href="#" class="left" target="_blank"><img width="145" height="88" src="<?php echo Yii::app()->request->baseUrl.'/'.$val[logo]; ?>" alt="<?php echo $val[company]; ?>" /></a>
										<div class="left">
										<a href="#" target="_blank"><?php echo $val[company]; ?></a>
										<span class='time'><i class="icon"></i><?php echo $val[create_time]; ?></span>
										</div>
									</li>
								<?php } ?>
							</ul>-->
						</div>
					</div>
					<!--日历-->
					<div class="calendar">
						
					</div>
                            </div>
                </div>
	</div>
	<div class="popBox hide" id='popBox_tips'>
		<div class="shadeBox"></div>
		<div class="popBox_content">
			<a href="javascript:void(0)" class="close_btn icon">关闭</a>
			<h4 class="popBox_title"><i class='icon success_icon'></i><span id='tips_msg'>您已报名参加<?php echo $model->title; ?>，请耐心等待审核。<span></h4>
		</div>
	</div>
	<div class="popBox hide" id='popBox_host'>
		<div class="shadeBox"></div>
		<div class="popBox_content">
			<a href="javascript:void(0)" class="close_btn icon">关闭</a>
			<h4 class="popBox_title">联系主办方</h4>
			<div class="popBox_body">
				<form class="clearfix" action="" id='suggest_form'>
					<textarea placeholder='请输入您要发送的信息，并注明您的联系方式（邮箱／电话）' required='required' rows='4' id='suggest_content'></textarea>
					<em class='warning'></em>
					<div class="btn_right right">
						<button class='quick_btn'>取消</button>
						<button class='send_btn'>发送</button>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<div class="popBox hide" id='popBox_share'>
		<div class="shadeBox"></div>
		<div class="popBox_content">
			<a href="javascript:void(0)" class="close_btn icon">关闭</a>
			<h4 class="popBox_title">分享到微信朋友圈</h4>
			<div class="popBox_body">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/wx.png" alt="分享二维码" />
			</div>
			<p class="text">
				打开微信，点击底部的“发现”，使用“扫一扫即可将网页分享到我的朋友圈
			</p>
		</div>
	</div>