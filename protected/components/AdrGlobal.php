<?php 
class AdrGlobal{
	public static $zero = '--';
	//public static $email_name = 'qingbing@wisemedia.cn';
    public static $Form_Type = array(
        "input"=>"单行文本框",
        "textarea"=>"多行文本框",
        "radio"=>"单选按钮框",
        "checkbox"=>"多选按钮框",
    );
    public static function getSysStatus(){
        return Yii::app()->params['status'];
    }
    /**
     * 数字格式化
     * @param double|string $number 要格式化的数字
     * @param int $decimals 保留小数位数
     * @param string $suffix 后缀，如:'%'
     * @return string
     */
    public static function numberFormat($number, $decimals = 0, $suffix = ''){
    	if (empty($number)) {
    		return number_format(0, $decimals).$suffix;
    	}
    	elseif ($number == AdrGlobal::$zero) {
    		return $number;
    	}
    	else {
    		$number = (empty($decimals) ? $number : round($number, $decimals));
    		return number_format($number, $decimals).$suffix;
    	}
    }
	
    /**
     * 2015-12-22 检验当前用户是否有权访问传入的参数所指定的对象
     */
    public static function userRequestVerify($data) {

        $model = $data['model'];

        $id = round($data['id']);
        //var_dump($id);exit;
        $sign = false;
        switch ($model) {
            case 'Article':
                $user_id = Yii::app()->user->id;
                //if (User::model()->isSuperUserById($user_id)) {
                    //$sign = true;
                //} else {
                    $sign = Article::model()->checkAccessArticle($id, $user_id);
               // }
                break;
            case 'Event':
                $user_id = Yii::app()->user->id;
                //if (User::model()->isSuperUserById($user_id)) {
                    //$sign = true;
                //} else {
                    $sign = Event::model()->checkAccessEvent($id, $user_id);
                //}
                break;
        }
        if (!$sign) {
            throw new CHttpException(403, '无访问权限。');
        }
        return;
    }
    /**
     * 获取报表选择日期，默认日期为今天
     * @param string $type 获取报表日期的类型(get或是post)
     * @return array 返回日期数组
     * @author tangone
     * @date 2015-12-20
     */
    
    public static function getReportDate($type = 'get'){
    	if ($type == 'get') {
    		$startdate = substr($_GET['search_sdate'],0,10);
    		$enddate = substr($_GET['search_edate'],0,10);
    	}
    	else {
    		$startdate = substr($_POST['search_sdate'],0,10);
    		$enddate = substr($_POST['search_edate'],0,10);
    	}
    	if(empty($startdate))
    	{
    		if(empty($enddate))
    		{
    			//$sDate = new DateTime("-30 day");
    			//$startdate = $sDate->format('Y-m-d');
    			$startdate = date('Y-m-d');
    			$enddate = date('Y-m-d');
    		}
    		else
    		{
    			$eDate = new DateTime($enddate);
    			$tmp = $eDate->getTimestamp()  - 3600*24*30;
    			$sDate = new DateTime("@$tmp");
    			$startdate = $sDate->format('Y-m-d');
    		}
    	}
    	elseif(empty($enddate))
    	{
    		$enddate = date('Y-m-d');
    	}
    
    	return array(
    			'start_date'=>$startdate,
    			'end_date'=>$enddate
    	);
    }
    
    /**
     * 跳转到各类型用户的登陆默认页
     */
    public static function redirectToDefaultPage(){
    	$controller = Yii::app()->getController();
    	$controller->redirect(array('/user/selectHost'));
    }
	//表格信息导出为csv文件函数//by qb 2015-12-22
	public static function export_csv($datas,$name,$heads){//print_r($datas);
		$head = $heads;
		$filename = $name.'.csv';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$fp = fopen('php://output', 'a');
		// 输出Excel列名信息
		
		$names = explode(' - ', $name);
		//print_r($names);exit;
		$report_name[] = iconv('utf-8', 'gbk', "报表名称：".$names[0]);
		$report_date[] = iconv('utf-8', 'gbk', "日期范围：".$names[1]);
		$date[] = iconv('utf-8', 'gbk', "导出时间：".date('Y-m-d H:i:s',time()));
		fputcsv($fp, $report_name);
		fputcsv($fp, $date);
		fputcsv($fp, $report_date);
		
		foreach ($head as $i => $v) {
			$head[$i] = iconv('utf-8', 'gbk', $v);
		}
		// 将数据通过fputcsv写到文件句柄
		fputcsv($fp, $head);
		// 计数器
		$cnt = 0;
		$limit = 100000;
		$i = 2;
		foreach ($datas as $key => $val) {
			$cnt ++;
		   //每隔$limit行，刷新一下输出buffer
			if ($limit == $cnt) { //刷新一下输出buffer
				ob_flush();
				flush();  //刷新buffer
				$cnt = 0;
			}
			foreach($heads as $keys => $vs){
				foreach ($val as $n => $v) {
					if($n == $keys){
						$rows[$n] = iconv('utf-8', 'gbk', $v);
					}
				}
			}
			fputcsv($fp, $rows);
		}
		die();//防止调用此方法之后的页面输出
	}
		
        public static function email($address,$message_all,$title)
        {
                $len = strpos($address, "@");
                $user_name = substr($address,0,$len);
                Yii::import('application.extensions.phpmailer.JPhpMailer');
                $mail_from = "openday@ita1024.com";
                $mail = new JPhpMailer;
                $mail->IsSMTP();
                $mail->CharSet = "UTF-8";
                $mail->Host = "smtp.ita1024.com";
                $mail->SMTPAuth = true;
                $mail->Username = $mail_from;
                $mail->Password = "jdtech@618";//"1qaz@WSX";
                $mail->SetFrom($mail_from, '中国互联网技术联盟ITA');
                $mail->IsHTML(true);
                $mail->Subject = $title;
                $mail->Body = $message_all;
                //$mail->AddAttachment($attachment);附件
                $mail->AddAddress($address, $user_name);
                if($mail->Send()){
                    return true;
                }else{
                    return false;
                }	
        }
}
?>