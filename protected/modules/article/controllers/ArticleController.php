<?php

class ArticleController extends Controller
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
		$model=new Article;
		$user_id = Yii::app()->user->id;
		$date = date("Y-m-d",time());
		$model->start_date = $date;
		$model->end_date = $date;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$areas = Yii::app()->db->createCommand()->select('province')->from('act_area_def')->group('province')->queryAll();
		if($areas){
			foreach($areas as $a){
				$ar_province[$a['province']]= $a['province'];
			}
		}
		$tag_arrs = Yii::app()->db->createCommand()->select('tag_id,tag_name')->from('act_label')->queryAll();
		$article_id = '';
		$article_id = Yii::app()->db->createCommand()->select('article_id')->from("act_ticket_type")->where("is_use=0 AND user_id=$user_id")->queryScalar();
		if($article_id) $_id = Yii::app()->db->createCommand()->select('id')->from("act_article")->where("id=$article_id")->queryScalar();
		//var_dump($article_id);exit;
		if(empty($article_id) && empty($_id)){
			$id = time().str_pad(mt_rand(1, 999), 3, '9', STR_PAD_LEFT);
                        $model->ticket_id = false;
		}else{
                        $model->ticket_id = true;
			$id = $article_id;
		}
		//var_dump($id);exit;
		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
			$model->picture;
			$uploadedimage=CUploadedFile::getInstance($model, 'picture');//start_time
			$uploaddir="./uploads/img_app/";
			if(is_object($uploadedimage) && get_class($uploadedimage)==='CUploadedFile')
			{
				$filename = md5(uniqid());
				$ext = $uploadedimage->extensionName;
				$uploadfile=$uploaddir . $filename . '.' . $ext;
				$model->picture='./uploads/img_app/' . $filename . '.' . $ext;
			}
			$model->id = $id;
                        $model->sign_count = 0;
			$model->label = trim($model->label,',');
			$model->user_id = Yii::app()->user->id;
			if(!$model->status) $model->status = 0;
			$articles = Yii::app()->db->createCommand()->select('article_id')->from("act_ticket_type")->where("is_use=0 AND user_id=$user_id")->queryScalar();
			if(!$article_id){
				$model->ticket_id = '';
			}else{
				$model->ticket_id = true;
			}
			$model->saveRelation();
			if($model->save()){
				$id = $model->id;
				if(!empty($uploadedimage)) $uploadedimage->saveAs($uploadfile);
				$sql_update = "UPDATE act_ticket_type SET is_use=1 WHERE article_id=$id";
				Yii::app()->db->createCommand($sql_update)->query();
				if($model->status == 1) {
					$this->redirect(array('/article/article/'));
				}else{
					$this->redirect(array('/activity/view/','id'=>$model->id));
				}
			}
		}
		$this->render('create',array(
			'model'=>$model,
			'id'=>$id,
			'ar_province'=>$ar_province,
			'tag_arrs'=>$tag_arrs
		));
	}
	public function actionShowCity(){
		if(isset($_POST['city']))
		{
			$province = $_POST['city'];
			$string1 = $string2 = '';
			$areas = Yii::app()->db->createCommand()->select('city')->from('act_area_def')->where("province = '$province'")->queryAll();
			if($areas){
				foreach($areas as $a){
					$string1 .='<option value="'.$a[city].'" >'.$a[city].'</option>';
				}
			}
			if($areas){
				$i = 0;
					foreach($areas as $a){
					$string2 .= '<li data-original-index="'.$i.'"><a tabindex="0" class="" data-normalized-text="<span class=&quot;text&quot;>'.$a[city].'</span>"><span class="text">'.$a[city].'</span><span class="check-mark"></span></a></li>';
					$i++;
				}
			}
			echo json_encode(array("string1" => "$string1","string2" => "$string2"));
		}
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		AdrGlobal::userRequestVerify(array('model' => 'Article', '', 'id' => $id));
		$model=$this->loadModel($id);
                $model->ticket_id = true;
		$date = date("Y-m-d",time());
		$date2 = date("Y-m-d",strtotime("+1 day"));
		$startdate = $date;
		$enddate = $date2;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        $areas = Yii::app()->db->createCommand()->select('province')->from('act_area_def')->group('province')->queryAll();
		$label = trim($model->label,',');
		if($label) $tag_arrs_chose = Yii::app()->db->createCommand()->select('tag_id,tag_name')->from('act_label')->where("tag_id in($label)")->queryAll();
		if($areas){
			foreach($areas as $a){
				$ar_province[$a['province']]= $a['province'];
			}
		}
		$tag_arrs = Yii::app()->db->createCommand()->select('tag_id,tag_name')->from('act_label')->queryAll();
		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
			$uploadedimage=CUploadedFile::getInstance($model, 'picture');
			$uploaddir="./uploads/img_app/";
			if(is_object($uploadedimage) && get_class($uploadedimage)==='CUploadedFile')
			{
				$filename = md5(uniqid());
				$ext = $uploadedimage->extensionName;
				$uploadfile=$uploaddir . $filename . '.' . $ext;
				$model->picture='./uploads/img_app/' . $filename . '.' . $ext;
			}else{
				$model->picture = $_POST['hidLogo'];
			}
            $model->label = trim($model->label,',');
			$model->ticket_id = true;
			$model->saveRelation();
			if($model->save()){
				if(!empty($uploadedimage)) $uploadedimage->saveAs($uploadfile);
				$sql_update = "UPDATE act_ticket_type SET is_use=1 WHERE article_id=$id";
				Yii::app()->db->createCommand($sql_update)->query();
				$this->redirect(array('/activity/view/id/'.$id));
			}
		}
		$this->render('update',array(
			'model'=>$model,
			'id'=>$id,
			'ar_province'=>$ar_province,
			'tag_arrs'=>$tag_arrs,
			'ticket_arrs'=>$ticket_arrs,
			'tag_arrs_chose'=>$tag_arrs_chose
		));
	}
	public function actionUpdatePicture($id)
	{
		AdrGlobal::userRequestVerify(array('model' => 'Article', '', 'id' => $id));
		$model=$this->loadModel($id);
		$model->is_position = 1;
		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
			$uploadedimage=CUploadedFile::getInstance($model, 'homepic');
			$uploaddir="./uploads/img_app/";
			if(is_object($uploadedimage) && get_class($uploadedimage)==='CUploadedFile')
			{
				$filename = md5(uniqid());
				$ext = $uploadedimage->extensionName;
				$uploadfile=$uploaddir . $filename . '.' . $ext;
				$model->homepic='./uploads/img_app/' . $filename . '.' . $ext;
			}else{
				$model->homepic = $_POST['hidHomepic'];
			}
			//var_dump($_POST['Article']['is_position']);exit;
			if($_POST['Article']['is_position']) {
				$model->is_position = 2;
			}else{
				$model->is_position = 0;
			}
			$sql_update = "UPDATE act_article SET homepic='$model->homepic',is_position='$model->is_position' WHERE id=$id";
			$is_ok = Yii::app()->db->createCommand($sql_update)->query();
			if($is_ok){
				if(!empty($uploadedimage)) $uploadedimage->saveAs($uploadfile);
				$this->redirect(array('/article/article/'));
			}
		}
		$this->render('updatepic',array(
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
                AdrGlobal::userRequestVerify(array('model' => 'Article', '', 'id' => $id));
		$this->loadModel($id)->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	public function actionChangeStatus()
	{
		$id = $_POST['id'];
		$status = $_POST['status'];
		$is_position = $_POST['is_position'];
		if($status){
			$sql_update = "UPDATE act_article SET status=$status WHERE id=$id";
			$count = Yii::app()->db->createCommand($sql_update)->query();
			if($count) echo json_encode(array("message" => "1111111"));
		}else if($is_position){
			if($is_position == -1) $is_position = 0;
			$sql_update = "UPDATE act_article SET is_position=$is_position WHERE id=$id";
			$count = Yii::app()->db->createCommand($sql_update)->query();
			if($count) echo json_encode(array("message" => "1111111"));
		}else{
			echo json_encode(array("message" => ""));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$user_id = Yii::app()->user->id;
		if(isset($_GET['status'])){
			$status = $_GET['status'];
			$conditions = "status=$status AND user_id=$user_id";
		}else{
			$conditions = "status=0 AND  user_id=$user_id";
		}
		$pageSize = 5;
		$dataProvider=new CActiveDataProvider('Article',array(
					'sort' => array(
                        'defaultOrder' => 'id DESC',
					),
					'criteria'=>array(
						'condition'=>$conditions,
					),
					'pagination'=>array(
						'pageSize'=>$pageSize,
					),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Article the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Article::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Article $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='article-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
