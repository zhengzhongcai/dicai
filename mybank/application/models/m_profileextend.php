<?php
class M_profileExtend extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function index(){}
	 
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
    
}
?>