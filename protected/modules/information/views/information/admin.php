<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ac_manage.css" />
<script>
    $(function () {
        var arrSelect = new Array();
        $("#information-grid .select-on-check").click(function () {
            arrSelect = selectItems();
            var nums_on = arrSelect.length;
            $("#attendees_selected_prompt").html("已选取" + nums_on + "个");
        });
        $("#information-grid .select-on-check-all:input:checkbox").click(function () {
            arrSelect = selectItemsAll();
            var nums_on = arrSelect.length;
            if (document.getElementById("information_id_all").checked) {
                $("#information-grid #attendees_selected_prompt").html("已选取" + nums_on + "个");
            } else {
                $("#information-grid #attendees_selected_prompt").html("已选取0个");
            }

        });
        $("#attendees_btn_export").click(function () {

            $("#download").val("true");
            $("#submitform").submit();
            $("#download").val("0");
            return false;
            //$("#submitform").submit();
        })
        $("#search_key_primary").click(serchFn);
        
        $('a.infor_icon').on('mouseenter mouseleave', function (event) {
            var _this = $(this);
            var _this_pop = _this.find('.popover');
            var _this_pop_w = _this_pop.width();
            var _this_pop_h = _this_pop.height();

            if (event.type == 'mouseenter') {
                _this_pop.show();
                _this_pop.css('margin-top', -1 * _this_pop_h / 2);
            }
            if (event.type == 'mouseleave') {
                _this_pop.hide();
            }
        })
    });

    function serchFn() {
        key_word = $("#attendees_search_key").val();
        search_type = $("#attendees_search_atatus").val();
        $.fn.yiiGridView.update("information-grid", {
            data: {
                "key_word": key_word,
                "status": search_type,
            }
        });
    }
    ;
    function selectItemsAll() {
        var arrSelect = new Array();
        $('.select-on-check:input:checkbox').each(function (i) {
            arrSelect[i] = $(this).val();
        });
        return arrSelect;
    }

    function checkThroughBatch() {

        var arrSelect = selectItems();
        if (arrSelect.length) {
            if (confirm('确认审核选中内容?')) {
                ajaxCheckThrough(arrSelect);
            }
        } else
            alert('请选择数据!');
    }

    function ajaxCheckThrough(arrid) {
        var id_list = new Array();
        if (jQuery.isArray(arrid))
            id_list = arrid;
        else
            id_list.push(arrid);
        $.ajax({
            'type': 'POST',
            'data': {
                'id_list': id_list,
            },
            'dataType': 'json',
            'url': '<?php echo $this->createUrl("/information/information/checkThrough") ?>',
            success: function (data) {
                $.fn.yiiGridView.update('information-grid');
                //$('.select-on-check:input:checkbox:checked').parent().parent().click();
            }
        });
    }
    function sendEmailBatch() {

        var arrSelect = selectItems();
        if (arrSelect.length) {
            if (confirm('确认发送邮件?')) {
                ajaxSendEmail(arrSelect);
            }
        } else
            alert('请选择数据!');
    }
    function ajaxSendEmail(arrid) {
        var id_list = new Array();
        if (jQuery.isArray(arrid))
            id_list = arrid;
        else
            id_list.push(arrid);
        $.ajax({
            'type': 'POST',
            'data': {
                'id_list': id_list,
            },
            'dataType': 'json',
            'url': '<?php echo $this->createUrl("/information/information/sendEmail") ?>',
            success: function (data) {
                if (data.message) {
                    alert("发送成功！");
                } else {
                    alert("发送失败！");
                }
                $('.select-on-check:input:checkbox:checked').parent().parent().click();
            }
        });
    }

    function selectItems() {
        var arrSelect = new Array();
        $('.select-on-check:input:checkbox:checked').each(function (i) {
            arrSelect[i] = $(this).val();
        });
        return arrSelect;
    }
</script>

