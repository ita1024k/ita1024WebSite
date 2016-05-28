<?php

/**
 * This is the model class for table "act_information".
 *
 * The followings are the available columns in table 'act_information':
 * @property integer $id
 * @property string $phone
 * @property string $name
 * @property string $nickname
 * @property integer $sex
 * @property string $company
 * @property string $business
 * @property string $email
 * @property string $workinglife
 * @property string $create_time
 * @property string $other_data
 */
class Information extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'act_information';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id', 'required'),
			array('sex', 'numerical', 'integerOnly'=>true),
			array('phone', 'length', 'max'=>18),
			array('name', 'length', 'max'=>55),
			array('nickname, business, workinglife', 'length', 'max'=>30),
			array('company', 'length', 'max'=>80),
			array('email', 'length', 'max'=>100),
			array('article_id, ticket_id, create_time, other_data,status', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, article_id, ticket_id, phone, name, nickname, sex, company, business, email, workinglife, create_time, other_data', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'article_id' => 'article_id',
			'ticket_id' => 'ticket_id',
			'phone' => 'Phone',
			'name' => 'Name',
			'nickname' => 'Nickname',
			'sex' => 'Sex',
			'company' => 'Company',
			'business' => 'Business',
			'email' => 'Email',
			'workinglife' => 'Workinglife',
			'create_time' => 'Create Time',
			'other_data' => 'Other Data',
			'status' => 'status',
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
		if($_GET['article_id']){
			$article_id = $_GET['article_id'];
		}else{
			$article_id = 'non';
		}
		if($_GET['key_word']){
			$email = $_GET['key_word'];
		}
		if(preg_match("/^[\w\-\.]+@[\w\-]+(\.\w+)+$/",$_GET['key_word']) && $email){
			$this->email = $email;
		}else if($email){
			$this->name = $email;
		}
		if(isset($_GET['status'])) {
			if($_GET['status'] == 'dai') $_GET['status'] = 0;
			if($_GET['status'] == '-1') $_GET['status'] = '';
			$this->status = $_GET['status'];
		}
		$criteria->compare('id',$this->id);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('article_id',$article_id,true);
		$criteria->compare('ticket_id',$this->ticket_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('business',$this->business,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('workinglife',$this->workinglife,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('other_data',$this->other_data,true);
		$criteria->compare('status',$this->status,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array(
                            'defaultOrder' => 'id DESC',
                        ),
			'pagination'=>array(
				'pageSize'=>20,
			)
		));
	}
	public function getState($id){
		$cmd = Yii::app()->db->createCommand()->select('status')->from('act_information')->where('id=:id',array(':id'=>$id));
		$status = $cmd->queryScalar();
		if($status == 0){
			$string = '<span class="label">待审核</span>';
		}else{
			$string = '<span class="label active">有效</span>';
		}
		return $string;
	}
        public function getMoereData($id){
            $data = Yii::app()->db->createCommand()->select('*')->from('act_information')->where("id=$id")->queryAll();
            $string = '';
            //var_dump($data);exit;
            $data_orders = $data_new = array();
            $data_orders = json_decode($data[0]['other_data'],true);
            if(!empty($data_orders)){
                foreach ($data_orders as $ks=>$vl){
                    if($vl['input_name']){
                        $data_new[$vl['input_name']] = $vl['input_title'];
                        //$headerlist_2['input_name'.$ks] =$vl['input_name'];
                    }else if($vl['checkbox_name']){
                        $checkbox_title = '';
                        if(!empty($vl['checkbox_title'])){
                            foreach($vl['checkbox_title'] as $vc){
                                $checkbox_title .= $vc.',';
                            }
                        }
                        $checkbox_title = trim($checkbox_title,',');
                        $data_new[$vl['checkbox_name']] = $checkbox_title;
                    }else if($vl['textarea_name']){
                        $data_new[$vl['textarea_name']] = $vl['textarea_title'];
                    }else if($vl['radio_name']){
                        $data_new[$vl['radio_name']] = $vl['radio_title'][0];
                    }
                }
            }
            //var_dump($data_new);exit;
            $string .= '<a href="javascript:void(0)" class="icon infor_icon" id=""><div class="popover" role="tooltip" id=""><h5 class="tit">详细信息</h5>';
            $string .='<div class="popover_in">';
            $string .= '<div class="msg_list"><span>所在公司：</span>'.$data[0][company].'</div>';
            $string .= '<div class="msg_list"><span>所在职务：</span>'.$data[0][business].'</div>';
            $string .= '<div class="msg_list"><span>工作年限：</span>'.$data[0][workinglife].'</div>';
            foreach ($data_new as $key=>$val){
                $string .= '<div class="msg_list"><span>'.$key.'：</span>'.$val.'</div>';
            }
            //$string .= '<div class="msg_list"><span>兴趣爱好：</span>文艺</div>';
            $string .='</div><i class="icon icon_triggle_right"></i></div></a>';
            return $string;
        }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Information the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
