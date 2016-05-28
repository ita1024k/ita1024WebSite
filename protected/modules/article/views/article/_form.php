<?php
?>
<div class="container">
    <div class="creat_body">
        <div class="creat_label">填写基本信息</div>
        <?php 
		$form=$this->beginWidget('CActiveForm', array(
				'id' => 'ac_base_form',
				'enableAjaxValidation' => false,
				'enableClientValidation' => true,
				'clientOptions' => array('validateOnSubmit' => true),
				'htmlOptions'=>array('enctype'=>'multipart/form-data','class'=>'ac_creat_form', 'novalidate'=>'novalidate'),
		));
			?>
		<?php //echo $form->errorSummary($model); ?>
		<div class="form_group record_name clearfix">
					<label for='ac_address' class="place_label ac_label">填写名称<em class='icon need_icon'></em></label>
			<?php echo $form->textField($model,'title',array("class"=>'form_control',"placeholder"=>'请在这里输入标题',"maxlength"=>'100',"required"=>'required')); ?>
		</div>
			<div class="form_group ac_place clearfix">
				<label for='ac_address' class="place_label ac_label">选择地点<em class='icon need_icon'></em></label>
				<div class='form_control_all clearfix'>
					<select id="select_province" name="Article[province]" class='select_province form_control'>
						<!--以下option为请求加载，初始化没有-->
						<option <?php if(!$model->province) echo 'selected="selected"'; ?> >省份/直辖市</option>
						<?php 
							foreach($ar_province as $key=>$val){ 
								if($val == $model->province) {
									echo '<option value="'.$val.'" selected="selected" >'.$val.'</option>';
								}else{
									echo '<option value="'.$val.'">'.$val.'</option>';
								}
							}
						?>
					</select>
					<select id="select_city"  name="Article[city]" class='form_control'>
						<!--以下option为请求加载，初始化没有-->
						<option <?php if(!$model->city) echo 'selected="selected"'; ?> >请先选择省份/直辖市</option>
						<?php if($model->city) echo '<option value="'.$model->city.'" selected="selected">'.$model->city.'</option>'; ?>
					</select>
					<input id="City" name="City" type="hidden" value="<?php $model->city ?>" />
					<input id="Setting_Province" name="Setting.Province" type="hidden" value="<?php $model->province ?>" />
					<input id="Location" name="Location" type="hidden" value="" />
					<?php echo $form->textField($model,'address',array("class"=>'form_control ac_reate_place_input',"placeholder"=>'例如：北京市海淀区中关村南大街',"maxlength"=>'100',"required"=>'required')); ?>
				</div>
			</div>
			<script type="text/javascript">
			$(function(){
				$('#select_province').selectpicker();
				$('#select_city').selectpicker();
				$('#event_start_time').selectpicker();
				$('#event_end_time').selectpicker();
				$('.btn.selectpicker').on('click',function(){
					var _this = $(this);
					var _this_bootstrap_select = _this.parents('.bootstrap-select');
					var _this_dropdown_menu = $(this).next();
					//如果是打开状态
					if(_this_bootstrap_select.hasClass('open')){
						_this_bootstrap_select.removeClass('open');
						_this_dropdown_menu.hide();
					//如果是关闭状态
					}else{
						if(_this.attr('data-id')=='select_city'){
							var province_choose = _this_bootstrap_select.prev().prev().find('.filter-option').text();

							if(province_choose=='省份/直辖市'){
								_this_dropdown_menu.find('li').eq(0).show().siblings().hide();
								
							}else{
								_this_dropdown_menu.find('li').eq(0).hide().siblings().show();
							}
						}
						_this_dropdown_menu.show();
						_this_bootstrap_select.addClass('open').siblings('.bootstrap-select').removeClass('open').find('.dropdown-menu').hide();
						
					}
				})
				$('ul.inner.selectpicker').on('click','li',function(){
					var _this = $(this);
					var text = _this.find('span.text').text();
					var next_bootstrap_select = _this.parents('.bootstrap-select').next().next();
					if(text=='省份/直辖市'){
						next_bootstrap_select.find('.filter-option').text('请先选择省份/直辖市');
						next_bootstrap_select.find('.dropdown-menu').find('li').eq(0).show();
					}else{
						if(_this.parents('.dropdown-menu').prev().attr('data-id')=='select_province'){
							showCity(text,next_bootstrap_select);
							var that_text = next_bootstrap_select.find('.dropdown-menu').find('li').eq(1).text();
							next_bootstrap_select.find('.filter-option').text(that_text);
						}
					}
					_this.parents('.bootstrap-select').removeClass('open').find('.dropdown-menu').hide();
				})
			})
			function showCity(text,next_bootstrap_select){
				$.ajax({
					url:'<?php echo $this->createUrl('/article/article/showCity'); ?>',
					data: {
						city:text,
					},
					type:"POST",
					dataType:'json',
					success:function(data){
						if(data.string1){
							$("#select_city").html(data.string1);
						}
						if(data.string2){
							next_bootstrap_select.find('.filter-option').text('请先选择省份/直辖市');
							next_bootstrap_select.find('.dropdown-menu .selectpicker').html(data.string2);
						}
					}
				});
			}
			</script>
			<!--活动时间-->
			<div class="form_group place_date clearfix">
				<label class="ac_label">活动时间<em class='icon need_icon'></em></label>
				<div class="form_control_all">
					<div class="delay_date ac_radio">
						<label for='delay_date'>
								<?php echo $form->checkBox($model,'delay_date',array("id"=>"delay_date","class"=>'delay_date_check radio_icon icon')); ?>待定
						</label>
					</div>
					<div class="form_date">
							<div class="start_date left">
									<div class='tit'>开始时间：</div>
									<div class="date_content">
											<i class="icon icon_calendar"></i>
											<?php 
												$this->widget('zii.widgets.jui.CJuiDatePicker', array(
													//'name'=>'publishDate',
													'model'=>$model,  
													'attribute'=>'start_date',
													'options'=>array(
														//'showAnim'=>'fold',
														'dateFormat'=>'yy-mm-dd',
														'mode'=>'datetime',
													),
													'htmlOptions'=>array(
														"class"=>"form_control"
													),
												));
											?>
											
											<i class="icon icon_clock"></i>
											<select id="event_start_time" name="Article[start_time]" class='ac_time form_control selectpicker' data-size="9">
												<?php
													$this->renderPartial('__options_time');
												?>
											</select>
									</div>
							</div>
							<span class="icon icon_big_arrow left"></span>
							<div class="end_date left">
									<div class='tit'>结束时间：</div>
									<div class="date_content">
											<i class="icon icon_calendar"></i>
											<?php 
												$this->widget('zii.widgets.jui.CJuiDatePicker', array(
													//'name'=>'publishDate',
													'model'=>$model,  
													'attribute'=>'end_date',
													'options'=>array(
														//'showAnim'=>'fold',
														'dateFormat'=>'yy-mm-dd',
														'mode'=>'datetime',
													),
													'htmlOptions'=>array(
														"class"=>"form_control"
													),
												));
											?>
											<i class="icon icon_clock"></i>
											<select id="event_end_time" name="Article[end_time]" class='ac_time form_control'>
													<?php
														$this->renderPartial('__options_time');
													?>
											</select>
									</div>
							</div>
					</div>
				</div>
			</div>
		<div class="form_group clearfix">
				<label for="" class='record_label'>上传封面</label>
				<div id="record_poster" class='record_poster clearfix'>
						<div class="left poster_preview" id='poster_preview'>
								<img src="<?php if($model->picture) echo Yii::app()->request->baseUrl.'/'.$model->picture; else echo Yii::app()->request->baseUrl."/images/upLoad_img.jpg";  ?>" alt="" id="logo_image" class="logo_image" alt='海报' />
						</div>
						<div class="left media_body">
								<div class="tips">一张漂亮的封面，能让你的文章锦上添花，带来更多用户报名 
	及增加传播效果</div>
								<div id='poster_error_msg' class='alert alert_error'></div>
								<div class="btn_upload">
										<i class="icon upload_icon"></i>
										<span>上传</span>
										<?php
												echo CHtml::activeFileField($model,'picture',array("id"=>"poster_input",'accept'=>"image/*"));
										?>
										<input type="hidden" name="hidLogo" value="<?php echo $model->picture; ?>">
								</div>
						</div>
				</div>
			</div>
			<div class="form_group">
					<label for='ac_address' class="place_label ac_label">活动人数<em class='icon need_icon'></em></label>
			<?php echo $form->textField($model,'nums',array("class"=>'form_control',"placeholder"=>'请在这里人数',"maxlength"=>'100',"required"=>'required')); ?>
		</div>
			<!--添加标签-->
			<div class="form_group">
			   <label class="control_label ac_label">添加标签</label>
			   <div class="ac_add_label clearfix">
				   <button type="button" class="ac_add_label_btn" id='ac_add_label_btn'><span class="icon icon_ac_add"></span></button>
				   <div class="ac_add_label_list">
					   <ul>
					   
							<?php if($tag_arrs_chose){ foreach ($tag_arrs_chose as $key=>$val){ ?>
								<li id="a<?php echo $val['tag_id']; ?>" rel="<?php echo $val['tag_id']; ?>"><?php echo $val['tag_name']; ?><i class="icon-close" onclick="delIndexLabel('<?php echo $val['tag_id']; ?>')"></i></li>
							<?php }} ?>
					   </ul>
					   <span class="ac_add_label_tips" style='display:none' title="添加合适的标签有利于用户在站内、站外发现您的活动， 最多添加五个标签">最多添加五个标签</span>
				   </div>
				   <div class="ac_add_label_modal hide">
					   <ul>
							<?php foreach ($tag_arrs as $key=>$val){ ?>
								<li id="ma<?php echo $val['tag_id']; ?>" rel="<?php echo $val['tag_id']; ?>"><?php echo $val['tag_name']; ?></li>
							<?php } ?>
						</ul>
					</div>
					<?php echo $form->hiddenField($model,'label');?>
				</div>
			</div>
			<!--隐私设置-->
			<div class="form_group">
				<label for="ac_privacy" class="control_label ac_label ac_privacy_label">隐私设置</label>
				<div class="ac_radio ac_privacy_radio">
					<label><?php echo $form->checkBox($model,'support',array("class"=>'radio_icon icon')); ?>设为私密活动</label>
					<span class="text_muted"> 本活动为内部活动，将不会在【中国互联网技术联盟】网站公开展示。</span>
				</div>
			</div> 
		<div class='form_group clearfix'>
				<label for="" class='details_label record_label'>详细内容<em class='icon need_icon'></em></label>
				<div class='form_control editor_box'>
					<!--此处放置文本编辑器,此处我下载的utf-8版本，如果需修改，请重新下载-->
					<?php echo $form->textarea($model,'contdata',array("id"=>"EventBaseDescription","placeholder"=>"请填写活动内容","style"=>"height:400px;width:1040px;z-index；1","required"=>'required'));?>
				</div>
		</div>
		<input type="hidden" name="Article[status]" id="Article_status" value="<?php echo $model->status; ?>">
		<?php $this->endWidget(); ?>
	</div>
    <div class="creat_body ac_add_item ac_add_item_short">
		<div class="creat_label">设置报名表单</div>
		<div class="text_muted"><i class="icon icon_add_primary"></i>如果您需要收集报名者的必要信息，可<em class="blue" style='font-weight:bold'>添加</em>此项设置</div>
	</div>
	
	<div class="creat_body ac_add_item hide">
		<div class="creat_label">设置报名表单</div>
		<form action="<?php echo $this->createUrl('/signForm/signForm/create'); ?>" id="ac_template_form" method="post">
		<div id="edit_template_items" class="ac_sign_form left">
				<fieldset>
					<input type="hidden" name="activityId" value="<?php echo $id; ?>" />
					<input type="hidden" name="version" value="1" />
					<input type="hidden" id="template_form_sort_max" name="sortmax" value="0" />
					<h3>联系方式<em>（报名用户注册资料，必填）</em></h3>
					<div id="ac_template_form_contact" class="ac_sign_required">
						<div class="form_group">
							<label><input type="checkbox" checked="checked" disabled="disabled" class='icon square_icon_checked'>必填</label>
							<span>姓名</span>
							<input type="text" class="form_control" placeholder="报名用户的姓名或昵称"  value='' disabled="disabled" style='margin-left:-5px;'>
						</div>
						<div class="form_group">
							<label><input type="checkbox" checked="checked" disabled="disabled" class='icon square_icon_checked'>必填</label>
							<span>手机号码</span><input type="text" class="form_control" placeholder="报名用户的手机号码"  value='' disabled="disabled">
						</div>
						<div class="form_group">
							<label><input type="checkbox" checked="checked" disabled="disabled" class='icon square_icon_checked'>必填</label>
							<span>电子邮箱</span><input type="text" class="form_control" placeholder="报名用户的电子邮箱" value='' disabled="disabled">
						</div>
						<div class="form_group">
							<label><input type="checkbox" checked="checked" disabled="disabled" class='icon square_icon_checked'>必填</label>
							<span>所在公司</span><input type="text" class="form_control" placeholder="报名用户的电子邮箱"  value='' disabled="disabled">
						</div>
						<div class="form_group">
							<label><input type="checkbox" checked="checked" disabled="disabled" class='icon square_icon_checked'>必填</label>
							<span>所在职务</span><input type="text" class="form_control" placeholder="报名用户的电子邮箱"  value='' disabled="disabled">
						</div>
						<div class="form_group">
							<label><input type="checkbox" checked="checked" disabled="disabled" class='icon square_icon_checked'>必填</label>
							<span>工作年限</span><input type="text" class="form_control" placeholder="报名用户的电子邮箱"  value='' disabled="disabled">
						</div>
					</div>
					<h3>其他</h3>
					<!--如果没有自定义的话显示p-->
