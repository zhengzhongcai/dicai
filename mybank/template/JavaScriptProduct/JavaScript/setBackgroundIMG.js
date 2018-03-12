function createBackgroundDIV(imgSrc,php_imgSrc,css_top,css_left,css_width,css_height,css_zIndex)
{
	//alert("css_top:"+css_top+"\ncss_left: "+css_left+"\ncss_width: "+css_width+"\ncss_height: "+css_height+"\ncss_zIndex: "+css_zIndex);
	if(_("bgDIV"))
	{
		with(_("bgDIV").style)
		{
			top=css_top+"px";
			left=css_left+"px";
			width=css_width+"px";
			height=css_height+"px";
		};
		_("bgImg").src=imgSrc;
		_("bgImg").setAttribute("php_download_path",php_imgSrc);
		with(_("bgImg").style)
		{
			width=css_width+"px";
			height=css_height+"px";
		}
	}
	else
	{
		var bDIV=document.createElement("div");
		bDIV.setAttribute("id","bgDIV");
		var csstext="position:absolute;top:"+css_top+"px;left:"+css_left+"px;width:"+css_width+"px;height:"+css_height+"px;z-index:"+css_zIndex+"; padding:0px 0px 0px 0px;";
		//alert(css_zIndex);
		bDIV.style.cssText=csstext;
		document.body.appendChild(bDIV);
		
		//解决IE下  为模板添加背景后右键添加子区域失效
		if(document.all)
		{var bgImg="<img src='"+imgSrc+"' php_download_path='"+php_imgSrc+"' id=\"bgImg\" style=\"width:"+css_width+"px;height:"+css_height+"px;\" border='0' oncontextmenu=\"try{clearPos();}catch(e){};createRMenue(this);\"; onclick=\"try{clearPos();}catch(e){};\" />";}
		else
		{var bgImg="<img src='"+imgSrc+"' php_download_path='"+php_imgSrc+"' id=\"bgImg\" style=\"width:"+css_width+"px;height:"+css_height+"px;\" border='0' />";}
		bDIV.innerHTML=bgImg;
		
	}
}
/* * * * * * * * * * * * * * * * * ** * * * * * ** * * * * * *

					加载背景图片

********************  *     *   *     * * *  ** * x* * ** * * *  */
function loadBgPhoto(imgURL,phpDownloadUrl)
{
	imgURL=imgURL.replace(/%253A/g,":").replace(/%252F/g,"/").replace(/%2540/g,"@");
	phpDownloadUrl=phpDownloadUrl.replace(/%253A/g,":").replace(/%252F/g,"/").replace(/%2540/g,"@");
	
	var info=getCanvasInfo("apDiv1");
		createBackgroundDIV(imgURL,//图片路径
							phpDownloadUrl,
							info.t().toString().replace(/px/g,""),//y坐标
							info.l().toString().replace(/px/g,""),//x坐标
							info.w().toString().replace(/px/g,""),//宽度
							info.h().toString().replace(/px/g,""),//高度
							parseInt(info.z())-1//悬浮层次
							);
}
function setURL(img,fatherDIV)
{
	var imgURL=_(img).src;   //图片显示路径
	var php_imgURL=_(img).getAttribute("php_download_path");   //图片下载路径
	if(_("bgImg"))//如果存在背景图对象,就只更改图片的路径
	{
		_("bgImg").src=imgURL;
	}
	else//不存在就创建背景图层和背景图对象
	{
		var info=getCanvasInfo(fatherDIV);
		createBackgroundDIV(imgURL,//图片路径
							php_imgURL,//PHP下载图片到用户文件夹的路径
							info.t().toString().replace(/px/g,""),//y坐标
							info.l().toString().replace(/px/g,""),//x坐标
							info.w().toString().replace(/px/g,""),//宽度
							info.h().toString().replace(/px/g,""),//高度
							parseInt(info.z())-1//悬浮层次
							);
	}
}
function setURLK(fileArea,fatherDIV)
{
	var imgURL=_(fileArea).files.item(0).getAsDataURL(); // 注 此处从客户端获取背景图 Firefox
	if(_("bgImg"))//如果存在背景图对象,就只更改图片的路径
	{
		_("bgImg").src=imgURL;
	}
	else//不存在就创建背景图层和背景图对象
	{
		var info=getCanvasInfo(fatherDIV);
		createBackgroundDIV(imgURL,//图片路径
							info.t().toString().replace(/px/g,""),//y坐标
							info.l().toString().replace(/px/g,""),//x坐标
							info.w().toString().replace(/px/g,""),//宽度
							info.h().toString().replace(/px/g,""),//高度
							parseInt(info.z())-1//悬浮层次
							);
	}
}

