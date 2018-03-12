// JavaScript Document
// 设置对话框全局默认配置
(function(){
    var d = art.dialog.defaults;
    d.skin = ['default', 'chrome', 'facebook', 'aero'];
    d.drag = true;
    d.showTemp = 100000;
})();
var pageInfo1 = { curent: 1, pageSize: 20, count: 0, type: "" ,container:'yiWancheng' , src:"index.php/remind/getHistoryRemind/"};
var pageInfo2 = { curent: 1, pageSize: 20, count: 0, type: "" ,container:'daiDanShi' ,src:"index.php/remind/loadUserRemindInfo/"};
function setData(str,c,pageInfo) {
    bug("服务器返回的文件列表", str, "green");
    c.innerHTML = "";
    str = str.split("__@__");
    c.innerHTML = str[0];
    pageInfo.count = str[1];
    pageInfo.curent = 1;
	pageInfo.pageSize = str[2];
	//print_r(pageInfo);
}
function setPageData(str,c,pageInfo) {
    bug("服务器返回的文件列表", str, "green");
    c.innerHTML = "";
    str = str.split("__@__");
    c.innerHTML = str[0];
    pageInfo.count = str[1];
	pageInfo.pageSize = str[2];
}
//查看审批的信息 对话框
// 2010年11月28日14:02:24 by 莫波
function viewNodeInfo(listId)
{
	art.dialog({
		title:'播放计划查看',
		id:'viewNodeInfoUi',
		skin: 'chrome',
		lock:true,
		content: '信息加载中....'
	});

	var ajax = new AJAXRequest();
		ajax.timeout=300000;
		ajax.ontimeout=function(e) 
		{
			art.dialog({
				skin: 'chrome',
			id: 'timeOutUi',
			content: '你指定的信息,加载失败!<br>请求超时......'});
			art.dialog.get('viewNodeInfoUi').close();
		}
		
		ajax.onexception=function(e) 
		{
			art.dialog({
				skin: 'chrome',
			id: 'serverError',
			content: '无法加载您需要的信息!'});
			art.dialog.get('viewNodeInfoUi').close();
		}
		ajax.post("index.php?control=playlist&action=getOneOfPlayList", 
		"listId="+listId,
		function(obj)
		{
			var st=obj.responseText;
			bug("服务器返回的播放计划的详细信息",st,"green");
			var state=st.split("__bx__");
			if(state[0]=="Excel")
			{viewInfoFromExcel(state[1]);}
			else if(state[0]=="DataBase")
			{ viewNodeInfoTreatment(state[1]);}
			else if(state[0]=="Error")
			{ alert(state[1]);}
		});

}

//dsy/查看审批的信息 对话框
function viewNodeInfodsy(s,t,r,v,g,u)
{
	art.dialog({
		title:'播放计划查看',
		id:'viewNodeInfoUi',
		skin: 'chrome',
		lock:true,
		content: '信息加载中....'
	});

	var ajax = new AJAXRequest();
		ajax.timeout=300000;
		ajax.ontimeout=function(e) 
		{
			art.dialog({
				skin: 'chrome',
			id: 'timeOutUi',
			content: '你指定的信息,加载失败!<br>请求超时......'});
			art.dialog.get('viewNodeInfoUi').close();
		}
		
		ajax.onexception=function(e) 
		{
			art.dialog({
				skin: 'chrome',
			id: 'serverError',
			content: '无法加载您需要的信息!'});
			art.dialog.get('viewNodeInfoUi').close();
		}
		ajax.get('index.php/playlist/getAllFile/'+s+'/'+t+'/'+r+'/'+v+'/'+g+'/'+u+'',
		function(obj)
		{
			var st=obj.responseText;
			bug("服务器返回的播放计划的详细信息",st,"green");
			var state=st.split("__bx__");
			if(state[0]=="Excel")
			{viewInfoFromExcel(state[1]);}
			else if(state[0]=="File")
			{ viewInfoFromFile(state[1]);}
			else if(state[0]=="Error")
			{ alert(state[1]);}
		});
}
//处理 服务器返回的播放计划的详细信息 
// 2010年11月28日14:09:38 by 莫波
function viewNodeInfoTreatment(st)
{
	//alert(st);
	var info=eval(st);
	var tb='<table width="100%" border="0" cellspacing="0" cellpadding="0">\
				<tr><td>播放计划信息</td></tr>\
				<tr>\
					<td>表名称:'+info[0]+' 表类型:'+info[1]+' 所属部门:'+info[2]+' 创建人:'+info[4]+' </td>\
				</tr>\
				<tr><td>节目单信息</td></tr>\
				<tr>\
					<td>\
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fileListContainer" id="plistInfoTable">\
							<tr class="titleContainer">\
								<td class="title_item wh"><!--input type="checkbox" id="name1" name="titleConter_input" value="1" fileName="" /--><label for="name1">编号</label></td>\
								<td class="title_item wm" >节目单名称</td>\
								<td class="title_item " >开始时间</td>\
								<td class="title_item " >结束时间</td>\
								<td class="title_item" >创建人员</td>\
								<td class="title_item" >所属部门</td>\
								<td class="title_item final_item" >处理</td>\
							</tr>';
							var pinfo=info[5];
							for(var i=0,n=pinfo.length; i<n; i++)
							{
							//	alert(n+"魔波");
								tb+='<tr class="listContent" id="profile_"'+i+'>';
									for(var a=0,b=pinfo[i].length; a<b; a++)
									{
									//	alert(b+"觉得是开放");
									//	a!=4?tb+='<td class="lisContent_item" >'+pinfo[i][a]+'</td>':'';
										if(a!=4 & a!=7){//第6和的7位的数据不用显示
											tb+='<td class="lisContent_item" >'+pinfo[i][a]+'</td>'
										}else{
											tb+='';
										}
									
										if(a==b-1)
										{tb+='<td class="lisContent_item final_item" ><a href="javascript:void(0);" onclick="viewNodeInfodsy(\''+info[0]+'\',\''+pinfo[i][2]+'\',\''+pinfo[i][3]+'\',\''+pinfo[i][7]+'\',\''+pinfo[i][0]+'\',\''+pinfo[i][1]+'\')">查看</a></td>';}
									}
								tb+='</tr>';
							}
						tb+='</table>\
					</td>\
				</tr>\
			</table>';
	with(art.dialog.get("viewNodeInfoUi"))
	{
		content(tb); //赋值对话框
		position();  //居中
	}
}

