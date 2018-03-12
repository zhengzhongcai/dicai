<?php
class FFMPEGCLASS
{
	var $ff_movie;
	var $moveFullPath;
	var $persistent;
	function FFMPEGCLASS($moveFullPath,$persistent=false)
	{
		$this->moveFullPath=$moveFullPath;
		$this->persistent=$persistent;
	}
	
	function open()
	{  
		$this->ff_movie=new ffmpeg_movie(
										 $this->moveFullPath, //路径物理地址
										 $this->persistent //是否持久连接
										 );
	}
	//获取时长
	function getCountTime()
	{
		$FrameCount=$this->ff_movie->getFrameCount();  //电影总帧数
		$FrameRate=$this->ff_movie->getFrameRate();		//电影的播放速度(帧/秒)
		$Seconds=floor($FrameCount/$FrameRate/60);
		$TimeCount=($FrameCount/$FrameRate)%60+$Seconds*60;
		return $TimeCount;
	}
}
?>