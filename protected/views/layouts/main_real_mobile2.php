<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta name="language" content="en" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile/common.css" />
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/fontResize.js"></script>
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
<!--字体大小自适应-->
<script>
	var _font = new fontResize();
	_font.init();
</script>
<!--头部开始-->
<header class='header'>
	<a href="http://www.ita1024.com/" class="back"><img src='<?php echo Yii::app()->request->baseUrl; ?>/images/back_icon.png' alt='返回上一级按钮'/></a>
	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/login_logo.png" alt="爱它就分享logo" class='logo'>
	<h1>正文</h1>
</header>
<?php echo $content; ?>

<a href='javascript:void(0)' title='回到顶部' class='icon icon_top' id='toTop'>回到顶部</a>	
</body>
</html>