//处理 服务器返回的播放计划的详细信息
//
function viewInfoFromExcel(st)
{
	var info=eval(st);
	var tb='<table width="100%" border="0" cellspacing="0" cellpadding="0">\
				<tr><td></td></tr>\
				<tr>\
					<td>导入文件名称:'+info[0]+' 表类型:'+info[1]+' 所属部门:'+info[2]+' 创建人:'+info[4]+' </td>\
				</tr>\
				<tr><td>上传文件信息</td></tr>\
				<tr>\
					<td>\
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fileListContainer" id="plistInfoTable">\
							<tr class="titleContainer">\
								<td class="title_item wh"><!--input type="checkbox" id="name1" name="titleConter_input" value="1" fileName="" /--><label for="name1">编号</label></td>\
								<td class="title_item " >文件名称</td>\
								<td class="title_item " >开始时间</td>\
								<td class="title_item " >结束时间</td>\
								<td class="title_item " >分辨率</td>\
								<td class="title_item" >文件类型</td>\
								<td class="title_item final_item" >处理</td>\
							</tr>';
							var pinfo=info[5];
							for(var i=0,n=pinfo.length; i<n; i++)
							{	
								//alert(n);
								tb+='<tr class="listContent" id="profile_"'+i+'>';
									for(var a=0,b=pinfo[i].length; a<b; a++)
									{
										//alert(b);
									//	a!=6 ?tb+='<td class="lisContent_item" >'+pinfo[i][a]+'</td>':'';
										if(a!=6 & a!=2){//第6和的7位的数据不用显示
											tb+='<td class="lisContent_item" >'+pinfo[i][a]+'</td>'
										}else{
											tb+='';
										}
										
										if(a==b-1)
										{tb+='<td class="lisContent_item final_item" ><a href="javascript:void(0);" onclick="viewFile(\''+pinfo[i][2]+'\',\''+pinfo[i][6]+'\')">预览</a></td>';}
									}
								tb+='</tr>';
							}
							
						tb+='</table>\
					</td>\
				</tr>\
			</table>';
	with(art.dialog.get("viewNodeInfoUi"))
	{
		content(tb); //赋值对话框
		position();  //居中
	}
}
//dsy获得媒体文件
function viewInfoFromFile(st)
{
//alert(st);
	var info=eval(st);
	var tb='<table width="100%" border="0" cellspacing="0" cellpadding="0">\
				<tr><td></td></tr>\
				<tr>\
					<td>播放单元名称:'+info[0]+' 表类型:'+info[1]+' 所属部门:'+info[2]+' 创建人:'+info[4]+' </td>\
				</tr>\
				<tr><td>播放单元文件信息</td></tr>\
				<tr>\
					<td>\
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fileListContainer" id="plistInfoTable">\
							<tr class="titleContainer">\
								<td class="title_item wh"><!--input type="checkbox" id="name1" name="titleConter_input" value="1" fileName="" /--><label for="name1">编号</label></td>\
								<td class="title_item wm" >文件名称</td>\
								<td class="title_item " >开始时间</td>\
								<td class="title_item " >结束时间</td>\
								<td class="title_item " >文件大小</td>\
								<td class="title_item " >文件类型</td>\
								<td class="title_item final_item" >处理</td>\
							</tr>';
							var pinfo=info[5];
							for(var i=0,n=pinfo.length; i<n; i++)
							{	
								//alert(n);
								tb+='<tr class="listContent" id="profile_"'+i+'>';
									for(var a=0,b=pinfo[i].length; a<b; a++)
									{
										//alert(b);
									//	a!=6 ?tb+='<td class="lisContent_item" >'+pinfo[i][a]+'</td>':'';
										if(a!=6 & a!=7){//第6和的7位的数据不用显示文件类型和路径
											tb+='<td class="lisContent_item" >'+pinfo[i][a]+'</td>'
										}else{
											tb+='';
										}
										//文件的大小
										if(pinfo[i][4]=="0KB"){
											pinfo[i][4]="1KB";
										}
										
										if(a==b-1)
										{tb+='<td class="lisContent_item final_item" ><a href="javascript:void(0);" onclick="viewFile(\''+pinfo[i][6]+'\',\''+pinfo[i][7]+'\')">预览</a></td>';}
									}
								tb+='</tr>';
							}
							
						tb+='</table>\
					</td>\
				</tr>\
			</table>';
	with(art.dialog.get("viewNodeInfoUi"))
	{
		content(tb); //赋值对话框
		position();  //居中
	}
}
//预览Profile
//预览Profile
function viewProfie(Path)
{
	var w=width(document),
	h=height(document);
	var path="FileLib/"+Path+"/"+Path+"_view.html";
	art.dialog({
		title:"播放单元预览",
		id:'viewPro',
	//width:w,
	//height:h,
    content: '信息加载中',
    skin: 'chrome',
	lock:true
	});
	
	setTimeout(function(){with(art.dialog.get("viewPro"))
	{
		content('<iframe id="view_prof" style="display:block; margin:0px; padding:0px; width:'+(w-30)+'px; height:'+(h-55)+'px;"  src="'+path+'" frameborder="0" allowtransparency="true"  onload="resizeViewPro(this.id)"></iframe>');
		}},500)
}

