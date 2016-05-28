<?php

/**
 * This is the model class for table "act_content".
 *
 * The followings are the available columns in table 'act_content':
 * @property integer $id
 * @property string $input_time
 * @property string $update_time
 * @property string $content
 * @property integer $allow_comment
 * @property integer $status
 * @property string $picture
 * @property string $relation
 */
class ArticleContent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'act_article_content';
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
			//array('id, allow_comment, status', 'numerical', 'integerOnly'=>true),
			//array('picture', 'length', 'max'=>100),
			//array('relation', 'length', 'max'=>50),
			array('input_time, update_time, content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, input_time, update_time, content, allow_comment, status, picture, relation', 'safe', 'on'=>'search'),
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
			'id' => '任务ID',
			'input_time' => '开始日期',
			'update_time' => '结束日期',
			'content' => '任务描述',
			'allow_comment' => '支持设备',
			'status' => '任务状态',
			'picture' => '缩略图',
			'relation' => 'Relation',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('input_time',$this->input_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('allow_comment',$this->allow_comment);
		$criteria->compare('status',$this->status);
		$criteria->compare('picture',$this->picture,true);
		$criteria->compare('relation',$this->relation,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArticleContent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
