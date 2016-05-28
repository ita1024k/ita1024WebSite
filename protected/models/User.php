<?php

/**
 * This is the model class for table "act_user".
 *
 * The followings are the available columns in table 'act_user':
 * @property integer $user_id
 * @property string $media_id
 * @property string $user_name
 * @property string $email
 * @property integer $status
 * @property string $phone
 * @property string $password
 * @property integer $user_type
 * @property string $adrss
 * @property integer $country
 * @property string $weburl
 * @property string $connect
 * @property integer $company_id
 * @property string $company
 * @property string $postcode
 * @property integer $open_state
 * @property string $token
 * @property integer $pay_percent
 */
class User extends CActiveRecord
{
        public $confirm_password = '';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'act_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('media_id, user_name, password, user_type, open_state', 'required'),
			array('status, user_type, country, company_id, open_state, pay_percent', 'numerical', 'integerOnly'=>true),
			array('media_id', 'length', 'max'=>33),
                        array('password,confirm_password', 'length', 'min' => 6, 'tooShort' => 'Password can not be less than 6'),
			array('user_name, postcode', 'length', 'max'=>30),
			array('email, phone', 'length', 'max'=>255),
			array('password, connect', 'length', 'max'=>50),
			array('adrss, weburl', 'length', 'max'=>150),
			array('company', 'length', 'max'=>100),
			array('token', 'length', 'max'=>32),
                        array('user_name,email', 'unique', 'on' => 'register'),
                        array('user_name,email', 'unique', 'on' => 'create'),
                        array('user_name,email', 'unique'),
                        array('confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Inconsistent password', 'on' => 'create'),
                        array('user_id, media_id, user_name, title, email, status, phone, password, confirm_password, user_type, adrss, connect, company, zipcode, open_state, token', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, media_id, user_name, email, status, phone, password, user_type, adrss, country, weburl, connect, company_id, company, postcode, open_state, token, pay_percent', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => '用户ID',
			'media_id' => '媒体ID',
			'user_name' => 'User Name',
			'email' => 'Email',
			'status' => '状态',
			'phone' => 'Phone',
			'password' => 'MD5加密',
			'user_type' => '用户登陆类型，0为超级用户，1为广告主用户，2为媒体人',
			'adrss' => 'Adrss',
			'country' => 'Country',
			'weburl' => 'Weburl',
			'connect' => 'Connect',
			'company_id' => 'publisher所属的代理商，为0则没有代理商',
			'company' => 'Company',
			'postcode' => 'Postcode',
			'open_state' => 'Open State',
			'token' => 'API接口验证码',
			'pay_percent' => '资源毛利率',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                if($_GET['key_word']){
                        $this->user_name = $_GET['key_word'];
		}
                if($_GET['status']){
                        $this->status = $_GET['status'];
		}
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('media_id',$this->media_id,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('user_type',$this->user_type);
		$criteria->compare('adrss',$this->adrss,true);
		$criteria->compare('country',$this->country);
		$criteria->compare('weburl',$this->weburl,true);
		$criteria->compare('connect',$this->connect,true);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('open_state',$this->open_state);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('pay_percent',$this->pay_percent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
				'pageSize'=>5,
			)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
     * 判断当前用户是否属于超级管理员组
     * @param integer $user_id
     * @return array
     * @author guoqiang.zhang
     * @date 2015-12-22
     */
    public function isSuperUserById($user_id) {
        $adminColumn = Rights::module()->superuserName;
        $sql = "select count(u.user_id) as num from ofr_user u left join AuthAssignment au on u.user_id = au.userid where au.userid = " . $user_id . " AND au.itemname = '" . $adminColumn . "'";
        $result = $this->getDbConnection()->createCommand($sql)->queryScalar();
        return $result ? true : false;
    }
    public function getState($user_id){
        if($user_id){
            $sql = "SELECT status FROM act_user WHERE user_id = $user_id";
            $status  = Yii::app()->db->createCommand($sql)->queryScalar();
            //echo $status;
            if($status == 1){
                $string = '<span class="label label_grey">待审核</span>';
                return $string;
            }else if($status == 2){
                $string = '<span class="label label_orange">未通过</span>';
                return $string;
            }else{
                $string = '<span class="label label_blue">已通过</span>';
                return $string;
            }
        }
    }
    public function setState($user_id){
        if($user_id){
            $sql = "SELECT status FROM act_user WHERE user_id = $user_id";
            $status  = Yii::app()->db->createCommand($sql)->queryScalar();
            if($status == 0){
                if($user_id == 1){
                    $string = '<span class="label label_pass_green">通过</span>';
                }else{
                    $string = '<span class="label label_pass_green">通过</span><span class="label label_notPass" onclick="ajaxCheckThrough(2,'.$user_id.');">不通过</span>';
                }
                return $string;
            }else{
                if($user_id == 1){
                    $string = '<span class="label label_pass_green">通过</span>';
                }else{
                    $string = '<span class="label label_pass_grey" onclick="ajaxCheckThrough(0,'.$user_id.');">通过</span><span class="label label_notPass" onclick="ajaxCheckThrough(2,'.$user_id.');">不通过</span>';
                }
                return $string;
            }
        }
    }
    public function editState($user_id){
            $string = '<span class="label label_action_blue"><a href="resetpw/id/'.$user_id.'">重置密码</a></span><span class="label label_action_blue"><a href="update/id/'.$user_id.'">编辑</a></span>';
            return $string;
    }
}
