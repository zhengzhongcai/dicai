<?php
include_once("../CLASS/xmlClass.php");    //引用PHP XML操作类    
include_once("../config.php");
//重置FTP路径

$profile_name=$_POST["profilename"];

$ftpPath="ftp://".FTP_SERVER."/import/".$profile_name."/";

$local_path="../../FileLib/".$profile_name."/";
$xml = file_get_contents($local_path.$profile_name.".xml");    //读取XML文件     
$data=XML_unserialize($xml);  


$Areas_Array=$data["profiles"]["areas"]["area"];



//获取模板信息
$tmpInfo=$data["profiles"]["template"];
$Profile=$data["profiles"]["profile"];
echo "TempName:\"".$tmpInfo["TemplateName"]."\",";


/*echo "<hr>";
echo $data["profiles"]["profile"]["ProfileType"]."___".$tmpInfo["TemplateTLR"];
echo "<hr>";*/


$k_info=checkPro($data["profiles"]["profile"]["ProfileType"],$tmpInfo["TemplateTLR"]);

$k_inf=explode("x",$k_info);

echo "W:\"".$k_inf[0]."\",";
echo "H:\"".$k_inf[1]."\",";
echo "TempType:\"".$data["profiles"]["profile"]["ProfileType"]."\",";
if($tmpInfo["TemplateBgPic"]=="")
{echo "TempPic:0\"_@_@@_@_";}
else
{
	echo "BgImageFullPath:\"".urlencode("../".$local_path.$tmpInfo["TemplateBgPic"])."\",";
	echo "BgImagePath:\"".iconv("gb2312","UTF-8",urldecode("../".$local_path.$tmpInfo["TemplateBgPic"]))."\",";
	echo "BgImageName:\"".$tmpInfo["TemplateBgPic"]."\",";
	echo "TempPic:\"".iconv("gb2312","UTF-8",urldecode("../".$local_path.$tmpInfo["TemplateBgPic"]))."\"_@_@@_@_";
	}


$Profile=$data["profiles"]["profile"];
//print_r($sql_Profile_rows);

echo "'profileName':'".$profile_name."',";
echo "'profileType':'".$Profile["ProfileType"]."',";
echo "'profilePeriod':'".$Profile["ProfilePeriod"]."',";
echo "'touchJumpUrl':'".$Profile["Jump_URL"]."',";
echo "'tempWidth':'".$k_inf[0]."',";
echo "'tempHeight':'".$k_inf[1]."',";
echo "'tempBgGround':''";
echo "_@_@@_@_";

$dv="";       //--------------->文件div
$y=false;   //是否已经获取区域  false->还没有获取区


$areaId=array();