//   
function getCanvasInfo(fatherDIV)
{
	var canvas=_(fatherDIV);
	canvas.style.background="transparent";
	var info={	w:function(){return canvas.style.width  ?canvas.style.width  :getFinallyStyle(fatherDIV, "width");  },
				h:function(){return canvas.style.height ?canvas.style.height :getFinallyStyle(fatherDIV, "height"); },
				t:function(){return canvas.style.top    ?canvas.style.top    :getPosition(canvas).y; },
				l:function(){return canvas.style.left   ?canvas.style.left   :getPosition(canvas).x; },
				z:function(){return canvas.style.zIndex ?canvas.style.zIndex :getFinallyStyle(fatherDIV, "zIndex"); }
				};
	return info;
}
//获取最终样式属性 即 .ss{中的属性}
function getFinallyStyle(sElementId, sAttribute) 
{
    var oElement = document.getElementById(sElementId);
	var styleValue="";
    return !!document.defaultView ? 
			 eval("document.defaultView.getComputedStyle(oElement, null)." + sAttribute) :
			 eval("oElement.currentStyle." + sAttribute);
}
//获取HTML对象,相对于窗口的绝对位置
Number.prototype.NaN0=function(){return isNaN(this)?0:this;}
function getPosition(e)
{
	var left = 0;
	var top  = 0;
	while (e.offsetParent){
		left += e.offsetLeft + (e.currentStyle?(parseInt(e.currentStyle.borderLeftWidth)).NaN0():0);
		top  += e.offsetTop  + (e.currentStyle?(parseInt(e.currentStyle.borderTopWidth)).NaN0():0);
		e     = e.offsetParent;
	}
	left += e.offsetLeft + (e.currentStyle?(parseInt(e.currentStyle.borderLeftWidth)).NaN0():0);
	top  += e.offsetTop  + (e.currentStyle?(parseInt(e.currentStyle.borderTopWidth)).NaN0():0);
	return {x:left, y:top};
}


/***********************************************************************
*
*
*
*
*************************************************************************/


