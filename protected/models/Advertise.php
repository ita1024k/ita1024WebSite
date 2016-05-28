<?php

/**
 * This is the model class for table "act_advertise".
 *
 * The followings are the available columns in table 'act_advertise':
 * @property integer $advertise_id
 * @property integer $position_id
 * @property string $advertise_name
 * @property string $target_url
 * @property integer $status
 * @property string $logo
 */
class Advertise extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'act_advertise';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('position_id, advertise_name, target_url, logo', 'required'),
			array('position_id, status', 'numerical', 'integerOnly'=>true),
			array('advertise_name', 'length', 'max'=>80),
			array('target_url', 'length', 'max'=>90),
			array('logo', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('advertise_id, position_id, advertise_name, target_url, status, logo', 'safe', 'on'=>'search'),
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
			'advertise_id' => '广告ID',
			'position_id' => '广告位ID',
			'advertise_name' => '广告名称',
			'target_url' => '跳转链接',
			'status' => 'Status',
			'logo' => '广告图片',
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
                        $this->advertise_name = $_GET['key_word'];
		}
		$criteria->compare('advertise_id',$this->advertise_id);
		$criteria->compare('position_id',$this->position_id);
		$criteria->compare('advertise_name',$this->advertise_name,true);
		$criteria->compare('target_url',$this->target_url,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('logo',$this->logo,true);

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
	 * @return Advertise the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function editState($advertise_id){
                $string = '<span class="label label_action_blue"><a href="delete/id/'.$advertise_id.'">删除</a></span><span class="label label_action_blue"><a href="update/id/'.$advertise_id.'">编辑</a></span>';
                return $string;
        }
}
