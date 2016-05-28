<?php

class EventController extends Controller
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
	public function actionCreate()
	{
		$model=new Event;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Event']))
		{
			$model->attributes=$_POST['Event'];
			$uploadedimage=CUploadedFile::getInstance($model, 'logo');
			$uploaddir="./uploads/img_app/";
			if(is_object($uploadedimage) && get_class($uploadedimage)==='CUploadedFile')
			{
				$filename = md5(uniqid());
				$ext = $uploadedimage->extensionName;
				$uploadfile=$uploaddir . $filename . '.' . $ext;
				$model->logo='./uploads/img_app/' . $filename . '.' . $ext;
			}
			$model->user_id = Yii::app()->user->id;
			if(!$model->status) $model->status = 0;
			$model->saveRelation();
			if($model->save()){
				if(!empty($uploadedimage)) $uploadedimage->saveAs($uploadfile);
				if($model->status == 1) {
					$this->redirect(array('/event/event/'));
				}else{
					$this->redirect(array('/eventlist/view/','id'=>$model->event_id));
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		AdrGlobal::userRequestVerify(array('model' => 'Event', '', 'id' => $id));
		$model=$this->loadModel($id);
                if(isset($_POST['Event']))
		{
                    $model->attributes=$_POST['Event'];
                    $uploadedimage=CUploadedFile::getInstance($model, 'logo');
                    $uploaddir="./uploads/img_app/";
                    if(is_object($uploadedimage) && get_class($uploadedimage)==='CUploadedFile')
                    {
                            $filename = md5(uniqid());
                            $ext = $uploadedimage->extensionName;
                            $uploadfile=$uploaddir . $filename . '.' . $ext;
                            $model->logo='./uploads/img_app/' . $filename . '.' . $ext;
                    } else {
                        $model->logo = $_POST['hidLogo'];
                    }
					$model->status = 0;
                    $model->saveRelation();
                    if($model->save()){
                            if(!empty($uploadedimage)) $uploadedimage->saveAs($uploadfile);
                            $this->redirect(array('/eventlist/view/','id'=>$model->event_id));
                    }
                }
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		AdrGlobal::userRequestVerify(array('model' => 'Event', '', 'id' => $id));
		$this->loadModel($id)->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Event;
		$dataProvider = $model->searchAll();
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
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
}