//获取图片资源
function getBGpicture()
{
	createPICsourceContainer();
	$.ajax({url:"../../ajaxPHP/getBackgroundImage.php",type:"POST",success: function(data){_("picContainerID").innerHTML=data;}});
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
	_("pgSize").setAttribute("countItems",picArray.length);
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
			if(picArray[i]){
			picDivItems.push(picArray[i]);
			}
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

/**********************

						*****图片选择界面UI生成*******

*******************/
//创建一个遮盖层
function createCoverDV()
{
	//定义遮盖层的样式
	var w="";
	var h="";
	var oty="";
		if(document.all){
				oty="filter:alpha(opacity=10)";
				w=document.documentElement.scrollWidth;
				h=document.documentElement.clientHeight;
			}
			else
			{
				oty="opacity:0.1;";
				w=document.documentElement.scrollWidth;
				h=document.documentElement.clientHeight;
			}
	var table="<table border='0' align=center style=\"height:"+h+"px; font-size:20px; border:0px black solid; \"><tr><td align=center id=\"PicContainerArea\">信息加载中......</td></tr></table>";
	var css="position:absolute;top:0px; left:0px; width:"+w+"px;height:"+h+"px; display:block; background-color:#ccc;z-index: 900;"+oty;
	var coverDV=document.createElement("div");
	coverDV.setAttribute("id","coverID");
	coverDV.style.cssText=css;
	document.body.appendChild(coverDV);
	
	var cDV=document.createElement("div");
	cDV.setAttribute("id","coverID_area");
	cDV.style.cssText="position:absolute;top:0px; left:0px; width:"+w+"px;height:"+h+"px; display:block; z-index:1000;";
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
//创建一个遮盖层
function createCoverDV2()
{

	//定义遮盖层的样式
	var w="";
	var h="";
	var oty="";
		if(document.all){
				oty="filter:alpha(opacity=10)";
				w=document.documentElement.scrollWidth;
				h=document.documentElement.clientHeight;
			}
			else
			{
				oty="opacity:0.1;";
				w=document.documentElement.scrollWidth;
				h=document.documentElement.clientHeight;
			}
	var table="<table align=center style=\"height:"+h+"px; font-size:20px; border:0px black solid; \"><tr><td align=center id=\"PicContainerArea2\">信息加载中......</td></tr></table>";
	var css="position:absolute;top:0px; left:0px; width:"+w+"px;height:"+h+"px; display:block; background-color:#ccc;z-index: 900;"+oty;
	var coverDV=document.createElement("div");
	coverDV.setAttribute("id","coverID2");
	coverDV.style.cssText=css;
	document.body.appendChild(coverDV);
	
	var cDV=document.createElement("div");
	cDV.setAttribute("id","coverID_area2");
	cDV.style.cssText="position:absolute;top:0px; left:0px; width:"+w+"px;height:"+h+"px; display:block; z-index:1000;";
	document.body.appendChild(cDV);
	_("coverID_area2").innerHTML=table;
}

//关闭遮盖层
function closeCoverDV2()
{
	_("coverID2").style.display="none";
	_("coverID_area2").style.display="none";
}
//显示遮盖层
function showCoverDV2()
{
	_("coverID2").style.display="block";
	_("coverID_area2").style.display="block";
}
//生成背景图选择界面
function createBGpictureSelectUI(i)
{
	if(_("picContainerID")&&_("picContainerID").childNodes.length)
	{
		if(_("bgImg")&&$Name("moshi")[1].checked)
		{
			_("bgImgaes_button").innerHTML="";
			var toolBarArea="<button style=\"height:30px; border:1px; margin-top:1px;\" start_index=\"0\" end_index=\"0\" id='lastpg' onclick=\"lastPage(this)\">上一页</button>";
			toolBarArea+="<input style=\"width:30px;height:28px;border:1px;margin-left:5px;margin-top:-1px;\" type='text' id=\"pgSize\" value=\"10\" countItems=\"0\" />";
			toolBarArea+="<button style=\"height:30px; border:1px; margin-top:3px; margin-left:5px;\" start_index=\"0\" end_index=\"0\" id='nextpg' onclick=\"nextPage(this)\">下一页</button>";
			toolBarArea+="<button style=\"width:100px;height:30px;border:1px; margin-left:100px;\" onclick=\"reF()\">刷新</button>";
			toolBarArea+="<button style=\"width:100px;height:30px;border:1px; margin-left:100px;\" onclick=\"updateBackgroundIMG()\">修改</button>";
			toolBarArea+="<button style=\"width:50px;height:30px;border:1px; margin-left:50px;\" onclick=\"closeCoverDV()\">关闭</button>";
			_("bgImgaes_button").innerHTML=toolBarArea;
		}
		else
		{
			_("bgImgaes_button").innerHTML="";
			var toolBarArea="<button style=\"height:30px; border:1px; margin-top:1px;\" start_index=\"0\" end_index=\"0\" id='lastpg' onclick=\"lastPage(this)\">上一页</button>";
			toolBarArea+="<input style=\"width:30px;height:28px;border:1px;margin-left:5px;margin-top:-1px;\" type='text' id=\"pgSize\" value=\"10\" countItems=\"0\" />";
			toolBarArea+="<button style=\"height:30px; border:1px; margin-top:3px; margin-left:5px;\" start_index=\"0\" end_index=\"0\" id='nextpg' onclick=\"nextPage(this)\">下一页</button>";
			toolBarArea+="<button style=\"width:100px;height:30px;border:1px; margin-left:100px;\" onclick=\"reF()\">刷新</button>";
			toolBarArea+="<button style=\"width:100px;height:30px;border:1px; margin-left:100px;\" onclick=\"setBackgroundIMG(this)\">确定</button>";
			toolBarArea+="<button style=\"width:50px;height:30px;border:1px; margin-left:50px;\" onclick=\"closeCoverDV()\">关闭</button>";
			_("bgImgaes_button").innerHTML=toolBarArea;
		}
		showCoverDV();
		setSource(0,null);
	}
	else
	{
		if(!i)
		{
			getBGpicture();
			createCoverDV();
			var picArea="<div id='picAreas' style=\"width:300px; height:380px; float:left; display:block; background-color:#ccc;\"><img src=\"../../images_M/ajax-loader.gif\" style=\"margin-top:60px;\" width=\"50\" height=\"50\"  /></div>";
			var showpicArea="<div id='showpicAreas' style=\"width:399px; height:380px; float:left; border-left:1px solid #eee; background-color:#fff;\" ></div>";
			var toolBarArea="<div style=\"width:700px;display:block; height:35px; background-color:#eeeeee; float:left; \" id=\"bgImgaes_button\" >";
			toolBarArea+="<button style=\"height:30px; border:1px; margin-top:1px;\" start_index=\"0\" end_index=\"0\" id='lastpg' onclick=\"lastPage(this)\">上一页</button>";
			toolBarArea+="<input style=\"width:30px;height:28px;border:1px;margin-left:5px;margin-top:-1px;\" type='text' id=\"pgSize\" value=\"10\" countItems=\"0\" />";
			toolBarArea+="<button style=\"height:30px; border:1px; margin-top:3px; margin-left:5px;\" start_index=\"0\" end_index=\"0\" id='nextpg' onclick=\"nextPage(this)\">下一页</button>";
			toolBarArea+="<button style=\"width:100px;height:30px;border:1px; margin-left:100px;\" onclick=\"reF()\">刷新</button>";
			toolBarArea+="<button style=\"width:100px;height:30px;border:1px; margin-left:100px;\" onclick=\"setBackgroundIMG(this)\">确定</button>";
			toolBarArea+="<button style=\"width:50px;height:30px;border:1px; margin-left:50px;\" onclick=\"closeCoverDV()\">关闭</button>";
			toolBarArea+="</div>";
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
				//alert("获得");
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
		picid=items[i].getAttribute("id");
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
	img.setAttribute("php_download_path",mytitle.fileFullPath);
	img.src=mytitle.myPath;
	//alert((img.height)/((img.width)/300));
	//var bs=parseInt(img.height)/parseInt((img.width))/400;
	img.style.cssText=oty+"height:360px;";
	_("showpicAreas").appendChild(img);
	//_("showpicAreas").style.paddingTop="10px";
	//_("showpicAreas").style.paddingTop="10px";
}
//修改背景图
function updateBackgroundIMG()
{
	var mfPath=_("mimg").getAttribute("php_download_path");
	var tpID=_("apDiv1").getAttribute("tempId");
	$.ajax({url:"../../ajaxPHP/updateBackgroundImage.php",
	data:{
		TempID:tpID,//模板ID
		bgImg:mfPath//模板背景
		},
		type:"POST",
		success: function(data){
			var string=data.split("_@_@@_@_");
									var s=string[0];
									if(s=="OK")
									{
										setURL("mimg","apDiv1");
										closeCoverDV();
									}
									else
									{
										alert("操作提示:\n模板背景更新失败");
										_("coverID").style.display="none";
										_("coverID_area").style.display="none";
									}
		}});
}
//设置背景图(为新建的模板新增)
function setBackgroundIMG()
{
	setURL("mimg","apDiv1");
	closeCoverDV();
}

//刷新模板数据
function reF()
{
	//删掉之前填充的数据
	_("picAreas").innerHTML="";
	window.document.body.appendChild(_("picContainerID"));
	createBGpictureSelectUI(0);
}