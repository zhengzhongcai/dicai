
fileListContainer

var allSource=_("content").childNodes;
 
for(var key in allSource)
{
	if(allSource[key].nodeName!="#TEXT"&&allSource[key].tagName=="DIV")
	{
		//实例化多个的分页对象
	}
}














//获取图片资源
function getBGpicture()
{
	createPICsourceContainer();
	var myajax= new DedeAjax(null,true,savePicSource);
	//myajax.AddKey("full_path",info.filePath);
	myajax.SendPost("../../ajaxPHP/getBackgroundImage.php");
}
//创建获取图片资源容器并存储取图片资源
function savePicSource(PicSource)
{
	
	_("picContainerID").innerHTML=PicSource;
}
function createPICsourceContainer()
{
	var picContainer=document.createElement("div");
	picContainer.setAttribute("id","picContainerID");
	picContainer.style.display="none";
	window.document.body.appendChild(picContainer);
}
//创建图片数组 
function createPicList()
{
	var picArray=new Array();
	var picItems=_("picContainerID").childNodes;
	//alert("picItems\n"+picItems.length);
	for(var i=0; i<picItems.length; i++)
	{
		//alert(i+"__"+picItems[i]);
		if(picItems[i].nodeName!="#text")
		{
			if(picItems[i].tagName=="DIV")
			{
				//alert(i+"__"+picItems[i]);
				picArray.push(picItems[i].cloneNode(true));
			}
		}
	}
	_("pgSize").setAttribute("countItems",picArray.length)
	return picArray;
}
/***************************图片界面分页**************************/
//获取当前页的元素(图片分页UI)
function currentPaging(start_index,end_index)
{
	var picDivItems=new Array();
	var picArray=createPicList();
	//alert(picArray);
	for(var i=start_index ; i<end_index; i++)
	{
		picDivItems.push(picArray[i]);
	}
	return picDivItems;
}
//分页操作函数
function lastPage(obj)//上一页
{
	var sourceArray;
	var pageSize=parseInt(_("pgSize").value);
	var start_index  =  parseInt(obj.getAttribute("start_index"));
	var end_index    =  parseInt(obj.getAttribute("end_index"));
	var countItems=(parseInt(_("pgSize").getAttribute("countItems"))-1);
	if(start_index!=0)
	{
		obj.setAttribute("start_index",start_index-pageSize);
		obj.setAttribute("end_index",end_index-pageSize);
		sourceArray= currentPaging(start_index-pageSize,end_index-pageSize);
	}
	else
	{
		obj.setAttribute("start_index",countItems-1-pageSize);
		obj.setAttribute("end_index",countItems-1);
		sourceArray= currentPaging(countItems-1-pageSize,countItems-1);
	}
	setSource(1,sourceArray);
}
function nextPage(obj)//下一页
{
	var sourceArray;
	var pageSize=parseInt(_("pgSize").value);
	var start_index  =  parseInt(obj.getAttribute("start_index"));
	var end_index    =  parseInt(obj.getAttribute("end_index"));
	var countItems=(parseInt(_("pgSize").getAttribute("countItems")));
	//alert(countItems-end_index+"___"+(pageSize));
	if((countItems-start_index)<=pageSize)
	{
		obj.setAttribute("start_index","0");
		obj.setAttribute("end_index",pageSize);
		//alert("小于等于\n开始: "+start_index+"\n结束: "+end_index);
		sourceArray= currentPaging(start_index,countItems);
	}
	else
	{
		p=pageSize;
		s=end_index;
		e=p+end_index;
		obj.setAttribute("start_index",s);
		obj.setAttribute("end_index",e);
		//alert("开始: "+(start_index)+"\n结束: "+(end_index)+"\n每一页的条数:"+pageSize+"\n下一次起始页:"+s+"\n下一次结束页:"+e);
		sourceArray= currentPaging(start_index,end_index);
	}
	
	setSource(1,sourceArray);
}

