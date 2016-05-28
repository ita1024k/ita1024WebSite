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
	$.fn.yiiGridView.update("advertise-grid", {
		data: {
			"key_word":key_word,
		}
	});
};
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
            <a class="crumbs_nav_item"><em class="blue">广告管理</em></a>
        </div>
        <div class="content authority_content">
                <div class="attendees_toolbar clearfix" style="margin-bottom: 5px;" id='attendees_toolbar'>
                        <div class="left left_top">
                                <input type="text" class='form_control' placeholder='搜索' title="" id='attendees_search_key' />
                                <button class='btn btn_primary' id='search_key_primary'>搜索</button>
                        </div>
                        <a class="btn btn_primary left_right right" href='create' target="_blank">新建广告</a>
                </div>
                <?php 
                    $columns = array(
                            array(
                                    //'htmlOptions'=>array('class'=>'check_td'),
                                    'header'=>'ID',
                                    'name'=>'name',
                                    'value'=>'$data[advertise_id]',
                                    'type'=>"raw",
                                    'footerHtmlOptions'=>array('style'=>'display:none')
                            ),
                            array(
                                    //'htmlOptions'=>array('class'=>'check_td'),
                                    'header'=>'广告位ID',
                                    'name'=>'name',
                                    'value'=>'$data[position_id]',
                                    'type'=>"raw",
                                    'footerHtmlOptions'=>array('style'=>'display:none')
                            ),
                            array(
                                    //'htmlOptions'=>array('class'=>'check_td'),
                                    'header'=>'广告名称',
                                    'name'=>'name',
                                    'value'=>'$data[advertise_name]',
                                    'type'=>"raw",
                                    'footerHtmlOptions'=>array('style'=>'display:none')
                            ),
                            array(
                                    'header'=>'跳转链接',
                                    'name'=>'company',
                                    'value'=>'$data[target_url]',
                                    'type'=>"raw",
                                    'footerHtmlOptions'=>array('style'=>'display:none')
                            ),
                            array(
                                    'header'=>'操作',
                                    'name'=>'status',
                                    'value'=>'Advertise::model()->editState($data[advertise_id])',
                                    'type'=>"raw",
                                    'footerHtmlOptions'=>array('style'=>'display:none')
                            ),
                    );
            ?>
                <?php
                //$this->widget('zii.widgets.grid.CGridView', array(
                        $this->widget('zii.widgets.grid.CGridView', array(
                                'id'=>'advertise-grid',
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