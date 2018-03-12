// JavaScript Document
//-- 分页参数
ready(function() {
	loadTree();
	//loadGrid();
	
});
var pageInfo = { curent: 1, pageSize: 20, count: 0, type: "" };
function setData(str) {
    bug("服务器返回的文件列表", "<textarea>"+str+"</textarea>", "green");
    _("gridContainer").innerHTML = "";
    str = str.split("__@__");
    _("gridContainer").innerHTML = str[0];
    pageInfo.count = str[1];
    pageInfo.curent = 1;
	pageInfo.pageSize = str[2];
	_("totalpage").innerHTML = pageInfo.count;
}
function setPageData(str) {
    bug("服务器返回的文件列表", "<textarea>"+str+"</textarea>", "green");
    _("gridContainer").innerHTML = "";
    str = str.split("__@__");
    _("gridContainer").innerHTML = str[0];
    pageInfo.count = str[1];
	pageInfo.pageSize = str[2];
}

/**
 * @description  Tree操作
 */

//从数据库获取用户的文件分类
function loadTree()
{
	//alert("sadfsadsa");
	var ajax = new AJAXRequest();
	ajax.get("index.php?control=filetype&action=index", function(obj)
	{
		_("mainTree").innerHTML=obj.responseText;
		bindTreeEvent();
	});
}

function bindTreeEvent(ts)
{
	ts=ts||getChildNodes(_("mainTree"));
	//alert(ts.length);
	for(var i=0,n=ts.length; i<n; i++)
	{
		if(ts[i].tagName=="A")
		{
			//bindRightClick(ts[i],treeRightMenu);
			bindLeftClick(ts[i],getFileList);
			//alert(getNextChild(ts[i]).tagName);
			if(getNextChild(ts[i]).tagName=="DIV")
			{
				bindLeftClick(ts[i],showTreeNode);
				bindTreeEvent(getChildNodes(getNextChild(ts[i])));
			}
		}
	}
};

/**
 * 
 * @name		showTreeNode
 * @description	打开/关闭记录
 * @author		BB
 * @param		{} ev
 * @return
 * @version		2010.9.17   2013.2.28 modify by kycool	
 */
function showTreeNode(ev) {

	var o=getEventObject(ev);
	var nNode=getNextChild(o);
	var t=getChildNodes(o);
	//alert(nNode.tagName);
	//如果存在子目录
	if(nNode.tagName=="DIV")
	{
		if(getCorentStyle(nNode,"display")=="none")
		{
			nNode.style.display="block";
			t[0].innerHTML="-";
		}
		else
		{
			nNode.style.display="none";
			t[0].innerHTML="+";
		}
	}

}

/**
 * 
 * @name		getFileList
 * @description	查询鼠标点击的文件的类型,重置文件预览,设置上传的文件类型
 * @param		
 * @return		
 * @author		BB
 * @version		2011.1.25 
 */
function getFileList(ev)
{

	//重置预览窗口
	review();
	var o=getEventObject(ev);
	var _o=getRootNode(o);
	//alert(o.tagName);
	var typ = getAttr(o, "id").split("_")[1];
	
			//$('#gridContainer').datagrid("loadData",result);
	    	$('#gridContainer').datagrid("changeUrl","index.php?control=fileManageGrid&action=getOneType");
	    	$('#gridContainer').datagrid({
					queryParams: {
						type:typ
					}
				});
	// $.ajax({
		// type:"post",
		// data:{page:1,type:typ,rows:20},
		// url:"index.php/fileManageGrid/getOneType",
		// success:function(result){
// 			
// 	    	
		// },
		// dataType:"JSON"
	// });
	
	//设置上传时候的文件类型
	resources.setUpFileType(_o.id,o.id);
}


//tree节点右键触发的事件
function treeRightMenu(ev)
{
	//重置预览窗口
	review();

	var p=getMousePos(ev);
	var o=getEventObject(ev);
	var _o=getRootNode(o);
	bug("tree节点右键触发的事件:","鼠标位置:x->"+p.x+" y-->"+p.y+" 一级节点内容-><textarea>"+_o.innerHTML+"</textarea> 触发事件节点内容->"+txt(o)+" 一级节点->"+_o.tagName);
	createRightMenu(p.x,p.y,_o.id,o.id,_o);
	//绑定隐藏事件
	bindLeftClick(document, closeTreeRihthMenu);
}

function getRootNode(o)
{
	var _o="";
	while(o.getAttribute("id")!="mainTree")
	{
		_o=o;
		o=getParentNode(o);
	}
	if(_o.tagName=="A")
	{
		return _o;
	}
	else
	{
		return getPrevChild(_o);
	}
}

//创建tree右键菜单界面
function createRightMenu(x,y,typeId,nodeId,o)
{

	//<A onclick=\"addTreeNode('"+i+"')\">添加子类型</A>\
	var str=''+
	'<div style="display:block; ">'+
		'<a href="javascript:void(0)" id="" onclick="createUploadUI(\''+typeId+'\'),setTypeId(\''+typeId+'\',\''+txt(o)+'\'),setNodeId(\''+nodeId+'\')" class="list_left"><span class="list_right"><b class="list_ico">&nbsp;</b>上传文件</span></a>'+
	'</div>	';
	rightMenue("_treeRightMenu",str,x,y);
}
//关闭tree右键菜单
function closeTreeRihthMenu()
{
	_("_treeRightMenu").style.display="none";
}