function resizeViewPro(o)
{
		var p=getIframe_WH(o);
		//alert(p.w+"----"+h)
		_(o).style.width=p.w+"px";
		_(o).style.height=p.h+"px";
		art.dialog.get("viewPro").size(p.w,parseInt(p.h)+10);
		setTimeout(function(){
			art.dialog.get("viewPro").position();
		},500);
		
}
function getIframe_WH(iframeObj)
{ 
	var _w=0,_h=0;
	 var iframeHeight=0;  
            if (navigator.userAgent.indexOf("Firefox")>0) { // Mozilla, Safari, ...
				_w=(_(iframeObj).contentDocument.body.style.width).replace("px","");
				_h=(_(iframeObj).contentDocument.body.style.height).replace("px","");  
            } else if (navigator.userAgent.indexOf("MSIE")>0) { // IE  记  
				_w=((document.frames[iframeObj].document.getElementsByTagName("body")[0]).style.width).replace("px",""); 
				_h=((document.frames[iframeObj].document.getElementsByTagName("body")[0]).style.height).replace("px",""); 
            }  
	return {w:_w,h:_h}
} 
//预览文件
function viewFile(t,s)
{
	art.dialog({
		id:'viewFileWin',
    content: '信息加载中.....',
    skin: 'chrome',
	lock:true});
	setTimeout(function(){
		art.dialog.get("viewFileWin").content('<iframe style="display:block; width:255px; height:175px; overflow:hidden"  src="index.php/viewFile/index/'+t+'/'+s+'" frameborder="0" allowtransparency="true"></iframe>');
		art.dialog.get("viewFileWin").position();
		},1000);
}



