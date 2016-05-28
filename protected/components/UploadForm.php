<?php
class UploadForm extends CFormModel{
	public $upload;
 
	//private $options;
	private $type;
    public $network = array();
    private $website;
 
	public function __construct($type=null /*, $options*/){
		//$this->options = $options;
		if(empty($type))
			$this->type = 'jpg,png,gif';
		else
			$this->type = $type;


	}
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
        $size = $this->getMinFileSize();
        return $this->getRules($this->type, $size);
	}

    public function getRules($type,$size){
        return array(
            array('upload', 'file',
                'types' => $type,
                'maxSize' => $size,
                'tooLarge'=>'文件大小超过限制('.(int)($size/1024).'k)!'
            ),
        );
    }

    /**
     * 获取多个网络中最少的文件尺寸
     * @return mixed
     * @author guoqiang.zhang
     */
    public function getMinFileSize(){
        $temp_file_rules = array();
        $temp_rules = array();
        foreach($this->network as $network){
            $network = (int)$network;
            $temp_file_rules[$network] = $this->getNetworkRule($network);
            if($this->type=='flv'){
                $temp_rules[] = $temp_file_rules[$network]['flv'];
            }
            elseif ($this->type=='mp4'){
                $temp_rules[] = $temp_file_rules[$network]['mp4'];
            }
            else{
                $temp_rules[] = $temp_file_rules[$network]['file'];
            }
        }

        return min($temp_rules);
    }

    /**
     * 获取不同网络文件尺寸配置信息
     * @param $network
     * @return array
     * @author guoqiang.zhang
     */
    public function getNetworkRule($network){
        switch($network){
            case 1:
                //taobao
                $file_rule = array(
                    'file' => 150 * 1024,
                    'flv'  => 150 * 1024
                );
                break;
            case 2:
                //google
                $file_rule = array(
                    'file' => 150 * 1024,
                    'flv'  => 150 * 1024
                );
                break;
            case 3:
                //qq
                $file_rule = array(
                    'file' => 150 * 1024,
                    'flv'  => 3072 * 1024
                );
                break;
            case 4:
                //allyes
                $file_rule = array(
                    'file' => 50 * 1024,
                    'flv'  => 50 * 1024
                );
                break;
            case 5:
                //kejet
                $file_rule = array(
                    'file' => 150 * 1024,
                    'flv'  => 150 * 1024
                );
                break;
            case 6:
                //adchina
                $file_rule = array(
                    'file' => 50 * 1024,
                    'flv'  => 50 * 1024
                );
                break;
            case 7:
                //miaozhen
                $file_rule = array(
                    'file' => 50 * 1024,
                    'flv'  => 50 * 1024
                );
                break;
            case 8:
                //sina
                $file_rule = array(
                    'file' => 100 * 1024,
                    'flv'  => 100 * 1024
                );
                break;
            case 9:
                //youku
                $file_rule = array(
                    'file' => 50 * 1024,
                    'flv'  => 50 * 1024
                );
                break;
            case 10:
                //baidu
                $file_rule = array(
                    'file' => 55 * 1024,
                    'flv' => 100 * 1024
                );
                break;
            case 11:
                //sohu
                $file_rule = array(
                    'file' => 100 * 1024,
                    'flv' => 100 * 1024,
                    'mp4' => 4096 * 1024
                );
                break;
            default:
                //新建素材(默认值）
                $file_rule = array(
                    'file' => 150 * 1024,
                    'flv'  => 3072 * 1024,
                    'mp4'  => 4096 * 1024
                );
                break;
        }
//        echo $network;
//        print_r($file_rule);
        return $file_rule;
    }
}
?>