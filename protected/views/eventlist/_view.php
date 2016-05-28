<?php
echo '<div class="item">
		<h4 class="record_list_tit"><a href="'.Yii::app()->request->baseUrl.'/eventlist/view/id/'.$data->event_id.'" target="_blank">'.$data->event_title.'</a></h4>
		<p class="des">'.$data->description.'</p>
		<div class="article_meta clearfix" >
			<span class="left">
				作者: <em>'.$data->event_author.'</em>
			</span>
			<span class="right">
				<i class="icon grey_clock_icon"></i>'.$data->create_time.'
			</span>
		</div>
	</div>';
?>