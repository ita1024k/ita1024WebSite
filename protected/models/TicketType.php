<?php

/**
 * This is the model class for table "act_ticket_type".
 *
 * The followings are the available columns in table 'act_ticket_type':
 * @property integer $ticket_id
 * @property string $ticket_title
 * @property integer $article_id
 * @property integer $user_id
 * @property integer $quantity
 * @property double $price
 * @property integer $status
 * @property string $description
 * @property integer $needapply
 * @property integer $is_use
 * @property string $SN
 * @property integer $SoldNumber
 * @property integer $IsSeriesTicket
 * @property string $PriceStr
 */
class TicketType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'act_ticket_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('ticket_title, article_id, user_id', 'required'),
			//array('price', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('ticket_id, ticket_title, article_id, user_id, quantity, price, status, description, needapply, is_use, SN, SoldNumber, IsSeriesTicket, PriceStr', 'safe', 'on'=>'search'),
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
			'ticket_id' => 'Ticket',
			'ticket_title' => 'Ticket Title',
			'article_id' => 'Article',
			'user_id' => 'User',
			'quantity' => 'Quantity',
			'price' => 'Price',
			'status' => '0为已经开始报名，1为未开始报名',
			'description' => 'Description',
			'needapply' => '0不需要审核，1需要审核',
			'is_use' => '0未使用1已经使用',
			'SN' => 'Sn',
			'SoldNumber' => 'Sold Number',
			'IsSeriesTicket' => '0不是私密活动，1是私密活动',
			'PriceStr' => 'Price Str',
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

		$criteria->compare('ticket_id',$this->ticket_id);
		$criteria->compare('ticket_title',$this->ticket_title,true);
		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price',$this->price);
		$criteria->compare('status',$this->status);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('needapply',$this->needapply);
		$criteria->compare('is_use',$this->is_use);
		$criteria->compare('SN',$this->SN,true);
		$criteria->compare('SoldNumber',$this->SoldNumber);
		$criteria->compare('IsSeriesTicket',$this->IsSeriesTicket);
		$criteria->compare('PriceStr',$this->PriceStr,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TicketType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getTicket($id){
		$user_id = Yii::app()->user->id;
		if($id){
			$ticket_arrs = Yii::app()->db->createCommand()->select('*')->from("act_ticket_type")->where("article_id = '$id' AND user_id = '$user_id'")->queryAll();
		}else{
			$ticket_arrs = Yii::app()->db->createCommand()->select('*')->from("act_ticket_type")->where("is_use = '0' AND user_id = '$user_id'")->queryAll();
		}
		
		
		foreach($ticket_arrs as $key=>$val){
			$status_title = $val['status'] == 0 ? ($val['SoldNumber'] > 0 ? '停售票种': '删除票种') : '恢复票种';
			$status = $val['status'] == 0 ? 'true' : 'false';
                        $needapply_css = $val['needapply'] == 1 ? 'square_icon_checked' : 'square_icon_check';
                        $quantity =  $val['quantity'] > 0 ? $val['quantity'] : '不限';
			$string .= '<table class="event-create-ticket event_free_ticket" id="event_create_ticket'.$val[SN].'">
		<tbody>
			<tr>
				<th title="免费票"><div><input type="text" value="'.$val[ticket_title].'" disabled="&quot;disabled&quot;" id="event_ticket_title'.$val[SN].'"></div></th>
                <th><div class="event-create-ticket-range"><input type="text" value="'.$val[quantity].'" disabled="&quot;disabled&quot;" id="event_ticket_quantity'.$val[SN].'"><em>'.$quantity.'</em></div></th>
                <th>
					<div class="clearfix"><strong class="show">免费</strong></div>
				</th>
				<th><div><span class="text-muted">报名尚未开始</span></div></th>
                <th><div class="event-create-td-last"><span class="event-create-ticket-edit-toggle" title="更多票种设置" onclick="showElement('.$val[SN].')"><i class="icon-create-config"></i></span><span title="'.$status_title.'" onclick="javascript:changeTiecketStatus(\''.$val[SN].'\', '.$status.', 0);return false;"><i class="icon-trash"></i></span></div></th>
            </tr>
			<tr class="event-create-ticket-config" id="edit_ticket_config'.$val[SN].'">
				<td colspan="5">
<form action="/activity/index.php?r=TicketType/TicketType/AjaxCreate" id="event_ticket_form'.$val[SN].'" method="post"><input type="hidden" name="SN" value="'.$val[SN].'">
						<input type="hidden" name="Title" value="'.$val[ticket_title].'" id="Title'.$val[SN].'">
						<input type="hidden" name="Quantity" value="'.$val[quantity].'" id="Quantity'.$val[SN].'">
						<input type="hidden" name="Price" value="'.$val[price].'" id="Price'.$val[SN].'">
						<input type="hidden" name="Status" value="'.$val[status].'" id="Status'.$val[SN].'">
						<input type="hidden" name="Group" value="'.$val[ticket_id].'" id="Group'.$val[SN].'">
						<input type="hidden" name="activityId" value="'.$val[article_id].'" id="activityId'.$val[SN].'">
						<input type="hidden" name="src_quantity_num" value="NaN" id="src_quantity_num'.$val[SN].'">
						<input type="hidden" name="NeedApply" value="'.$val[needapply].'" id="NeedApply'.$val[SN].'">
                        <input type="hidden" value="0" id="SoldNumber'.$val[SN].'">
						<div>
							<label class="ac_label">票种说明</label>
							<input name="Description" type="text" class="form_control ac_control" style="width: 766px" maxlength="200" placeholder="限制200汉字" value="'.$val[description].'" id="Description'.$val[SN].'">
						</div>
						<div style="margin-top:10px;">
							<label class="ac_label">是否审核</label>
							<label class="ac_create_checkbox form_control">
								<input type="checkbox" id="at_needapply'.$val[SN].'" value="1" class="icon '.$needapply_css.'">凡报名/订购此类票需要经过我审核
							</label>
						</div>
						<div class="text_center submit_btn">
							<button class="btn btn_primary"" type="button" onclick="javascript:saveEventTicket(\''.$val[SN].'\');return false;">保存</button>
							<button class="btn btn_default" onclick="javascript:$(\'#event_create_ticket'.$val[SN].'\').removeClass(\'event-create-ticket-edit\');return false;">关闭</button>
						</div>
</form>				</td>
			</tr>
		</tbody>
	</table>';
		}
		
		return $string;
	}
}