//添加tree节点
function addTreeNode(i)
{
	var s=document.createElement("A");
	s.id="ss"+i;
	s.innerHTML="我是添加的节点";
	addClassName(s,"itm");
	getNextChild(_(i)).appendChild(s);
}

/**
 * @description		Grid操作
 */
//加载Grid
// function loadGrid()
// {
    // _("gridContainer").innerHTML = "";
    // pageInfo.count = 0;
	// var s='{"my_comm":"0","my_pageNum":"1"}';
	// var ajax = new AJAXRequest();
	// ajax.get("index.php/fileManageGrid/index/" + s, function (obj) {
	    // setData(obj.responseText);
	    // pageInfo.type = "";
	    // bindEventGrid();
	// });
// }
/*************************************************************
|
|	函数名:bindEventGrid
|	功能:给Grid绑定所需的事件
|	返回值:
|	参数:
|	函数关联:
|		-被调用:
|		-主动调用:
|	创建时间:2010年9月18日13:13:08
|	修改时间:
|
**************************************************************/
function bindEventGrid(ts)
{
	// ts=ts||getChildNodes(getChildNodes(_("fileListContainer"))[0],"tr","class=listContent");
	// //alert(getChildNodes(_("fileListContainer"))[0].tagName);
	// for(var i=0,n=ts.length; i<n; i++)
	// {
		// bindRightClick(ts[i],gridRowRightMenu);
		// bindLeftClick(ts[i],clickRowState);
		// bindMouseOver(ts[i],mouseOverRowState);
		// bindMouseOut(ts[i],mouseOutRowState);
	// }
}
/*************************************************************
|
|	函数名:clickRowState
|	功能:点击鼠标左键时   在Grid的Row上做相应的操作
|	返回值:
|	参数:
|	函数关联:
|		-被调用:
|		-主动调用:
|	创建时间:2010年9月18日13:14:48
|	修改时间:
|
**************************************************************/
function clickRowState(ev)
{
	var p=getMousePos(ev); //-->触发鼠标事件的位置
	var o=getEventObject(ev); //-->触发鼠标事件的对象
	while(o.nodeName.toLowerCase()!="tr")
	{
		o=getParentNode(o);
	}//---->获取到行对象

	//alert(p.x+"__"+p.y+" o:"+o.tagName);

	var f=getFirstChild(o); // 第一个子节点
	var f_checkBox=getFirstChild(f);//获取复选框

	//勾选或者撤销复选框---------------

	var c=getChildNodes(o);
	if(f_checkBox.checked)
	{
		f_checkBox.checked=false;
		for(var i=0,n=c.length; i<n; i++)
		{
			c[i].style.backgroundColor="";
		}
	}
	else
	{
		f_checkBox.checked=true;
		for(var i=0,n=c.length; i<n; i++)
		{
			c[i].style.backgroundColor="#FF9";
		}
	}


	//-------------------------------
	//alert(p.x+"\n"+p.y+"\n"+o.nodeName+"\n"+f.innerHTML);
}
/*************************************************************
|
|	函数名:gridRowRightMenu
|	功能:点击鼠标右键时   在Grid的Row上做相应的操作
|	返回值:
|	参数:
|	函数关联:
|		-被调用:
|		-主动调用:
|	创建时间:2010年9月18日13:14:48
|	修改时间:
|
**************************************************************/
function gridRowRightMenu(ev)
{
	var p=getMousePos(ev);
	var o=getEventObject(ev);
	while(o.nodeName.toLowerCase()!="tr")
	{
		o=getParentNode(o);
	}//---->获取到行对象

	//alert(p.x+"__"+p.y+" o:"+o.tagName);

	var f=getFirstChild(o); // 第一个子节点
	var f_checkBox=getFirstChild(f);//获取复选框
	gridRightMenu(p.x,p.y,getAttr(f_checkBox,"id"));
	//绑定隐藏事件
	bindLeftClick(document, gridRightMenuClose);
}
function gridRightMenu(x,y,id)
{
	var oid=id;
	id=id.split("_")[1];
	//<A onclick="createShengHeUI(\''+id+'\',\''+oid+'\')" href="JavaScript:void(0)">审 核</A>\
	var str=''+
	'<div style="display:block; ">'+
		'<A onclick="resources.deleteFile(\''+id+'\',\''+oid+'\')" href="JavaScript:void(0)">删 除</A>'+
	'</div>';
	rightMenue("_gridRightMenu",str,x,y);
}


