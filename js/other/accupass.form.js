function resolveEventFormView(items, index, addParticipant) {
    var htmlTmp = "";
    var ctllength = (items != null ? items.length : 0) + (addParticipant ? 3 : 0);
    var marbtm = (ctllength < 5 ? 22 : (ctllength < 8 ? 16 : (ctllength < 10 ? 10 : 8)));
    if (addParticipant) {
        htmlTmp += '<div class="control-group" style="margin-bottom:' + marbtm + 'px;">';
        htmlTmp += '<label class="control-label" style="font-weight:bold;" for="participants[' + index + '][0].Value">参加人' + (1 + index) + ' 姓名<font style="color:red;">&nbsp;*</font></label>';
        htmlTmp += '<div class="controls">';
        htmlTmp += '<input type="hidden" name="participants[' + index + '][0].Key" value="participant_name" />';
        htmlTmp += '<input type="text" name="participants[' + index + '][0].Value" class="input-xxlarge required" placeholder="请输入参加人姓名" title="请输入参加人姓名"/>';
        htmlTmp += '</div></div>';
        
        htmlTmp += '<div class="control-group" style="margin-bottom:' + marbtm + 'px;">';
        htmlTmp += '<label class="control-label" style="font-weight:bold;" for="participants[' + index + '][2].Value">参加人' + (1 + index) + ' 手机号码<font style="color:red;">&nbsp;*</font></label>';
        htmlTmp += '<div class="controls">';
        htmlTmp += '<input type="hidden" name="participants[' + index + '][2].Key" value="participant_phone" />';
        htmlTmp += '<input type="text" name="participants[' + index + '][2].Value" class="input-xxlarge required digits" placeholder="请输入参加人手机号码" title="请输入参加人手机号码"/>';
        htmlTmp += '</div></div>';

        htmlTmp += '<div class="control-group" style="margin-bottom:' + marbtm + 'px;">';
        htmlTmp += '<label class="control-label" style="font-weight:bold;" for="participants[' + index + '][1].Value">参加人' + (1 + index) + ' 电子邮箱</label>';
        htmlTmp += '<div class="controls">';
        htmlTmp += '<input type="hidden" name="participants[' + index + '][1].Key" value="participant_email" />';
        htmlTmp += '<input type="text" name="participants[' + index + '][1].Value" class="input-xxlarge email" placeholder="请输入参加人电子邮箱" title="请输入参加人电子邮箱"/>';
        htmlTmp += '</div></div><hr style="margin:25px 0px;"/>';
    }
    if (items != null && items.length > 0) {
        var i = 0;
        var flagAddi = false;
        for (iii = 0; iii < items.length; iii++) {
            flagAddi = false;
            var tmpItem = items[iii];
            var tmpmbtm = marbtm;
            if (tmpItem.Type == 'radio' || tmpItem.Type == 'checkbox') {
                tmpmbtm = marbtm - 8;
                htmlTmp += '<div style="clear:both;margin-bottom:6px;"></div>';
            }
            else htmlTmp += '<div style="clear:both;"></div>';
            htmlTmp += '<div class="control-group" style="margin-bottom:' + tmpmbtm + 'px;">';
            htmlTmp += '<label class="control-label" style="font-weight:bold;" for="items[' + index + '][' + i + '].Value">' +
                    tmpItem.Title + (tmpItem.Required ? '<font style="color:red;">&nbsp;*</font>' : '')
            if ((tmpItem.Type == 'radio' || tmpItem.Type == 'checkbox') && tmpItem.Subitems != null && tmpItem.Subitems.length > 0) {
                if (!tmpItem.Required) htmlTmp += '<input name="items[' + index + '][' + i + '].Value" style="height:0px;width:0px;border:0px;visibility:hidden;" checked="checked" type="' + tmpItem.Type + '" value="" />';
                else htmlTmp += '<input name="items[' + index + '][' + i + '].Value" style="height:0px;width:0px;border:0px;visibility:hidden;" class="required" type="' + tmpItem.Type + '" value="" />';
            }
            else if (tmpItem.Type == 'file') {
                htmlTmp += '<input name="items[' + index + '][' + i + '].Value" style="height:0px;width:0px;border:0px;visibility:hidden;" type="text" value="" class="' + (tmpItem.Required ? 'required' : '') + '" />';
            }
            htmlTmp += '</label><div class="controls';
            if (tmpItem.Type == 'file') { htmlTmp += ' event-upload-controls ' }
            htmlTmp += '">';
            if ((tmpItem.Type != 'radio' && tmpItem.Type != 'checkbox' && tmpItem.Type != 'select') || (tmpItem.Subitems != null && tmpItem.Subitems.length > 0)) {
                htmlTmp += '<input type="hidden" name="items[' + index + '][' + i + '].Key" value="' + tmpItem.Key + '" />';
                flagAddi = true;
            }
            var itemDesc = tmpItem.Description != null && $.trim(tmpItem.Description) != '' ? tmpItem.Description.replace("\"", "\\\"").replace("\n", " ").replace(/\s+/g, " ") : '';
            if (tmpItem.Type == 'input' || tmpItem.Type == 'number' || tmpItem.Type == 'date' || tmpItem.Type == 'email') {
                htmlTmp += '<input type="text" name="items[' + index + '][' + i + '].Value" class="input-xxlarge ' + (tmpItem.Required ? ' required ' : '') + (tmpItem.Type != 'input' ? tmpItem.Type : '') + '"' +
						' placeholder = "' + itemDesc + '" title = "' + itemDesc + '"/>';
            }
            else if (tmpItem.Type == 'textarea') {
                htmlTmp += '<textarea name="items[' + index + '][' + i + '].Value" rows = "5" class="input-xxlarge ' + (tmpItem.Required ? ' required ' : '') + '"' +
						' placeholder = "' + itemDesc + '" title = "' + itemDesc + '"></textarea>';
            }
            else if (tmpItem.Type == 'radio' || tmpItem.Type == 'checkbox') {
                if (tmpItem.Subitems != null && tmpItem.Subitems.length > 0) {
                    htmlTmp += '<div style="margin-top:5px;">';
                    if (itemDesc != '') htmlTmp += '<div class="ctl_prompt">' + itemDesc + '</div>';
                    var maxItemLength = 0;
                    for (var j = 0; j < tmpItem.Subitems.length; j++) {
                        if (tmpItem.Subitems[j].length > maxItemLength) maxItemLength = tmpItem.Subitems[j].length;
                    }
                    var contr_width = maxItemLength < 4 ? "input-mini" : (maxItemLength < 6 ? 'input-small' : (maxItemLength < 9 ? 'input-medium' : (maxItemLength < 13 ? 'input-large' : (maxItemLength < 19 ? 'input-xlarge' : 'input-xxlarge'))))
                    for (var j = 0; j < tmpItem.Subitems.length; j++) {
                        htmlTmp += '<div class="' + contr_width + '" style="float:left;margin:0px 10px 0px 0px;"><label class="' + tmpItem.Type + '">';
                        htmlTmp += '<input name="items[' + index + '][' + i + '].Value" type="' + tmpItem.Type + '" value="' + tmpItem.Subitems[j].replace("\"", "\\\"").replace("\n", " ") + '" />&nbsp;' + tmpItem.Subitems[j];
                        htmlTmp += '</label></div>';
                    }
                    htmlTmp += '</div>';
                }
            }
            else if (tmpItem.Type == 'select') {
                if (tmpItem.Subitems != null && tmpItem.Subitems.length > 0) {
                    htmlTmp += '<select name="items[' + index + '][' + i + '].Value" class="input-xxlarge ' + (tmpItem.Required ? ' required ' : '') + '" title = "' + itemDesc + '">';
                    htmlTmp += '<option value="请选择">请选择</option>';
                    for (var j = 0; j < tmpItem.Subitems.length; j++) {
                        htmlTmp += '<option value="' + tmpItem.Subitems[j].replace("\"", "\\\"").replace("\n", " ") + '">' + tmpItem.Subitems[j] + "</option>";
                    }
                    htmlTmp += '</select>';
                    if (itemDesc != '') htmlTmp += '<span class="ctl_prompt">&nbsp;&nbsp;' + itemDesc + '</span>';
                }
            }
            else if (tmpItem.Type == 'file') {
                htmlTmp += '<span id="att_' + index + '_' + i + '" onclick="attachSrcEle = $(this).prev();$(\'#asyn_upload_register_form input\').click();">点击上传</span>';
                if (itemDesc != '') htmlTmp += '<div class="ctl_prompt" style="text-align:left;line-height: 3;margin-left: -20px;clear:both;">&nbsp;&nbsp;' + itemDesc + '</div>';
            }
            htmlTmp += '</div>';
            htmlTmp += '</div>';
            if (flagAddi) i++;
        }
        htmlTmp += '<div style="clear:both;"></div>'
    }
    return htmlTmp;
}
