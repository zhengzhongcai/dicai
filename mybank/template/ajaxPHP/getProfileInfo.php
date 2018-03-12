<?php
//header("Content-type:text/html;charset=gb2312");
include_once("../MySqlDateBase.class.php");
include_once("../readMode.php");

function getfilePath($s)
{
	$o=$s;
	$t=strrpos($s,"@");
	$r="";
	//echo $t.$s."<br>";
	if($t!=false)
	{
		$p=explode("@",$s);
		$r="ftp://".$p[1];
	}
	else
	{ $r=$o;}
	
	return $r;
}


$t=new TemplateManagement();
$SqlDB = new MySqlDateBase();

//$profilename=$_GET["profilename"];
$profileid=$_POST["profileid"];

$sql_Profile="select ProfileID, ProfileType,ProfileName,ProfilePeriod,TouchJumpUrl,TemplateID from profile where ProfileID='".$profileid."'";
$sql_Profile_rows=$SqlDB->getRows($SqlDB->Query($sql_Profile));




//获取模板信息
$bl=1;
$tmpInfo=$t->GetTempInfo($sql_Profile_rows[0]["TemplateID"]);
echo "TempID:\"".$tmpInfo["TemplateID"]."\",";
echo "TempName:\"".$tmpInfo["TemplateName"]."\",";
echo "W:\"".$tmpInfo["F_Width"]."\",";
echo "H:\"".$tmpInfo["F_Height"]."\",";
echo "TempType:\"".$sql_Profile_rows[0]["ProfileType"]."\",";
if($tmpInfo["Extend1"]=="")
{echo "TempPic:\"0\",BgImageName:\"\"_@_@@_@_";}
else
{
	$r=split("//",$tmpInfo["Extend1"]);
	//$np=split("@",$r[1]);
	//$name_password=$np[0];
	 if(count($r)>1)
    {
        $pathArray=split("/",$r[1]);
    }
	else
    {
        $pathArray=array($tmpInfo["Extend1"]);
    }
	$path="/";
	for($i=1; $i<count($pathArray); $i++)
	{
		$path.=$pathArray[$i]."/";
	}
	$path=substr($path,0,strlen($path)-1);
	$fname=$pathArray[count($pathArray)-1];
	$fph=$tmpInfo["Extend1"];
	echo"BgImageFullPath:\"".urlencode($fph)."\",";
	echo "BgImagePath:\"".urlencode($path)."\",";
	echo "BgImageName:\"".$fname."\",";
	
	echo "TempPic:\"http://".$_SERVER['SERVER_NAME']."/CI/Material/".$tmpInfo["Extend1"]."\"_@_@@_@_";
}


//print_r($sql_Profile_rows);
echo "'ProfileID':'".$sql_Profile_rows[0]["ProfileID"]."',";
echo "'profileName':'".iconv("gb2312","utf-8",urldecode(preg_replace("/\_/","%",$sql_Profile_rows[0]["ProfileName"])))."',";
echo "'profileType':'".$sql_Profile_rows[0]["ProfileType"]."',";
echo "'profilePeriod':'".$sql_Profile_rows[0]["ProfilePeriod"]."',";
echo "'templateID':'".$sql_Profile_rows[0]["TemplateID"]."',";
echo "'touchJumpUrl':'".$sql_Profile_rows[0]["TouchJumpUrl"]."',";
echo "'tempWidth':'',";
echo "'tempHeight':'',";
echo "'tempBgGround':'',";

$ProfileID=$sql_Profile_rows[0]["ProfileID"];
$sql_Profile_des="select SequenceNum,PlaylistType,PlaylistSubType,PlaylistID from profile_describe where ProfileID=".$ProfileID;
$sql_Profile_des_rows=$SqlDB->getRows($SqlDB->Query($sql_Profile_des));
//echo "<pre>";
//print_r($sql_Profile_des_rows);
//echo "</pre><br><br><br>";
//检测背景音乐区域
$hasBackgroundAudioArea=false;
for($i=0,$n=count($sql_Profile_des_rows); $i<$n; $i++)
{
	if($sql_Profile_des_rows[$i]["SequenceNum"]=="101")
	{
		$hasBackgroundAudioArea=true;
		break;
	}
}
if($hasBackgroundAudioArea){
	echo "'hasBackgroundAudio':true"; //标示是否存在背景音乐区域
}
echo "_@_@@_@_";



