<?php

class SignFormController extends Controller
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAjaxCreate()
	{       
                
		
		$dataForms = $_POST['datas'];
		$data_1 = $data_2 = $data_new = array();
                
		foreach($dataForms as $key=>$val){
			if($val['name'] == 'activityId'){
				$data_new['article_id'] = $val['value'];
                                $form_id = Yii::app()->db->createCommand()->select('form_id')->from("act_sign_form_type")->where("article_id=$data_new[article_id]")->queryScalar();
                            if($form_id){
                                $model=$this->loadModel($form_id);
                            }else{
                                $model=new SignFormType;
                            }
			}else if($val['name'] == 'version'){
				$data_new['version'] = $val['value'];
			}else if($val['name'] == 'sortmax'){
				$data_new['sortmax'] = $val['value'];
			}
			preg_match("/(?:\[)(.*)(?:\].)/i", $val['name'], $res_zk);
			preg_match("/\.(?:)(.*)/i",$val['name'], $res_dd);
			preg_match("/^(.*)(?:\[(.*)(?:\].))/i",$val['name'], $res_item);
			//echo $res_item['1'];
			if($res_item['1'] == 'items'){
				$data_2[$res_zk['1']][$res_dd['1']] = $val['value'];
			}
			
		}
		$other_data = json_encode($data_2);
		$data_new['other_data'] = $other_data;
		
		if(!empty($data_new))
		{
			$model->attributes=$data_new;
			if($model->save()){
				echo json_encode(array("message" => "1111111"));
			}
		}
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SignFormType the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SignFormType::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SignFormType $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sign-form-type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