function fangXing(id,o)
{
	//alert("in fangxing !");
	var _o=o;
	while(o.nodeName.toLowerCase()!="tr")
	{
		o=getParentNode(o);
	}//---->获取到行对象
	bug("向服务器提交信息:",id);

	var ajax = new AJAXRequest();
	ajax.get("index.php/remind/getUpUsers/",
	function(obj)
	{
		//alert("in ajax");
		bug("服务器返回信息:",obj.responseText,"green");
		var st=obj.responseText;
		//alert(st);
                //alert(st.indexOf("shengpi"));
		if(st.indexOf("shengpi")==0)
		{   
			
			if(st.indexOf("shengpi__#@#__[]")==0){
				viewRemindInfo(_o,o,id,"fangxing");			
				return;
			}
			else{
			       if(st.split("__#@#__")[1]=="over")
					{
					viewRemindInfo(_o,o,id,"fangxing");		//函数		
					 return;
					   }
					 else
					  {
					  shengpiUI(st.split("__#@#__")[1],_o,o,id);
					  }
			}
		}
	});
}
function shengpiUI(str,_o,o,id)
{
	var rs=eval(str);
	var listId=att(_o,"listId");
	var direction=att(_o,"direction");
	var showUrl=att(_o,"showUrl");
	var tr=getChildNodes(o);
	var tl=txt(tr[1]);
	var con=txt(tr[3]);
	bug("消息信息","消息名称: "+tl+"<br> 消息内容: "+con);
	var ui='<div style="dispaly:block; width:620px;"  id="shenPiTongYiTb"><table width="600" border="0" id="shenPiTb" class="sp_table"><tr><td colspan="3" align="left">审批收信人: </td></tr><tr style="font-size:12px;">';
	for(var i=0,n=rs.length; i<n; i++)
	{		
		if(i==0)
		{			
			ui+='<td><label><input name="shengpi_ui" type="radio" checked  value="'+rs[i].UserID+'" />'+rs[i].UserName+'</label></td>';			
		}
		else{
			if(rs[i].IsCheck == 1){
				ui+='<td><label><input name="shengpi_ui" type="radio" checked value="'+rs[i].UserID+'" />'+rs[i].UserName+'</label></td>';
			}else{
				ui+='<td><label><input name="shengpi_ui" type="radio" value="'+rs[i].UserID+'" />'+rs[i].UserName+'</label></td>';
			}
		}
		if((i+1)%3==0)
		{
			ui+='</tr><tr>';
		}

	}
	ui+='</tr><tr><td colspan="3" align="left">审批标题: <input type="hidden" value="'+tl+'" maxlength="24" id="sp_title" /><span class="sp_title" >'+tl+'</span></td></tr><tr><td colspan="3" align="left">审批历史:'+getsp_hcontent(listId,'shengPiTongYi')+'</td></tr><tr><td colspan="3" id="sp_hcontent"></td></tr></table></div>';
	
	str='<table style="vertical-align:top; font-size:14px; width:100%" align="center"><tr><td id="shengpi_user">'+ui+'</td></tr><tr><td align="left">审批内容:</td></tr><tr><td colspan="3" align="left"><textarea id="sp_content" style="width:100%; height:80px; border:1px; border:1px #ccc solid;"></textarea></td></tr><tr><td  align="center"><table align="center" border="0" cellspacing="0" cellpadding="0"><tr><td><a href="javascript:submitShengpiInfo(\''+listId+'__#@#__'+direction+'__#@#__'+id+'__#@#__'+showUrl+'\')" id="shSubmit"   class="abtn_left"><span class="abtn_right">提  交</span></a></td></tr></table></td></tr></table>';
	bug("审批UI","<textarea style='width:100%; height:100px;'>"+str.replace(/textarea/g,"txtarea")+"</textarea>");
	
	art.dialog({
		id:'shengPiTongYi',
		width:620,
    content: "信息加载中......",
    skin: 'chrome',
	lock:true
	});
	art.dialog.get("shengPiTongYi").content(str);
	str  = null;
}