<?php
    if($model->isNewRecord){
            $string = SignFormType::model()->getSignForm(0);
    }else{
            $string = SignFormType::model()->getSignForm($id);
    }
?>
					<?php if(empty($string)){ ?><p style="font-size:14px;padding:5px 15px;color:gray;" id='ac_template_form_tips'>未添加其他栏位（即不需要报名/购票人提供额外信息）。</p><?php } ?>
					<!--用户选择右侧内容,初始化为空-->

					<div id="ac_template_form_items" class='ac_template_form_items'>
                                            <?php
                                                    echo $string;
                                            ?>
					</div>
					<div class="form_actions submit_btn">
						<button href="#" class="btn btn_primary" onclick="javascript:saveEventForm(null);return false;">
							<i class="icon icon_success"></i>保存
						</button>						
						<button href="#" class="btn btn_default" onclick="javascript:reviewEventFormView();return false;">
							<i class="icon-play"></i>预览
						</button>
					</div>
				</fieldset>
		</div>
		</form>
		<div class="aside" id="edit_template_tools">
			<div class="ac_create_sign_form_custom">
						<h3>自定义栏位</h3>
						<button type="button" class="btn" onclick="javascript:addEventFormEmptyItem(0);return false;">
							<i class="icon icon_btn_add"></i>
							<span>单行文本框</span>
						</button>
						<button type="button" class="btn" onclick="javascript:addEventFormEmptyItem(1);return false;">
							<i class="icon icon_btn_add"></i>
							<span>多行文本框</span>
						</button>
						<button type="button" class="btn" onclick="javascript:addEventFormEmptyItem(2);return false;">
							<i class="icon icon_btn_add"></i>
							<span>单选按钮框</span><span class="icon-btn-add"></span>
						</button>
						<button type="button" class="btn" onclick="javascript:addEventFormEmptyItem(3);return false;">
							<i class="icon icon_btn_add"></i>
							<span>多选按钮框</span>
						</button>
			</div>
		</div>
		<div class="clear text_center">
			<button class="btn" type="button" id="ac_toggle"><span class="icon icon_top_arrow"></span>收起表单</button>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/accupass.form.js"></script>
	<div class="creat_body">
		<div class="creat_label">
			设置售票
		</div>
		<?php if($model->isNewRecord && !TicketType::model()->getTicket($id)){ ?>
                    <span class="right" style="padding: 15px 10px 0px;color:gray;position:relative;margin-top:-50px;" id="ac_ticket_alert_msg">目前还没有添加任何票种，请至少添加一个票种。</span>
		<?php } ?>
                <div class="ac_creat_form clearfix">
        	<div class="form_group">
            <?php
                    $this->renderPartial('__set_ticket',array('model'=>$model,'id'=>$id));
            ?>
            </div>
		</div>
	</div>
	<div class="submit_btn">
		<button class="btn btn_primary" id='creat_submit_btn_ac'><i class="icon icon_success"></i>发布</button>
		<!--<a class="btn btn_default" href='details.html' target="_blank">预览</a>-->
		<a class="btn btn_default" id='creat_submit_btn_ac_1'>保存草稿</a>
	</div>
