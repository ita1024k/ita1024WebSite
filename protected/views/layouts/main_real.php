<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . "/daterangepicker/daterangepicker-bs3.css" ?>" />
	
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/index.css" />
	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/creat_ac.css" />-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/common.css" />
	
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.0.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js"></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?660f886a442028997f3d1c4c85370d8e";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(hm, s);
})();
</script>
</head>
<body>
<div class='header'>
	<div class="container clearfix">
		<a href='<?php echo Yii::app()->request->baseUrl.'/'; ?>'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/login_logo.png" alt='logo' class='logo'></a>
		<ul class='nav clearfix'>
			<li><a href="<?php echo Yii::app()->request->baseUrl.'/'; ?>" id="aclist_ab" target="_blank">活动</a></li>
			<li><a href="<?php echo $this->createUrl('/eventlist'); ?>" id="eventlist_ac" target="_blank">活动实录</a></li>
			
		</ul>
			<?php if(!Yii::app()->user->isGuest){ ?>
                    <a href="<?php echo $this->createUrl('/site/logout'); ?>" class='login'>退出</a>
                <?php }else{ ?>
                    <a href="<?php echo $this->createUrl('/site/login'); ?>" class='login'>登录</a>
                <?php } ?>
			<?php 
			if(!Yii::app()->user->isGuest){ 
			$user_id = Yii::app()->user->id;
			$sql = "SELECT logo,company FROM act_user WHERE user_id = $user_id";
			$datas = Yii::app()->db->createCommand($sql)->queryAll();
			if(empty($datas[0]['logo'])) $datas[0]['logo'] = 'images/com_logo.jpg';
			?>
			<a  class='login' href="<?php echo Yii::app()->request->baseUrl.'/article/article/'; ?>"><img class="com_logo" alt="京东技术" height="32" width="32" src="<?php echo Yii::app()->request->baseUrl.'/'.$datas[0]['logo'];?>"><?php echo $datas[0]['company'];?></a>
			<?php } ?>
		<a href="<?php echo $this->createUrl('/article/article/create'); ?>" target="_blank" class='ac_creat'><i class='icon'></i>发布活动</a>
		<a href="<?php echo $this->createUrl('/event/event/create'); ?>" target="_blank" class='ac_record'><i class='icon'></i>发布实录</a>
                <?php if(Yii::app()->user->checkAccess("Admin")){ ?>
                    <a href="<?php echo $this->createUrl('/user/user/index'); ?>" class='ac_record'>用户管理</a>
                    <a href="<?php echo $this->createUrl('/advertise/advertise/admin'); ?>" class='ac_record'>广告管理</a>
                <?php } ?>
	</div>
</div>
<?php echo $content; ?>
<div class="footer">
	<div class="container clearfix">
		<div class="left">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/login_logo.png" alt="" class="flooter_logo">
			<span class='footer_email'>联系我们：openday@ita1024.com</span>
		</div>
		<div class="right footer_ewm">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/footer_ewm_03.jpg" alt="公司二维码" />
			<span>更多信息扫码了解</span>
		</div>
		<div class="right footer_intro">
			<h2 class="title">ITA介绍</h2>
			<h4 class="des">中国互联网技术联盟（Internet Technology Alliance，
简称ITA），致力于建立中国互联网企业之间技术交流，
技术传播以及IT前沿技术研讨的服务平台。</h4>
		</div>
	</div>
</div>
<div class='toTop' id='toTop'><a href='javascript:void(0)' title='回到顶部' class='icon icon_top'>回到顶部</a></div>
<!--<div id="footer">
	Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
	All Rights Reserved.<br/>
	<?php echo Yii::powered(); ?>
</div> footer -->
</body>
</html>
