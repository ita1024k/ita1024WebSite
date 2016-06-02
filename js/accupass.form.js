function resolveEventFormView(items, index, addParticipant) {//formItemsJson, 0, false formItemsJson为空的对象
    var htmlTmp = "";
    var ctllength = (items != null ? items.length : 0) + (addParticipant ? 3 : 0);
    /*var ctllength;
    if(items != null ){
      ctllength =  items.length//0
    }else{
        ctllength = 0;
    }
    if(addParticipant){//false
        ctllength +=3;
    }else{
        tllength += 0 ;
    }*/
    //tllength==0
    var marbtm = (ctllength < 5 ? 22 : (ctllength < 8 ? 16 : (ctllength < 10 ? 10 : 8)));
    /*var marbtm;
    if(ctllength < 5){
        marbtm = 22
    }else{
        if(ctllength < 8){
            marbtm = 16
        }else{
            if(ctllength < 10){
                marbtm = 10;
            }else{
                marbtm = 8;
            }
        }
    }*/
    //marbtm = 22
    if (addParticipant) {//addParticipant==false
        htmlTmp += '<div class="control_group" style="margin-bottom:' + marbtm + 'px;">';
        htmlTmp += '<label class="control_label" for="participants[' + index + '][0].Value">参加人' + (1 + index) + ' 姓名<i class="icon need_icon"></i></label>';
        htmlTmp += '<div class="controls">';
        htmlTmp += '<input type="hidden" name="participants[' + index + '][0].Key" value="participant_name" />';
        htmlTmp += '<input type="text" name="participants[' + index + '][0].Value" class="input_xlarge required" placeholder="请输入参加人姓名" title="请输入参加人姓名"/>';
        htmlTmp += '</div></div>';
        
        htmlTmp += '<div class="control_group" style="margin-bottom:' + marbtm + 'px;">';
        htmlTmp += '<label class="control_label" for="participants[' + index + '][2].Value">参加人' + (1 + index) + ' 手机号码<i class="icon need_icon"></i></label>';
        htmlTmp += '<div class="controls">';
        htmlTmp += '<input type="hidden" name="participants[' + index + '][2].Key" value="participant_phone" />';
        htmlTmp += '<input type="text" name="participants[' + index + '][2].Value" class="input_xlarge required digits" placeholder="请输入参加人手机号码" title="请输入参加人手机号码"/>';
        htmlTmp += '</div></div>';

        htmlTmp += '<div class="control_group" style="margin-bottom:' + marbtm + 'px;">';
        htmlTmp += '<label class="control_label" for="participants[' + index + '][1].Value">参加人' + (1 + index) + ' 电子邮箱</label>';
        htmlTmp += '<div class="controls">';
        htmlTmp += '<input type="hidden" name="participants[' + index + '][1].Key" value="participant_email" />';
        htmlTmp += '<input type="text" name="participants[' + index + '][1].Value" class="input_xlarge email" placeholder="请输入参加人电子邮箱" title="请输入参加人电子邮箱"/>';
        htmlTmp += '</div></div><hr style="margin:25px 0px;"/>';
    }
    if (items != null && items.length > 0) {
        var i = 0;
        var flagAddi = false;
        for (iii = 0; iii < items.length; iii++) {
            flagAddi = false;
            var tmpItem = items[iii];
            var tmpmbtm = marbtm;
            /*if (tmpItem.Type == 'radio' || tmpItem.Type == 'checkbox') {
                tmpmbtm = marbtm - 8;
                htmlTmp += '<div style="clear:both;margin-bottom:6px;"></div>';
            }else{
                htmlTmp += '<div style="clear:both;"></div>';   
            } */
            //htmlTmp += '<div class="control_group" style="margin-bottom:' + tmpmbtm + 'px;">'; /*style可删去*/
            htmlTmp += '<div class="control_group">';
            htmlTmp += '<label class="control_label" for="items[' + index + '][' + i + '].Value">' +
            tmpItem.Title + (tmpItem.Required ? '<i class="icon need_icon"></i>' : '')
            if ((tmpItem.Type == 'radio' || tmpItem.Type == 'checkbox') && tmpItem.Subitems != null && tmpItem.Subitems.length > 0) {
                if(!tmpItem.Required) {
                    htmlTmp += '<input name="items[' + index + '][' + i + '].Value" style="height:0px;width:0px;border:0px;visibility:hidden;" checked="checked" type="' + tmpItem.Type + '" value="" />';
                }else {
                   htmlTmp += '<input name="items[' + index + '][' + i + '].Value" style="height:0px;width:0px;border:0px;visibility:hidden;" class="required" type="' + tmpItem.Type + '" value="" />'; 
                }
            }else if (tmpItem.Type == 'file') {
                htmlTmp += '<input name="items[' + index + '][' + i + '].Value" style="height:0px;width:0px;border:0px;visibility:hidden;" type="text" value="" class="' + (tmpItem.Required ? 'required' : '') + '" />';
            }
            htmlTmp += '</label><div class="controls';
            //if (tmpItem.Type == 'file') { htmlTmp += ' event-upload-controls ' }
            htmlTmp += '">';
            if ((tmpItem.Type != 'radio' && tmpItem.Type != 'checkbox' && tmpItem.Type != 'select') || (tmpItem.Subitems != null && tmpItem.Subitems.length > 0)) {
                htmlTmp += '<input type="hidden" name="items[' + index + '][' + i + '].Key" value="' + tmpItem.Key + '" />';
                flagAddi = true;
            }
            var itemDesc = tmpItem.Description != null && $.trim(tmpItem.Description) != '' ? tmpItem.Description.replace("\"", "\\\"").replace("\n", " ").replace(/\s+/g, " ") : '';
            if (tmpItem.Type == 'input' || tmpItem.Type == 'number' || tmpItem.Type == 'date' || tmpItem.Type == 'email') {
                htmlTmp += '<input type="text" name="items[' + index + '][' + i + '].Value" class="input_xxlarge ' + (tmpItem.Required ? ' required ' : '') + (tmpItem.Type != 'input' ? tmpItem.Type : '') + '"' +
						' placeholder = "' + itemDesc + '" title = "' + itemDesc + '"/>';
            }else if (tmpItem.Type == 'textarea') {
                htmlTmp += '<textarea name="items[' + index + '][' + i + '].Value" rows = "5" class="input_xxlarge ' + (tmpItem.Required ? ' required ' : '') + '"' +
						' placeholder = "' + itemDesc + '" title = "' + itemDesc + '"></textarea>';
            }else if (tmpItem.Type == 'radio' || tmpItem.Type == 'checkbox') {
                if (tmpItem.Subitems != null && tmpItem.Subitems.length > 0) {
                    htmlTmp += '<div class="clearfix">';
                    if (itemDesc != '') htmlTmp += '<div class="ctl_prompt">' + itemDesc + '</div>';
                    var maxItemLength = 0;
                    for (var j = 0; j < tmpItem.Subitems.length; j++) {
                        if (tmpItem.Subitems[j].length > maxItemLength) maxItemLength = tmpItem.Subitems[j].length;
                    }
                    var contr_width = maxItemLength < 4 ? "input_mini" : (maxItemLength < 6 ? 'input_small' : (maxItemLength < 9 ? 'input_medium' : (maxItemLength < 13 ? 'input_large' : (maxItemLength < 19 ? 'input_xlarge' : 'input_xxlarge'))))
                    for (var j = 0; j < tmpItem.Subitems.length; j++) {
                        htmlTmp += '<div class="' + contr_width + '"><label class="' + tmpItem.Type + '">';
                        if (tmpItem.Type == 'radio'){
                            htmlTmp += '<input name="items[' + index + '][' + i + '].Value" class="icon radio_icon" type="' + tmpItem.Type + '" value="' + tmpItem.Subitems[j].replace("\"", "\\\"").replace("\n", " ") + '" />' + tmpItem.Subitems[j];
                        }
                        if (tmpItem.Type == 'checkbox'){
                            htmlTmp += '<input name="items[' + index + '][' + i + '].Value" class="icon square_icon_check" type="' + tmpItem.Type + '" value="' + tmpItem.Subitems[j].replace("\"", "\\\"").replace("\n", " ") + '" />' + tmpItem.Subitems[j];
                        }
                       
                        htmlTmp += '</label></div>';
                    }
                    htmlTmp += '</div>';
                }
            }else if (tmpItem.Type == 'select') {
                if (tmpItem.Subitems != null && tmpItem.Subitems.length > 0) {
                    htmlTmp += '<select name="items[' + index + '][' + i + '].Value" class="input_xxlarge ' + (tmpItem.Required ? ' required ' : '') + '" title = "' + itemDesc + '">';
                    htmlTmp += '<option value="请选择">请选择</option>';
                    for (var j = 0; j < tmpItem.Subitems.length; j++) {
                        htmlTmp += '<option value="' + tmpItem.Subitems[j].replace("\"", "\\\"").replace("\n", " ") + '">' + tmpItem.Subitems[j] + "</option>";
                    }
                    htmlTmp += '</select>';
                    if (itemDesc != '') htmlTmp += '<span class="ctl_prompt">' + itemDesc + '</span>';
                }
            }/*else if (tmpItem.Type == 'file') {
                htmlTmp += '<span id="att_' + index + '_' + i + '" onclick="attachSrcEle = $(this).prev();$(\'#asyn_upload_register_form input\').click();">点击上传</span>';
                if (itemDesc != '') htmlTmp += '<div class="ctl_prompt" style="text-align:left;line-height: 3;margin-left: -20px;clear:both;">' + itemDesc + '</div>';
            }*/
            htmlTmp += '</div>';
            htmlTmp += '</div>';
            if (flagAddi) i++;
        }
        htmlTmp += '<div style="clear:both;"></div>'
    }
    return htmlTmp;
}
