<?php

/**
 * This is the model class for table "act_article".
 *
 * The followings are the available columns in table 'act_article':
 * @property integer $id
 * @property string $title
 * @property string $user_id
 * @property string $nums
 * @property string $start_date
 * @property string $end_date
 * @property string $description
 * @property string $language
 * @property string $area
 * @property string $support
 * @property integer $status
 * @property string $picture
 */
class Article extends CActiveRecord
{
    public $contdata;
    public $ticket_id;
    public $ticketType = array();
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'act_article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, user_id, start_date, end_date, address, nums, ticket_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('title, user_id, support', 'length', 'max'=>30),
			array('nums, province, city', 'length', 'max'=>50),
			array('language', 'length', 'max'=>22),
			array('picture,homepic', 'length', 'max'=>100),
			array('start_date, province, city, end_date, address, start_time, end_time, description ,contdata,ticket_id,label,map_point,sign_count,ticketType,delay_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, user_id, nums, start_date, end_date, start_time, end_time, description, language,  province, city, support, status, picture, homepic, contdata, label', 'safe', 'on'=>'search'),
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
                    'ArticleContent' => array(self::HAS_MANY, 'ArticleContent', 'id'),//内容
                    'TicketType' => array(self::HAS_MANY, 'TicketType', 'article_id'),
		);
	}
        
	public function saveRelation(){
		$relationData = array();
		$input_time = date("Y-m-d H:i:s",time());
		$this->setRelationRecords('ArticleContent', array(array('input_time'=>$input_time,'update_time'=>$input_time,'content'=>$this->contdata)));
		
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => '活动名称',
			'user_id' => '用户ID',
			'nums' => '活动人数',
			'start_date' => '开始时间',
			'end_date' => '结束时间',
			'address'=>'活动地址',
			'description' => '活动描述',
			'language' => '语言',
			'province' => '活动省份',
			'city' => '活动城市',
			'support' => '隐私设置',
			'status' => '是否审核',
			'picture' => '活动海报',
			'label'=>'添加标签',
			'map_point'=>'map_point',
			'sign_count'=>'sign_count',
			'delay_date'=>'delay_date',
			'contdata'=>'内容',
			'ticket_id'=>'免费票种',
			'homepic'=>'首页BANNER',
		);
	}
	public function afterFind(){
		if(count($this->ArticleContent)){
			$this->contdata = $this->ArticleContent[0]->content;
                        //var_dump($this->ArticleContent);
		}
                if(count($this->TicketType)){
			$this->ticketType = $this->TicketType;
                        //var_dump($this->ticketType);exit;
		}
		parent::afterFind();
	}
	
	public function behaviors() {
		return array(
                        'CSaveRelationsBehavior' => array('class' => 'application.components.CSaveRelationsBehavior'),
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('nums',$this->nums,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('support',$this->support,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('picture',$this->picture,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('map_point',$this->map_point,true);
		$criteria->compare('sign_count',$this->sign_count,true);
		$criteria->compare('delay_date',$this->delay_date,true);
		$criteria->compare('homepic',$this->homepic,true);
		
		if(isset($_GET['tag_id']) && $_GET['tag_id'] != 0){
			$tag_id = $_GET['tag_id'];
			echo $tag_id;exit;
			$criteria->compare('label', $tag_id);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array(
                        'defaultOrder' => 'id DESC',
                        'attributes' => array(),
                        ),
                        //'pagination' => array(
                            //'pageSize' => Yii::app()->user->getState('pageSize'),
                        //)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Article the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function activityList() {
            $dataoffers_n = Yii::app()->db->createCommand()->select('*')->from('act_article')->where("status=0")->queryAll();
            //var_dump($dataoffers_n);exit;
            $new_dataoffers = new CArrayDataProvider($dataoffers_n, array(
                'sort' => array(
                    'attributes' => array(
                        'id'
                    ),
                    'defaultOrder' => 'id DESC'
                ),
                //'sort'=>array('attributes'=>array('id')),
                'pagination' => array(
                    'pageSize' => Yii::app()->user->getState('pageSize'),
                )
            ));

            return $new_dataoffers;
        }
    /**
     * 检测当前用户是否有权限操作
     * @date 2015-12-22
     */
    public function checkAccessArticle($id,$user_id){
        //if (Yii::app()->user->checkAccess('Admin')) {
            $num = $this->getDbConnection()->createCommand()->select('count(id)')->from('act_article')
                ->where('id=:oid AND user_id = :uid',array(':oid'=>$id,':uid'=>$user_id))
                ->queryScalar();
        //}
        return $num ? true : false;
    }
}