</div>

<!--弹窗错误提示，提交按钮时请用这个错误提示-->
<div class='popBox hide' id='popBox_warning'>
	<div class="popBox_content">
		<h4 class="popBox_title"><i class="icon warning_icon"></i><span id='pop_message_content'></span></h4>
	</div>
</div>
<!--用户自定义预览提示 预览活动表单-->
<div id="popBox_Userview" class="popBox hide">
	<div class="shadeBox"></div>
	<div class="popBox_content">
		<div class="popBox_header">
			<a href="javascript:void(0)" class="close_btn icon">关闭</a>
			<h4 class="popBox_title">预览活动表单</h4>
		</div>
		<div class="popBox_body">
				<div class="page_header" >
					<span class="header_label">必填内容</span>
					<div class="page_header_line"></div>
				</div>
				<div style="padding-left:30px;">
					<div class="control_group">
						<label class="control_label">姓名<i class='icon need_icon'></i></label>
						<div class="controls">
							<input type="text" class="required disabled" disabled="disabled" value="">
						</div>
					</div>
					<div class="control-group">
						<label class="control_label">手机号码<i class='icon need_icon'></i></label>
						<div class="controls">
							<input type="text" class="required disabled " disabled="disabled" value="">
						</div>
					</div>
					<div class="control_group">
						<label class="control_label">电子邮箱<i class='icon need_icon'></i></label>
						<div class="controls">
							<input type="text" class="required disabled" disabled="disabled" value="">
						</div>
					</div>
					<div class="control_group">
						<label class="control_label">所在公司<i class='icon need_icon'></i></label>
						<div class="controls">
							<input type="text" class="required disabled" disabled="disabled" value="">
						</div>
					</div>
					<div class="control_group">
						<label class="control_label">所在职务<i class='icon need_icon'></i></label>
						<div class="controls">
							<input type="text" class="required disabled" disabled="disabled" value="">
						</div>
					</div>
					<div class="control_group">
						<label class="control_label">工作年限<i class='icon need_icon'></i></label>
						<div class="controls workingLifeTime">
							<label for="workingLifeTime0"><input type="radio" name="workingLifeTime" value="无工作年限" id="workingLifeTime0" class="icon radio_icon">无工作年限</label>
							<label for="workingTime_less3"><input type="radio" name="workingLifeTime" value="1~3年" id="workingTime_less3" class="icon radio_icon">1~3年</label>
							<label for="workingTime_less5"><input type="radio" name="workingLifeTime" value="3~5年" id="workingTime_less5" class="icon radio_icon">3~5年</label>
							<label for="workingTime_less10"><input type="radio" name="workingLifeTime" value="5~10年" id="workingTime_less10" class="icon radio_icon">5~10年</label>
							<label for="workingTime_more10"><input type="radio" name="workingLifeTime" value="10年以上" id="workingTime_more10" class="icon radio_icon">10年以上</label>
						</div>
					</div>
				</div>
				<div class="page_header" style="margin-top:20px;">
					<span class="header_label">其他</span>
					<div class="page_header_line"></div>
				</div>
				<fieldset id="ac_template_form_fields" style="padding-left:30px;">
				</fieldset>
		</div>
		<div class="modal_footer submit_btn">
			<a href="#" class="btn btn_default close_btn" data-dismiss="modal">关闭</a>
		</div>
	</div>
