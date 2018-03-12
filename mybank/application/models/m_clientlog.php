<?php
class M_clientLog extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getProfileNameForLog($EventType,$str_info,$EventTypeName)
	{
		$str_new_info="";
		if($EventType=="1"||$EventType=="2")
		{
			//兼容 旧版本 Linux X86
			$pos=strpos($str_info,",");
			if(!is_bool($pos))
			{
				$str_info=substr($str_info,0,strpos($str_info,","));
			}
			
			
			$arr_info=explode("/",$str_info);
			//过滤FTP用户信息
			$arr_Ip=substr($arr_info[2],strpos($arr_info[2],"@")+1);
			$arr_Ip=substr($arr_Ip,0,-(strlen(strpos($arr_Ip,":"))+1));
			$arr_info[2]=$arr_Ip;
			
			$int_len=count($arr_info);
			$str_baseName=$arr_info[$int_len-1];
			$ext=strtolower(substr($str_baseName,strripos($str_baseName,".")+1));
			$str_fileName=substr($str_baseName,0,strripos($str_baseName,"."));
			switch($ext)
			{
				case "tar": 
					//转化profile名称
					$str_baseName=proDeName($str_baseName);
					$arr_info[$int_len-1]=$str_baseName;
				break;
				case "R01":break;
				default: 
				$arr_info[$int_len-1]=$this->formartInfo($str_fileName).".".$ext;
			}
			$str_new_info=implode("/",$arr_info);
			//$str_new_info=implode("/",$arr_info);
		}
		else if($EventType=="11" ||$EventType=="17")
		{
			if($str_info=="(null)"){$str_new_info=$EventTypeName;}
			else
			{
				$int_pos=strpos($str_info," ");
				
				if($int_pos === false)
				{
					$str_new_info=$this->formartInfo($str_info);
				}
				else
				{
					$str_h=$this->formartInfo(substr($str_info,0,$int_pos));
					$str_new_info=$str_h." ".proDeName(substr($str_info,$int_pos+1));
				}
			}
			//$str_new_info=$str_info;
		}
		else
		{$str_new_info=$EventTypeName;}
		return $str_new_info;
	}
	
	function getFileNameForLog($ckSum)
	{
		//return $ckSum;
		$sql="SELECT `FileName` FROM `play_file_property` where `CheckSum` = '".$ckSum."' and `FileName` is not null";
		$rs=$this->db->query($sql)->result_array();
		//return count($rs);
		if(count($rs)>0)
		{
		return $rs[0]["FileName"];
		}else{return $ckSum;}
	}
    function formartInfo($str)
	{
		$s=explode("@",$str);
				if(count($s)>1)
				{
					$s=explode(":",$s[1]);
					$txt="ftp://".$s[0].substr($s[1],strpos($s[1],"/")); 
				}
				else
				{$txt=$s[0];}
		if(@iconv("UTF-8","GBK",$txt))
		{
			return @iconv("UTF-8","GBK",$txt);
		}
		if(@iconv("GBK","UTF-8",$txt))
		{
			return @iconv("GBK","UTF-8",$str);
		}
		else
		{return @mb_convert_encoding(iconv("UTF-8","GBK//IGNORE",$txt),"UTF-8","GBK,GB2312");}
	}
}
?>