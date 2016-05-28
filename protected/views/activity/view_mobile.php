<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile/details_a.css" />
<?php
if($model->user_id){ 
	$user_id = $model->user_id;
	$sql = "SELECT logo,company FROM act_user WHERE user_id = $user_id";
	$datas = Yii::app()->db->createCommand($sql)->queryAll();
	if(empty($datas[0]['logo'])) $datas[0]['logo'] = 'images/com_logo.jpg';
}
?>
<script>
$(function(){
    var bm = <?php if($_GET['bm']) echo $_GET['bm']; else echo 0;  ?>;
    if(bm){
        alert("您已报名，请等待审核！");
        var string = window.location.href;
        var urls = string.split('?')[0];
        window.location = urls;
    }
    $("#aclist_ab").addClass("current");
})
function ajaxSendEmail(){
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
<section class="event_msg">
        <img src="<?php echo Yii::app()->request->baseUrl.'/'.$model->picture; ?>" alt='<?php echo $model->title; ?>' class='details_banner'>
        <h2 class='event_title'><?php echo $model->title; ?></h2>
        <div class="event_host">
                <a href="javascript:void(0)" class='host_name'><img class="apply_logo" alt='<?php echo $model->title; ?>' src="<?php echo Yii::app()->request->baseUrl.'/'.$datas[0]['logo']; ?>" /><?php echo $datas[0]['company']; ?></a><!--alt值根据实际情况变动-->
                <a href="javascript:void(0)" class='btn' id='touch_host'>联系主办方</a>
        </div>
        <div class="event_info">
                <div class="event_time">
                        <i class='icon clock_icon'></i>
                        <span><?php if($model->delay_date) echo "待定"; else echo $model->start_date.' '.$model->start_time.'～'.$model->end_date.' '.$model->end_time; //2016年3月19日 13:00 ～ 2016年3月19日 18:00?></span>
                </div>
                <div class="event_address">
                        <i class='icon address_icon'></i>
                        <span>(<?php echo $model->province.$model->city; ?>)<?php echo $model->address; ?></span>
                </div>
                <div class="event_people">
                        <i class='icon people_icon'></i>
                        <span>限额<?php echo $model->nums; ?>人</span>
                </div>
        </div>
</section>
<section>
    <div id="event_content" class='event_content article_content'>
                <?php echo $model->contdata; ?>
    </div>
</section>
<section class="aside">
    <?php if(!empty($advertise_arrs)){ ?>
        <a target="_blank" href="<?php echo $advertise_arrs[0]['target_url']; ?>" class="aside_top_ac">
            <img src="<?php echo Yii::app()->request->baseUrl.'/'.$advertise_arrs[0]['logo']; ?>" alt="" title="" />
        </a>
    <?php }else{ ?>
        <a  target="_blank" href="<?php echo Yii::app()->request->baseUrl; ?>" class="aside_top_ac">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/detail_img_07.jpg" alt="" title="" />
        </a>
    <?php } ?>
</section>
<?php $date = date("Y-m-d H:i:s",time()); if( $date < $model->end_date.' '.$model->end_time || $model->delay_date==1){ ?>
<footer class='fixed_bar clearfix'>
        <a href='javascript:void(0)' class='long_btn' id='join_btn'>立即参加</a>
</footer>
<?php } else { ?>
<footer class='fixed_bar clearfix'>
        <a href='javascript:void(0)' class='long_btn' id='join_btn_non'>立即参加</a>
</footer>
<?php } ?>
<section id='ticketBox' class='popBox ticketBox'>
        <div class="shadeBox"></div>
        <div class="pop_content">
                <a href="javascript:void(0)" class="close_btn icon">关闭</a>
                <h4 class="popBox_title">选择票券</h4>
                <div class="media clearfix">
                                <img src="<?php echo Yii::app()->request->baseUrl.'/'.$model->picture; ?>" alt="<?php echo $model->title; ?>" class="left">
                                <div class="media_body">
                                        <h5 class='media_title'><?php echo $model->title; ?></h5>
                                        <div class='media_time'><?php if($model->delay_date) echo "待定"; else echo $model->start_date.' '.$model->start_time.'～'.$model->end_date.' '.$model->end_time; //2016年3月19日 13:00 ～ 2016年3月19日 18:00?></div>
                                </div>
                </div>
                <div class="pop_body">
                        <div id="ac_tickets" class='ac_tickets'>
                                <ul class='tickets_list' id='tickets_list'>
                                        <!--初始化规则与pc端一致，若有多个li，均不选中，只有一个li时默认选择-->
                                        <?php
						//var_dump($model->ticketType->);exit;
                                                $count = count($model->ticketType);
						foreach($model->ticketType as $key=>$val){
					?>
                                        <li class="<?php if($count == 1) { echo 'checked';  $ticket_id = $val['ticket_id']; } ?>">
						<div class="tickets_list_item">
                                                    <div>
							<?php echo CHtml::hiddenField('item_ticket_id',$val['ticket_id']);?>
							<em><i class="icon lock_icon"></i>免费</em>
							<span class='tips_1'><?php echo $val['ticket_title'];?></span>
                                                    </div>
                                                    <?php if($val['description']){ ?><p class='explain' style='<?php if($count == 1) echo 'display:block'; ?>'>说明：<?php echo $val['description'];?></p><?php } ?>
                                                    <i class="icon checked_triangle hide"></i>
						</div>
					</li>
					<?php
						}
					?>
                                </ul>
                        </div>
                </div>
                <a href='javascript:void(0)' class='btn long_btn' id='join_ok_btn'>确定</a>
        </div>
</section>
<!--填写报名表单，点击报名确定时如果没有填写信息弹出-->
<section id='join_form' class='join_form' style='display:none'>
        <header class='join_form_header'>
                <a href="javascript:void(0)" class="back"><img src='<?php echo Yii::app()->request->baseUrl; ?>/images/back_icon.png' alt='返回上一级按钮'/></a>
                <h2 style='height:50px;line-height:50px;text-align:center;color:#fff;font-size:22px;background:#2d6ac8;'>报名表单</h2>
        </header>
        <div class="pop_content">
                <div class="pop_body">
                <div id="home_join_form">
                <form class="form" id="contact_valid_form" action="<?php echo Yii::app()->request->baseUrl; ?>/informate/ajaxCreate" method="POST">
                        <?php echo CHtml::hiddenField('Information[ticket_id]',$ticket_id);?>
                        <?php echo CHtml::hiddenField('Information[article_id]',$model->id);?>
                        <div class="controls form_valid_error_msg">
                                <div class="alert alert_error" id="form_valid_error_msg"></div>
                        </div>
                    <div class="control_group">
                            <label class="control_label">姓名<em class="icon need_icon"></em></label>
                            <div class="controls">
                                        <input type="text" name="Information[name]" id="contact_name" class="join_form_input required" required="required">
                            </div>
                    </div>
                    <div class="control_group">
                        <label class="control_label">手机号码<em class="icon need_icon"></em></label>
                        <div class="controls">
                            <input type="text" name="Information[phone]" minlength="6" maxlength="11" id="contact_phone" class="join_form_input required" required="required">
                        </div>
                    </div>
                    <div class="control_group">
                        <label class="control_label">电子邮箱<em class="icon need_icon"></em></label>
                        <div class="controls">
                            <input type="text" name="Information[email]" id="contact_email" class="join_form_input required" required="required">
                        </div>
                    </div>
                    <div class="control_group">
                        <label class="control_label">所在公司<em class="icon need_icon"></em></label>
                        <div class="controls">
                            <input type="text" name="Information[company]" id="contact_company" class="join_form_input required" required="required">
                        </div>
                    </div>
                    <div class="control_group">
                        <label class="control_label">所在职务<em class="icon need_icon"></em></label>
                        <div class="controls">
                            <input type="text" name="Information[business]" id="contact_duties" class="join_form_input required" required="required">
                        </div>
                    </div>
                    <div class="control_group radio_group">
                        <span class="control_label">工作年限<em class="icon need_icon"></em></span>
                        <div class="controls workingLifeTime radio_list">
                            <label for="workingLifeTime0"><input type="radio" name="Information[workinglife]" value="无工作年限" id="workingLifeTime" class="icon radio_icon">无工作年限</label>
                            <label for="workingTime_less3"><input type="radio" name="Information[workinglife]" value="1~3年" id="workingLifeTime" class="icon radio_icon">1~3年</label>
                            <label for="workingTime_less5"><input type="radio" name="Information[workinglife]" value="3~5年" id="workingLifeTime" class="icon radio_icon">3~5年</label>
                            <label for="workingTime_less10"><input type="radio" name="Information[workinglife]" value="5~10年" id="workingLifeTime" class="icon radio_icon">5~10年</label>
                            <label for="workingTime_more10"><input type="radio" name="Information[workinglife]" value="10年以上" id="workingLifeTime" class="icon radio_icon">10年以上</label>
                        </div>
                    </div>
                    <!--用户可能选择的多选框-->
                    <?php
                        $string_formItems = SignFormType::model()->getViewSignForm($model->id);
                        if(!empty($string_formItems)) echo $string_formItems;
                    ?>
                    </form>
            </div>
            </div>
            <div class="form_actions clearfix" id="form_actions">
                    <a id="join_submit_btn" class="btn short_btn">提交</a>
                    <a href="javascript:void(0)" class="btn default_btn">取消</a>
            </div>
        </div>
</section>
<section id='contact_host' class='popBox contact_host'>
        <div class="shadeBox"></div>
        <div class="pop_content">
                <a href="javascript:void(0)" class="close_btn icon">关闭</a>
                <h4 class="popBox_title">联系主办方</h4>
                <div class="pop_body">
                        <form class="clearfix" action="" id="suggest_form">
                                <textarea placeholder="请输入您要发送的信息，并注明您的联系方式（邮箱／电话）" required="required" rows="4" id="suggest_content"></textarea>
                                <em class="warning"></em>
                                <div class="btn_right clearfix">
                                        <a href='javascript:void(0)' class="btn short_btn">发送</a>
                                        <a href='javascript:void(0)' class="btn default_btn">取消</a>
                                </div>
                        </form>
                </div>
        </div>
</section>

<script type="text/javascript" src='<?php echo Yii::app()->request->baseUrl; ?>/js/other/details.js'></script>
