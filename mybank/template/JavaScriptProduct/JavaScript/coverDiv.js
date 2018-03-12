// JavaScript Document
function _(objId){return document.getElementById(objId);};
//创建一个遮盖层
function __createCoverDiv(containerID)
{
	if(!_(containerID))
	{
		var containerDiv=document.createElement("DIV");
		containerDiv.id=containerID;
		document.body.appendChild(containerDiv);	
	}
	//定义遮盖层的样式
	var w="";
	var h="";
	var oty="";
		if(document.all){
				oty="filter:alpha(opacity=10)";
				w=document.documentElement.scrollWidth;
				h=document.documentElement.scrollHeight;
			}
			else
			{
				oty="opacity:0.1;";
				w=document.documentElement.scrollWidth;
				h=document.documentElement.scrollHeight;
			}
	var table="<table align=center style=\"height:"+h+"px; font-size:20px; border:0px black solid; \"><tr><td align=center id=\"content_"+containerID+"\">信息加载中......</td></tr></table>";
	var css="position:absolute;top:0px; left:0px; width:"+w+"px;height:"+h+"px; display:block; background-color:#ccc;z-index: 900;"+oty;
	var coverDV=document.createElement("div");
	coverDV.setAttribute("id","cover_"+containerID);
	coverDV.style.cssText=css;
	_(containerID).appendChild(coverDV);
	var cDV=document.createElement("div");
	cDV.setAttribute("id","cover_content_"+containerID);
	cDV.style.cssText="position:absolute;top:0px; left:0px; width:"+w+"px;height:"+h+"px; display:block; z-index:1000;";
	cDV.innerHTML=table;
	_(containerID).appendChild(cDV);
	
}


//关闭遮盖层
function __closeCoverDiv(boolen,ContainerId)
{
	if(boolen)
	{
		_(ContainerId).innerHTML="";
	}
	else
	{
		_("cover_"+containerID).style.display="none";
		_("cover_content_"+containerID).style.display="none";
	}
}
//显示遮盖层
function __showCoverDiv(containerID)
{
	_("cover_"+containerID).style.display="block";
	_("cover_content_"+containerID).style.display="block";
}
function __content(containerID){return _("content_"+containerID);}


