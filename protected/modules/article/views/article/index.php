<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ac_manage.css" />
<?php 
    //var_dump($dataProvider);exit;
	$class_a = 'current';
?>
<div class="container clearfix">
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
			<a class='crumbs_nav_item'><em class='blue'>活动管理</em></a>
			<a class="crumbs_nav_item" href='<?php echo Yii::app()->request->baseUrl;?>/event/event/'>实录管理</a>
		</div>
        <div class="content">
            <ul class="user_tab clearfix" id="user_tab_ac">
                <li class='<?php if($_GET['status'] == '0' || $_GET['status'] == '') echo $class_a;?> a1'><a href="<?php echo Yii::app()->request->baseUrl;?>/article/article/index/status/0">已发布的</a></li>
                <li class='<?php if($_GET['status'] == '1') echo $class_a;?> a2'><a href="<?php echo Yii::app()->request->baseUrl;?>/article/article/index/status/1">草稿</a></li>
				<li class='<?php if($_GET['status'] == '5') echo $class_a;?> a3'><a href="<?php echo Yii::app()->request->baseUrl;?>/article/article/index/status/5">结束</a></li>
            </ul>
            <div class="tab_content">
                <?php $this->widget('zii.widgets.CListView', array(
			'id'=>'hot_recom_list',
			'dataProvider'=>$dataProvider,
			'itemView'=>'_view',
			'htmlOptions'=>array("class"=>"tab_item"),
			//'enablePagination'=>false,
			'summaryCssClass'=>'hide',
			'tagName'=>'ul',
			'pager'=>array(
				'class'=>'CLinkPager',//定义要调用的分页器类，默认是CLinkPager，需要完全自定义，还可以重写一个，参考我的另一篇博文：http://blog.sina.com.cn/s/blog_71d4414d0100yu6k.html
				'cssFile'=>false,//定义分页器的要调用的css文件，false为不调用，不调用则需要亲自己css文件里写这些样式
				'header'=>'',//定义的文字将显示在pager的最前面
				//'footer'=>'',//定义的文字将显示在pager的最后面
				'firstPageLabel'=>'首页',//定义首页按钮的显示文字
				'lastPageLabel'=>'尾页',//定义末页按钮的显示文字
				'nextPageLabel'=>'下一页',//定义下一页按钮的显示文字
				'prevPageLabel'=>'前一页',//定义上一页按钮的显示文字
				//关于分页器这个array，具体还有很多属性，可参考CLinkPager的API
			),
		)); ?>
            </div>
        </div>
</div>
<script>
$(function(){
    $("#user_tab_ac .a1").click(function(){
        /* var params = {
            'status':0,
        };
        $.fn.yiiListView.update('hot_recom_list', {
            'data':params
        }); */
        //$(this).addClass("current").siblings().removeClass("current");
    });
    $("#user_tab_ac .a2").click(function(){
        /* var params = {
            'status':1,
        };
        $.fn.yiiListView.update('hot_recom_list', {
            'data':params
        }); */
        //$(this).addClass("current").siblings().removeClass("current");
    });
	$("#user_tab_ac .a3").click(function(){
        /* var params = {
            'status':5,
        };
        $.fn.yiiListView.update('hot_recom_list', {
            'data':params
        }); */
        //$(this).addClass("current").siblings().removeClass("current");
    });
})
function changeStatus(id,status,is_position){
	if(is_position == 0) is_position = -1; 
	if(id){
		$.ajax({
            url:'<?php echo $this->createUrl('/article/article/changeStatus') ?>',
            data: {
				'id':id,
				'status':status,
				'is_position':is_position,
			},
            type:"POST",
            dataType:'json',
            success:function(data){
                if(data.message){
					alert('修改成功！');
					$.fn.yiiListView.update('hot_recom_list');
               	}
            }
        });
	}
}
</script>