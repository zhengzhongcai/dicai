<?php
class FileType
{
	public function FileType(){}
	public function getType($string)
	{
		$postFix=$this->getPostFix($string);
		//echo "postFix: ".$postFix."<br>";
		$tp=$this->FileTypeEmue();
		$type="";
		foreach($tp as $key=>$Value)
		{
			foreach($Value as $v)
			{
				if($v==$postFix)
				{
					$type=$key;
				}
			}
		}
		return $type==""?false:$type;
	}
	private function FileTypeEmue()
	{
		$type=array(
					"Video"=>array(".AVI",".MPG",".MPEG",".WMV",".VOB",".MOV",".MP4",".ASF",".DAT",".PPT",".FLV",".MKV",".RMVB"),
					"Audio"=>array(".WAV",".WMA", ".MP3",".MIDI"),
					"Txt"=>array(".TXT"),
					"Img"=>array(".JPEG",".GIF",".PNG",".BMP",".JPG"),
					"Swf"=>array(".SWF"),
					"Url"=>array(".HTM",".HTML",".DOC")
					);
		return $type;
	}
	private function getPostFix($string)
	{
		$str=$this->searchTag($string);
		if(strlen($str)<2)
		{
			$f_name=strrchr($string,$str);
			$f_PostFix=strrchr($string,".");
			return strtoupper($f_PostFix);
		}
		else
		{
			return "not found";
		}

	}
	private function searchTag($string)
	{
		return strstr($string,"/")?"/":strstr($string,"\\")?"\\":"none";
	}
	public function fileName($string)
	{
		//var_dump($string);
		$arr=explode("/",$string);
		
		return $arr[count($arr)-1];
		/*echo "<pre>";
		//echo $this->searchTag($string)."<br>";$this->searchTag($string)
		print_r($arr);
		echo "</pre>";*/
	}
	

}
?>