function getsp_hcontent(listId,type){

	var ajax = new AJAXRequest();
				ajax.ontimeout=function(e) 
					{
						art.dialog({
							skin: 'chrome',
						id: 'timeOutUi',
						content: '你指定的信息,加载失败!<br>请求超时......'});
						closeShengpi();
					}
				ajax.onexception=function(e) 
					{
						art.dialog({
							skin: 'chrome',
							id: 'serverError',
							content: '无法加载您需要的信息!'});
						closeShengpi();
					}
				ajax.post("index.php/remind/getHisRm/","arg="+listId, function(obj)
				{
					var st="<div id='content_res' style=''>"+obj.responseText+"</div>";
					bug("服务器返回的信息","<textarea style='width:800px; display:block;'>"+st+"</textarea>","green");
					
					if(clientHeight("sp_hcontent")<200){
						att(_("sp_hcontent"),"style","height:200px;");
					}
						html("sp_hcontent",st);
					if(type=="shengPiTongYi"){
						if(clientHeight(_("shenPiTongYiTb"))+100>clientHeight(document))
						{
							with(_("shenPiTongYiTb").style)
							{
								display="block";
								overflow="auto";
								height=(clientHeight(document)-185)+"px";
								width="625px";
							}
							art.dialog.get("shengPiTongYi").size(650,clientHeight(document)-68);
						}
						art.dialog.get("shengPiTongYi").position();
						
					}else if(type=="shengPiViewInfo"){
						
						bug("getsp_hcontent ","documentHeight: "+clientHeight(document)+"<br>shengPiViewInfotd_content: "+(clientHeight("content_res")));
						if(clientHeight(_("content_res"))+100>clientHeight(document))
						{
							with(_("content_res").style)
							{
								display="block";
								overflow="auto";
								height=(clientHeight(document)-100)+"px";
								width="625px";
							}
							art.dialog.get("shengPiViewInfo").size(650,clientHeight(document)-68);
						}
						art.dialog.get("shengPiViewInfo").position();
						
					}else if(type=="shengPiBoHui"){
						bug("getsp_hcontent ","documentHeight: "+clientHeight(document)+"<br>shengPiBoHuidialog: "+(clientHeight(_("shengPiBoHuidialog"))+50));
						if(clientHeight("shenPiBoHuiTb")+100>clientHeight(document))
						{
							
							with(_("shenPiBoHuiTb").style)
							{
								//backgroundColor="red";
								display="block";
								overflow="auto";
								width="625px";
								height=(clientHeight(document)-180)+"px";
							}
							art.dialog.get("shengPiBoHui").size(650,clientHeight(document)-30);
						}
						art.dialog.get("shengPiBoHui").position();
						//alert(clientHeight("shengPiBoHuidialog"));
					}
					
					
				});
				return "";
				
}
function closeShengpi()
{
	art.dialog.get("shengPiTongYi").close();
}
function submitShengpiInfo(str)
{
	var err=0;
	var collectionId=radioGroupValue("shengpi_ui").value;
	var sp_title   = trim(_("sp_title").value).replace(/\\/g,"\\\\").replace(/"/g,"\\\"").replace(/[\n\t\s]/g,"");
	var sp_content = trim(_("sp_content").value).replace(/\\/g,"\\\\").replace(/"/g,"\\\"").replace(/[\n\t\s]/g,""); 
	if(strLen(sp_title)<50)
	{
		sp_title=encodeURIComponent(sp_title);	
	}else {
		alert("您的标题超过(50个字符)长度!\n请重新填写!");
		err=1;
	}
	if(strLen(sp_content)<512)
	{
		sp_content=encodeURIComponent(sp_content);
	}else
	{
		alert("您的内容超过(511个字符)长度!\n请重新填写!");
		_("sp_content").focus();
		err=1;
	}
	if(!err)
	{
			var ld=str.split("__#@#__");
			  var listId=ld[0];
			  var direction=ld[1];
		  
			  bug("提交审批信息","collectionId:"+collectionId+"<br>listId:"+listId+"<br> direction:"+direction+"<br> sp_title:"+sp_title+"<br>sp_content:"+sp_content+"<br> 消息编号:"+ld[2]+"<br> 预览路径:"+ld[3]);
		  
			  var info='{"collectionId":"'+collectionId+'","title":"'+sp_title+'","content":"'+sp_content+'","listId":"'+listId+'","direction":"'+direction+'","infoId":"'+ld[2]+'","showUrl":"'+ld[3]+'"}';
			  var ajax = new AJAXRequest();
			  ajax.ontimeout=function(e) 
				  {
					  closeShengpi("shengPiTongYi",'你指定的信息,加载失败!<br>请求超时......');
				  }
			  ajax.onexception=function(e) 
				  {
					  closeShengpi("shengPiTongYi",'无法加载您需要的信息!');
				  }
			  ajax.post("index.php/remind/insertAppinfo/","arg="+info, function(obj)
			  {
				  var st=obj.responseText;
				  bug("submitShengpiInfo 服务器返回的信息",st,"green");
					  st=eval("("+st+")");
				   if(st["state"]=="true")
				   {
					   changeArtInfo("shengPiTongYi",st["serverInfo"]);
				   }
				  if(st["state"]=="false")
				   {
					   changeArtInfo("shengPiTongYi",st["errorInfo"]);
				   }
				  var tr=_("d_"+ld[2]);
				  rmChild(getParentNode(tr),tr);
				  
				  //刷新数据
				   getOnePageInfo("1");
				   getOnePageInfo("2");
			  });
	}
}


function sendPlayList(id,_o,id)
{
	if(!confirm("确定要下发到终端?")){
			return;              
	}
	       var listId='{"id":"'+att(_o,"listId")+'"}';
		bug("sendPlayList 向服务器提交下发数据","listId: "+listId);
		var ajax=new AJAXRequest();
		ajax.get("index.php/remind/getRemind/"+listId,function(obj)
		{
			var str=obj.responseText;
			str=str.split("_#@#_");
			send(str,id);
		});	
}

function send(s,id,_o)
{
	var ajaxTem = new AJAXRequest();
	ajaxTem.ontimeout=function(e) 
	{
		alert("请求超时！");
	}
	ajaxTem.onexception=function(e) 
	{
		alert("服务器错误,请稍后再试!");
	}
	//复制临时表示数据到正式表
	ajaxTem.post("index.php/playlist/upTemPlayList", 
		"PlayListId="+s[0],function(o)
		{
			var ajax = new AJAXRequest();
		ajax.timeout=40000;
			ajax.ontimeout=function(e) 
			{
				alert("请求超时！");
			}
			
			ajax.onexception=function(e) 
			{
				alert("服务器错误,请稍后再试!");
			}
			//------------------------
			//-终端 对应多个播放列表
			//------------------------
			//alert();
			ajax.post("index.php/client/AddClientPlayList", 
			"PlayListId="+s[0]+"&ClientID="+s[1],
			function(obj)
			{
			   var aajax = new AJAXRequest();
				aajax.post("index.php/socket/controlClients",
				"clientID="+s[1]+"&command=playlist&playListID="+s[0],
				function(obj)
				{
					var st=obj.responseText;
					bug("send 服务器信息",st,"green");
					if(st.indexOf("Register OK!")>-1)
					{
						unLockPlayListid(s[0]);
						infoOver(id,_o,3); 
					}
				});
			});
			
		});
}
 
