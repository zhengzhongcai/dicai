
<?php
//echo "<pre>";
//print_r($TreeSouce);

//for($i=0,$n=count($TreeSouce); $i<$n; $i++)
//{
	$tre=$TreeSouce;
	echo  createTreeSouce($tre);
//}
//$tree= json_encode($TreeSouce);
//echo "</pre>";


function createTreeSouce($tr,$node="")
{   //header ("Content-Type:text/html; charset=utf-8");
   // $node.='<a class="itm '.fileTypeDemo(0).'" href="javascript:void(0)" id="tre_all" fatherId="all" suffix="all"><span class="itm_tu">-</span>'.iconv('gbk','utf-8','È«²¿').'</a>';
	foreach($tr as $k => $v)
	{

		//$node.="<a class=\"itm\" href=\"javascript:void(0)\" id=\"tre_".$v["id"]."\><span class=\"itm_tu\">+</span>".$v["nodeName"]."</a>";
		
		if(array_key_exists("childNodes",$v))
		{
			if(is_array($v["childNodes"]))
			{
				$node.='<a class="itm '.fileTypeDemo($v["id"]).'" href="javascript:void(0)" id="tre_'.$v["id"].'" fatherId="'.$v["fatherId"].'" suffix="'.$v["suffix"].'"><span class="itm_tu">+</span>'.$v["nodeName"].'</a>';
				$node.='<div class="s_m" >';
				$node=createTreeSouce($v["childNodes"],$node);
				$node.='</div>';
			}
			else
			{
            
           
            
				$node.='<a class="itm" href="javascript:void(0)" id="tre_'.$v["id"].'" fatherId="'.$v["fatherId"].'"suffix="'.$v["suffix"].'"><span class="itm_tu"><img src="Skin/default/'.fileTypeDemo($v["id"]).'.gif" /></span><span class="itm_tu">- </span>'.$v["nodeName"].'</a>';
			}
		}
		else
		{
			
			$node.='<a class="itm" href="javascript:void(0)" id="tre_'.$v["id"].'" fatherId="'.$v["fatherId"].'"suffix="'.$v["suffix"].'"><span class="itm_tu"><img src="Skin/default/'.fileTypeDemo($v["id"]).'.gif" /></span><span class="itm_tu">- </span>'.$v["nodeName"].'</a>';
		}
		
		
	}
	return $node;
}

function fileTypeDemo($i)
{
	$fileTpd=array(
	"0"=>"all",
	"1"=>"video",
	"2"=>"audio",
	"3"=>"img",
	"4"=>"flash",
	"5"=>"dhtml",
	"6"=>"txt",
	"7"=>"bz2"
	);
	return $fileTpd[$i];
}
?>




