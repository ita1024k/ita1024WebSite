<?php
if($data->user_id){ 
	$user_id = $data->user_id;
	$sql = "SELECT logo,company FROM act_user WHERE user_id = $user_id";
	$datas = Yii::app()->db->createCommand($sql)->queryAll();
	if(empty($datas[0]['logo'])) $datas[0]['logo'] = 'images/com_logo.jpg';
}
echo '<li onmouseover="this.className=\'d_over\'" onmouseout="this.className=\'\'">
	<a href="activity/view/id/'.$data->id.'" target="_blank" title="'.$data->title.'" class="img_link">
		<img src="'.$data->picture.'" height="170" width="280" alt="'.$data->title.'" title="'.$data->title.'" class="list_img" />
	</a>
	<h3><a class="list_title" href="activity/view/id/'.$data->id.'" target="_blank">'.$data->title.'</a></h3>
	<div class="time_num clearfix">
		<span class="list_time"><i class="icon"></i>'.$data->start_date.'</span>
		<span class="limit_num">限额：<i>'.$data->nums.'</i>人</span>
	</div>
	<div class="apply clearfix">
		<a href="activity/view/id/'.$data->id.'" target="_blank" class="left">
			<img src="'.$datas[0][logo].'" height="170" width="280" alt="'.$datas[0][company].'" title="'.$datas[0][company].'" class="apply_logo" />
			<span class="name">'.$datas[0][company].'</span>
		</a>
		<a href="activity/view/id/'.$data->id.'" target="_blank" class="join">我要报名</a>
	</div>				
</li>';
?>