function unLockPlayListid(id)
{
	var ajax = new AJAXRequest();
			ajax.post("index.php/remind/unPlayListLock",
			'arg={"id":"'+id+'","state":"0"}',
			function(obj)
			{
				var st=obj.responseText;
				bug("unLockPlayListid 服务器返回的信息",st,"green");
				st=eval("("+st+")");
				 if(st["state"]=="true")
				 {
					alert("播放计划解锁成功!");
				 }
				 else
				 {alert("播放计划解锁失败!");}
				 
			});
}
/*

消息驳回
*/
function boHui(id,o,k)
{
	var _o=o;
	while(o.nodeName.toLowerCase()!="tr")
	{
		o=getParentNode(o);
	}//---->获取到行对象
	
	var listId=getAttr(_o,"listId");
	bug("向服务器提交信息:","消息ID: "+id+" listId: "+listId);
	var ajax = new AJAXRequest();
	
	//同意驳回 中的同意按钮
	if(k)
	{
		ajax.get("index.php/remind/getDUsers/"+id+"/"+listId, 
		function(obj)
		{
			bug("服务器返回信息:",obj.responseText,"green");
			var st=obj.responseText;
	
//			if(st=="null")  //表示没有接收的用户
//			{
//				viewRemindInfo(_o,o,id,"bohui");
//			}
			var idx=st.indexOf("state");
			if(idx>=0)  //表示驳回到了,消息的发起者
			{
				viewRemindInfo(_o,o,id,"bohuiover");
			}
			if(st.indexOf("boHui")==0&&st.indexOf("state")<0) //存在驳回用户
			{
				
				boHuiUI(st.split("_#@#_")[1],_o,o,id);
			}
		});
	}
	else //未读消息中的 不同意按钮
	{
		ajax.get("index.php/remind/buTongyi/"+id, 
		function(obj)
		{
			bug("服务器返回信息:",obj.responseText,"green");
			var st=obj.responseText;
	
			//if(st=="null")
//			{
//				viewRemindInfo(_o,o,id,"bohui");
//			}
			if(st.indexOf("boHui")==0)
			{
				
				boHuiUI(st.split("_#@#_")[1],_o,o,id);
			}
		});
	}
	
}

//创建驳回审批UI
function boHuiUI(str,_o,o,id)
{

	var rs=eval(str);
	var listId=att(_o,"listId");
	var direction=att(_o,"direction");
	var showUrl=att(_o,"showUrl");

	//消息名称
	var tr=getChildNodes(o);
	var tl=txt(tr[1]);
	var con=txt(tr[3]);
	bug("消息信息","消息名称: "+tl+"<br> 消息内容: "+con);
	
	//---------------------------------------------------------------------------------------------------------	
	var ui='<div style="dispaly:block; width:620;"  id="shenPiBoHuiTb"><table width="600" border="0" class="sp_table"><tr><td colspan="3" align="left">审批收信人:</td></tr><tr style="font-size:12px;">';
	for(var i=0,n=rs.length; i<n; i++)
	{		
		if(i==0)
		{ui+='<td><label><input name="bohui_ui" type="radio" checked  value="'+rs[i].UserID+'" />'+rs[i].UserName+'</label></td>';}
		else{
		ui+='<td><label><input name="bohui_ui" type="radio"  value="'+rs[i].UserID+'" />'+rs[i].UserName+'</label></td>';}
		if((i+1)%3==0)
		{
			ui+='</tr><tr>';
		}  
	}
	ui+='</tr><tr><td colspan="3" align="left">审批标题: <input type="hidden" value="'+tl+'" maxlength="24" id="sp_title" /><span class="sp_title" >'+tl+'</span></td></tr><tr><td colspan="3" align="left">审批历史:'+getsp_hcontent(listId,'shengPiBoHui')+'</td></tr><tr><td colspan="3" id="sp_hcontent"></td></tr></table></div>';
	
	str='<table style="vertical-align:top; font-size:12px; width:100%" align="center"><tr><td id="shengpi_user">'+ui+'</td></tr><tr><td align="left">审批内容:</td></tr><tr><td colspan="3" align="left"><textarea id="sp_content" style="width:100%; height:80px; border:1px; border:1px #ccc solid;"></textarea></td></tr><tr><td  align="center"><table align="center" border="0" cellspacing="0" cellpadding="0"><tr><td><a href="javascript:submitboHui(\''+listId+'__#@#__'+direction+'__#@#__'+id+'__#@#__'+showUrl+'\')" id="shSubmit"   class="abtn_left"><span class="abtn_right">提  交</span></a></td></tr></table></td></tr></table>';
	bug("审批UI","<textarea style='width:100%; height:100px;'>"+str.replace(/textarea/g,"txtarea")+"</textarea>");
	
	art.dialog({
		id:'shengPiBoHui',
		width:620,
    content: "信息加载中......",
    skin: 'chrome',
	lock:true
	});
	art.dialog.get("shengPiBoHui").content(str);
	str  = null;
}

