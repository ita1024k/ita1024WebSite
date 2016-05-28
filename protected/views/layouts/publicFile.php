<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl . "/daterangepicker/daterangepicker-bs3.css" ?>" />

<?php $a=Yii::app()->clientScript;
    $a->registerCoreScript('jquery');
	$a->registerScriptFile(Yii::app()->baseUrl.'/bootstrap/dist/js/bootstrap.min.js',CClientScript::POS_END);
	$a->registerScriptFile(Yii::app()->baseUrl.'/bootstrap/dist/js/bootstrap-switch.min.js',CClientScript::POS_END);
	?>
<script src="<?php echo Yii::app()->request->baseUrl . "/daterangepicker/moment.js" ?>"></script>
<script src="<?php echo Yii::app()->request->baseUrl . "/daterangepicker/daterangepicker.js" ?>"></script>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl . "/daterangepicker/bootstrap-datetimepicker.min.css" ?>" />
<script src="<?php echo Yii::app()->request->baseUrl . "/daterangepicker/bootstrap-datetimepicker.js" ?>"></script>
<script src="<?php echo Yii::app()->request->baseUrl . "/daterangepicker/bootstrap-datetimepicker.zh-CN.js" ?>"></script>

<style>
.fontsize{font-size:25px}
.dropdown-menu
{font-size: 12px;}
</style>

<script>

$(function(){

	$("#myTab li a ").click(function(){
		window.location=$(this).attr("href");
	});
    $('#reservation').daterangepicker({ 
		 opens: 'left',
		 //minDate:'<?php echo $startdate; ?>',
		 //startDate: '<?php echo $startdate; ?>',
		 //endDate: '2013-12-31'
         <?php echo AdrGlobal::$style; ?> 
		  }, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
      });
    
    $("[data-toggle='tooltip']").tooltip();
})

</script>