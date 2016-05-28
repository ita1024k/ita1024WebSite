<?php

class TicketTypeController extends Controller
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
	
	public function actionAjaxCreate()
	{
		$model=new TicketType;
		$TicketType = array();
		$user_id = Yii::app()->user->id;
		$article_id = $_POST['TicketType']['article_id'];
		$articles = Yii::app()->db->createCommand()->select('article_id')->from("act_ticket_type")->where("article_id=$article_id AND user_id=$user_id")->queryAll();
		$i = 1;
		if(count($articles)) $i = count($articles)+1;
		if(isset($_POST['TicketType']))
		{
			$model->attributes = $TicketType;
			$model->ticket_title = $_POST['TicketType']['ticket_title'];
			$model->article_id = $_POST['TicketType']['article_id'];
			$model->quantity = $_POST['TicketType']['quantity'];
			$model->price = $_POST['TicketType']['price'];
			$model->SN = $_POST['TicketType']['SN'];
			$model->needapply = $_POST['TicketType']['needapply'];
			$model->PriceStr = $_POST['TicketType']['PriceStr'];
			$model->is_use = $_POST['TicketType']['is_use'];
			$model->PriceStr = $_POST['IsSeriesTicket']['IsSeriesTicket'];
			$model->description = $_POST['TicketType']['description'];
			$model->user_id = Yii::app()->user->id;
			//var_dump($model);exit;
			if($model->save()){
				echo json_encode(array('message' => 'successful','ticket_id'=>$model->ticket_id));
			}else{
				echo json_encode(array('message' => 'failed','ticket_id'=>''));
			}
		}
	}
	
	public function actionAjaxUpdate()
	{
		if(isset($_POST['TicketType']))
		{
			$id = $_POST['TicketType']['ticket_id'];
			$user_id = Yii::app()->user->id;
			$article_id = $_POST['TicketType']['article_id'];
			$articles = Yii::app()->db->createCommand()->select('article_id')->from("act_ticket_type")->where("article_id=$article_id AND user_id=$user_id")->queryAll();
			$i = 1;
			if(count($articles)) $i = count($articles)+1;
			if($id){
				$model=$this->loadModel($id);
				if(isset($_POST['TicketType']))
				{
					$model->attributes='';
					$model->ticket_id = $id;
					$model->ticket_title = $_POST['TicketType']['ticket_title'];
					$model->article_id = $_POST['TicketType']['article_id'];
					$model->quantity = $_POST['TicketType']['quantity'];
					$model->price = $_POST['TicketType']['price'];
					$model->SN = $_POST['TicketType']['SN'];
					$model->needapply = $_POST['TicketType']['needapply'];
					//$model->PriceStr = $_POST['IsSeriesTicket']['IsSeriesTicket'];
					$model->description = $_POST['TicketType']['description'];
					
					if($model->save()){
						//echo "�ɹ���";
						echo json_encode(array('message' => 'successful','ticket_id'=>$model->ticket_id));
					}else{
						echo json_encode(array('message' => 'failed','ticket_id'=>''));
					}
				}
			}
		}
	}
	
	public function actionAjaxDelete(){
		$id = $_POST['ticket_id'];
		$article_id = $_POST['article_id'];
		$user_id = Yii::app()->user->id;
		$articles = Yii::app()->db->createCommand()->select('article_id')->from("act_ticket_type")->where("article_id=$article_id AND user_id=$user_id")->queryAll();
		if(count($articles) < 2){
			echo json_encode(array('message' => '至少有一个'));
		}else{
			if($id){
				$res = $this->loadModel($id)->delete();
				if($res) echo json_encode(array('message' => 'successful'));
			}
		}
		
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TicketType the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TicketType::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TicketType $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ticket-type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