/***************************图片选择界面UI生成**************************/
//创建一个遮盖层
function createCoverDV()
{
	//定义遮盖层的样式
	var w="";
	var h="";
	var oty="";
		try{
			oty="opacity:0.7;";
			h=document.documentElement.scrollHeight;
			w=document.documentElement.scrollWidth;
			}
			catch(e)
			{
				oty="Filter:alpha(opacity=50);";
				h=document.body.scrollHeight;
				w=document.body.scrollWidth;
			}
	var table="<table style=\"height:"+h+"px; width:100%;font-size:20px; border:1px black solid; \"><tr><td align=center id=\"PicContainerArea\">文件下载中......</td></tr></table>";
	var css="position:absolute;top:0px; left:0px; width:"+w+"px;height:"+h+"px; display:block; background-color:#ccc;z-index:3;"+oty;
	var coverDV=document.createElement("div");
	coverDV.setAttribute("id","coverID");
	coverDV.style.cssText=css;
	document.body.appendChild(coverDV);
	
	var cDV=document.createElement("div");
	cDV.setAttribute("id","coverID_area");
	cDV.style.cssText="position:absolute;top:0px; left:0px; width:"+w+"px;height:"+h+"px; display:block; z-index:4;";
	document.body.appendChild(cDV);
	_("coverID_area").innerHTML=table;
}
//关闭遮盖层
function closeCoverDV()
{
	_("coverID").style.display="none";
	_("coverID_area").style.display="none";
}
//显示遮盖层
function showCoverDV()
{
	_("coverID").style.display="block";
	_("coverID_area").style.display="block";
}
//生成背景图选择界面
function createBGpictureSelectUI(i)
{
	
	if(_("picContainerID")&&_("picContainerID").childNodes.length)
	{
		showCoverDV();
		setSource(0,null);
	}
	else
	{
		if(!i)
		{
			getBGpicture();
			createCoverDV();
			var picArea="<div id='picAreas' style=\"width:300px; height:380px; float:left; display:block; background-color:green;\"><img src=\"../../images_M/ajax-loader.gif\" style=\"margin-top:60px;\" width=\"50\" height=\"50\"  /></div>";
			var showpicArea="<div id='showpicAreas' style=\"width:400px; height:380px; float:left;background-color:red;\" ></div>";
			var toolBarArea="<div style=\"width:700px;display:block; height:35px; background-color:blue; float:left; \" id=\"bgImgaes_button\" ><button style=\"height:30px; border:1px; margin-top:1px;\" start_index=\"0\" end_index=\"0\" id='lastpg' onclick=\"lastPage(this)\">上一页</button><input style=\"width:30px;height:28px;border:1px;margin-left:5px;margin-top:-1px;\" type='text' id=\"pgSize\" value=\"10\" countItems=\"0\" /><button style=\"height:30px; border:1px; margin-top:3px; margin-left:5px;\" start_index=\"0\" end_index=\"0\" id='nextpg' onclick=\"nextPage(this)\">下一页</button><button style=\"width:100px;height:30px;border:1px; margin-left:100px;\" onclick=\"reF()\">刷新</button><button style=\"width:100px;height:30px;border:1px; margin-left:100px;\" onclick=\"setBackgroundIMG(this)\">确定</button></div>";
			_("PicContainerArea").innerHTML="<div style=\"display:block;width:700px; margin:0px;\">"+picArea+showpicArea+toolBarArea+"</div>";
			if(_("picContainerID")&&_("picContainerID").childNodes.length>1)
			{
				//alert("获得_"+_("picContainerID").id);
				setTimeout("setSource(0,null)",3000);
			}
			else
			{setTimeout("createBGpictureSelectUI(1)",500);}
		}
		else
		{
			if(_("picContainerID")&&_("picContainerID").childNodes.length>1)
			{
				alert("获得");
				setTimeout("setSource(0,null)",500);
			}
			else
			{setTimeout("createBGpictureSelectUI(1)",500);}
		}
	}
}
//填充数据
function setSource(source,sourceArray)
{
	_("picAreas").innerHTML="";
	var items,picclick,picid;
	if(source)
	{items=sourceArray;}
	else
	{
		var m=parseInt(_("pgSize").value);
		items=currentPaging(0,parseInt(_("pgSize").value));
		_("nextpg").setAttribute("start_index",m);
		_("nextpg").setAttribute("end_index",(m*2));
	}
	for(var i=0; i<items.length; i++)
	{
		picid=null;
		picclick=null;
		picid=items[i].id;
		picclick=function(picid){showPIC(picid);};
		items[i].setAttribute("onmouseout","this.style.background='transparent';");
		items[i].setAttribute("onmouseover","this.style.backgroundColor='#fff';");
		items[i].setAttribute("id",picid+"_"+i);
		items[i].attachEvent("onclick",picclick);//注册单击事件
		_("picAreas").appendChild(items[i]);
	}
}

//预览图片
function showPIC(ev)
{
	_("showpicAreas").innerHTML="";
	ev = ev || window.event;
	var target = ev.target || ev.srcElement;
	var mytitle=eval("({"+target.getAttribute("mytitle")+"})");
	
	//alert(mytitle.myPath);
	var oty="background-color:#fff; border:1px; width:380px;margin-top:10px;";
	try{
		oty+="opacity:1.0;";
	}
	catch(e)
	{
		oty+="Filter:alpha(opacity=100);";
	}
	
	var img=document.createElement("IMG");
	img.setAttribute("id","mimg");
	img.setAttribute("myfilePath",mytitle.fileFullPath);
	img.src=mytitle.myPath;
	img.style.cssText=oty+"height:360px;";
	_("showpicAreas").appendChild(img);
}
function setBackgroundIMG()
{
	
}
function reF()
{
	//删掉之前填充的数据
	_("picAreas").innerHTML="";
	window.document.body.appendChild(_("picContainerID"));
	createBGpictureSelectUI(0);
}