for($a=0; $a<count($Areas_Array); $a++)
{
	//创建模板区域
	$areaDiv.="<div id=\"".$Areas_Array[$a]["BlockID"]."\"   position=\"'left':'".$Areas_Array[$a]["X"]."','top':'".$Areas_Array[$a]["Y"]."','width':'".$Areas_Array[$a]["Width"]."','height':'".$Areas_Array[$a]["Height"]."'\" ";
	$areaDiv.=" onclick=\"areaMenue(event)\" ";
	$areaDiv.=" oncontextmenu=\"createAreaTypeMenue(event)\" ";
	
	
	$type=$Areas_Array[$a]["PlaylistType"];
	
	$subType=$Areas_Array[$a]["PlaylistSubType"];
	
	$areaId[$a]=$Areas_Array[$a]["BlockID"];
	
	
	if($Areas_Array[$a]["BlockID"]!=100) //注: id为100 的是led区域
	{
		//过滤主区域,  与没有划分类型的区域  
		if(gettype($Areas_Array[$a]["playLists"])!="string")
		{
			if($Areas_Array[$a]["playLists"]["file"][0]["FTPPath"]=="")
			{
				$s=array($Areas_Array[$a]["playLists"]["file"]);
				$Areas_Array[$a]["playLists"]["file"]="";
				$Areas_Array[$a]["playLists"]["file"]=$s;
			}
			//创建文件区域
			echo "<div id='file_".$Areas_Array[$a]["BlockID"]."' style='display:none; border:1px solid #ccc; width:150px; height:auto;'>";
			$y=false; 
			$Files_Array=$Areas_Array[$a]["playLists"]["file"];
			for($f=0; $f<count($Files_Array); $f++)
			{
				$dv="<div  id='file_".$Areas_Array[$a*1]["BlockID"]."_".$a."_".$f."' ";
			///	$dv.="title=\"'fileFullPath':'".urlencode($ftpPath.$Files_Array[$f]["FileName"])."',";
				if($type=="MESSAGE"&&$subType=="3"){$dv.="title=\"'fileFullPath':'".$Files_Array[$f]["FileName"]."',";}
				else
				{
					$dv.="title=\"'fileFullPath':'".urlencode(iconv("UTF-8","gb2312",$ftpPath.$Files_Array[$f]["FileName"]))."',";
					//$dv.="title=\"'fileFullPath':'".realpath(iconv("UTF-8","gb2312",urlencode($local_path.$Files_Array[$f]["FileName"])))."',";
					}
				$dv.="'mileSize':'".filesize(realpath(iconv("UTF-8","gb2312",$local_path.$Files_Array[$f]["FileName"])))."',";
				$dv.="'modifyDate':'".date("Y-m-d H:i:s", filemtime(realpath(iconv("UTF-8","gb2312",$local_path.$Files_Array[$f]["FileName"]))))."',";
				
				//过滤URL
				if($type=="MESSAGE"&&$subType=="3"){$dv.="'CheckSum':''\" ";}
				else
				{$dv.="'checkSum':'".md5_file(realpath(iconv("UTF-8","gb2312",$local_path.$Files_Array[$f]["FileName"])))."'\" ";}
				
				//echo "<br />".$type."------------".$subType."<br />";
				
			
			//Img
				if($type=="PICTURE"&&$subType=="0")
				{
					if(!$y)
					{
						$areaDiv.="mainType='N' ";
						$areaDiv.="o_bgColor='green' ";
						$areaDiv.="areaColor='#ccc' ";
						$areaDiv.="areaType='Img' ";
						$areaDiv.="style=\" background-color:#ccc;";
						$areaDiv.="text-align:center;position:absolute; border:0px solid; width:".($Areas_Array[$a]["Width"])."px; height:".($Areas_Array[$a]["Height"])."px; left:".($Areas_Array[$a]["X"])."px; top:".($Areas_Array[$a]["Y"])."px;\"  >图片区域</div>";
					}
					$y=true;
					$dv.=" onclick=\"editFileList('file_".$Areas_Array[$a]["BlockID"]."_".$a."_".$f."'),updateFileInfo('Img',null,'file_".$Areas_Array[$a]["BlockID"]."_".$a."_".$f."');\"  ";
					$dv.="playInfo=\"";
					$dv.="'playTime':'".$Files_Array[$f]["iEveryTime"]."',";
					$dv.="'replayCount':'".$Files_Array[$f]["iTotalCount"]."'\"";
				}
				//Swf
				if($type=="PICTURE"&&$subType=="1")
				{
					if(!$y)
					{
						$areaDiv.="mainType='N' ";
						$areaDiv.="o_bgColor='green' ";
						$areaDiv.="areaColor='#eee' ";
						$areaDiv.="areaType='Swf' ";
						$areaDiv.="style=\" background-color:#eee;";
						$areaDiv.="text-align:center;position:absolute; border:0px solid; width:".($Areas_Array[$a]["Width"])."px; height:".($Areas_Array[$a]["Height"])."px; left:".($Areas_Array[$a]["X"])."px; top:".($Areas_Array[$a]["Y"])."px;\"  >动画区域</div>";
					}
					$y=true;
					$dv.=" onclick=\"editFileList('file_".$Areas_Array[$a]["BlockID"]."_".$a."_".$f."'),updateFileInfo('Swf',null,'file_".$Areas_Array[$a]["BlockID"]."_".$a."_".$f."');\"  ";
					$dv.="playInfo=\"";
					$dv.="'playTime':'".$Files_Array[$f]["iEveryTime"]."',";
					$dv.="'replayCount':'".$Files_Array[$f]["iTotalCount"]."'\"";
				}
				//Txt   
				if($type=="MESSAGE"&&$subType=="0")
				{
					if(!$y)
					{
						$areaDiv.="mainType='N' ";
						$areaDiv.="o_bgColor='green' ";
						$areaDiv.="areaColor='#ccc' ";
						$areaDiv.="areaType='Txt' ";
						$areaDiv.="style=\" background-color:#ccc;";
						$areaDiv.="text-align:center;position:absolute; border:0px solid; width:".($Areas_Array[$a]["Width"])."px; height:".($Areas_Array[$a]["Height"])."px; left:".($Areas_Array[$a]["X"])."px; top:".($Areas_Array[$a]["Y"])."px;\"  >滚动字幕</div>";
					}
					$y=true;
					$dv.=" onclick=\"editFileList('file_".$Areas_Array[$a]["BlockID"]."_".$a."_".$f."'),updateFileInfo('Txt',null,'file_".$Areas_Array[$a]["BlockID"]."_".$a."_".$f."');\"  ";
					$dv.="playInfo=\"";
					$dv.="'font':'".$Files_Array[$f]["FontStyle"]."',";
					$dv.="'fontsize':'".$Files_Array[$f]["FontSize"]."',";
					
					$len=strlen(dechex($Files_Array[$f]["FontCtr"]));
					$se=dechex ($Files_Array[$f]["FontCtr"]);
					if($len<6)
					{
						for($m=0; $m<(6-$len); $m++)
						{
							$se.="0";
						}
						$dv.="'fontcolor':'#".$se."',";
					}
					else
					{
						$dv.="'fontcolor':'#".dechex ($Files_Array[$f]["FontCtr"])."',";
					}
					
					$len=strlen(dechex($Files_Array[$f]["BackCtr"]));
					$se=dechex ($Files_Array[$f]["BackCtr"]);
					if($len<6)
					{
						for($m=0; $m<(6-$len); $m++)
						{
							$se.="0";
						}
						$dv.="'bgcolor':'#".$se."',";
					}
					else
					{
						$dv.="'bgcolor':'#".dechex ($Files_Array[$f]["BackCtr"]*1)."',";
					}
					
					$dv.="'scrollamount':'".$Files_Array[$f]["Speed"]."',";
					$dv.="'direction':'".$Files_Array[$f]["strMoveType"]."',";
					$dv.="'replayCount':'".$Files_Array[$f]["PlayTime"]."'\"";
				}
				//URL
				if($type=="MESSAGE"&&$subType=="3")
				{
					if(!$y)
					{
						$areaDiv.="mainType='N' ";
						$areaDiv.="o_bgColor='green' ";
						$areaDiv.="areaColor='#999' ";
						$areaDiv.="areaType='Url' ";
						$areaDiv.="style=\" background-color:#999;";
						$areaDiv.="text-align:center;position:absolute; border:0px solid; width:".($Areas_Array[$a]["Width"])."px; height:".($Areas_Array[$a]["Height"])."px; left:".($Areas_Array[$a]["X"])."px; top:".($Areas_Array[$a]["Y"])."px;\"  >网页模板区域</div>";
					}
					$y=true;
					$dv.=" onclick=\"editFileList('file_".$Areas_Array[$a]["BlockID"]."_".$a."_".$f."'),updateFileInfo('Url',null,'file_".$Areas_Array[$a]["BlockID"]."_".$a."_".$f."');\"  ";
					$dv.="playInfo=\"";
					$dv.="'scrollType':'".$Files_Array[$f]["top"]."',";
					$dv.="'fileFullPath':'".$Files_Array[$f]["Url"]."'\"";
				}
				//AUDIO
				if($type=="AUDIO"&&$subType==0)
				{
					if(!$y)
					{ 
						$areaDiv.="mainType='N' ";
						$areaDiv.="o_bgColor='green' ";
						$areaDiv.="areaColor='#090' ";
						$areaDiv.="areaType='Audio' ";
						$areaDiv.="style=\" background-color:#090;";
						$areaDiv.="text-align:center;position:absolute; border:0px solid; width:".($Areas_Array[$a]["Width"])."px; height:".($Areas_Array[$a]["Height"])."px; left:".($Areas_Array[$a]["X"])."px; top:".($Areas_Array[$a]["Y"])."px;\"  >背景音乐</div>";
					}
					$y=true;
					$dv.=" onclick=\"editFileList('file_".$Areas_Array[$a]["BlockID"]."_".$a."_".$f."'),updateFileInfo('Audio',null,'file_".$Areas_Array[$a]["BlockID"]."_".$a."_".$f."');\"  ";
					$dv.="playInfo=\"";
					$dv.="'playTime':'".$Files_Array[$f]["PlayTime"]."',";
					$dv.="'replayCount':'".$Files_Array[$f]["ContinueCount"]."',";
					$dv.="'volume':'".$Files_Array[$f]["Volume"]."'\"";
				}
				$dv.=" >".basename($Files_Array[$f]["FTPPath"]).basename($Files_Array[$f]["Url"])."</div>";	
				
				//输出文件队列
				echo $dv;
			}
			echo "</div>";
		}
		else
		{
			if($type=="VIDEO"&&$subType=="0")
			{
				if(!$y)
				{
					$areaDiv.="mainType='Y' ";
					$areaDiv.="o_bgColor='#909' ";
					$areaDiv.="areaColor='#909' ";
					$areaDiv.="areaType='Video' ";
					$areaDiv.="style=\" background-color:#909;";
					$areaDiv.="text-align:center;position:absolute; border:0px solid; width:".($Areas_Array[$a]["Width"])."px; height:".($Areas_Array[$a]["Height"])."px; left:".($Areas_Array[$a]["X"])."px; top:".($Areas_Array[$a]["Y"])."px;\">主区域</div>";
				}
				echo "<div id='file_".$Areas_Array[$a]["BlockID"]."' style='display:none; border:1px solid #ccc; width:150px; height:auto;'>";
				echo "</div>";
			}
			else
			{
				if(!$y)
				{
					$areaDiv.="mainType='N' ";
					$areaDiv.="o_bgColor='green' ";
					$areaDiv.="areaColor='green' ";
					$areaDiv.="style=\" background-color:green;";
					$areaDiv.="text-align:center;position:absolute; border:0px solid; width:".$Areas_Array[$a]["Width"]."px; height:".$Areas_Array[$a]["Height"]."px; left:".$Areas_Array[$a]["X"]."px; top:".$Areas_Array[$a]["Y"]."px;\"  ></div>";
				}
			}
		}
	}
	else
	{
		//LED区域  处理
		
		}
}
echo "_@_@@_@_";


