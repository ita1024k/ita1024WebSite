<?php 
   // var_dump($data);exit;
?>
<li class="item clearfix">
        <div class="left">
                <h4 class="title"><a href='<?php echo Yii::app()->request->baseUrl.'/eventlist/view/id/'.$data["event_id"]; ?>' target="_blank"><?php echo $data['event_title']; ?></a></h4>
        </div>
        <div class="right">
				<a href="<?php echo Yii::app()->request->baseUrl.'/event/event/delete/id/'.$data["event_id"]; ?>" target="_blank">删除</a>
                <a href="<?php echo Yii::app()->request->baseUrl.'/eventlist/view/id/'.$data["event_id"]; ?>" target="_blank">实录预览</a>
                <a href="<?php echo Yii::app()->request->baseUrl.'/event/event/update/id/'.$data["event_id"]; ?>">实录编辑</a>
        </div>
</li>