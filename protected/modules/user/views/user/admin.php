<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ac_manage.css" />
<style>
    .attendees_list{height:450px;}
    .attendees_list .pager {
        margin-top: 0px;
        display: block;
    }
    .authority_container h2.title {
        border-bottom: 0px;
        padding-bottom: 0px;
    }
</style>
<script>
    
$(function(){
    $("#search_key_primary").click(serchFn);
});
function serchFn(){
	key_word = $("#attendees_search_key").val();
        search_type = $("#attendees_search_atatus").val();
	$.fn.yiiGridView.update("user-grid", {
		data: {
			"key_word":key_word,
                        "status":search_type,
		}
	});
};

function ajaxCheckThrough(status,user_id){
    
    $.ajax({
        'type':'POST',
        'data':{
            'status':status,
            'user_id':user_id,
        },
        'dataType':'json',
        'url':'<?php echo $this->createUrl("/user/user/checkThrough") ?>',
        success:function(data){
                $.fn.yiiGridView.update('user-grid');
            //$('.select-on-check:input:checkbox:checked').parent().parent().click();
        }
    });
}
</script>
<div class="container clearfix authority_container">
        <?php
                if(!Yii::app()->user->isGuest){ 
                        $user_id = Yii::app()->user->id;
                        $sql = "SELECT logo,company FROM act_user WHERE user_id = $user_id";
                        $datas = Yii::app()->db->createCommand($sql)->queryAll();
                        if(empty($datas[0]['logo'])) $datas[0]['logo'] = 'images/com_logo.jpg';
                }
        ?>
        <h2 class="title"><img class="com_logo" alt='<?php echo $datas[0]['company']; ?>' width="32" height="32" src='<?php echo Yii::app()->request->baseUrl.'/'.$datas[0]['logo'];?>' /><?php echo $datas[0]['company']; ?></img></h2>
        <div class="crumbs blue">
            <a class="crumbs_nav_item"><em class="blue">用户管理</em></a>
        </div>
        <div class="content authority_content">
                <div class="attendees_toolbar clearfix" style="margin-bottom: 5px;" id='attendees_toolbar'>
                        <div class="left left_top">
                                <select name="" id="attendees_search_atatus" class="form_control">
                                        <option value="" selected='selected'>审核状态</option>
                                        <option value="0" >已通过</option>
                                        <option value="1" >待审核</option>
                                        <option value="2" >未通过</option>
                                </select>
                                <input type="text" class='form_control' placeholder='搜索' title="" id='attendees_search_key' />
                                <button class='btn btn_primary' id='search_key_primary'>搜索</button>
                        </div>
                        <a class="btn btn_primary left_right right" href='create' target="_blank">新建发布者</a>
                </div>
                <?php 
                    $columns = array(
                            array(
                                    //'htmlOptions'=>array('class'=>'check_td'),
                                    'header'=>'ID',
                                    'name'=>'name',
                                    'value'=>'$data[user_id]',
                                    'type'=>"raw",
                                    'footerHtmlOptions'=>array('style'=>'display:none')
                            ),
                            array(
                                    //'htmlOptions'=>array('class'=>'check_td'),
                                    'header'=>'账号名',
                                    'name'=>'name',
                                    'value'=>'$data[user_name]',
                                    'type'=>"raw",
                                    'footerHtmlOptions'=>array('style'=>'display:none')
                            ),
                            array(
                                    'header'=>'公司名称',
                                    'name'=>'company',
                                    'value'=>'$data[company]',
                                    'type'=>"raw",
                                    'footerHtmlOptions'=>array('style'=>'display:none')
                            ),
                            array(
                                    'header'=>'状态',
                                    'name'=>'status',
                                    'value'=>'User::model()->getState($data[user_id])',
                                    'type'=>"raw",
                                    'footerHtmlOptions'=>array('style'=>'display:none')
                            ),
                            array(
                                    'header'=>'审核操作',
                                    'name'=>'status',
                                    'value'=>'User::model()->setState($data[user_id])',
                                    'type'=>"raw",
                                    'footerHtmlOptions'=>array('style'=>'display:none')
                            ),
                            array(
                                    'header'=>'操作',
                                    'name'=>'status',
                                    'value'=>'User::model()->editState($data[user_id])',
                                    'type'=>"raw",
                                    'footerHtmlOptions'=>array('style'=>'display:none')
                            ),
                    );
            ?>
                <?php
                //$this->widget('zii.widgets.grid.CGridView', array(
                        $this->widget('zii.widgets.grid.CGridView', array(
                                'id'=>'user-grid',
                                'dataProvider'=>$model->search(),
                                'afterAjaxUpdate'=>'function(){

                                }',
                                //'selectableRows'=>2,
                                'itemsCssClass'=>'table',
                                'htmlOptions'=>array("class"=>"attendees_list"),
                                'template'=>'{items}{pager}',
                                'columns'=>$columns,
                        ));
                ?>
                
        </div>
</div>