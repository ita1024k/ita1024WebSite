<?php

class InformateController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	/**
	 * AjaxCreates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAjaxCreate()
	{
		$model=new Information;
		if(isset($_POST['Information']))
		{
			$model->attributes=$_POST['Information'];
			$article_id = $_POST['Information']['article_id'];
                        if(!empty($_POST['Other_data'])) $model->other_data = json_encode($_POST['Other_data']);
			if($model->save()){
				if($article_id){
					$sql_update = "UPDATE act_article SET sign_count=sign_count+1 WHERE (`id`='$article_id')";
					$count = Yii::app()->db->createCommand($sql_update)->query();
				}
				$this->redirect(Yii::app()->request->baseUrl.'/activity/view/id/'.$article_id.'?bm=1');
                                //echo json_encode(array("message" => "1111111"));
                        }else{
                            $this->redirect(Yii::app()->request->baseUrl.'/activity/view/id/'.$article_id);
                        }
			
		}
		
	}
        
        public function actionAjaxSendEmail()
	{
            //var_dump($_POST['email_text']);exit;
            if(isset($_POST['article_id']) && isset($_POST['email_text']))
            {
                    $article_id = $_POST['article_id'];
                    $sql = "SELECT u.email FROM act_article a LEFT JOIN act_user u ON a.user_id = u.user_id WHERE a.id = $article_id";
                    $email = Yii::app()->db->createCommand($sql)->queryScalar();
                    $sql2 = "SELECT title FROM act_article WHERE id = $article_id";
                    $ar_title = Yii::app()->db->createCommand($sql2)->queryScalar();
                    $title = '来自ITA官网';
                    $message = $_POST['email_text'].'　此消息来自活动：<a href="http://www.ita1024.com/activity/view/id/'.$_POST[article_id].'" target="_brank">'.$ar_title.'</a>';//.$_POST['article_id'];
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
                    if($email) $is_ok = AdrGlobal::email($email,$message_all,$title);
                    if($is_ok) echo json_encode(array("message" => "1111111"));
            }
		
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
        
//    public function sendEmails($address,$message_all,$title){
//        $len = strpos($address, "@");
//        $user_name = substr($address,0,$len);
//        Yii::import('application.extensions.phpmailer.JPhpMailer');
//        $mail_from = "qinqingbing@yeah.net";
//        $mail = new JPhpMailer;
//        $mail->IsSMTP();
//        $mail->CharSet = "UTF-8";
//        $mail->Host = "smtp.yeah.net";
//        $mail->SMTPAuth = true;
//        $mail->Username = $mail_from;
//        $mail->Password = "";//"1qaz@WSX"; 
//        $mail->SetFrom($mail_from, 'Ita');
//        $mail->IsHTML(true);
//        $mail->Subject = $title;
//        $mail->Body = $message_all;
//        //$mail->AddAttachment($attachment);附件
//        $mail->AddAddress($address, $user_name);
//        if($mail->Send()){
//            return true;
//        }else{
//            return false;
//        }
//    }
}