function closeboHui()
{
	art.dialog.get("shengPiBoHui").close();
}
function submitboHui(str)
{
	var err=0;
	var collectionId=radioGroupValue("bohui_ui").value;
	var sp_title   = trim(_("sp_title").value).replace(/\\/g,"\\\\").replace(/"/g,"\\\"").replace(/[\n\t\s]/g,"");
	var sp_content = trim(_("sp_content").value).replace(/\\/g,"\\\\").replace(/"/g,"\\\"").replace(/[\n\t\s]/g,""); 
	if(strLen(sp_title)<50)
	{
		sp_title=encodeURIComponent(sp_title);	
	}else {
		alert("您的标题超过(50个字符)长度!\n请重新填写!");
		err=1;
	}
	if(strLen(sp_content)<512)
	{
		sp_content=encodeURIComponent(sp_content);
	}else
	{
		alert("您的内容超过(511个字符)长度!\n请重新填写!");
		_("sp_content").focus();
		err=1;
	}
	if(!err)
	{
		var ld=str.split("__#@#__");
		var listId=ld[0];
		var direction=ld[1];
		bug("驳回审批信息","collectionId:"+collectionId+"<br>listId:"+listId+"<br> direction:"+direction+"<br> sp_title:"+sp_title+"<br>sp_content:"+sp_content+"<br> 旧的消息编号:"+ld[2]+"<br>预览路径:"+ld[3]);
		var info='{"collectionId":"'+collectionId+'","title":"'+sp_title+'","content":"'+sp_content+'","listId":"'+listId+'","direction":"'+direction+'","infoId":"'+ld[2]+'","showUrl":"'+ld[3]+'"}';
		var ajax = new AJAXRequest();
		ajax.post("index.php/remind/boHuiAppinfo/","arg="+info, function(obj)
		{
			var st=obj.responseText;
			bug("服务器返回的信息",st,"green");
			st=eval("("+st+")");
			if(st["state"])
			{
				 var tr=_("d_"+ld[2]);
				 rmChild(getParentNode(tr),tr);			
				  //刷新数据
				   getOnePageInfo("1");
				   getOnePageInfo("2");
				alert(st["serverInfo"]);
			}
			else
			{alert(st["errorInfo"]);
			 }
			 closeboHui();
		});
	}
}
//消息发送起始端
function infoOver(id,o,state)
{
	bug("infoOver 向服务器提交信息:",id);
	var ajax = new AJAXRequest();
	ajax.post("index.php/remind/setInfoOver/",
	'arg={"state":"'+state+'","id":"'+id+'"}',
	function(obj)
	{
		var st=obj.responseText;
		bug("infoOver 服务器返回的信息+",st,"green");
		st=eval("("+st+")");
		if(st["state"])
		{
			var tr=_("d_"+id);
			 rmChild(getParentNode(tr),tr);			
			  //刷新数据
				   getOnePageInfo("1");
				   getOnePageInfo("2");
			alert(st["serverInfo"]);
		}
		else
		{alert(st["errorInfo"]);
		 }
	});
	/*bug("向服务器提交信息:",id);
	var ajax = new AJAXRequest();
	ajax.get("index.php/remind/infoOver/"+id, function(obj)
	{
		var st=obj.responseText;
		bug("服务器返回的信息+",st,"green");
		 if(st==1)
		 {  
		    try{
			 var tr=_("d_"+id);
			 rmChild(getParentNode(tr),tr);			
			 closeboHui();
			 alert("消息处理完成");
			}
			catch(e){}
		 }
	});*/
}
function viewRemindInfo(_o,o,id,state)
{
	var listId=att(_o,"listId");

	var direction=att(_o,"direction");

	var showUrl=att(_o,"showUrl");

	var ui='<table width="600" border="0" class="sp_table"><tr><td colspan="3" align="left">审批历史</td></tr><tr><td colspan="3" id="sp_hcontent" style="padding:0px;"></td></tr></table>';
	str=ui;
	bug("审批UI","<textarea style='width:100%; height:100px;'>"+str.replace(/textarea/g,"txtarea")+"</textarea>");
	
	art.dialog({
		id:'shengPiViewInfo',
		width:620,
		
    content: "信息加载中......",
    skin: 'chrome',
	yesFn:function(){
						if(state=="fangxing")
						{
							sendPlayList(id,_o,id);
						}
//						if(state=="bohui")
//						{
//							infoOver(id,o,2);
//						}
						if(state=="bohuiover")
						{
							unLockPlayListid(showUrl);
							infoOver(id,o,4);
						}
					},
	noFn:true,
	lock:true
	});
	art.dialog.get("shengPiViewInfo").content(str);
	str  = null;
	getsp_hcontent(listId,"shengPiViewInfo");
//	art.dialog.get("shengPiViewInfo").size(620,200);
}
//加载 数据
function onloadSouce()
{
	var ajax = new AJAXRequest();
		ajax.timeout=300000;
		ajax.ontimeout=function(e) 
		{
			art.dialog({
				skin: 'chrome',
			id: 'timeOutUi',
			content: '你指定的信息,加载失败!<br>请求超时......'});
			art.dialog.get('viewNodeInfoUi').close();
		}
		
		ajax.onexception=function(e) 
		{
			art.dialog({
				skin: 'chrome',
			id: 'serverError',
			content: '无法加载您需要的信息!'});
			art.dialog.get('viewNodeInfoUi').close();
		}
		ajax.post("index.php/playlist/getOneOfPlayList", 
		"listId="+listId,
		function(obj)
		{
			var st=obj.responseText;
			bug("服务器返回的播放计划的详细信息",st,"green");
			var state=st.split("__bx__");
			if(state[0]=="Excel")
			{viewInfoFromExcel(state[1]);}
			else if(state[0]=="DataBase")
			{ viewNodeInfoTreatment(state[1]);}
			else if(state[0]=="Error")
			{ alert(state[1]);}
		});
}