$TemplateS=$data["profiles"]["templates"]["tdiv"];
$int_c=count($TemplateS);

for($mId=0; $mId<count($areaId); $mId++)
{
	for($m=0; $m<$int_c; $m++)
	{
		//echo $areaId[$mId]."--".$TemplateS[$m]["BlockID"]."<br>";
		if($areaId[$mId]==$TemplateS[$m]["BlockID"])
		{
			array_splice($TemplateS,$m,1);
		}
	}
	$int_c=count($TemplateS);
}

$int_c=count($TemplateS);
for($ms=0;$ms<$int_c; $ms++)
{
	$areaDiv.="<div id=\"".$TemplateS[$a]["BlockID"]."\"   position=\"'left':'".$TemplateS[$ms]["X"]."','top':'".$TemplateS[$ms]["Y"]."','width':'".$TemplateS[$ms]["Width"]."','height':'".$TemplateS[$ms]["Height"]."'\" ";
	$areaDiv.=" onclick=\"areaMenue(event)\" ";
	$areaDiv.=" oncontextmenu=\"createAreaTypeMenue(event)\" ";
	$areaDiv.="mainType='N' ";
	$areaDiv.="o_bgColor='green' ";
	$areaDiv.="areaColor='green' ";
	$areaDiv.="style=\" background-color:green;";
	$areaDiv.="text-align:center;position:absolute; border:0px solid; width:".$TemplateS[$ms]["Width"]."px; height:".$TemplateS[$ms]["Height"]."px; left:".$TemplateS[$ms]["X"]."px; top:".$TemplateS[$ms]["Y"]."px;\"  ></div>";
}

