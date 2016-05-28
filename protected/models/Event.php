<?php

/**
 * This is the model class for table "act_event".
 *
 * The followings are the available columns in table 'act_event':
 * @property integer $event_id
 * @property integer $user_id
 * @property string $event_title
 * @property string $event_author
 * @property string $description
 * @property string $create_time
 * @property integer $status
 * @property string $logo
 */
class Event extends CActiveRecord
{
	public $contdata;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'act_event';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, event_title, event_author, contdata', 'required'),
			array('user_id, status', 'numerical', 'integerOnly'=>true),
			array('event_title', 'length', 'max'=>150),
			array('event_author', 'length', 'max'=>30),
			array('description', 'length', 'max'=>250),
			array('logo', 'length', 'max'=>100),
			array('contdata', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, event_title, event_author, description, create_time, status, logo,contdata', 'safe', 'on'=>'search'),
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
			'EventContent' => array(self::HAS_MANY, 'EventContent', 'event_id'),//内容
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'event_id' => 'Event',
			'user_id' => 'User',
			'event_title' => '文章标题',
			'event_author' => '文章作者',
			'description' => '描述',
			'create_time' => '更新时间',
			'status' => '1审核0不审核',
			'logo' => '图片',
			'contdata'=>'正文'
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

		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('event_title',$this->event_title,true);
		$criteria->compare('event_author',$this->event_author,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('logo',$this->logo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Event the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function saveRelation(){
		//$relationData = array();
		//$input_time = date("Y-m-d H:i:s",time());
		//var_dump($this->contdata);exit;
		$this->setRelationRecords('EventContent', array(array('content'=>$this->contdata)));
		
	}
	
	public function afterFind(){
		if(count($this->EventContent)){
			$this->contdata = $this->EventContent[0]->content;
			//var_dump($this->ArticleContent);
		}
		parent::afterFind();
	}
	
	public function behaviors() {
		return array(
			'CSaveRelationsBehavior' => array('class' => 'application.components.CSaveRelationsBehavior'),
		);
	}
        
        public function searchAll(){
            $isread = 0;
            if($_GET['status']) $isread = $_GET['status'];
            $new_arrs = array();
            $user_id = Yii::app()->user->id;
            $command = Yii::app()->db->createCommand();
            $command->select('*');
            $command->from('act_event');
            $command->where("user_id='$user_id' AND status=$isread");
            $new_arrs = $command->queryAll();
            //var_dump($new_arrs);exit;
            $dataProvider = new CArrayDataProvider($new_arrs, array(
                'id'=>'hot_recom_list',
                'sort'=>array(
                    'attributes'=>array(
                        'event_id',
                    ),
                    'defaultOrder'=>'event_id DESC'
                ),
                'pagination'=>array(
                    'pageSize'=>5,
                )
            ));
            
            return $dataProvider;
        }
	/**
     * 检测当前用户是否有权限操作
     * @return boolean
     * @date 2015-12-22
     */
    public function checkAccessEvent($id,$user_id){
        //if (Yii::app()->user->checkAccess('Admin')) {
            $num = $this->getDbConnection()->createCommand()->select('count(event_id)')->from('act_event')
                ->where('event_id=:oid AND user_id = :uid',array(':oid'=>$id,':uid'=>$user_id))
                ->queryScalar();
        //}
        return $num ? true : false;
    }
}