<div class="container clearfix">
    <?php
    if (!Yii::app()->user->isGuest) {
        $user_id = Yii::app()->user->id;
        $sql = "SELECT logo,company FROM act_user WHERE user_id = $user_id";
        $datas = Yii::app()->db->createCommand($sql)->queryAll();
        if (empty($datas[0]['logo']))
            $datas[0]['logo'] = 'images/com_logo.jpg';
    }
    ?>
    <form id='submitform' class='hide' method='get' action='<?php echo Yii::app()->request->baseUrl . "/information/information/admin/"; ?>'>
        <?php
        echo CHtml::hiddenField('download', "", array('id' => 'download'));
        echo CHtml::hiddenField('article_id', $_GET['article_id'], array('id' => 'download_article_id'));
        ?>
    </form>
    <h2 class="title"><img class="com_logo" alt='<?php echo $datas[0]['company']; ?>' width="32" height="32" src='<?php echo Yii::app()->request->baseUrl . '/' . $datas[0]['logo']; ?>' /><?php echo $datas[0]['company']; ?></img></h2>
    <div class="crumbs">
        <a class="crumbs_nav_item" href='<?php echo Yii::app()->request->baseUrl; ?>/article/article/'>活动管理</a>
        <i class='seperate_line'>|</i>
        <a class="crumbs_nav_item">
            <em class="blue">名单管理</em>
        </a>
    </div>
    <div class="content">
        <div class="content_box">
            <h3 class="title">报名名单</h3>
            <div class="attendees_toolbar clearfix" id='attendees_toolbar'>
                <div class="left left_top">
                    <input type="text" class='form_control' placeholder='输入姓名或Email' title="" id='attendees_search_key' style="" >
                    <select name="" id="attendees_search_atatus" class="form_control">
                        <option value="-1">状态</option>
                        <option value="dai">待审核</option>
                        <option value="1">有效票</option>
                        <!--<option value="5">已取消</option>-->
                    </select>
                    <button class='btn btn_primary' id='search_key_primary'>查询</button>
                </div>
                <div class="right right_top">
                    <button id="attendees_btn_agree" class="btn btn_primary" onclick="checkThroughBatch();"><i class="icon attendees_admin"></i>审核</button>
                    <button id="attendees_btn_notice" class="btn btn_primary" onclick="sendEmailBatch();"><i class="icon attendees_notice"></i>通知</button>
                    <button id="attendees_btn_export" class="btn btn_primary last"><i class="icon attendees_export"></i>导出</button>
                </div>
                <!--<div class="alert alert-error" id="attendees_error_msg">未查询到任何名单，请修改查询条件重试。</div>-->
            </div>
            <!--<div id="attendees_selected_prompt" class="left">已选取0笔</div>-->
            <?php
            $columns = array(
                array(
                    'class' => 'CCheckBoxColumn',
                    'name' => 'id',
                    'id' => 'information_id',
                    'htmlOptions' => array('class' => 'check_td'),
                    'footerHtmlOptions' => array('style' => 'display:none')
                ),
                array(
                    //'htmlOptions'=>array('class'=>'check_td'),
                    'header' => '名称',
                    'name' => 'name',
                    'value' => '$data[name]',
                    'type' => "raw",
                    'footerHtmlOptions' => array('style' => 'display:none')
                ),
                array(
                    'header' => '手机',
                    'name' => 'phone',
                    'value' => '$data[phone]',
                    'type' => "raw",
                    'footerHtmlOptions' => array('style' => 'display:none')
                ),
                array(
                    'header' => '邮箱',
                    'name' => 'email',
                    'value' => '$data[email]',
                    'type' => "raw",
                    'footerHtmlOptions' => array('style' => 'display:none')
                ),
                array(
                    'header' => '状态',
                    'name' => 'status',
                    'value' => 'Information::model()->getState($data[id])',
                    'type' => "raw",
                    'footerHtmlOptions' => array('style' => 'display:none')
                ),
                array(
                    'header' => '报名时间',
                    'name' => 'create_time',
                    'value' => '$data[create_time]',
                    'type' => "raw",
                    'footerHtmlOptions' => array('style' => 'display:none')
                ),
                array(
                    'header' => '更多信息',
                    'name' => 'moredata',
                    'value' => 'Information::model()->getMoereData($data[id])',
                    'type' => "raw",
                    'footerHtmlOptions' => array('style' => 'display:none')
                ),
            );
            ?>
            <?php
            //$this->widget('zii.widgets.grid.CGridView', array(
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'information-grid',
                'dataProvider' => $model->search(),
                'afterAjaxUpdate' => 'function(){
                    $("a.infor_icon").on("mouseenter mouseleave", function (event) {
                        var _this = $(this);
                        var _this_pop = _this.find(".popover");
                        var _this_pop_w = _this_pop.width();
                        var _this_pop_h = _this_pop.height();

                        if (event.type == "mouseenter") {
                            _this_pop.show();
                            _this_pop.css("margin-top", -1 * _this_pop_h / 2);
                        }
                        if (event.type == "mouseleave") {
                            _this_pop.hide();
                        }
                    })
                }',
                'selectableRows' => 2,
                'itemsCssClass' => 'table',
                'htmlOptions' => array("class" => "attendees_list"),
                'template' => '<div class="clearfix clear" style="margin-bottom:30px;">
							<div class="right">
								{summary}
							</div>
						</div>
						{items}{pager}
						',
                'columns' => $columns,
            ));
            ?>
        </div>		
    </div>
</div>