echo $areaDiv;


function checkPro($type,$pro)
{
	
	switch($type)
	{
		case "X86":
					switch($pro)
					{
						
						//横向
						//4:3
						case "1":return "800x600";    break;
						case "0":return "1024x768";   break;
						case "2":return "1280x1024";  break;
						case "3":return "1600x1200";  break;
						
						//
						case "4" :return "1280x800";break;
						case "8" :return "1366x768";break;
						case "5" :return "1440x900";break;
						case "6":return "1680x1050";break;
						case "9":return "1920x1080";break;
						case "7":return "1920x1200";break;
						//纵向
						case "11"  :return "600x800";break;
						case "10" :return "768x1024";break;
						case "14" :return "800x1280";break;
						case "12":return "1024x1280";break;
						case "18" :return "768x1366";break;
						case "15" :return "900x1440";break;
						//case "1200x1600":return array("c"=>"4","em"=>"13","hj"=>40);break;
						case "16":return "1050x1680";break;
						case "19":return "1080x1920";break;
						case "17":return "1200x1920";break;
					};break;
		case "em8621":
					switch($pro)
					{
						//横向
						case "1"  :return "800x600";break;
					};break;
		case "NXP":
						switch($pro)
						{
							
							//横向
							case "1"  :return "800x600";break;
							case "0" :return "1024x768";break;
							case "2" :return "1280x720";break;
							case "3":return "720x480";break;
							case "4" :return "720x576";break;
							case "9":return "1920x1080";break;
						};break;
	}
}
?>