</div>
<!--发布成功提示-->
	<div class="popBox hide" id="popBox_tips">
		<div class="shadeBox"></div>
		<div class="popBox_content">
			<a href="javascript:void(0)" class="close_btn icon">关闭</a>
			<h4 class="popBox_title"><i class="icon success_icon"></i><span id='tips_msg'></span></h4>
		</div>
	</div>
<?php
    if($model->isNewRecord){
            $arr_formItemsJson = SignFormType::model()->getJsSignForm(0);
    }else{
            $arr_formItemsJson = SignFormType::model()->getJsSignForm($id);
    }
?>
<script type='text/javascript'>
    var formEmptyItems = [{"Key":"I_0","Sort":0,"Type":"input","Category":"CUSTOM","IsDefault":false,"Required":false,"Multiple":false,"Title":"","Subitems":[],"Description":null,"IsHide":false,"Value":null,"TypeTitle":"单行文本框"},{"Key":"I_0","Sort":0,"Type":"textarea","Category":"CUSTOM","IsDefault":false,"Required":false,"Multiple":false,"Title":"","Subitems":[],"Description":null,"IsHide":false,"Value":null,"TypeTitle":"多行文本框"},{"Key":"I_0","Sort":0,"Type":"radio","Category":"CUSTOM","IsDefault":false,"Required":false,"Multiple":false,"Title":"","Subitems":[],"Description":null,"IsHide":false,"Value":null,"TypeTitle":"单选按钮框"},{"Key":"I_0","Sort":0,"Type":"checkbox","Category":"CUSTOM","IsDefault":false,"Required":false,"Multiple":false,"Title":"","Subitems":[],"Description":null,"IsHide":false,"Value":null,"TypeTitle":"多选按钮框"}];
    var slist = '<?php echo urlencode(json_encode($arr_formItemsJson));?>';
    var list = eval(decodeURIComponent(slist));
    var formItemsJson = new Array();
    if(list.length != 0) formItemsJson = list;
    var $formItemTemp = $("#ac_template_form_items");
    var formEditableVar = true;
    $(function(){
        $("#ac_template_form_items square_icon_checked").val("true");
    });
    //添加自定义内容
    function addEventFormEmptyItem(index){
            if(formEmptyItems != null && formEmptyItems.length > index && index >= 0){
                    var emptyItem = formEmptyItems[index];//获取每一个新建输入框的对象
                    if(emptyItem != null){
                            formItemsJson.push(createTemplateFormItem(emptyItem));
                            renderEventFormTemplate();
                    }
                    formItemsJsonTemp = formItemsJson.slice();
                    //$formItemTemp.sortable('refresh');拖放排序
            }
    }
    function createTemplateFormItem(item){
            if(item == null){
                    return null;
            } 
            var sortTmp = parseInt($("#template_form_sort_max").val());
            sortTmp++;
            var result = {
                    Id : "I_" + sortTmp,
                    Sort : sortTmp,
                    Type : item.Type,
                    Category : "CUSTOM",
                    IsDefault : item.IsDefault,
                    Required : false,
                    Multiple : item.Multiple,
                    Title : item.Title,
                    Description : item.Description,
                    IsHide : item.IsHide,
                    TypeTitle : item.TypeTitle,
                    Subitems : new Array()
            };

            if(item.Subitems != null && item.Subitems.length > 0){
                    for(var i = 0; i<item.Subitems.length; i++) result.Subitems.push(item.Subitems[i]);
            }
            $("#template_form_sort_max").val(sortTmp);
            return result;
    }

    function renderEventFormTemplate(){
            var itemsHtml = "";
            if(formItemsJson != null && formItemsJson.length > 0){
                    for(i=0;i<formItemsJson.length;i++){
                            var tmpItem = formItemsJson[i];
            var title;
            if(tmpItem.Title == ""){
                    title = tmpItem.TypeTitle;
            }else{
                    title = tmpItem.Title;
            }
                            itemsHtml += '<div class="form_group" id="efi_' + i + '">';
                            itemsHtml += '<input type="hidden" name="items[' + i + '].Type" value="' + tmpItem.Type + '" />';
                            itemsHtml += '<input type="hidden" name="items[' + i + '].Sort" value="' + tmpItem.Sort + '" />';
                            itemsHtml += '<input type="hidden" name="items[' + i + '].Category" value="' + tmpItem.Category + '" />';
                            itemsHtml += '<input type="hidden" name="items[' + i + '].Multiple" value="' + tmpItem.Multiple + '" />';
                            itemsHtml += '<input type="hidden" name="items[' + i + '].IsHide" value="' + tmpItem.IsHide + '" />';
                            itemsHtml += '<label><input type="checkbox" class="icon square_icon_check" name="items[' + i + '].Required" value="true" ' + (tmpItem.Required ? 'checked="checked"' : '') + ' onchange="javascript:onChangeFormItemValue(0, this, ' + i + ', 0);"/>必填</label>';
                            itemsHtml += '<input type="text" class="form_control required form_control_type" title="'+title+'" placeholder="'+title+'" name="items[' + i + '].Title" value="' + (tmpItem.Title == null ? "" : tmpItem.Title.replace("\"","\\\"").replace("\n"," ")) + '" onchange="javascript:onChangeFormItemValue(1, this, ' + i + ', 0);"/>';

                            itemsHtml += '<input type="text" name="items[' + i + '].Description" class="form_control form_control_tips" value="' + (tmpItem.Description == null ? "" : tmpItem.Description.replace("\"","\\\"").replace("\n"," ")) + '" onchange="javascript:onChangeFormItemValue(2, this, ' + i + ', 0);" placeholder="提示信息写在这里！"/>';
                            itemsHtml += '<span name="ac_form_item_ctrl" class="icon icon_trash" title="删除栏位" onclick="javascript:removeEventFormItem(' + i + ');return false;"></span>';

                            if(tmpItem.Type == "radio" || tmpItem.Type == "checkbox" || tmpItem.Type == "select"){
                                    itemsHtml += '<div class="clearfix">选项列表<div class="ac_create_sign_select" id="efis_' + i + '">';
                                    itemsHtml += renderEventFormItemValues(i, tmpItem);
                                    itemsHtml += '</div></div></div>';
                            }

                            itemsHtml += '</div>';
                    }
            }

            $("#ac_template_form_items").empty(); 
            $("#ac_template_form_items").append(itemsHtml);
            if(itemsHtml == ""){
                    $("#ac_template_form_items").before('<p style="font-size:14px;padding:5px 15px;color:gray;" id="ac_template_form_tips">未添加其他栏位（即不需要报名/购票人提供额外信息）。</p>')
            }else{
                    $('#ac_template_form_tips').remove();
            }
            if(!formEditableVar){
                    var formItemctrls = $("a[name='ac_form_item_ctrl']");
                    if(formItemctrls != null){
                            formItemctrls.attr("onclick", function(){ return false; });
                            formItemctrls.addClass("disabled");
                    }
                    var formItemInputs = $("#ac_template_form_items input");
                    if(formItemInputs != null) {
                            formItemInputs.addClass("disabled");
                            formItemInputs.attr("disabled", true);
                    }
            }
    }
    function onChangeFormItemValue(type, itemObj, index, subIndex){
            if(formItemsJson != null && formItemsJson.length > index && index >= 0){
                    var eleItem = $(itemObj);
                    if(type == 0) {
                        if(eleItem.attr('class') == 'icon square_icon_check'){
                            formItemsJson[index].Required = false;
                        }else{
                            formItemsJson[index].Required = true;
                        }
                    }
                    else if(type == 1) formItemsJson[index].Title = eleItem.val();
                    else if(type == 2) formItemsJson[index].Description = eleItem.val();
                    else if(type == 3) {
                            if(formItemsJson[index].Subitems != null && formItemsJson[index].Subitems.length > subIndex && subIndex >= 0){
                                    formItemsJson[index].Subitems[subIndex] = eleItem.val();
                            }
                    }
            }
    }
    function renderEventFormItemValues(i, tmpItem){
            itemsHtml = ''
            if(tmpItem.Subitems != null && tmpItem.Subitems.length > 0){
                    for(var j = 0; j < tmpItem.Subitems.length; j++){
                            itemsHtml += '<div><input type="text" class="form_control required form_control_type" name="items[' + i + '].Subitems[' + j + ']" value="' + (tmpItem.Subitems[j] == null ? "" : tmpItem.Subitems[j].replace("\"","\\\"").replace("\n"," ")) + '" onchange = "javascript:onChangeFormItemValue(3, this, ' + i + ', ' + j + ');"/>';
                            itemsHtml += '<span name="ac_form_item_ctrl" class="icon icon_close" onclick="javascript:removeEventFormItemValue(' + i + ',' + j + ');"></span></div>';
                    }
            }
            itemsHtml += '<button class="btn ac_add_label_btn" onclick="javascript:addEventFormItemValue(' + i + ');return false;"><span name="ac_form_item_ctrl" class="icon icon_ac_add"></span></button>'
            return itemsHtml;
    }
    function addEventFormItemValue(index){
            if(formItemsJson != null && formItemsJson.length > index && index >= 0){
                    if(formItemsJson[index].Subitems == null) formItemsJson[index].Subitems = new Array();
                    formItemsJson[index].Subitems.push("");
                    var efis = $('#efis_' + index);
                    if(efis != null){
                            efis.empty(); 
                            efis.append(renderEventFormItemValues(index, formItemsJson[index]));
                    }
            }
    }
    function removeEventFormItemValue(index, subIndex){
            if(formItemsJson != null && formItemsJson.length > index && index >= 0 && subIndex >= 0){
                    var tmpItem = formItemsJson[index];
                    if(tmpItem.Subitems != null && tmpItem.Subitems.length > subIndex){
                            formItemsJson[index].Subitems.splice(subIndex,1);
                            var efis = $('#efis_' + index);
                            if(efis != null){
                                    efis.empty(); 
                                    efis.append(renderEventFormItemValues(index, formItemsJson[index]));
                            }
                    }
            }
    }
    
    function removeEventFormItem(index){
            if(formItemsJson != null && formItemsJson.length > index && index >= 0){
                    formItemsJson.splice(index,1);
                    renderEventFormTemplate();
            }
            $(this).parent().tooltip('destroy')
            formItemsJsonTemp = formItemsJson.slice()
    }
    //用户自定义提交
    var saveEventFormSuccess = null;
    function saveEventForm(func){
            $('body').css('position','inherit');
            $('span.blackShadeWarning').remove();
            saveEventFormSuccess = func;
            var aele = $("#ac_template_form input[name='activityId']");
            if(aele != null && (aele.val() == null || aele.val() == "" || parseInt(aele.val()) < 1) && $("#activity_id")){
                    aele.val($("#activity_id").val());
            }
            //验证是否为空
            var required_item = $('#ac_template_form').find('.required');
            var if_stop = 1;

            for(var i=0;i<required_item.length;i++){
                    var x_w=0,y_h=0;
                    if(required_item.eq(i).val()==''){
                            var _this_required_item = required_item.eq(i);
                            _this_required_item.addClass('help_inline');
                            var x_w = _this_required_item.offset().left+43;
                            var y_h = _this_required_item.offset().top-30;
                            $('body').css('position','relative').append('<span class="blackShadeWarning icon" style="top:'+y_h+'px;left:'+x_w+'px;">这是必填项</span>');
                            if_stop=0;
                            return false;
                            break;
                    }else{
                            $('body').css('position','inherit');
                            $('span.blackShadeWarning').remove();
                            if_stop=1;
                    }
            }
            if(if_stop==0){
                    return false;
            }
			datas = $('#ac_template_form').serializeArray();
			
			saveEventFormAll(datas);
			
           /*  $('#ac_template_form').submit(); */
    }
	
	function saveEventFormAll(datas){
		$.ajax({
			url:'<?php echo $this->createUrl('/signForm/signForm/ajaxCreate'); ?>',
			data: {
				datas,
				},
			type:"POST",
			dataType:'json',
			success:function(data){
				if(data.message){
					alert("保存成功！");
					$('#ac_toggle').on('click',function(){
						$(this).parents('.ac_add_item').hide().prev().show();
					})
				}
			}
		});
	}
	
    //预览
    function reviewEventFormView(){
            var htmlTmp = resolveEventFormView(formItemsJson, 0, false);
            if(htmlTmp == null || htmlTmp == ""){
                    htmlTmp = '<p style="font-size:14px;padding:0px 30px;color:gray;">未添加其他栏位（即不需要报名/购票人提供额外信息）。</p>';
            } 
            $("#ac_template_form_fields").empty(); 
            $("#ac_template_form_fields").append(htmlTmp);
            $('#popBox_Userview').show();
    }
