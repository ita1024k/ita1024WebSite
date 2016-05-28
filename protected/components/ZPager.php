<?php
/**
 * ZPager class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */


/**
 * ZPager displays a dropdown list that contains options leading to different pages of target.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.web.widgets.pagers
 * @since 1.0
 */
class ZPager extends CLinkPager
{
	/**
	 * @var string the text shown before page buttons. Defaults to 'Go to page: '.
	 */
	public $header;
	/**
	 * @var string the text shown after page buttons.
	 */
	public $footer;
	/**
	 * @var string the text displayed as a prompt option in the dropdown list. Defaults to null, meaning no prompt.
	 */
	public $promptText;
	/**
	 * @var string the format string used to generate page selection text.
	 * The sprintf function will be used to perform the formatting.
	 */
	public $pageTextFormat;
	/**
	 * @var array HTML attributes for the enclosing 'div' tag.
	 */
	public $htmlOptions=array();

	/**
	 * Initializes the pager by setting some default property values.
	 */
	public function init()
	{
		if($this->header===null)
			$this->header=Yii::t('yii','Go to page: ');
		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->getId();
		if($this->promptText!==null)
			$this->htmlOptions['prompt']=$this->promptText;
		if(!isset($this->htmlOptions['onchange']))
			$this->htmlOptions['onchange']="if(this.value!='') {window.location=this.value;};";
	}

	/**
	 * Executes the widget.
	 * This overrides the parent implementation by displaying the generated page buttons.
	 */
	public function run()
	{
		/* if(($pageCount=$this->getPageCount())<=1)
			return;
		$pages=array();
		for($i=0;$i<$pageCount;++$i)
			$pages[$this->createPageUrl($i)]=$this->generatePageText($i);
		$selection=$this->createPageUrl($this->getCurrentPage());
		echo $this->header;
		echo CHtml::dropDownList($this->getId(),$selection,$pages,$this->htmlOptions);
		echo $this->footer; */
		
		$this->registerClientScript();
		$buttons=$this->createPageButtons();
		//var_dump($this);exit;
		//$buttons[] = CHtml::tag('span', array('style'=>'height:25px;width:100px;text-align:center;line-height:25px;margin-left:148px;'),'共'.$this->getPageCount().'页');
		//$buttons[] = CHtml::tag('span', array('style'=>'height:25px;line-height:25px;margin-left:30px;'), '前往第  '.CHtml::textField('pageNumber', '', array('style'=>'border:1px solid #717071;width:42px;height:21px;text-align:center',)).CHtml::tag('span',array('id'=>'gotoBtn'),'确定').'  页');
		if(empty($buttons))
				return;
		echo $this->header;
		echo CHtml::tag('div',$this->htmlOptions,implode("\n",$buttons));
		echo $this->footer;
		
		
	}
	protected function createPageButton($label,$page,$class,$hidden,$selected)
    {
		if($hidden || $selected)
				$class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
		return CHtml::link($label,$this->createPageUrl($page),array('class'=>$class));
    }

    protected function createPageButtons()
    {
		if(($pageCount=$this->getPageCount())<=1)
				 return array();
		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();

		// first page
		//$buttons[]=$this->createPageButton($this->firstPageLabel,0,$this->firstPageCssClass,$currentPage<=0,false);

		// prev page
		if(($page=$currentPage-1)<0)
				 $page=0;
		 $buttons[]=$this->createPageButton($this->prevPageLabel,$page,$this->previousPageCssClass,$currentPage<=0,false);

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
				 $buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);

		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
				$page=$pageCount-1;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,$this->nextPageCssClass,$currentPage>=$pageCount-1,false);

		// last page
		//$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,$this->lastPageCssClass,$currentPage>=$pageCount-1,false);

		return $buttons;
    }
	/**
	 * Generates the list option for the specified page number.
	 * You may override this method to customize the option display.
	 * @param integer $page zero-based page number
	 * @return string the list option for the page number
	 */
	protected function generatePageText($page)
	{
		if($this->pageTextFormat!==null)
			return sprintf($this->pageTextFormat,$page+1);
		else
			return $page+1;
	}
	public static function registerCssFile($url=null)  
	{  
		if($url===null)  
			$url=CHtml::asset(Yii::getPathOfAlias('application.components.css.pager').'.css');  
		Yii::app()->getClientScript()->registerCssFile($url);  
	} 
}