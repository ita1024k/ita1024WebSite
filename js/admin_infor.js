$(function(){
	var arrSelect = new Array();
	$(".select-on-check").click(function(){
		arrSelect = selectItems();
		var nums_on = arrSelect.length;
		alert(13123);
		$("#attendees_selected_prompt").html("已选取"+nums_on+"个");
	});
	$(".select-on-check-all:input:checkbox").click(function(){
		arrSelect = selectItemsAll();
		var nums_on = arrSelect.length;
		alert(13123);
		if(document.getElementById("information_id_all").checked){
			$("#attendees_selected_prompt").html("已选取"+nums_on+"个");
		}else{
			$("#attendees_selected_prompt").html("已选取0个");
		}
		
	});
	$("#attendees_btn_export").click(function(){
		//$("#l_slot_name").val($('#slot-st').val());
		//alert(1111);
		$("#submitform").submit();
	})
	
	$("#search_key_primary").click(serchFn);
	
});
function serchFn(){
	key_word = $("#attendees_search_key").val();
	search_type = $("#attendees_search_atatus").val();
	$.fn.yiiGridView.update("information-grid", {
		data: {
			"key_word":key_word,
			"status":search_type,             
		}
	});
};
function selectItemsAll(){
    var arrSelect = new Array();
    $('.select-on-check:input:checkbox').each(function(i){
        arrSelect[i]=$(this).val();
    });
    return arrSelect;
}

function checkThroughBatch(){

    var arrSelect = selectItems();
    if (arrSelect.length) {
        if(confirm('确认审核选中内容?')){
            ajaxCheckThrough(arrSelect);
        }
    }
    else
        alert('请选择数据!');
}

function ajaxCheckThrough(arrid){
    var id_list = new Array();
    if(jQuery.isArray(arrid))
        id_list = arrid;
    else
        id_list.push(arrid);
    $.ajax({
        'type':'POST',
        'data':{
            'id_list':id_list,
        },
        'dataType':'json',
        'url':'<?php echo $this->createUrl("/information/information/checkThrough") ?>',
        success:function(data){
			$.fn.yiiGridView.update('information-grid');
            //$('.select-on-check:input:checkbox:checked').parent().parent().click();
        }
    });
}

function sendEmailBatch(){

    var arrSelect = selectItems();
    if (arrSelect.length) {
        if(confirm('确认发送邮件?')){
            ajaxSendEmail(arrSelect);
        }
    }
    else
        alert('请选择数据!');
}
function ajaxSendEmail(arrid){
    var id_list = new Array();
    if(jQuery.isArray(arrid))
        id_list = arrid;
    else
        id_list.push(arrid);
    $.ajax({
        'type':'POST',
        'data':{
            'id_list':id_list,
        },
        'dataType':'json',
        'url':'<?php echo $this->createUrl("/information/information/sendEmail") ?>',
        success:function(data){
            if(data.result == 'error'){
                alert(data.message);
            }
            $('.select-on-check:input:checkbox:checked').parent().parent().click();
        }
    });
}

function selectItems(){
    var arrSelect = new Array();
    $('.select-on-check:input:checkbox:checked').each(function(i){
        arrSelect[i]=$(this).val();
    });
    return arrSelect;
}