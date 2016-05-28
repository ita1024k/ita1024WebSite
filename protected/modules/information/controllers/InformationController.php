<?php

class InformationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public function filters(){
		return array(
			'rights'
		);
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Information('search');
		$model->unsetAttributes(); // clear any default values
		if(isset($_GET['Information']))
			$model->attributes=$_GET['Information'];
		
		//下载
		$article_id = $_GET['article_id'];
		$download = $_GET['download'];
		if($download) {
			$headerlist_1 = array('name'=>'名称','phone'=>'手机','email'=>'邮箱','company'=>'所属公司','business'=>'所属职务','workinglife'=>'工作年限','status'=>'状态','create_time'=>'报名时间');
			$headerlist_2 = array();
			$data = $this->getAllData($article_id);
                        //var_dump($data);exit;
			if(!empty($data)){
				foreach($data as $key=>$val){
                                        $data_orders = json_decode($val['other_data'],true);
                                        
					$data_new[$key][name] = $val[name];
					$data_new[$key][phone] = $val[phone];
					$data_new[$key][email] = $val[email];
                                        $data_new[$key][company] = $val[company];
                                        $data_new[$key][business] = $val[business];
                                        $data_new[$key][workinglife] = $val[workinglife];
					if($val[status] == 1){
						$data_new[$key][status] = '有效';
					}else{
						$data_new[$key][status] = '待审核';
					}
                                        if(!empty($data_orders)){
                                            foreach ($data_orders as $ks=>$vl){
                                                if($vl['input_name']){
                                                    $data_new[$key]['input_name'.$ks] = $vl['input_title'];
                                                    $headerlist_2['input_name'.$ks] =$vl['input_name'];
                                                }else if($vl['checkbox_name']){
                                                    $checkbox_title = '';
                                                    if(!empty($vl['checkbox_title'])){
                                                        foreach($vl['checkbox_title'] as $vc){
                                                            $checkbox_title .= $vc.',';
                                                        }
                                                    }
                                                    $checkbox_title = trim($checkbox_title,',');
                                                    $data_new[$key]['checkbox_name'.$ks] = $checkbox_title;
                                                    $headerlist_2['checkbox_name'.$ks] =$vl['checkbox_name'];
                                                }else if($vl['textarea_name']){
                                                    $data_new[$key]['textarea_name'.$ks] = $vl['textarea_title'];
                                                    $headerlist_2['textarea_name'.$ks] =$vl['textarea_name'];
                                                }else if($vl['radio_name']){
                                                    $data_new[$key]['radio_name'.$ks] = $vl['radio_title'][0];
                                                    $headerlist_2['radio_name'.$ks] =$vl['radio_name'];
                                                }
                                            }
                                        }
					$data_new[$key][create_time] = $val[create_time];
                                        
				}
			}
                        $headerlist = array_merge($headerlist_1,$headerlist_2);
                        //var_dump($data_new);exit;
			AdrGlobal::export_csv($data_new,"报名数据",$headerlist);
		}
		
		$this->render('admin',array(
			'model'=>$model,
		));
	}
        public function getAllData($article_id){
            $data = Yii::app()->db->createCommand()->select('*')->from('act_information')->where("article_id=$article_id")->queryAll();
            return $data;
        }
        /**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	public function actionCheckThrough()
	{
		$id_list = $_POST['id_list'];
		$string_id = '';
		if(!empty($id_list)){
			foreach($id_list as $val){
				$string_id .= $val.',';
			}
			$string_id = trim($string_id,',');
		}
		if($string_id){
			////$sql = "SELECT id FROM act_information WHERE id in($string_id) AND status = 0";
			////$datas = Yii::app()->db->createCommand($sql)->queryAll();
			$sql_update = "UPDATE act_information SET status=1 WHERE id in($string_id) AND status = 0";
			$count = Yii::app()->db->createCommand($sql_update)->query();
			if($count) echo json_encode(array("message" => "1111111"));
		}else{
			echo json_encode(array("message" => ""));
		}
	}
	
	public function actionSendEmail()
	{
		$id_list = $_POST['id_list'];
                //var_dump($id_list);exit
		$string_id = '';
		if(!empty($id_list)){
			foreach($id_list as $key=>$val){
				$string_id .= $val.',';
			}
			$string_id = trim($string_id,',');
		}
		if($string_id){
			$sql = "SELECT a.id,a.email,a.article_id,b.title FROM act_information a LEFT JOIN act_article b ON a.article_id = b.id WHERE a.id in($string_id) AND a.status = 1";
			$datas = Yii::app()->db->createCommand($sql)->queryAll();
		}
		
                //$this->sendEmails($email,$title);
		if(!empty($datas)){
			foreach($datas as $key=>$val){
                                $title = '您的报名已通过审核';
                                $message = '您的报名已通过审核，活动信息：<a href="http://www.ita1024.com/activity/view/id/'.$val[article_id].'" target="_brank">'.$val[title].'</a>，活动将于近期开始，请您提前安排好时间参加。';//.$_POST['article_id'];
                                $message_all = " 
                                    <html>
                                    <head> 
                                    <title>来自ITA官网</title>
                                    </head>
                                    <body>
                                    <p>$message</p>
                                    </body>
                                    </html>
                                ";
				AdrGlobal::email($val['email'],$message_all,$title);
			}
			echo json_encode(array("message" => "1111111"));
		}else{
			echo json_encode(array("message" => ""));
		}
	}
        /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Information the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Information::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Information $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='information-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
