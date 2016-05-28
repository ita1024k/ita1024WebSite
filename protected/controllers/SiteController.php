<?php

class SiteController extends Controller
{
	public $layout='column2';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		///var_dump(Yii::app()->session);
		$this->pageTitle=Yii::app()->name;
		$tag_id = !empty($_GET['tag_id']) ? $_GET['tag_id'] : null; 
		$position_arrs = Yii::app()->db->createCommand()->select('*')->from('act_advertise')->where("position_id='100012' AND status='0'")->limit("5")->queryAll();
		if(!empty($tag_id)){
			$conditions = "status=0 AND support='0' AND (label like '%,$tag_id' or label like '%,$tag_id,%' or label like '$tag_id,%')";
		}else{
			$conditions = "status=0 AND support='0'";
		}
		$data_Provider=new CActiveDataProvider('Article',array(
			'criteria'=>array(
				'condition'=>$conditions,
			),
		));
		$totalCount = $data_Provider->totalItemCount+8;
		$pageSize = 8;
		if(isset($_GET['page'])){
			$currentPage = $_GET['page'];
			$pageSize = $data_Provider->pagination->pageSize;
			if($totalCount > $currentPage*8){
				$pageSize = $currentPage*8;
			}
		}
		//echo $pageSize;exit;
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
			'position_arrs'=>$position_arrs,
                        'totalCount'=>$totalCount,
                        'pageSize_first'=>8,
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
        
        public function actionForgetEmail()
	{
		$model=new User();
		$this->performAjaxValidation($model);
		//$this->layout= '//layouts/public_main';
		if(!Yii::app()->user->isGuest)
		{
			$this->redirect(Yii::app()->homeUrl);
		}
		else
		{
			$this->render('forgetEmail',array('model'=>$model));
		}
		
	}
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
            if(Yii::app()->user->isGuest){
                $this->layout='noframe';
		$model=new LoginForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
            }else{
                $this->redirect(Yii::app()->homeUrl);
            }
	}
        
        public function actionEmailAjax()
	{
		if($_REQUEST)
		{
			$email = $_REQUEST['email'];
                        
			$base = base64_encode($email);
                        $str = md5(uniqid());
                        $string = substr($str,6,6);
                        $base = $string.$base;
			$ResetUrl = Yii::app()->request->hostInfo.Yii::app()->homeUrl."site/resetPassword?email=$base";
			$homeUrl = Yii::app()->request->hostInfo.Yii::app()->homeUrl."site/login";
			//$html = "<a href='$ResetUrl'>".'请点击链接重新设置您的密码！'."</a>";
			$html = "<div id='' style='border:1px solid #ccc;background-color: #fff ;border-radius: 10px;margin-right: auto;margin-top: 25px;width: 700px;'>
			<div class='form123' style=''>
				<p class='note' style='padding-top:30px;padding-bottom:30px;padding-left:50px;'>
				            亲爱的用户
                    <a href='$ResetUrl' style=''>请点击链接重新设置您的密码！</a></p>
			    <p class='' style='border-top:1px solid #CCCCCC;width:100%;'></p>
				<div class='user-list-div1' style='padding-bottom:10px;padding-left:50px;'>
					<div class='input-group' style='font-style: italic;'>
                                        <b>ITA中国互联网联盟<b>
					</div>
				</div>
				<div class='clear'></div>
			</div><!-- form -->
			</div>";
			$title = "找回密码";
			$sql = Yii::app()->db->createCommand("SELECT user_id FROM act_user WHERE email = '$email'")->queryScalar();
			if($sql)
			{
                                AdrGlobal::email($email, $html,$title);
				$label = 1;
			}
			else 
			{
				$label = "请输入正确的邮箱地址";
			}
			
			echo json_encode ($label);
		}
	
	}
        public function actionResetPassword()
	{
                //echo 222;exit;
		$model=new User();
		$this->performAjaxValidation($model);
		if(isset($_POST['User']))
		{          
			$email = base64_decode(substr($_GET['email'],6));
			$password = md5($_POST['User']['password']);
			$sql_update = "UPDATE act_user SET password = '$password' WHERE email = '$email'";
			$command = Yii::app()->db->createCommand($sql_update)->execute();
			$state = 1;
		}
		
		if(!Yii::app()->user->isGuest)
		{
			$this->redirect(Yii::app()->homeUrl);
		}
		else
		{
		   $this->render('resetPassword',
                           array(
                                'model'=>$model,
                                'state'=>$state
                           )
                        );
		}
	
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
        /**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='agent-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}