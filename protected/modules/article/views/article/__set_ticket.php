<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/event_create.css" />
<?php $a=Yii::app()->clientScript;
    $a->registerCoreScript('jquery');
	$a->registerScriptFile(Yii::app()->baseUrl.'/bootstrap/dist/js/bootstrap.min.js',CClientScript::POS_END);
	$a->registerScriptFile(Yii::app()->baseUrl.'/bootstrap/dist/js/bootstrap-switch.min.js',CClientScript::POS_END);
	$a->registerScriptFile(Yii::app()->baseUrl.'/js/art-template.js',CClientScript::POS_END);
	?>
<?php
if($model->isNewRecord){
	$string = TicketType::model()->getTicket(0);
}else{
	$string = TicketType::model()->getTicket($id);
}
?>
<table class="event-create-ticket event_ticket_thumbs_header" id="event_free_ticket_thumbs_header" <?php if(!$string){ ?>style="display: none;"<?php } ?>>
	<thead>
		<tr>
			<th><div>票种名称</div></th>
			<th><div>限额<span class="icon-event-ticket-alert" title="" data-original-title="设置为0表示不限数量（不会超过活动总限额）"></span></div></th>
			<th><div>价格（元）</div></th>
			<th><div>状态</div></th>
			<th><div class="event-create-td-last">操作</div></th>
		</tr>
	</thead>
</table>
<input type="hidden" name="ticket_status" id="Article_ticket_status" value="<?php echo $model->ticket_id; ?>">
<div id="event_free_ticket_thumbs" <?php if(!$string){ ?>style="display: none;"<?php } ?>>
	<?php
		echo $string;
	?>
</div>

<button class="btn_create_add btn_add_primary" id="add-free-ticket" onclick="javascript:checkRefoundSettingAndAddTicket(true);return false;">
	<span class="icon icon_add_primary"></span>免费票种
</button>
<script>
	function showElement(SN){
		$("#event_create_ticket" + SN).toggleClass("event-create-ticket-edit");
		$("#event_create_ticket" + SN).attr("class")
		if($("#event_create_ticket" + SN).attr("class") === 'event-create-ticket event_free_ticket'){
			$("#event_ticket_title" + SN).attr("disabled","disabled");
			$("#event_ticket_quantity" + SN).attr("disabled","disabled");
		}else{
			$("#event_ticket_title" + SN).removeAttr("disabled");
			$("#event_ticket_quantity" + SN).removeAttr("disabled");
		}
	}
	var eventTicketFreeJson = {"SN":1,"Status":0,"Price":0,"Title":"免费票","Description":null,"Quantity":0,"SoldNumber":0,"NeedApply":0,"Enabled":0,"StatusStr":"报名尚未开始","IsSeriesTicket":0,"PriceStr":"免费"};
	var hasSetRefund = false;
	var canEditRefund = false;
	var changeRefundSettingOnly = true;
	function checkRefoundSettingAndAddTicket(free)
	{
		if(!hasSetRefund && !free)
		{
			//弹出收费设定modal
			changeRefundSettingOnly = false;
			$('#event-create-ticket-refund').modal();
			return;
		}
		else
		{
			addEventTicketTemplate(free);
		}
	}
	function addEventTicketTemplate(free){
		var etthumbs = $(free ? "#event_free_ticket_thumbs" : "#event_charge_ticket_thumbs");
		var newTicketJson = (free ? eventTicketFreeJson : eventTicketChargeJson);
		newTicketJson.SN = (Math.ceil(Math.random()*(10000000-1)+1));
		var itemsHtml = template('event_ticket_template', newTicketJson);
		$(".event-create-ticket").removeClass("event-create-ticket-edit")
		if(free) $("#event_free_ticket_thumbs_header").show();
		else $("#event_charge_ticket_thumbs_header").show();

		etthumbs.append(itemsHtml);
		etthumbs.show();
		console.log(newTicketJson);
		if(newTicketJson.SN){
			$.ajax({
				url:'<?php echo $this->createUrl('/ticketType/ticketType/ajaxCreate') ?>',
				data: {
					'TicketType[ticket_title]':newTicketJson.Title,
					'TicketType[article_id]':'<?php echo $id; ?>',
					'TicketType[price]':newTicketJson.Price,
					'TicketType[SN]':newTicketJson.SN,
					'TicketType[description]':newTicketJson.Description,
					'TicketType[quantity]':newTicketJson.Quantity,
					'TicketType[needapply]':newTicketJson.NeedApply,
					'TicketType[status]':newTicketJson.StatusStr,
					'TicketType[PriceStr]':newTicketJson.PriceStr,
					'TicketType[is_use]':newTicketJson.Enabled,
					'TicketType[IsSeriesTicket]':newTicketJson.IsSeriesTicket,
					},
				type:"POST",
				dataType:'json',
				success:function(data){
					if(data.message == 'successful'){
						$("#Group"+newTicketJson.SN).val(data.ticket_id);
                                                $("#Article_ticket_status").val(1);
                                                $("#ac_ticket_alert_msg").addClass("hide");
					}else{
						alert(data.message);
					}
				}
			});
		}
	}
	function saveEventTicket(SN){
		$.ajax({
			url:'<?php echo $this->createUrl('/ticketType/ticketType/ajaxUpdate') ?>',
			data: {
				'TicketType[ticket_id]':$("#Group"+SN).val(),
				'TicketType[ticket_title]':$("#event_ticket_title"+SN).val(),//newTicketJson.Title,
				'TicketType[article_id]':'<?php echo $id; ?>',
				'TicketType[price]':$("#Price"+SN).val(),
				'TicketType[SN]':SN,
				'TicketType[description]':$("#Description"+SN).val(),
				'TicketType[quantity]':$("#event_ticket_quantity"+SN).val(),
				'TicketType[needapply]':$("#at_needapply"+SN).is(':checked') ? 1 : 0,
				'TicketType[status]':$("#Status"+SN).val(),
				//'TicketType[PriceStr]':'',
				//'TicketType[is_use]':'',
				//'TicketType[IsSeriesTicket]':$("#IsSeriesTicket"+SN).val(),
				},
			type:"POST",
			dataType:'json',
			success:function(data){
				if(data.message == 'successful'){
					showElement(SN);
                                        $("#event_create_ticket"+SN+" .event-create-ticket-range em").text($("#event_ticket_quantity"+SN).val());
				}else{
					alert(data.message);
				}
			}
		});
	}
	function changeTiecketStatus(SN,is_ok,i){
		confirm("确认删除吗？");
		if(is_ok && SN){
			$.ajax({
				url:'<?php echo $this->createUrl('/ticketType/ticketType/ajaxDelete') ?>',
				data: {
					'ticket_id':$("#Group"+SN).val(),
					'article_id':'<?php echo $id; ?>',
				},
				type:"POST",
				dataType:'json',
				success:function(data){
					if(data.message == 'successful'){
						$('#event_create_ticket'+SN).remove();
					}else{
						alert('至少一个！');
					}
				}
			});
		}
	}
