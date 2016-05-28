<?php 
   // var_dump($data);exit;
?>
<li class="item clearfix">
        <div class="left">
                <h4 class="title"><a href='<?php echo Yii::app()->request->baseUrl.'/activity/view/id/'.$data["id"]; ?>' target="_blank"><?php echo $data['title']; ?></a></h4>
				<p class="time">开始时间：<span><?php echo $data['start_date'].' '.$data['start_time']; ?> ～ <?php echo $data['start_date'].' '.$data['end_time']; ?></span></p>
        </div>
        <div class="right">
				<?php if($data["status"] == 0) { ?>
				<a onclick="changeStatus(<?php echo $data["id"] ?>,5,'')">设置结束</a>
				<?php if($data['is_position'] == 1){ ?>
					<a onclick="changeStatus(<?php echo $data["id"] ?>,'',0)">取消推荐</a>
				<?php }else if($data['is_position'] == 0){ ?>
					<a onclick="changeStatus(<?php echo $data["id"] ?>,'',1)">设置推荐</a>
				<?php 
					}
					
					}
				?>
                <a href="<?php echo Yii::app()->request->baseUrl.'/activity/view/id/'.$data["id"]; ?>" target="_blank">活动预览</a>
                <a href="<?php echo Yii::app()->request->baseUrl.'/article/article/update/id/'.$data["id"]; ?>" target="_blank">活动编辑</a>
				<?php if($data["status"] == 0) { ?><a href="<?php echo Yii::app()->request->baseUrl.'/information/information/admin?article_id='.$data["id"]; ?>">名单管理</a><?php } ?>
        </div>
</li>