//审核文件
function shenheFile()
{
	var info=_("shState").value.split(",");
	//获取审核信息
	var sat=radioGroupValue("sh").value;
	var sh_info=_("sh_OtherInfo").value;
	sh_info=sh_info.substring(0,100).replace(/\"/g,"”");

	var shResult=("{'info':'"+sh_info+"','id':'"+info[0]+"','state':'"+sat+"'}").replace(/\'/g,"\"");
	bug("开始传送审核信息--> ","文件ID: "+info[0]+" trID: "+info[1]+" 审核的状态: "+sat+" 审核信息: "+sh_info);
	bug("向服务器提交的信息--> ",shResult);
	var oid=info[1];
	var ajax = new AJAXRequest();
	ajax.get("index.php/fileManage/shenheFile/"+shResult, function(obj)
	{
		bug("服务器返回的信息--> ",obj.responseText,"green");

		//alert(obj.responseText);
		/*var st=obj.responseText;
		try{st=eval(st);}catch(e)
		{
			alert("审核失败!");
			return ;
		}
		if(st[0].length=1)
		{
			var tbody=getChildNodes(_("fileListContainer"))[0];
			var tr=_(oid)
			while(tr.nodeName.toLowerCase()!="tr")
			{
				tr=getParentNode(tr);
			}//---->获取到行对象
			rmChild(tbody,tr);
			alert("审核成功");
		}*/
	});
}

//创建审核UI
function createShengHeUI(id,oid)
{
	bug("创建见审核对话框","文件ID: "+id+" trID: "+oid);
	var t,l,w,h,str;
	h=document.documentElement.clientHeight;
	w=document.documentElement.clientWidth;
	h>200?t=(h-200)/2:"0";
	w>350?l=(w-350)/2:"0";
	str='<table style="vertical-align:top; font-size:14px; margin-top:25px;" align="center"><tr><td>状态:</td><td><label><input type="radio" name="sh" checked="checked" value="1" id="sh_0" />通过</label>&nbsp;&nbsp;<label><input type="radio" name="sh" value="0" id="sh_1" />驳回</label></td></tr><tr><td>备  注:</td><td><label><textarea name="sh_OtherInfo" style="width:100%; height:50px; border:1px solid #0C3;" id="sh_OtherInfo"></textarea></label></td></tr><tr><td colspan="2" align="center"><table align="center" border="0" cellspacing="0" cellpadding="0"><tr><td><a href="javascript:void(0)" id="shSubmit"  class="abtn_left"><span class="abtn_right">提  交</span></a></td></tr></table></td></tr></table><input name="shState" id="shState" value="'+id+','+oid+'" type="hidden" />';
	openWindow("shenhe","文件审核",l,t,"350px","200px",str);
	lockScreen(_("window_inner_shenhe").style.zIndex-1);
	bindLeftClick("window_closeButton_shenhe",closeShenHe);
	bindLeftClick("shSubmit",shenheFile);
}
function closeShenHe()
{
	document.body.removeChild(_("appWindow_shenhe"));
	unLockScreen();
}
//关闭tree右键菜单
function gridRightMenuClose()
{
	_("_gridRightMenu").style.display="none";
}

/**
 * @name		mouseOverRowState
 * @description	鼠标滑入tr时的操作   在Grid的Row上做相应的操作
 * @param		ev  event
 * @returns		void		
 * @author		BB
 * @version		2010.9.18
 */
function mouseOverRowState(ev)
{
	var o=getEventObject(ev); //-->触发鼠标事件的对象
	while(o.nodeName.toLowerCase()!="tr")
	{
		o=getParentNode(o);
	}//---->获取到行对象
	addClassName(o,"listContent_Over");
	o.style.color="#00f";
}

/**
 * @name		mouseOutRowState
 * @description	鼠标滑出tr时的操作   在Grid的Row上做相应的操作
 * @param		ev  事件
 * @return		
 * @author		BB
 * @version		2010.9.18
 */
function mouseOutRowState(ev)
{
	var o=getEventObject(ev); //-->触发鼠标事件的对象
	while(o.nodeName.toLowerCase()!="tr")
	{
		o=getParentNode(o);
	}//---->获取到行对象
	removeClassName(o,"listContent_Over");
	o.style.color="#000";
}

//文件预览
function view(tp,url,ev)
{
//alert(url);
	// if(tp!=6){
		_("flashIframe").src="index.php?control=viewFile&action=index&tp="+tp+"&url="+encodeURIComponent(url);
	// }else{
	// 	alert("this  is  a text");
	// }
	stopBubble(ev);
}
function review()
{
//alert(url);
	_("flashIframe").src="index.php?control=viewFile&action=index&tp=''&url=''";
}


/**
 * 
 * @description		文件上传
 */


function createUploadUI(type_ui_id)
{
	resources.fileInfo.files=[];
	resources.upload.fileNameList=[];
	var upload_ui=''+
        '<div id="divSWFUploadUI" class="divSWFUploadUI">'+
            '<div class="fieldset flashUpload" >'+
                '<span class="legend">文件队列</span>'+
                '<span id="divLoadingContent" class="loadInfo" style="display:none;" >上传组件正在加载中........  请稍候!</span>'+
                '<span id="divLongLoading" class="loadInfo" style="display:none;" >上传组件的花费很长的时间来加载或负载故障。请确保启用Adobe Flash Player 插件。<br />SWFUpload is taking a long time to load or the load has failed.  Please make sure that the Flash Plugin is enabled and that a working version of the Adobe Flash Player is installed.</span>'+
                '<span id="divAlternateContent" class="loadInfo" style="display:none;">我们很抱歉。 上传组件无法加载。您可能需要安装或升级Flash Player 。请点击<a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash">"这里"</a> 来获取flash插件.<br />We\'re sorry.  SWFUpload could not load.  You may need to install or upgrade Flash Player.Visit the <a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash">Adobe website</a> to get the Flash Player.</span>'+
                '<div style="display:block;" id="fsUploadProgress" class="fileLists"></div>'+
           ' </div>'+
            '<!--p id="divStatus"></p-->'+
            '<div>'+
                '<span id="spanButtonPlaceholder"></span>'+
                '<button id="btnUpload" class="bx-button"><span class="bx_bt_title">添加文件</span><span class="bx_r_bg"></span></button> '+
                '<button id="btn_uploadStart" class="bx-button"><span class="bx_bt_title">开始上传</span><span class="bx_r_bg"></span></button> '+
                '<button id="btnCancel" class="bx-button"><span class="bx_bt_title">取消所有</span><span class="bx_r_bg"></span></button> '+
				'<button id="btn_clearFileList" class="bx-button"><span class="bx_bt_title">清空队列</span><span class="bx_r_bg"></span></button> '+
				'<button id="btn_exitUpload" class="bx-button"><span class="bx_bt_title">退出上传</span><span class="bx_r_bg"></span></button> '+
            '</div>'+
            '<br style="clear: both;" />'+
        '</div>';
	tip.tip({
		id:"uploadFileUi",
		title:"文件上传",
		width:700,
		padding:"0px",
		message:upload_ui,
		close:function(){resources.resetUpInfo(); getOnePageInfo();}
	});
	tip.tipInfo.defaultState=false;
	var info = { typeSuffix: resources.updateInfo.typeSuffix.replace(/\./g,";*.").substring(1), typeDescription: resources.updateInfo.typeDescription, nodeId: resources.updateInfo.nodeId };
	setTimeout(function(){
	        uploadUI(info);
    	    $("#btn_exitUpload").click(resources.upload.exiteUpload);
    	    $("#btn_clearFileList").click(resources.upload.clearFileList);
	    },500);
}
function closeUploadWindow()
{
	art.dialog.list['uploadFileUi'].close();
	//document.body.removeChild(_("appWindow_uploadWindow"));
	//unLockScreen();
}

//保存文件类型ID
// 被 createRightMenu 调用
function setTypeId(id,t)
{
	bug("保存文件类型的ID--> ",id);

	resources.updateInfo.typeId=id.split("_")[1];
	//_("fileType").value=t;
}
//保存目录节点ID
// 被 createRightMenu 调用
function setNodeId(id)
{
	bug("保存目录节点ID--> ",id);
	resources.updateInfo.nodeId=id.split("_")[1];
}

//分页

function changPage(o)
{
	var firp=_("firPage"); //--> 第一页
	var prvp=_("prvPage"); //--> 上一页
	var nxtp=_("nxtPage"); //--> 下一页
	var finp=_("finPage"); //--> 最后一页
	switch(o)
	{
	    case firp:
	        pageInfo.curent = 0;
	        prvp.setAttribute("page", "-1");
	        nxtp.setAttribute("page", "1");
	        break;
		case prvp :
			prvp.setAttribute("page","-1");
			nxtp.setAttribute("page","1");
		break;
		case nxtp :
			prvp.setAttribute("page","-1");
			nxtp.setAttribute("page","1");
		break;

		case finp :
			prvp.setAttribute("page","-1");
			nxtp.setAttribute("page", "1");
			pageInfo.curent = att(finp,"page");;
		break;
	}

}

//分页
function pageAtion(o) {
    changPage(o);

    var _cunrent = pageInfo.curent + attr(o, 'page') * 1;
    if(_cunrent=="3000"){_cunrent=pageInfo.count;}
    if (_cunrent != 0 && _cunrent <= pageInfo.count) {
        pageInfo.curent = _cunrent;
        bug("page params info", print_r(pageInfo));
        getOnePageInfo();
    }
}


function getOnePageInfo() {
    $('#gridContainer').datagrid("reload");
}
//
function checkedItem(o,ev)
{
	if(o.checked)
	{o.checked=false;}
	else
	{o.checked=true;}
}

//获取以选择的文件的Id
function getCheckedFile()
{
	var trs=getChildNodes(getChildNodes(_("fileListContainer"))[0],"tr","class=listContent");
	var str=new Array(),o="";
	for(var i in trs)
	{
		o=getFirstChild(getFirstChild(trs[i]));
		//bug("getCheckedFile",o.tagName);
		if(o.checked)
		{
			str.push(o.value);
		}
	}
	if(str.length==0){return "";}
	//str=str.join(",");
	return str;
}



//get ftp server
function getFtpServer()
{

	art.dialog({
		id:"ftpServerUI",
		title:"文件上传",
		content: '加载中请稍候......',
		skin: 'chrome',
		lock:true});
	var ajax = new AJAXRequest();
	ajax.get("index.php?control=fileManage&action=getAllFtp", function(obj)
	{
		//alert(obj.responseText);
		//_("mainTree").innerHTML=obj.responseText;
		var ftpSerInfo=obj.responseText;
		if(ftpSerInfo!=""){ftpSerInfo=eval(obj.responseText);}else{alert("您未添加任何的FTP服务器!");}

		//alert(ftpSerInfo.length);

		var str='<table width="100%" height="200" border="0" cellspacing="0" cellpadding="0"><tr><td>FTP 服务器列表</td></tr> <tr><td height="200" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0" style="font-size:12px;"><tr>';
		for(var i=0,n=ftpSerInfo.length; i<n; i++)
		{
			if(i%3!=0||i==0)
			{
				str+='<td><label class="label"><input type="checkbox" name="ftpSerItm" value="'+ftpSerInfo[i].ip+'" ftpName="'+ftpSerInfo[i].nm+'" />'+ftpSerInfo[i].nm+'<i style="color:#ccc">(IP:'+ftpSerInfo[i].ip+')</i></label></td>'
			}
			else{str+='</tr><tr><td><label class="label"><input type="checkbox" name="ftpSerItm" value="'+ftpSerInfo[i].ip+'" ftpName="'+ftpSerInfo[i].nm+'" />'+ftpSerInfo[i].nm+'<i style="color:#ccc">(IP:'+ftpSerInfo[i].ip+')</i></label></td>';}
		}
    	//<td>&nbsp;</td>
		str+='</tr></table></td></tr><tr><td align="center"><table border="0" align="center" cellspacing="0" cellpadding="0"><tr><td><a href="javascript:void(0)" id="finPage" onclick="tbFTP()"  class="abtn_left"><span class="abtn_right">开始同步</span></a></td></tr></table></td></tr></table>';
		art.dialog.list['ftpServerUI'].content(str);
		art.dialog.list['ftpServerUI'].position();
	});
}
//---
// FTP服务器
function getCheckedFtpSer()
{
	var ftps=_name("ftpSerItm");
	var str=new Array(),o="";
	for(var i in ftps)
	{
		o=ftps[i];
		//bug("getCheckedFile",o.tagName);
		if(o.checked)
		{
			bug(o.value,att(o,"ftpName"));
			str.push([o.value,att(o,"ftpName")]);
		}
	}

	if(str.length==0){return "";}
	str=convertToJson(str);
	str="["+str.substring(1,str.length-1)+"]";
	return str;
}
//----
// 检测是否选中的文件
function checkFtpSerAndFile()
{
	var str=getCheckedFile();
	if(str.length==0){alert("您没有选择任何文件!");return false;}
	getFtpServer();
}
//同步FTP  Ftp server 选择界面
function tbFTP()
{
	var str=getCheckedFile();
	var ftpstr=getCheckedFtpSer();
	if(str.length==0){alert("请选择您要发送的FTP服务器!");return false;}
	bug("tbFTP",str);
	bug("ftpstr",ftpstr);
	var itmStr="";
	var cs="";
	for(var i=0, n=str.length; i<n; i++)
	{
		//alert(i%2);
		cs=i%2==0?" background-color:#eee;":" background-color:#fff;";
		itmStr+='<div style="display:block; width:100%; height:100%; overflow:hidden; margin-bottom:2px; '+cs+'"><i class="fl_state">等待中</i><strong class="fl_nm">'+html(_("f_name_"+str[i]))+'</strong><i><a  title="取消当前文件的发送......" href="javascript:void(0)" id="finPage" onclick="delFtpFile()"  class="sbtn_left"><span class="sbtn_right">ⅹ</span></a></i></div>';

	}
	itmStr+='<div style="display:block; text-align:center; width:100%; height:100%; overflow:hidden; margin-top:2px; "><a href="javascript:void(0)" id="finPage" onclick="startTbFtp()"  class="abtn_left"><span class="abtn_right">开始同步</span></a></div>';
	art.dialog.list['ftpServerUI'].content(itmStr);
	art.dialog.list['ftpServerUI'].position();
}

function startTbFtp()
{
	setTimeout(art.dialog.list['ftpServerUI'].content('同步完成...'),3000);
	}


	function selectFileList()
   {
	//重置预览窗口
	review();
	var filename = document.getElementById('txt_FileName').value;
	var sfilesize = document.getElementById('txt_sFileSize').value;
	var efilesize = document.getElementById('txt_eFileSize').value;
	var filenotes = document.getElementById('txt_FileNotes').value;
	pageInfo.count = 0;
	//var s = '{"my_comm"="0","pageCount":"' + pageInfo.count + '","my_pageNum":"' + pageInfo.curent + '","FileType":"' + pageInfo.type + '","filename":"' + filename + '","sfilesize":"' + sfilesize + '","efilesize":"' + efilesize + '","filenotes":"' + filenotes + '"}';
	//--重置分页条件
    var s = "my_comm=0&pageCount=" + pageInfo.count + "&my_pageNum="+ pageInfo.curent + "&FileType=" + pageInfo.type + "&filename=" + filename + "&sfilesize=" + sfilesize + "&efilesize=" + efilesize + "&filenotes=" + filenotes;
	bug("分类获取文件的参数: ",s);
	var ajax = new AJAXRequest();
	ajax.post("index.php?control=fileManageGrid&action=selectFilelist",s, function (obj) {
	    setData(obj.responseText);
	    bindEventGrid();
	});
}

var resources={
		fileInfo:{files:[]},
		updateInfo:{typeUiId:"all",nodeId:"all",typeSuffix:"",typeName:"",typeDescription:"",typeId:""},
		resetUpInfo:function(){
				resources.fileInfo.files=[];
				resources.upload.fileNameList=[];
				resources.updateInfo.typeUiId="all";
				resources.updateInfo.typeId="";
				resources.updateInfo.nodeId="all";
				resources.updateInfo.typeName="";
			},
		setUpFileType:function(typeUiId,nodeId){

				if(typeUiId=="all")
				{
				    resources.updateInfo.typeUiId = "all";
				    resources.updateInfo.nodeId = "all";
					return ;
				}
				resources.updateInfo.typeUiId=typeUiId;
				resources.updateInfo.typeId=typeUiId.split("_")[1];
				resources.updateInfo.nodeId=nodeId.split("_")[1];
				resources.updateInfo.typeName = resources.updateInfo.typeDescription = txt(nodeId).replace(/[ \-]/ig,"");
				resources.updateInfo.typeSuffix = attr(_(nodeId), "suffix");
			},
		updateReady:function(){
				createUploadUI(resources.updateInfo.typeUiId);
				setTypeId(resources.updateInfo.typeUiId,resources.updateInfo.typeName);
				setNodeId(resources.updateInfo.nodeId);
			},
		/*createTypeSelect:function(){
				art.dialog({
				id:"file_type_select",
				padding:5,
				title:"文件类型选择",
				content: '<table width="600" border="0" cellspacing="0" style="font-size:12px;" cellpadding="2">\
						  <tr>\
							<td><label><input type="radio" name="fileTypeRadios" value="1" id="fileTypeRadios_0" checked />视频</label></td>\
							<td><label><input type="radio" name="fileTypeRadios" value="2" id="fileTypeRadios_1" />音频</label></td>\
							<td><label><input type="radio" name="fileTypeRadios" value="3" id="fileTypeRadios_2" />图片</label></td>\
							<td><label><input type="radio" name="fileTypeRadios" value="4" id="fileTypeRadios_3" />动画</label></td>\
							<td><label><input type="radio" name="fileTypeRadios" value="5" id="fileTypeRadios_4" />超文本</label></td>\
							<td><label><input type="radio" name="fileTypeRadios" value="6" id="fileTypeRadios_5" />TXT文本</label></td>\
							<td><label><input type="radio" name="fileTypeRadios" value="7" id="fileTypeRadios_6" />升级包</label></td>\
						  </tr>\
						</table>',
				skin: 'chrome',
				ok:function(){
						var tp_id=radioGroupValue("fileTypeRadios").value;
						resources.setUpFileType("tre_"+tp_id,"tre_"+tp_id);
						resources.update();

					},
				cancel:function(){},
				lock:true});
			},*/
		update:function(){
				/*if(resources.updateInfo.typeUiId=="all")
				{
					resources.createTypeSelect();
				}
				else
				{*/
					resources.updateReady();
				//}
			},

		/**
		 * 
		 * @name		getCheckedFile
		 * @description	获取选中的文件id 在Grid的Row上做相应的操作
		 * @return		
		 * @author		BB
		 * @version		2012.7.27
		 */
		getCheckedFile:function (){
			var objchecked=[];
			var input_checkbox = _name("lisContent_item_input");
			for(var i=0, n=input_checkbox.length; i<n; i++)
			{
				if(input_checkbox[i].checked)
				{
					objchecked[objchecked.length]=input_checkbox[i].id;
				}
			}
			if(objchecked.length>0){
					return  objchecked;
			}else {
					return  false;
			}	
			return false;
		},

		/**
		 * @name deleteFileInfo
		 * @author BB
		 * @description 删除选中的文件
		 * @return void
		 * @version 2013.2.28 modify by kycool
		 */
		deleteFileInfo:function (){
    			var id=resources.getCheckedFile();
    			if(!id){
    					alert("亲爱的用户：请选中要删除的文件");
    					return;
    			}
    			var iddelete=[],iddeltetype=[];
    			for(var i=0,n=id.length;i<n;i++){
    				if(typeof(id[i])=="string"){
    					iddeltetype[iddeltetype.length]=id[i];
    					iddelete[iddelete.length]=id[i].split("_")[1];
    				}
    			}
    			var iddeletestring=iddelete.join(",");//删除文件的id组成的字符串
    			resources.deleteFile(iddeletestring,iddeltetype);
				//window.document.location.reload();
				//loadGrid();
		},	

		verify:function(){
    			var id=resources.getCheckedFile();
    			if(!id){
    					alert("亲爱的用户：请选中要审核的文件");
    					return;
    			}
    			var iddelete=[];//iddeltetype=[];
    			for(var i=0,n=id.length;i<n;i++){
    				if(typeof(id[i])=="string"){
    					//iddeltetype[iddeltetype.length]=id[i];
    					iddelete[iddelete.length]=id[i].split("_")[1];
    				}
    			}
    			var iddeletestring=iddelete.join(",");//删除文件的id组成的字符串
    			resources.verifyFile(iddeletestring);
		},	

		verifyFile:function(id){
			tip.tip({message:"文件审核中，请稍后.....",stateClose:false,id:"kverify"});
			$.get("index.php?contol=fileManage&action=verifyFile&id="+id,function(data){
				loadGrid();
				tip.change("审核文件成功","kverify");
				setTimeout(function(){tip.tipClose("kverify");},1000);
			});
		},

		deleteFile:function(id,oid){
			tip.tip({message:"文件删除中,请稍候.....",stateClose:false});
			
			$.get("index.php?control=fileManage&action=deleteFile&id="+id, function(data)
			{
				bug("文件删除服务器返回的消息",data,"green");
				var st=data;
				try{st=eval("("+st+")");}
				catch(e)
				{
					tip.change("删除失败<br>"+obj.responseText);
					tip.tipInfo.defaultState=true;
					return ;
				}
				if(st["state"]=="true")
				{
					var str_unused="";
					if(st["data"].hasOwnProperty("unused"))
					{
						var array_unused=st["data"]["unused"];
						for(var i=0,n=array_unused.length; i<n; i++)
						{
							str_unused+=array_unused[i]["fileName"]+" "+(array_unused[i]["state"]=="true"?"成功.\n":"失败("+array_unused[i]["info"]+").\n");
						}
						var tbody=getChildNodes(_("fileListContainer"))[0];
						for(var oidstring in oid){
							var tr=_(oid[oidstring]);
							while(tr.nodeName.toLowerCase()!="tr")
							{
								tr=getParentNode(tr);
							}//---->获取到行对象
							rmChild(tbody,tr);
						}
					}
					var str_used="";
					if(st["data"].hasOwnProperty("used"))
					{
						var array_used=st["data"]["used"];
						for(var i=0,n=array_used.length; i<n; i++)
						{
							str_used+=array_used[i]["fileName"]+" 被使用.<br />";
						}
					}

					tip.change(st["message"]+"\n"+str_unused + str_used);
					tip.tipInfo.defaultState=true;
				}
				loadGrid();
				//kycool add 在删除成功后提示自动消失
				setTimeout(function(){tip.tipClose();},2000);
			});
		},
		updateFileInfo:function(){
			var file_info=resources.fileInfo.files;
			if(file_info.length<=0){return ;}
			tip.tip({id:"save_file_info",message:"文件信息保存中,请稍等!",stateClose:false});
			$.ajax({
				type:"POST",
				url:"index.php?control=c_fileManage&action=updateFileInfo",
				data:{data:file_info},
				success: function(data){resources.saveSucess(data);},
				timeout: function(){},
				error: function(){}
				});

		},
		saveSucess:function(info){
			resources.fileInfo.files=[];
			info=$.parseJSON(info);
			if(typeof(info)=="object")
			{
				getOnePageInfo();
				tip.tipInfo.defaultState=true;
				closeUploadWindow();
				if(typeof(info.data)=="string")
				{
					tip.change(info.data,"save_file_info");
					//tip.tipTime(1,"save_file_info");
				}
				var mes="";
				for(var i=0,n=info.data.length; i<n; i++)
				{
					if(info.data[i].state)
					{
						mes+=info.data[i].fileName +" 成功!<br />";
					}
					else
					{
						mes+=info.data[i].fileName +" 失败!<br />";
					}
				}
				tip.change("备注保存状态如下:<br />"+mes,"save_file_info");
				tip.tipTime(1,"save_file_info");
			}
			else
			{
				tip.change("备注保存失败,"+info.data+",但是不影响文件的使用!","save_file_info");
			}
		},
		checkAllFile:function(){
			var input_checkbox = _name("lisContent_item_input");
			for(var i=0, n=input_checkbox.length; i<n; i++)
			{
				if(input_checkbox[i].checked)
				{
					input_checkbox[i].checked=false;
				}
				else
				{
					input_checkbox[i].checked=true;
				}
			}
		}
	};
resources.upload={

	fileNameList:[],
	start_upload:function(){
		swfu.startUpload();
		resources.upload.uploadBtnShow(false);
	},
	delFileCache:function(fileName){
		for(var i = 0,n = resources.upload.fileNameList.length; i<n; i++)
		{
			//resources.upload.checkName(resources.upload.fileNameList[i]);
			if(resources.upload.fileNameList[i]["name"]==fileName)
			{
				resources.upload.fileNameList.splice(i,1);
			}
		}
	},
	formatBytes:function(size) { 
		var units = ['B', 'KB', 'MB', 'GB', 'TB']; 
		for (var i = 0; size >= 1024 && i < 4; i++) {size /= 1024; }
		return size.toFixed(2)+"."+units[i]; 
	},
	queueUploadSucess:function(numFilesUploaded){
		//直接在服务器保存文件，不在从这里保存
		//resources.updateFileInfo();
		resources.upload.fileNameList=[];
		tip.tipInfo.defaultState=true;//开启可关闭上传界面的锁定
		setTimeout(function(){
			var adupload = art.dialog.list['uploadFileUi'];
			if (adupload) adupload.close();
		},3000);
	},
	uploadSucessEveryOne:function(serverInfo,fileInfo){
		bug("服务器返回的消息:",serverInfo);

		s=eval("("+serverInfo+")");
		if(s.state)
		{
			bug("---",print_r(s));
			//如果为true表示需要创建预览文件，这里主要处理视频文件
			if(s.data.createViewFile_key){
			//	resources.upload.createViewFile(s.data.fileName,s.data.fileMd5);
			}
			
			return  ;
			//文件大小
			//_("fileSize").value=s.fileSize;
			var fileSharing=radioGroupValue("Sharing").value;
			var info={
					fileSharing:fileSharing,
					fileOtherInfo:_("file_OtherInfo").value,
					fileId:s.data.insertId,
					fileName:s.data.fileName
					};
			resources.fileInfo.files.push(info);
			
		}
		else
		{
			//tip.tip({id:"upload_file_info",message:s.data,stateClose:true});

				var flist=resources.upload.fileNameList;

					for(var a=0,b=flist.length; a<b; a++)
					{
						if(resources.upload.fomartFileName(fileInfo.name)==flist[a]["name"])
						{
							_(flist[a].stateId).innerHTML="<span style='color:red; font-weight:bold;'>"+s.data+"</span>";
							_(flist[a].cancelId).style.display="none";
						}
					}
			bug("服务器未返回正确的消息:",print_r(s),"red");
		}
	}
/*,
	createViewFile:function(name,Md5){
		alert(name+" \n "+Md5);
		$.ajax({
			type:"POST",
			url:"createFileView.php",
			data:{data:{fileName:name,Md5:Md5}},
			success:function(){
				alert("file_Name: "+name+"\nfileMd5:"+Md5);
			},
			error:function(){
				
			}
		});
	}*/,
	setFileList:function(info){
		resources.upload.fileNameList.push(info);
	},
	checkFileNameByList:function(){
		if(resources.upload.fileNameList.lenght==0){return false;}
		var name="",nameArray=[];
		for(var i = 0,n = resources.upload.fileNameList.length; i<n; i++)
		{
			//resources.upload.checkName(resources.upload.fileNameList[i]);
			nameArray.push("'"+resources.upload.fileNameList[i]["name"]+"'");
		}
		name=nameArray.join(",");
		resources.upload.checkName(name);
		//resources.upload.fileNameList=[];
	},
	fomartFileName:function(fileName){
		
		var str_fName=fileName.replace(/[^\u4e00-\u9fa5A-Za-z0-9_\.\-]/g,"");
		bug("fomartFileName :","fileName:"+fileName+" newName:"+str_fName);
		return str_fName;
	},
	checkName:function(name){
		bug("检查文件名称","文件名: "+name);
		$.ajax({
			type:"POST",
			url:"index.php?control=c_fileManage&action=checkFileName",
			data:{data:{fileName:name}},
			success: function(data){
				bug("服务器返回的信息:",data,"green");
				var res=eval("("+data+")");
				if(res.state)
				{
					//_(info.id).innerHTML="文件已存在";
					res=res.data;
					var flist=resources.upload.fileNameList;
					for(var i=0,n=res.length; i<n; i++)
					{
						for(var a=0,b=flist.length; a<b; a++)
						{
							if(res[i]["FileName"]==flist[a]["name"])
							{
								resources.upload.cancleUploadFile(flist[a]);
							}
						}
	
					}
				}
			},
			error: function(data){}
			});
		
	},
	cancleUploadFile:function(info){
		_(info.stateId).innerHTML="取消";
		swfu.cancelUpload(info.fileId,false);
		_(info.stateId).innerHTML="<span style='color:red; font-weight:bold;'>文件已经有用户上传</span>";
		_(info.cancelId).style.display="none";
	},
	exiteUpload:function(){
	    swfu.cancelQueue();
	    tip.tipInfo.defaultState=true;//开启可关闭上传界面的锁定
        art.dialog.list['uploadFileUi'].close();
	},
	clearFileList:function(){
		swfu.cancelQueue();
		resources.upload.fileNameList=[];
		setTimeout(function (){_("fsUploadProgress").innerHTML="";},500);
		
	},
	tipEveryUpload:function(file){
		var flist=resources.upload.fileNameList;
		for(var a=0,b=flist.length; a<b; a++)
		{
			if(resources.upload.fomartFileName(file.name)==flist[a]["name"])
			{
				_(flist[a].stateId).innerHTML="文件处理中";
				_(flist[a].cancelId).style.display="none";
				break;
			}
		}
	},
	//selectFileBtnShow:function(state){
//		var swf_=getFirstChild("broswerButtonContainer");
//		if(!state){
//			with(swf_.style)
//			{
//				width="1px";
//				height="1px";
//			}
//		}
//		else
//		{
//			with(swf_.style)
//			{
//				width="61px";
//				height="22px";
//			}
//		}
//	},
	uploadBtnShow:function(state){
		_("strat_up_btn").disabled=state;
	}
};



$(document).ready(function(e) {
    $("#upload_bt").click(resources.update);
	$("#tre_all").click(function(){resources.setUpFileType("all","");});
	$("#delete_btn").click(function(){
	      art.dialog.confirm('你确定要删除选中的文件吗？', function () {
                resources.deleteFileInfo();
            }, function () {
                art.dialog.tips('您取消了删除操作!');
            }); 
	       
	});
	$("#verify").click(function(){
		art.dialog.confirm("您确定进行文件审核吗？",function(){
				resources.verify();
		},function(){
				art.dialog.tips('您取消了审核操作');
		});
	});

	$("reverify").click();
	
});