</script>
<script id="event_ticket_template" type="text/art-template">
	<table class="event-create-ticket {{Price >= 0.01 ? 'event_charge_ticket' : 'event_free_ticket'}}" id="event_create_ticket{{SN}}">
		<tbody>
			<tr>
				<th title="{{Title}}"><div><input type="text" value="{{Title}}" {{ SN > 0 ? 'disabled="disabled"':''}} id="event_ticket_title{{SN}}"/></div></th>
                <th><div class="event-create-ticket-range"><input type="text" value="{{Quantity}}" {{ SN > 0 ? 'disabled="disabled"':''}} id="event_ticket_quantity{{SN}}"/><em>{{(Quantity <= 0 ? '不限' : Quantity)}}</em></div></th>
                <th>
					{{if Price >= 0.01}}
						<div class="event-create-ticket-range">
							<input type="text" {{ SN > 0 ? 'disabled="disabled"':''}} id="event_ticket_price{{SN}}" value="{{Price}}"/><strong>{{PriceStr}}RMB</strong>
						</div>
					{{else}}
						<div><strong class="show">{{PriceStr}}</strong></div>
					{{/if}}
				</th>
				<th><div><span class="text-muted">{{StatusStr}}</span></div></th>
                <th><div class="event-create-td-last"><span class="event-create-ticket-edit-toggle" title="更多票种设置" onclick="showElement({{SN}})"><i class="icon-create-config"></i></span><span title="{{ Status == 0 ? (SoldNumber > 0 ? '停售票种': '删除票种') : '恢复票种'}}" onclick="javascript:changeTiecketStatus('{{SN}}', {{ Status == 0 ? 'true' : 'false' }}, {{SoldNumber}});return false;"><i class="{{ Status == 0 ? (SoldNumber > 0 ? 'icon-ticket-pause': 'icon-trash') : 'icon-ticket-start'}}"></i></span></div></th>
            </tr>
			<tr class="event-create-ticket-config" id="edit_ticket_config{{SN}}">
				<td colspan="5">
<form action="<?php echo $this->createUrl('/tickettype/tickettype/ajaxCreate') ?>" id="event_ticket_form{{SN}}" method="post"><input type="hidden" name="SN" value="{{SN}}"/>
						<input type="hidden" name="Title" value="{{Title}}" id="Title{{SN}}"/>
						<input type="hidden" name="Quantity" value="{{Quantity}}" id="Quantity{{SN}}"/>
						<input type="hidden" name="Price" value="{{Price}}" id="Price{{SN}}"/>
						<input type="hidden" name="Status" value="{{Status}}" id="Status{{SN}}"/>
						<input type="hidden" name="Group" value="{{Group}}" id="Group{{SN}}"/>
						<input type="hidden" name="activityId" value="<?php echo $id;?>" id="activityId{{SN}}"/>
						<input type="hidden" name="src_quantity_num" value="{{QuantityUnit*Quantity}}" id="src_quantity_num{{SN}}"/>
						<input type="hidden" name="NeedApply" value="{{NeedApply ? 'true':'false'}}" id="NeedApply{{SN}}" />
                        <input type="hidden" value="{{SoldNumber}}" id="SoldNumber{{SN}}"/>
						<div>
							<label class="ac_label">票种说明</label>
							<input name="Description" type="text" class="form_control ac_control" maxlength="200" placeholder="限制200汉字" value="{{Description}}"/>
						</div>
						<div style="margin-top:10px;">
							<label class="ac_label">是否审核</label>
							<label class="ac_create_checkbox form_control">
								<input type="checkbox" id="at_needapply{{SN}}" value="1" class="icon square_icon_check">凡报名/订购此类票需要经过我审核
							</label>
						</div>
						<div class="text_center submit_btn">
							<button class="btn btn_primary"  type="button" onclick="javascript:saveEventTicket('{{SN}}');return false;">保存</button>
							<button class="btn btn_default" onclick="javascript:$('#event_create_ticket{{SN}}').removeClass('event-create-ticket-edit');return false;">关闭</button>
						</div>
</form>				</td>
			</tr>
		</tbody>
	</table>
</script>