//-----------------------------
//		分页 
//-----------------------------

function changPage(o,pageControlId)
{
	var pageInfo=pageInfoPz(pageControlId);
	var firp=_("firPage"+pageControlId); //--> 第一页
	var prvp=_("prvPage"+pageControlId); //--> 上一页
	var nxtp=_("nxtPage"+pageControlId); //--> 下一页
	var finp=_("finPage"+pageControlId); //--> 最后一页
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
			att(finp,"page",pageInfo.curent);;
		break;
	}
	
}

//分页
function pageAtion(o,pageControlId) {
    changPage(o,pageControlId);
	var pageInfo=pageInfoPz(pageControlId);
    var _cunrent = (parseInt(pageInfo.curent) + parseInt(att(o, 'page')) );
	//bug("pageAtion","_cunrent:"+_cunrent);
    if (_cunrent != 0 && _cunrent <= pageInfo.count) {
        pageInfo.curent = _cunrent;
        
        bug("page params info", print_r(pageInfo));
        getOnePageInfo(pageControlId)
    }
	if(_cunrent> pageInfo.count)
	{
		pageInfo.curent = pageInfo.count;
		bug("page params info", print_r(pageInfo));
        getOnePageInfo(pageControlId)
	}
}


function getOnePageInfo(pageControlId) {
    var ajax = new AJAXRequest();
    ajax.timeout = 300000;
    ajax.ontimeout = function (e) {
        art.dialog({
            skin: 'chrome',
            id: 'timeOutUi',
            content: '你指定的信息,加载失败!<br>请求超时......'
        });
    }
    ajax.onexception = function (e) {
        art.dialog({
            skin: 'chrome',
            id: 'serverError',
            content: '无法加载您需要的信息!'
        });
    }
	var pIc=pageInfoControl(pageControlId);
   
    ajax.get( pIc.info.src+pIc.s, function (obj) {
        setPageData(obj.responseText,pIc.c,pIc.info);
        
    });
}

function pageInfoControl(pageControlId)
{
	var pInfo=pageInfoPz(pageControlId);
	var pic={};
	 pic.s = '{"my_comm":"0","pageCount":"' + pInfo.count + '","my_pageNum":"' + pInfo.curent + '","FileType":"' + pInfo.type + '"}';
	 pic.c=_(pInfo.container);
	 pic.info=pInfo;
	 return pic;
}

function pageInfoPz(pageControlId)
{
	var pInfo="";
	if(pageControlId=="1")
	{
		pInfo=pageInfo1;
	}
	else{pInfo=pageInfo2;}
	return pInfo;
}




function changeArtInfo(id,str,img)
{
	if(img){img='<img src="'+img+'" width="50" height="50" border="0" />';}
	else{img="";}
	var st='<table width="100%" border="0" cellspacing="0" cellpadding="0">\
  <tr>\
    <td>&nbsp;</td>\
    <td>&nbsp;</td>\
    <td>&nbsp;</td>\
  </tr>\
  <tr>\
    <td>&nbsp;</td>\
    <td><table width="100%" border="0" height="50" cellspacing="0" cellpadding="0">\
  <tr>\
    <td>'+img+'</td>\
    <td>'+str+'</td>\
  </tr>\
</table>\
</td>\
    <td>&nbsp;</td>\
  </tr>\
  <tr>\
    <td>&nbsp;</td>\
    <td align="center"  >\
	<table border="0"  align="center" cellspacing="0" cellpadding="0"><tr><td id="controlButtonContainer"><a href="javascript:void(0)" id="firPage1" onclick="closeShengpi()"  class="abtn_left"><span class="abtn_right">关闭</span></a></td></tr></table>\
</td>\
    <td>&nbsp;</td>\
  </tr>\
</table>';

art.dialog.get(id).content(st);
}