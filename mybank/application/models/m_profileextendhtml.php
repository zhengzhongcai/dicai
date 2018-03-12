<?php
class M_profileExtendHtml extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function index(){}
    //-----------------------------------------
    //  功能说明:
    //          主区域预览
    //  参数:
    //      $filePath,$width,$height
    //  时间: 2010/12/10 23:45:30
    //  作者: BOBO
    //-----------------------------------------

	function videoTypeHtml($filePath,$width,$height)
	{
		$path=base_url().'swf/52-mediaplayercs3.swf?playmedia='.$filePath.'/mainAreaView.xml&autoplay=true&dockcontrols=false&panelcolor=000000';
		$cont='<object data="'.$path.'"
type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" >
<param name="movie" value="'.$path.'" />
<param name="allowFullScreen" value="true"/>
<embed src="'.$path.'" width="'.$width.'" height="'.$height.'" autostart="true" ></embed> 
</object>';
		return $cont;
	}
    //-----------------------------------------
    //  功能说明:
    //          将关联信息转化为js文件
    //  参数:
    //      $arr array: 关联信息转; $folderPath string: Profile Name;
    //  时间: 2011-9-26 22:46:44
    //  作者: BOBO
    //-----------------------------------------
    function relevanceInfoToFile($arr,$folderPath)
    {
	
		$filepath="Filelib/".$folderPath."/relevanceInfo.js";
        $info="var arr_relevance=".json_encode($arr).";";
		echo $filePath." ".$info;
        $fp = fopen($filePath, "w");
        @chmod($filePath,0777);
        fwrite($fp, $info);
        fclose($fp);
		
    }
    
    //-----------------------------------------
    //  功能说明:
    //          拷贝socket相关文件
    //  参数:
    //      $folderPath string: 节目文件夹
    //  时间: 2011/10/21 17:53:20
    //  作者: BOBO
    //-----------------------------------------
    function copySocketInfo($folderPath)
    {
        
        $swf=@copy("swf/SharpSocket.swf","Filelib/".$folderPath."/SharpSocket.swf");
        $sjs=@copy("swf/swfobject.js","Filelib/".$folderPath."/swfobject.js");
        $scjs=@copy("swf/swfobjectControl.js","Filelib/".$folderPath."/swfobjectControl.js");
        
        if($swf&&$sjs&&$scjs)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    //-----------------------------------------
    //  功能说明:
    //          拷贝bx.core.js相关文件
    //  参数:
    //      $folderPath string: 节目文件夹
    //  时间: 2011/10/23 23:46:45
    //  作者: BOBO
    //-----------------------------------------
    function copyBxJs($folderPath)
    {
        $sjs=@copy("JavascriptClass/bx.core.js","Filelib/".$folderPath."/bx.core.js");
        if($sjs)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
	
	function setAudioPlay($folderPath){
		
		$swfPlayer=@copy(SWF."/player_mp3_multi.swf","Filelib/".$folderPath."/player_mp3_multi.swf");
		$player=@copy("areaPlayTemp/audioPlayer.html","Filelib/".$folderPath."/audioPlayer.html");
        if($swfPlayer&&$player)
        {
            return true;
        }
        else
        {
            return false;
        }
	}
}
?>