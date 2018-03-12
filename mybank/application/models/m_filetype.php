<?php
class M_filetype extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	/**
	 * 
	 * 获取所有的文件类型
	 * 
	 * @author		BB
	 * @name		getFileTypeKeyTitle
	 * @return		Array 	$info
	 * @internal	kycool add note
	 * @copyright	2012.7.19 create by BB
	 */
	function getFileTypeKeyTitle()
	{
		$sql="SELECT `id`, `nodeName` FROM `userfiletype` WHERE 1";
		$res=$this->db->query($sql)->result_array();
		$info=array();
		foreach($res as $k=>$v)
		{
			$info[$k]["key"]=$v["id"];
			$info[$k]["title"]=$v["nodeName"];
		}
		return $info;
	}

	/**
	 * 
	 * 获取所有文件类型
	 * 
	 * @author		BB
	 * @name		getFileTypeTitleById
	 * @param		int $id
	 * @return		
	 * @internal	kycool add note
	 * @copyright	2012.7.19 create by BB
	 */
	function getFileTypeTitleById($id)
	{
		$res=$this->getFileTypeKeyTitle();
		$info=array();
		foreach($res as $k=>$v)
		{
			if($v["key"]==$id)
			{
				return $v["title"];
			}
		}
		return false;
	}
	

	/**
	 * 获取所有的文件类型,并且组成对应的数据结构:
	 * "all files:*.*;-视频:*.avi;*.mpg;*.mpeg;*.wmv;*.vob;*.mov;*.mp4;*.asf;*.dat;*.ppt;*.flv;*.mkv;*.ts;*.rmvb;-音频:*.mp3;"
	 * 
	 * @author		BB
	 * @name		getFileTypeForFlashUpload
	 * @return		int $str_fileType
	 * @internal	kycool add note	
	 * @copyright	2013.1.16
	 */
    function getFileTypeForFlashUpload(){
    	$arr_fileType=array();
		$str_fileType="";
		$str_allType="全部:";
    	$this->db->select("*");
		$this->db->where("stem","1");
		$res=$this->db->get("userFileType")->result_array();
		if(count($res)){
			$suffix="";
			for($i=0,$n=count($res); $i<$n; $i++){
				$suffix=substr(preg_replace("/\./", ";*.", $res[$i]["suffix"]), 1).";";
				$arr_fileType[]=$res[$i]["nodeName"].":".$suffix;
				$str_allType.=$suffix;
			}
			$str_fileType=$str_allType."-".implode("-", $arr_fileType);
		}
		return $str_fileType;
    }
    
    /**
     * 
     * 通过后缀名获取文件类型的ID
     * 
     * @author		BB
     * @name		getFileTypeIDBySuffix
     * @return		int  $str_fileTypeId
     * @internal	kycool add note
     * @copyright	2013.1.16 create by BB  2013.2.27 modify by kycool 
     */
    function getFileTypeIDBySuffix($suffix){
		$str_fileTypeId="";
    	$this->db->select("id,suffix");
		$this->db->where("stem","1");
		$res=$this->db->get("userFileType")->result_array();
		if(count($res)){
			for($i=0,$n=count($res); $i<$n; $i++){
				if(preg_match("/".$suffix."/",$res[$i]["suffix"])){
					$str_fileTypeId =  $res[$i]["id"];
					break;
				}		
			}
		}
		return $str_fileTypeId;
    }
}
	
?>