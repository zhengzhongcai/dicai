<?php

function createViewFileXMl($profileName,$fileInfo)
{
	$doc=new DOMDocument("1.0","utf-8");  #声明文档类型-------------utf-8
	@$doc->formatOutput=true;               #设置可以输出操作
	
	#声明根节点，最好一个XML文件有个跟节点
	
	$playlist=$doc->createElement("playlist");    #创建节点对象实体
	$playlists=$doc->appendChild($playlist);      #把节点添加进来(作为根节点)
	
	$trackList = $doc->createElement('trackList');
	$trackLists = $playlists->appendChild($trackList);

	foreach($fileInfo as $v)
	{
		if($v["type"]=="Video")
		{
			if(count($v["files"])>0)
			{
				foreach($v["files"] as $f)
				{
					if($f["fileInfo"]["fileType"]=="Img")  //当前只支持 视频 和 图片
					{
					
						$track=$doc->createElement("track");
						$tracks=$trackLists->appendChild($track);
						
						$creator=$doc->createElement("creator");
						$creator->appendChild($doc->createTextNode($f["fileInfo"]["fileName"]));
						
						$title=$doc->createElement("title");
						$title->appendChild($doc->createTextNode($f["fileInfo"]["fileType"]));
						
						$location=$doc->createElement("location");
						$location->appendChild($doc->createTextNode(base_url()."Material/".fileNameEncode($f["fileInfo"]["fileViewPath"])));
						
						
						$tracks->appendChild($creator);
						$tracks->appendChild($title);
						$tracks->appendChild($location);
						
						
							$duration=$doc->createElement("duration");
							$duration->appendChild($doc->createTextNode("5000"));
							$tracks->appendChild($duration);
						
					}
					if($f["fileInfo"]["fileType"]=="Video")
					{
						$track=$doc->createElement("track");
						$tracks=$trackLists->appendChild($track);
						
						$creator=$doc->createElement("creator");
						$creator->appendChild($doc->createTextNode($f["fileInfo"]["fileName"]));
						
						$title=$doc->createElement("title");
						$title->appendChild($doc->createTextNode($f["fileInfo"]["fileType"]));
						
						$location=$doc->createElement("location");
						$location->appendChild($doc->createTextNode(base_url()."Material/view/".$f["fileInfo"]["fileViewPath"]));
						
						$tracks->appendChild($creator);
						$tracks->appendChild($title);
						$tracks->appendChild($location);
					}
					
				}
				
			}
		}
	}
	
	
	//$fp = fopen('FileLib/'.$profileName.'/mainAreaView.xml', "w ");   //创建文档tt.txt
//fwrite($fp, "待写入的内容 ");   //写入内容
	//fclose($fp);
	//保存xml
	if($doc->save('FileLib/'.$profileName.'/mainAreaView.xml'))
		return true;
	else
		return false;
	
}


?>