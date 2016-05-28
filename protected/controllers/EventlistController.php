<?php

class EventlistController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		
		$model = $this->loadModel($id);
		//echo $model->label;exit;
                $url = 'http://www.ita1024.com/eventlist/view/id/'.$id;
                $img_wx = $this->qrcode($url);
		$this->pageTitle= $model->event_title.' - '.Yii::app()->name;
		$label_arrs = array();
		if(!empty($model->label)){
			$label_arrs = Yii::app()->db->createCommand()->select('tag_id,tag_name')->from('act_label')->where("tag_id in($model->label)")->queryAll();
		}
		$position_arrs = Yii::app()->db->createCommand()->select('*')->from('act_article')->where("is_position='1' AND status='0' AND support='0'")->limit("6")->queryAll();
		$hot_arrs = Yii::app()->db->createCommand()->select('*')->from('act_article')->where("status='0' AND support='0'")->limit("6")->order("sign_count DESC")->queryAll();
		$event_arrs = Yii::app()->db->createCommand()->select('*')->from('act_event')->where("status='0'")->limit("6")->order("create_time DESC")->queryAll();
		$company_arrs = Yii::app()->db->createCommand()->select('*')->from('act_user')->where("user_type='1'")->limit("6")->order("user_id DESC")->queryAll();
                $advertise_arrs = Yii::app()->db->createCommand()->select('*')->from('act_advertise')->where("position_id=100011")->limit("1")->order("advertise_id DESC")->queryAll();
		//var_dump($this->isMobile());exit;
                if(!$this->isMobile()){
                    $this->render('view',array(
                            'model'=>$model,
                            'label_arrs'=>$label_arrs,
                            'position_arrs'=>$position_arrs,
                            'hot_arrs'=>$hot_arrs,
                            'event_arrs'=>$event_arrs,
                            'company_arrs'=>$company_arrs,
                            'advertise_arrs'=>$advertise_arrs,
                            'img_wx'=>$img_wx
                    ));

                }else{
                    $this->layout='//layouts/column3';
                    $this->render('view_mobile',array(
                            'model'=>$model,
                            'label_arrs'=>$label_arrs,
                            'position_arrs'=>$position_arrs,
                            'hot_arrs'=>$hot_arrs,
                            'event_arrs'=>$event_arrs,
                            'company_arrs'=>$company_arrs,
                            'advertise_arrs'=>$advertise_arrs,
                            'img_wx'=>$img_wx
                    ));
                }
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->pageTitle= '活动实录 - '.Yii::app()->name;
                $url = 'http://www.ita1024.com/eventlist';
                $img_wx = $this->qrcode($url);
		$position_arrs = Yii::app()->db->createCommand()->select('*')->from('act_article')->where("is_position='1' AND status='0'")->limit("6")->queryAll();
		$hot_arrs = Yii::app()->db->createCommand()->select('*')->from('act_article')->where("status='0'")->limit("6")->order("sign_count DESC")->queryAll();
		$event_arrs = Yii::app()->db->createCommand()->select('*')->from('act_event')->where("status='0'")->limit("6")->order("create_time DESC")->queryAll();
		$company_arrs = Yii::app()->db->createCommand()->select('*')->from('act_user')->where("user_type='1'")->limit("6")->order("user_id DESC")->queryAll();
		$advertise_arrs = Yii::app()->db->createCommand()->select('*')->from('act_advertise')->where("position_id=100011")->limit("1")->order("advertise_id DESC")->queryAll();
                $conditions = "status=0";
		$dataProvider=new CActiveDataProvider('Event',array(
					'sort' => array(
                        'defaultOrder' => 'event_id DESC',
					),
					'criteria'=>array(
						'condition'=>$conditions,
						//'order'=>'create_time DESC',
						//'with'=>array('author'),
					),
					'pagination'=>array(
						'pageSize'=>12,
					),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'position_arrs'=>$position_arrs,
			'hot_arrs'=>$hot_arrs,
			'event_arrs'=>$event_arrs,
			'company_arrs'=>$company_arrs,
                        'advertise_arrs'=>$advertise_arrs,
                        'img_wx'=>$img_wx
		));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Event the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Event::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Event $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='event-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        function isMobile() {
            // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
            if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
                return true;
            }
            //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
            if (isset($_SERVER['HTTP_VIA'])) {
                //找不到为flase,否则为true
                return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
            }
            //判断手机发送的客户端标志,兼容性有待提高
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
                // 从HTTP_USER_AGENT中查找手机浏览器的关键字
                if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                    return true;
                }
            }
            //协议法，因为有可能不准确，放到最后判断
            if (isset($_SERVER['HTTP_ACCEPT'])) {
                // 如果只支持wml并且不支持html那一定是移动设备
                // 如果支持wml和html但是wml在html之前则是移动设备
                if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                    return true;
                }
            }
            return false;
        }
        public function qrcode($url){
            Yii::$enableIncludePath = false;
            Yii::import ('application.extensions.phpqrcode.phpqrcode', 1 );
            //QRcode::png("$url");
            //include 'phpqrcode.php';    
            $value = $url; //二维码内容   
            $errorCorrectionLevel = 'L';//容错级别   
            $matrixPointSize = 6;//生成图片大小   
            //生成二维码图片   
            QRcode::png($value, 'images/qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);   
            $logo = 'images/mylogo1.png';//准备好的logo图片   
            $QR = 'images/qrcode.png';//已经生成的原始二维码图   

            if ($logo !== FALSE) {   
                $QR = imagecreatefromstring(file_get_contents($QR));   
                $logo = imagecreatefromstring(file_get_contents($logo));   
                $QR_width = imagesx($QR);//二维码图片宽度   
                $QR_height = imagesy($QR);//二维码图片高度   
                $logo_width = imagesx($logo);//logo图片宽度   
                $logo_height = imagesy($logo);//logo图片高度   
                $logo_qr_width = $QR_width / 5;   
                $scale = $logo_width/$logo_qr_width;   
                $logo_qr_height = $logo_height/$scale;   
                $from_width = ($QR_width - $logo_qr_width) / 2;   
                //重新组合图片并调整大小   
                imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,   
                $logo_qr_height, $logo_width, $logo_height);   
            }   
            //输出图片   
            imagepng($QR, 'images/helloweixin.png');   
            //echo '<img src="'.Yii::app()->request->baseUrl.'/images/helloweixin.png">';
            return '/images/helloweixin.png';
        }
}