</script>
<script type="text/javascript" src='<?php echo Yii::app()->request->baseUrl; ?>/js/creat.js'></script>
<!--以下script为编辑器相关js，如需修改请自行修改-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/utf8-php/ueditor.config.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/utf8-php/ueditor.all.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/utf8-php/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
	var descEditor;
	var onSaveEventTagPageSuccess;
	descEditor = new UE.ui.Editor();
	descEditor.render("EventBaseDescription");
	var hasDescChanged = false;
	var canedit = true;
	var autoSaveFlag = true;
	function setContent(isAppendTo) {
		UE.getEditor('EventBaseDescription').setContent('欢迎使用ueditor', isAppendTo);
	}
	//UE.getEditor('EventBaseDescription').ready(function() {
		//UE.getEditor('EventBaseDescription').setContent('');
	//});
	//想要改变编辑器内字体，请在config.js中设置  ,initialStyle:'
	//上传
</script>
<script>

function checkValue(){
    var r = '';
    var id = '';
    $(".ac_add_label_list ul li").each(function(x){
        id = $(this).attr("rel");
        r+=id+',';
    });
    $("#Article_label").val(r);
}
function addIndexLabel(value,id){
    var r = '';
    if ($(".ac_add_label_list ul #a"+id).length <= 0 && $(".ac_add_label_list ul li").length <=4 ){
        $(".ac_add_label_list ul").append("<li id='a" + id + "' rel='" + id + "'>" + value + "<i class='icon-close' onclick=delIndexLabel('" + id + "')></i></li>");
        $(".ac_add_label_modal ul #ma"+id).addClass("active");
        checkValue();
    }
}
function delIndexLabel(id){
    $(".ac_add_label_list ul #a" + id).remove();
    //alert($(".ac_add_label_list ul li").attr("rel"));
    if($(".ac_add_label_list ul #a"+id).length <= 0){
        $(".ac_add_label_modal ul #ma"+id).removeClass("active");
        checkValue();
    }
}


</script>