//子区域
$templateID=$sql_Profile_rows[0]["TemplateID"];
$childAreas=$t->GetBlock($templateID);
 // echo "\n\n\n<pre>";
 // print_r($childAreas);
 // echo "</pre><br><br>\n\n\n\n";
//  
//  
//  
  // echo "<pre>";
 // print_r($sql_Profile_des_rows);
 // echo "</pre><br><br><br>\n\n\n\n";
//  
 
$areaDiv="";

$y=false;   //是否已经获取区域  false->还没有获取区域




	for($c=0,$length=count($childAreas); $c<$length; $c++)
	{
			$areaDiv.="<div id=\"".$childAreas[$c]["BlockID"]."\" position=\"'left':'".$childAreas[$c]["X"]."','top':'".$childAreas[$c]["Y"]."','width':'".$childAreas[$c]["Width"]."','height':'".$childAreas[$c]["Height"]."'\" ";
			$areaDiv.=" onclick=\"areaMenue(event)\" ";
			//$areaDiv.=" oncontextmenu=\"createAreaTypeMenue(event)\" ";
			for($i=0,$n=count($sql_Profile_des_rows); $i<$n; $i++)
			{
				//echo "\n".$childAreas[$c]["BlockID"]."====".$sql_Profile_des_rows[$i]["SequenceNum"]."\n";
				
				if($childAreas[$c]["BlockID"]==$sql_Profile_des_rows[$i]["SequenceNum"])
				{
					
					echo "<div key='".$sql_Profile_des_rows[$i]["SequenceNum"]."'  id='file_".$sql_Profile_des_rows[$i]["SequenceNum"]."' style='display:none; border:1px solid #ccc; width:100%; height:240px;'>";
					$PlaylistID=$sql_Profile_des_rows[$i]["PlaylistID"];
					$sql_playlist_des="select PlayFileID,ControlPara1,ControlPara2,ControlPara3,ControlPara4,ControlPara5,ControlPara6,ControlPara7,ControlPara8,ControlPara9 from playlist_describe where PlaylistID=".$PlaylistID;
					$sql_playlist_des_rows=$SqlDB->getRows($SqlDB->Query($sql_playlist_des));
					
					$type=$sql_Profile_des_rows[$i]["PlaylistType"];
					$subType=$sql_Profile_des_rows[$i]["PlaylistSubType"];
					
					
					$y=false;
					for($a=0; $a<count($sql_playlist_des_rows); $a++)
					{
						//$pt_h=getfilePath($sql_file_inf_rows[0]["URL"]);
						$PlayFileID=$sql_playlist_des_rows[$a]["PlayFileID"];
						$sql_file_inf="SELECT pl . *
FROM `play_file_property` AS pl
LEFT JOIN `play_file_property` AS pp ON pl.`CheckSum` = pp.`CheckSum`
WHERE pl.`FileName` IS NOT NULL AND pp.`PlayFileID` =".$PlayFileID;
						$sql_file_inf_rows=$SqlDB->getRows($SqlDB->Query($sql_file_inf));
						$file_ui_id=$sql_Profile_des_rows[$i]["SequenceNum"]."_".$PlayFileID;
						
						
						
						$dv="<div key='".$sql_Profile_des_rows[$i]["SequenceNum"]."' class='area-file-listitem' id='".$file_ui_id."' 
							fileInfo=\"'fileID':'".$sql_file_inf_rows[0]["PlayFileID"]."','fileName':'".$sql_file_inf_rows[0]["FileName"]."',
									'filePath':'".iconv("GBK","UTF-8",preg_replace("/ftp:\/\/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\//","",$sql_file_inf_rows[0]["URL"]))."',
									'fileViewPath':'".$sql_file_inf_rows[0]["FileViewURL"]."',
									'fileSize':'".$sql_file_inf_rows[0]["FileSize"]."',
									'modifyDate':'".$sql_file_inf_rows[0]["ModifyDate"]."',
									'filemd5':'".$sql_file_inf_rows[0]["CheckSum"]."',";
					
						//视频
						if($type=="VIDEO"&&$subType=="0")
						{
							if(!$y)
							{
								$areaDiv.="mainType='Y' ";
								$areaDiv.="o_bgColor='#060' ";
								$areaDiv.="areaColor='#060' ";
								$areaDiv.="areaType='Video' ";
								$areaDiv.="style=\" background-color:#060;";
								$areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  >主区域</div>";
							}
							$y=true;
							$tpy="";
							switch($sql_file_inf_rows[0]["FileType"])
							{
								case "1":$tpy="Video"; break;
								case "2":$tpy="Audio"; break;
								case "3":$tpy="Img"; break;
								case "4":$tpy="Swf"; break;
								case "5":$tpy="Url"; break;
								case "6":$tpy="Txt"; break;
								default:$tpy="Video"; 
							}
							$dv.="'fileType':'".$tpy."'\"";
							$dv.=" style='cursor:pointer;' onclick=\"editFileList('".$file_ui_id."'),updateFileInfo('".$tpy."',null,'".$file_ui_id."');\"  ";
							$dv.="playInfo=\"";
							$dv.="'playTime':'".($sql_playlist_des_rows[$a]["ControlPara1"]/1000)."',";
							$dv.="'replayCount':'".$sql_playlist_des_rows[$a]["ControlPara2"]."',";
							$dv.="'speed':'".$sql_playlist_des_rows[$a]["ControlPara4"]."'\"";
						}
						//Img
						elseif($type=="PICTURE"&&$subType=="0")
						{
							if(!$y)
							{
								$areaDiv.="mainType='N' ";
								$areaDiv.="o_bgColor='green' ";
								$areaDiv.="areaColor='#0C0' ";
								$areaDiv.="areaType='Img' ";
								$areaDiv.="style=\" background-color:#0C0;";
								$areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  >图片区域</div>";
							}
							$y=true;
							$dv.="'fileType':'Img'\"";
							$dv.=" style='cursor:pointer;' onclick=\"editFileList('".$file_ui_id."'),updateFileInfo('Img',null,'".$file_ui_id."');\"  ";
							$dv.="playInfo=\"";
							$dv.="'playTime':'".$sql_playlist_des_rows[$a]["ControlPara1"]."',";
							
							$dv.="'replayCount':'".$sql_playlist_des_rows[$a]["ControlPara2"]."'\"";
							
						}
						//Swf
						elseif($type=="PICTURE"&&$subType=="1")
						{
							if(!$y)
							{
								$areaDiv.="mainType='N' ";
								$areaDiv.="o_bgColor='green' ";
								$areaDiv.="areaColor='#63F' ";
								$areaDiv.="areaType='Swf' ";
								$areaDiv.="style=\" background-color:#63F;";
								$areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  >动画区域</div>";
							}
							$y=true;
							$dv.="'fileType':'Swf'\"";
							$dv.=" style='cursor:pointer;' onclick=\"editFileList('".$file_ui_id."'),updateFileInfo('Swf',null,'".$file_ui_id."');\"  ";
							$dv.="playInfo=\"";
							$dv.="'playTime':'".$sql_playlist_des_rows[$a]["ControlPara1"]."',";
							
							$dv.="'replayCount':'".$sql_playlist_des_rows[$a]["ControlPara2"]."'\"";
						}
						//Txt   
						elseif($type=="MESSAGE"&&$subType=="0")
						{
							if(!$y)
							{
								$areaDiv.="mainType='N' ";
								$areaDiv.="o_bgColor='green' ";
								$areaDiv.="areaColor='#96F' ";
								$areaDiv.="areaType='Txt' ";
								$areaDiv.="style=\" background-color:#96F;";
								$areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  >滚动字幕</div>";
							}
							$y=true;
							$dv.="'fileType':'Txt'\"";
							$dv.=" style='cursor:pointer;' onclick=\"editFileList('".$file_ui_id."'),updateFileInfo('Txt',null,'".$file_ui_id."');\"  ";
							$dv.="playInfo=\"";
							$dv.="'font':'".$sql_playlist_des_rows[$a]["ControlPara6"]."',";
							$dv.="'fontsize':'".$sql_playlist_des_rows[$a]["ControlPara1"]."',";
							
							$len=strlen(dechex ($sql_playlist_des_rows[$a]["ControlPara2"]));
							$se=dechex($sql_playlist_des_rows[$a]["ControlPara2"]);
							$e="";
							if($len<6)
							{
								for($m=0; $m<(6-$len); $m++)
								{
									$e.="0";
								}
								$dv.="'fontcolor':'#".$e.$se."',";
							}
							else
							{
								$dv.="'fontcolor':'#".dechex ($sql_playlist_des_rows[$a]["ControlPara2"])."',";
							}
							
							
							$len1=strlen(dechex($sql_playlist_des_rows[$a]["ControlPara3"]));
							$se=dechex($sql_playlist_des_rows[$a]["ControlPara3"]);
							$e="";
							if($len1<6)
							{
								for($m=0; $m<(6-$len1); $m++)
								{
									$e.="0";
								}
								$dv.="'bgcolor':'#".$e.$se."',";
							}
							else
							{
								$dv.="'bgcolor':'#".dechex ($sql_playlist_des_rows[$a]["ControlPara3"])."',";
							}
							
							//$dv.="'bgcolor':'#".dechex ($sql_playlist_des_rows[$a]["ControlPara3"]*1)."',";
							$dv.="'scrollamount':'".$sql_playlist_des_rows[$a]["ControlPara4"]."',";
							$dv.="'direction':'".$sql_playlist_des_rows[$a]["ControlPara7"]."',";
							$dv.="'replayCount':'".$sql_playlist_des_rows[$a]["ControlPara5"]."'\"";
						}
						//URL
						elseif($type=="MESSAGE"&&$subType=="3")
						{
							if(!$y)
							{
								$areaDiv.="mainType='N' ";
								$areaDiv.="o_bgColor='green' ";
								$areaDiv.="areaColor='#69F' ";
								$areaDiv.="areaType='Url' ";
								$areaDiv.="style=\" background-color:#69F;";
								$areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  >网页模板区域</div>";
							}
							$y=true;
							
							// 当网页区域的文件属于一个网页地址 例如: http://www.baidu.com
							if($sql_playlist_des_rows[$a]["ControlPara8"]!=""){
								$dv="<div key='".$sql_Profile_des_rows[$i]["SequenceNum"]."'  id='".$file_ui_id."_".$a."' fileInfo=\"'fileID':'".$sql_file_inf_rows[0]["PlayFileID"]."','fileName':'".$sql_playlist_des_rows[$a]["ControlPara8"]."','filePath':'".$sql_playlist_des_rows[$a]["ControlPara8"]."','fileViewPath':'".$sql_playlist_des_rows[$a]["ControlPara8"]."','fileSize':'','modifyDate':'','filemd5':'',";
								
								$dv.="'fileType':'Url1'\"";
								$dv.=" style='cursor:pointer;' onclick=\"editFileList('".$file_ui_id."_".$a."'),updateFileInfo('Url',null,'".$file_ui_id."_".$a."');\"  ";
								$dv.="playInfo=\"'direction':'".$sql_playlist_des_rows[$a]["ControlPara7"]."','strBgorURL':'".$sql_playlist_des_rows[$a]["ControlPara8"]."',";
								$dv.="'scrollType':'".$sql_playlist_des_rows[$a]["ControlPara7"]."',";
								$dv.="'playTime':'".$sql_playlist_des_rows[$a]["ControlPara1"]."',";
								$dv.="'fileFullPath':'".$sql_playlist_des_rows[$a]["ControlPara8"]."'\"";
								//去掉http://头
								$f_name=preg_replace("/(http\:\/\/)|(https\:\/\/)|(ftp\:\/\/)/","",urldecode($sql_playlist_des_rows[$a]["ControlPara8"]));
								$pos_index=strpos($f_name,"/");
								if(!is_bool($pos_index))
								{
									$f_name=substr($f_name,0,$pos_index);
								}
								$sql_file_inf_rows[0]["FileName"]=$f_name;
							}
							
							if($sql_playlist_des_rows[$a]["ControlPara8"]==""){
								$dv.="'fileType':'Url'\"";
								$dv.=" style='cursor:pointer;' onclick=\"editFileList('".$file_ui_id."'),updateFileInfo('Url',null,'".$file_ui_id."');\"  ";
								$dv.="playInfo=\"
									'playTime':'".$sql_playlist_des_rows[$a]["ControlPara1"]."',
									'scrollType':'".$sql_playlist_des_rows[$a]["ControlPara7"]."'\"";
							}
							
						}
						// elseif($type=="MESSAGE"&&$subType=="2")
						// {
							// if(!$y)
							// {
								// $areaDiv.="mainType='N' ";
								// $areaDiv.="o_bgColor='green' ";
								// $areaDiv.="areaColor='#69F' ";
								// $areaDiv.="areaType='Url' ";
								// $areaDiv.="style=\" background-color:#69F;";
								// $areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  >网页模板区域</div>";
							// }
							// $y=true;
							// $y=true;
							// $dv.="'fileType':'Img'\"";
							// $dv.=" style='cursor:pointer;' onclick=\"editFileList('".$file_ui_id."'),updateFileInfo('Img',null,'".$file_ui_id."');\"  ";
							// $dv.="playInfo=\"";
							// $dv.="'playTime':'".$sql_playlist_des_rows[$a]["ControlPara1"]."',";
							// $dv.="'scrollType':'".$sql_playlist_des_rows[$a]["ControlPara7"]."',";
							// $dv.="'replayCount':'".$sql_playlist_des_rows[$a]["ControlPara2"]."',";
							
							// $dv.="'fileFullPath':'".$sql_playlist_des_rows[$a]["ControlPara8"]."'\"";
						// }
						// elseif($type=="MESSAGE"&&$subType=="1")
						// {
							// if(!$y)
							// {
								// $areaDiv.="mainType='N' ";
								// $areaDiv.="o_bgColor='green' ";
								// $areaDiv.="areaColor='#69F' ";
								// $areaDiv.="areaType='Url' ";
								// $areaDiv.="style=\" background-color:#69F;";
								// $areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  >网页模板区域</div>";
							// }
							// $y=true;
							// $y=true;
							// $dv.="'fileType':'Img'\"";
							// $dv.=" style='cursor:pointer;' onclick=\"editFileList('".$file_ui_id."'),updateFileInfo('Img',null,'".$file_ui_id."');\"  ";
							// $dv.="playInfo=\"";
							// $dv.="'playTime':'".$sql_playlist_des_rows[$a]["ControlPara1"]."',";
							// $dv.="'scrollType':'".$sql_playlist_des_rows[$a]["ControlPara7"]."',";
							// $dv.="'replayCount':'".$sql_playlist_des_rows[$a]["ControlPara2"]."'\"";
						// }
						//AUDIO
						elseif($type=="AUDIO"&&$subType=="0")
						{
							if(!$y)
							{
								$areaDiv.="mainType='N' ";
								$areaDiv.="o_bgColor='green' ";
								$areaDiv.="areaColor='#090' ";
								$areaDiv.="areaType='Audio' ";
								$areaDiv.="style=\" background-color:#090;";
								$areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  >背景音乐</div>";
							}
							$y=true;
							$dv.="'fileType':'Audio'\"";
							$dv.=" style='cursor:pointer;' onclick=\"editFileList('".$file_ui_id."'),updateFileInfo('Audio',null,'".$file_ui_id."');\"  ";
							$dv.="playInfo=\"";
							$dv.="'playTime':'".$sql_playlist_des_rows[$a]["ControlPara1"]."',";
							$dv.="'replayCount':'".$sql_playlist_des_rows[$a]["ControlPara2"]."',";
							
							$dv.="'volume':'".$sql_playlist_des_rows[$a]["ControlPara5"]."'\"";
						}
						else 
						{
							$areaDiv.="mainType='N' ";
							$areaDiv.="o_bgColor='green' ";
							$areaDiv.="areaColor='green' ";
							$areaDiv.="style=\" background-color:green;";
							$areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  ></div>";
						}
						$dv.=" >".$sql_file_inf_rows[0]["FileName"]."</div>";	
						
						//输出文件队列
						echo $dv;
					}//
					echo "</div>";
					
					
					
					
					if(count($sql_playlist_des_rows)<=0)
					{
						if($type=="VIDEO"&&$subType=="0")
						{
							if(!$y)
							{
								$areaDiv.="mainType='Y' ";
								$areaDiv.="o_bgColor='#060' ";
								$areaDiv.="areaColor='#060' ";
								$areaDiv.="areaType='Video' ";
								$areaDiv.="style=\" background-color:#060;";
								$areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  >主区域</div>";
							}
							$y=true;
						}
						//Img
						elseif($type=="PICTURE"&&$subType=="0")
						{
							if(!$y)
							{
								$areaDiv.="mainType='N' ";
								$areaDiv.="o_bgColor='green' ";
								$areaDiv.="areaColor='#0C0' ";
								$areaDiv.="areaType='Img' ";
								$areaDiv.="style=\" background-color:#0C0;";
								$areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  >图片区域</div>";
							}
							$y=true;
							
						}
						//Swf
						elseif($type=="PICTURE"&&$subType=="1")
						{
							if(!$y)
							{
								$areaDiv.="mainType='N' ";
								$areaDiv.="o_bgColor='green' ";
								$areaDiv.="areaColor='#63F' ";
								$areaDiv.="areaType='Swf' ";
								$areaDiv.="style=\" background-color:#63F;";
								$areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  >动画区域</div>";
							}
							$y=true;
							
						}
						//Txt   
						elseif($type=="MESSAGE"&&$subType=="0")
						{
							if(!$y)
							{
								$areaDiv.="mainType='N' ";
								$areaDiv.="o_bgColor='green' ";
								$areaDiv.="areaColor='#96F' ";
								$areaDiv.="areaType='Txt' ";
								$areaDiv.="style=\" background-color:#96F;";
								$areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  >滚动字幕</div>";
							}
							$y=true;
							
						}
						//URL
						elseif($type=="MESSAGE"&&$subType=="3")
						{
							if(!$y)
							{
								$areaDiv.="mainType='N' ";
								$areaDiv.="o_bgColor='green' ";
								$areaDiv.="areaColor='#69F' ";
								$areaDiv.="areaType='Url' ";
								$areaDiv.="style=\" background-color:#69F;";
								$areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  >网页模板区域</div>";
							}
							$y=true;
							
						}
						//AUDIO
						elseif($type=="AUDIO"&&$subType=="0")
						{
							if(!$y)
							{
								$areaDiv.="mainType='N' ";
								$areaDiv.="o_bgColor='green' ";
								$areaDiv.="areaColor='#090' ";
								$areaDiv.="areaType='Audio' ";
								$areaDiv.="style=\" background-color:#090;";
								$areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  >背景音乐</div>";
							}
							$y=true;
							
						}
						else 
						{
							$areaDiv.="mainType='N' ";
							$areaDiv.="o_bgColor='green' ";
							$areaDiv.="areaColor='green' ";
							$areaDiv.="style=\" background-color:green;";
							$areaDiv.="text-align:center;position:absolute; border:0px solid; cursor:pointer; width:".($childAreas[$c]["Width"])."px; height:".($childAreas[$c]["Height"])."px; left:".($childAreas[$c]["X"])."px; top:".($childAreas[$c]["Y"])."px;\"  ></div>";
						}
					}
					break;
				}
			}

			
		
	}
	//-----------------------------------
	//
	//	背景音乐区域
	//
	//-----------------------------------
	if($hasBackgroundAudioArea)
	{
		for($i=0,$n=count($sql_Profile_des_rows); $i<$n; $i++)
		{
			if($sql_Profile_des_rows[$i]["SequenceNum"]=="101")
			{
				echo "<div id='file_".$sql_Profile_des_rows[$i]["SequenceNum"]."' style='display:none; border:1px solid #ccc; width:100%; height:240px;'>";
				$PlaylistID=$sql_Profile_des_rows[$i]["PlaylistID"];
				$sql_playlist_des="select PlayFileID,ControlPara1,ControlPara2,ControlPara3,ControlPara4,ControlPara5,ControlPara6,ControlPara7,ControlPara8,ControlPara9 from playlist_describe where PlaylistID=".$PlaylistID;
				$sql_playlist_des_rows=$SqlDB->getRows($SqlDB->Query($sql_playlist_des));
				
				$type=$sql_Profile_des_rows[$i]["PlaylistType"];
				$subType=$sql_Profile_des_rows[$i]["PlaylistSubType"];
				
				
				$y=false;
				for($a=0; $a<count($sql_playlist_des_rows); $a++)
				{
					//$pt_h=getfilePath($sql_file_inf_rows[0]["URL"]);
					$PlayFileID=$sql_playlist_des_rows[$a]["PlayFileID"];
					$sql_file_inf="SELECT pl . *
			FROM `play_file_property` AS pl
			LEFT JOIN `play_file_property` AS pp ON pl.`CheckSum` = pp.`CheckSum`
			WHERE pl.`FileName` IS NOT NULL AND pp.`PlayFileID` =".$PlayFileID;
					$sql_file_inf_rows=$SqlDB->getRows($SqlDB->Query($sql_file_inf));
					$file_ui_id=$sql_Profile_des_rows[$i]["SequenceNum"]."_".$PlayFileID;
					$dv="<div key='".$sql_Profile_des_rows[$i]["SequenceNum"]."'  id='".$file_ui_id."' 
						fileInfo=\"'fileID':'".$sql_file_inf_rows[0]["PlayFileID"]."','fileName':'".$sql_file_inf_rows[0]["FileName"]."',
								'filePath':'".$sql_file_inf_rows[0]["URL"]."',
								'fileViewPath':'".$sql_file_inf_rows[0]["FileViewURL"]."',
								'fileSize':'".$sql_file_inf_rows[0]["FileSize"]."',
								'modifyDate':'".$sql_file_inf_rows[0]["ModifyDate"]."',
								'filemd5':'".$sql_file_inf_rows[0]["CheckSum"]."',";
				
					
					if($type=="AUDIO"&&$subType=="0")
					{
						$dv.="'fileType':'Audio'\"";
						$dv.=" style='cursor:pointer;' onclick=\"editFileList('".$file_ui_id."'),updateFileInfo('Audio',null,'".$file_ui_id."');\"  ";
						$dv.="playInfo=\"";
						$dv.="'playTime':'".$sql_playlist_des_rows[$a]["ControlPara1"]."',";
						$dv.="'replayCount':'".$sql_playlist_des_rows[$a]["ControlPara2"]."',";
						
						$dv.="'volume':'".$sql_playlist_des_rows[$a]["ControlPara5"]."'\"";
					}
					$dv.=" >".$sql_file_inf_rows[0]["FileName"]."</div>";	
					
					//输出文件队列
					echo $dv;
				}
				echo "</div>";
				break ;
			}
		}
	}


//输出   模板信息
echo "_@_@@_@_";
echo $areaDiv;
$SqlDB->Close();


?>