<?php
/**
 * This is the model class for table "act_sign_form_type".
 *
 * The followings are the available columns in table 'act_sign_form_type':
 * @property integer $form_id
 * @property integer $article_id
 * @property integer $version
 * @property string $sortmax
 * @property string $other_data
 */
class SignFormType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'act_sign_form_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_id', 'required'),
			array('article_id, version', 'numerical', 'integerOnly'=>true),
			array('sortmax', 'length', 'max'=>50),
			array('other_data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('form_id, article_id, version, sortmax, other_data', 'safe', 'on'=>'search'),
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
			'form_id' => 'Form',
			'article_id' => 'Article',
			'version' => 'Version',
			'sortmax' => 'Sortmax',
			'other_data' => 'Other Data',
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

		$criteria->compare('form_id',$this->form_id);
		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('version',$this->version);
		$criteria->compare('sortmax',$this->sortmax,true);
		$criteria->compare('other_data',$this->other_data,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SignFormType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function getSignForm($id){
                $string = '';
                
		if($id){
                    $form_arrs = Yii::app()->db->createCommand()->select('*')->from("act_sign_form_type")->where("article_id = '$id'")->queryAll();
                    //var_dump($form_arrs);
                    foreach($form_arrs as $key=>$val){
                            $data_orders = json_decode($val['other_data'],true);
                            $square_icon_check = 'square_icon_checked';
                            if(!empty($data_orders)){
                                foreach ($data_orders as $k=>$v){
                                    if(!empty($v["Required"])){
                                        $square_icon_check = 'square_icon_checked';
                                    }else{
                                        $square_icon_check = 'square_icon_check';
                                    }
                                    $string .= '<div class="form_group" id="efi_'.$k.'">';
                                    $string .= '<input type="hidden" name="items['.$k.'].Type" value="'.$v[Type].'">
                                        <input type="hidden" name="items['.$k.'].Sort" value="'.$v[Sort].'">
                                        <input type="hidden" name="items['.$k.'].Category" value="'.$v[Category].'">
                                        <input type="hidden" name="items['.$k.'].Multiple" value="'.$v[Multiple].'">
                                        <input type="hidden" name="items['.$k.'].IsHide" value="'.$v[IsHide].'">
                                        <label><input type="checkbox" class="icon '.$square_icon_check.'" name="items['.$k.'].Required" value="true" onchange="javascript:onChangeFormItemValue(0, this, '.$k.', 0);">必填</label>
                                        <input type="text" class="form_control required form_control_type" title="'.$v[Title].'" placeholder="'.$v[Title].'" name="items['.$k.'].Title" value="'.$v[Title].'" onchange="javascript:onChangeFormItemValue(1, this, '.$k.', 0);">
                                        <input type="text" name="items['.$k.'].Description" class="form_control form_control_tips" value="'.$v[Description].'" onchange="javascript:onChangeFormItemValue(2, this, '.$k.', 0);" placeholder="'.$v[Description].'">
                                        <span name="ac_form_item_ctrl" class="icon icon_trash" title="删除栏位" onclick="javascript:removeEventFormItem('.$k.');return false;"></span>';
                                    if(!empty($v['Subitems[0]'])){
                                        $string .= '<div class="clearfix">选项列表
                                            <div class="ac_create_sign_select" id="efis_'.$k.'">';
                                            for($i=0;$i<100;$i++){
                                                if($v['Subitems['.$i.']']){
                                                    $im = $v['Subitems['.$i.']'];
                                                    $string .= '<div>
                                                    <input type="text" class="form_control required form_control_type" name="items['.$k.'].Subitems['.$i.']" value="'.$im.'" onchange="javascript:onChangeFormItemValue(3, this, '.$k.', '.$i.');">
                                                    <span name="ac_form_item_ctrl" class="icon icon_close" onclick="javascript:removeEventFormItemValue('.$v[Sort].','.$i.');"></span>
                                                    </div>';
                                                }
                                            }
                                        $string .= '<button class="btn ac_add_label_btn" onclick="javascript:addEventFormItemValue(2);return false;"><span name="ac_form_item_ctrl" class="icon icon_ac_add"></span></button></div>
                                            </div>';
                                        }
                                    $string .= '</div>';
                                }
                            }
                    }
		}
                //$string = iconv('gbk', 'utf-8', $string);
		return $string;
	}
        public function getJsSignForm($id){
            $new_data_orders = $Subitems = array();
            if($id){
                $form_arrs = Yii::app()->db->createCommand()->select('*')->from("act_sign_form_type")->where("article_id = '$id'")->queryAll();  
                foreach($form_arrs as $key=>$val){
                        $data_orders = json_decode($val['other_data'],true);
                        
                        if(!empty($data_orders)){
                            $sort_i = 1;
                            foreach ($data_orders as $k=>$v){
                                $Subitems = array();
                                $v_new['Category'] = $v['Category'];
                                $v_new['Description'] = $v['Description'];
                                $v_new['Id'] = 'I_'.$sort_i;
                                $v_new["IsDefault"] = false;
                                $v_new['IsHide'] = $v['IsHide'];
                                $v_new['Multiple'] = $v['Multiple'];
                                $v_new["Required"] = $v['Required'] ? $v['Required'] : false;
                                $v_new['Sort'] = $sort_i;
                                if(!empty($v['Subitems[0]'])){
                                    for($i=0;$i<100;$i++){
                                        if($v['Subitems['.$i.']']){
                                            $im = $v['Subitems['.$i.']'];
                                            $Subitems[] = $im;
                                        }
                                    }
                                }
                                $v_new["Subitems"] = $Subitems;
                                $v_new['Title'] = $v['Title'];
                                $v_new['Type'] = $v['Type'];
                                $v_new['TypeTitle'] = AdrGlobal::$Form_Type["$v[Type]"];
                                $new_data_orders[] = $v_new;
                                $sort_i++;
                            }
                            
                        }
                }
            }
            //var_dump($new_data_orders);exit;
            return $new_data_orders;
	}
        public function getViewSignForm($id){
            $new_data_orders = array();
            $string = '';
            if($id){
                $new_data_orders = $this->getJsSignForm($id);
                if(!empty($new_data_orders)){
                        foreach ($new_data_orders as $key=>$val){
                            if(!empty($val["Required"])){
                                $square_icon_check = '<em class="icon need_icon"></em>';
                                $check_class = 'must_check_other';
                            }else{
                                $square_icon_check = '';
                                $check_class = '';
                            }
							if($val[Type] == 'radio'){
								$other_class = 'block_group radio_list';
							}else if($val[Type] == 'checkbox'){
								$other_class = 'block_group checkbox_list';
							}
                            $string .= '<div class="control_group '.$check_class.' '.$other_class.'">';
                            $string .= '<label class="control_label">'.$val[Title].$square_icon_check.'</label>';
                            if($val[Type] == 'input'){
                                $string .= '<input type="hidden" id="title_show" name="Other_data['.$val[Sort].'][input_name]" value="'.$val[Title].'">';
                                $string .= '<input type="hidden" id="is_type" value="input">';
                                $string .= '<div class="controls single_input_box">
                                                <input type="text" name="Other_data['.$val[Sort].'][input_title]" class="join_form_input">
                                            </div>';
                            }else if($val[Type] == 'textarea'){
                                $string .= '<input type="hidden" id="title_show" name="Other_data['.$val[Sort].'][textarea_name]" value="'.$val[Title].'">';
                                $string .= '<input type="hidden" id="is_type" value="textarea">';
                                $string .= '<div class="controls textarea_input_box">
                                                <textarea  name="Other_data['.$val[Sort].'][textarea_title]" class="join_form_input"></textarea>
                                            </div>';
                            }else if($val[Type] == 'radio' && !empty ($val[Subitems])){
                                $string .= '<input type="hidden" id="title_show" name="Other_data['.$val[Sort].'][radio_name]" value="'.$val[Title].'">';
                                $string .= '<input type="hidden" id="is_type" value="radio">';
                                $string .= '<div class="controls radio_list">';
                                foreach ($val[Subitems] as $k=>$v){
                                    $string .= '<label for=""><input type="radio" name="Other_data['.$val[Sort].'][radio_title]" value="'.$v.'" id="" class="icon radio_icon">'.$v.'</label>';
                                }
	                        $string .= '</div>';
                                $val[Subitems] = array();
                            }else if($val[Type] == 'checkbox' && !empty ($val[Subitems])){
                                $string .= '<input type="hidden" id="title_show" name="Other_data['.$val[Sort].'][checkbox_name]" value="'.$val[Title].'">';
                                $string .= '<input type="hidden" id="is_type" value="checkbox">';
                                $string .= '<div class="controls checkbox_list">';
                                foreach ($val[Subitems] as $k=>$v){
                                    $string .= '<label for=""><input type="checkbox" name="Other_data['.$val[Sort].'][checkbox_title][]" value="'.$v.'" id="" class="icon square_icon_check">'.$v.'</label>';
                                }
                                $string .= '</div>';
                            }
                            $string .= '</div>';
                        }
                }
            }
            return $string;
	}
}

