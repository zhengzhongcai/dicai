// JavaScript Document
function buttonCheck(obj,objAllName){
	var cIds=_name(objAllName);
	if(obj.title=='全'){
		for(var a=0,n=cIds.length; a<n; a++)
		{
			cIds[a].checked=true;
				var row = client_tree.getRowById(cIds[a].attributes.rowid.value);
				row.obj.isChecked = true;
				client_tree.updateRow(cIds[a].attributes.rowid.value, row);
		}
		obj.title='反';
	}else{
		for(var a=0,n=cIds.length; a<n; a++)
		{
			cIds[a].checked=false;
				var row=client_tree.getRowById(cIds[a].attributes.rowid.value);
				row.obj.isChecked=false;
				client_tree.updateRow(cIds[a].attributes.rowid.value,row);
		}
		obj.title='全';
	}
}
//增加的按组选择
function checkGroup(obj){
	var cIds=_name('clientID');
	if(obj.title=='全'){
		for(var a=0,n=cIds.length; a<n; a++)
		{
			//alert(cIds[a].attributes.pNode.value);
			if (cIds[a].attributes.pNode.value==obj.value){
				var row=client_tree.getRowById(cIds[a].attributes.rowid.value);
				row.obj.isChecked=true;
				client_tree.updateRow(cIds[a].attributes.rowid.value,row);
			//cIds[a].checked=true;
			}
		}
		obj.title='反';
	}else{
		for(var a=0,n=cIds.length; a<n; a++)
		{
			if (cIds[a].attributes.pNode.value==obj.value) {
				var row=client_tree.getRowById(cIds[a].attributes.rowid.value);
				row.obj.isChecked=false;
				client_tree.updateRow(cIds[a].attributes.rowid.value,row);
				//cIds[a].checked = false;
			}
		}
		obj.title='全';
	}
}
function device_checkbox_click(self){

	var row=client_tree.getRowById($(self).attr('rowId'));
	if (row.obj.isChecked==true){
		row.obj.isChecked=false;
	} else {
		row.obj.isChecked=true;
	}

}

function checkAll(id,objAllName){
	var cIds=_name(objAllName);
	//alert("呵呵");
	
	if(_(id).checked==true){
		for(var a=0,n=cIds.length; a<n; a++)
		{
			cIds[a].checked=true;
		}
	}else{
		for(var a=0,n=cIds.length; a<n; a++)
		{
			cIds[a].checked=false;
		}
	}
}
ready(function() {
	//setTimeout("getClientStatus()",30000);
});

//获取终端信息 上下线 从数据库中获得
function getClientsInfo(){
		$.ajax({
			url:"index.php?control=client&action=getClientInfoAjax",
			type:"post",
			success:function(str){
				$("#clientTable").html(str);
			},
			error:function(){
				alert("加载信息出错");
			}
		});
}



//终端控制
function controlAjax(command){
	switch (command){
			case 'setClientDownload':readyComond(command);break;
			case 'shengpi':readyComond(command);break;
			case 'playlist':readyComond(command);break;
			case 'shutTime':readyComond(command);break;
			case 'screen':readyComond(command);break;
			case 'volume':readyComond(command);break;
			case 'profile':readyComond(command);break;
			case 'upgrate':
				file=_("upgratefile").value;
				if(file==''){
					art.dialog({
					    content: '您没有选择升级包',
					    ok: function () {
					    	this.close();
					    	setTimeout(function(){
					    		readyComond(command);
					    	},200);
					    },
					    cancelVal: '关闭',
					    cancel: function(){return true;}
					});
					return;
				}else{
					art.dialog({
					    content: '您确定要升级？',
					    ok: function () {
					    	this.close();
					    	setTimeout(function(){
					    		readyComond(command);
					    	},200);
					    },
					    cancelVal: '关闭',
					    cancel: function(){return true;}
					});
					break;
				}
			case 'screenshot': readyComond(command);break;
			case 'reboot':
					
					art.dialog({
					    content: '您确定要重启？',
					    ok: function () {
					    	this.close();
					    	setTimeout(function(){
					    		readyComond(command);
					    	},200);
					    	
					    },
					    cancelVal: '关闭',
					    cancel: function(){return true;}
					});
					break;
			case 'shutDown': 
					
					art.dialog({
					    content: '您确定要关机？',
					    ok: function () {
					    	this.close();
					    	setTimeout(function(){
					    		readyComond(command);
					    	},200);
					    	
					    },
					    cancelVal: '关闭',
					    cancel: function(){return true;}
					});
					break;
			case 'play': readyComond(command); break;
			case 'pause':readyComond(command); break;
			case 'stop':readyComond(command); break;
			case 'stopInsert': readyComond(command); break;
			case 'wakeup': readyComond(command); break;//远程开机
		}		
	
}
function readyComond(command){
	var clientID;
	clientID=getClientID();//获得终端数组	
	//alert(command);
	if(clientID==''){
		tip.tip({message:"您未选择任何终端!"});
		return false;
	}
		var dataInfo;
		switch (command){
			case 'setClientDownload':
			var sp=_("clientSpeed").value;
			var spDv=_("speedDv_0").checked==true?_("speedDv_0").value:_("speedDv_1").value;
			dataInfo="&clientSpeed="+sp+spDv;
			break;
			case 'shengpi':
				var playList=_("playList");
				var lastTime=playList.options[playList.selectedIndex].title;
				
				var DBdate=lastTime.replace(","," ");
				var dNow=new Date();
				yy=dNow.getFullYear();
				mm=((parseInt(dNow.getMonth())+1).toString().length==2)?dNow.getMonth()+1:"0"+(dNow.getMonth()+1);
				dd=((parseInt(dNow.getDate())).toString().length==2)?dNow.getDate():"0"+(dNow.getDate());
				//dd=dNow.getDate();
				xslen = dNow.getHours().toString().length;
				xs = dNow.getHours();
				if(xslen!=2)
				{
				   xs = "0"+dNow.getHours();
				}
				fzlen = dNow.getMinutes().toString().length;
				fz =  dNow.getMinutes();
				if(fzlen!=2)
				{
				   fz = "0"+dNow.getMinutes();
				}
				curDate=yy+"-"+mm+"-"+dd+" "+xs+":"+fz+":"+dNow.getSeconds();
				//alert(curDate);
				if(DBdate<curDate){
					
					tip.tip({message:"播放计划已过期，请重新选择播放计划"});
					return false;
				}
						
				var listType = playList.options[playList.selectedIndex].getAttribute("type");
				var clientType = getClientType();
				for(var i =0, n=clientType.length; i<n; i++){
					if(clientType[i].indexOf(listType)==-1){
						tip.tip({message:"您选择的播放列表和终端类型不相符!"});
						return ;
						
					}
				}
				dataInfo="&shengpi="+_("playList").value;
				
				break;

			case 'playlist':
				var playList=_("playList");
				var lastTime=playList.options[playList.selectedIndex].title;
				//alert(lastTime);
				var DBdate=lastTime.replace(","," ");
				var dNow=new Date();
				yy=dNow.getFullYear();
				mm=((parseInt(dNow.getMonth())+1).toString().length==2)?dNow.getMonth()+1:"0"+(dNow.getMonth()+1);
				dd=((parseInt(dNow.getDate())).toString().length==2)?dNow.getDate():"0"+(dNow.getDate());
				//dd=dNow.getDate();
				xslen = dNow.getHours().toString().length;
				xs = dNow.getHours();
				if(xslen!=2)
				{
				   xs = "0"+dNow.getHours();
				}
				fzlen = dNow.getMinutes().toString().length;
				fz =  dNow.getMinutes();
				if(fzlen!=2)
				{
				   fz = "0"+dNow.getMinutes();
				}
				curDate=yy+"-"+mm+"-"+dd+" "+xs+":"+fz+":"+dNow.getSeconds();
				if(DBdate<curDate){
					tip.tip({message:"播放计划已过期，请重新选择播放计划"});
					return false;
				}
				
				dataInfo="&playListID="+_("playList").value;
				clientManage.updateUi.updatePlayListToClient(playList.options[playList.selectedIndex].innerHTML.split("----")[0]);
				break;
			case 'shutTime':
				dataInfo="&shutOnTime="+_("shutOnTime").value+"&shutOffTime="+_("shutOffTime").value;
				break;
			case 'screen':
				dataInfo="&screenResolution="+_("ScreenResolution").value+"&rotateDirection="+_("RotateDirection").value;
				break;
			case 'volume':
				dataInfo="&volume="+_("Volume").value;
				break;
			case 'profile':
				dataInfo="&profileID="+_("insertProfile").value;
				break;
			case 'upgrate':
				file=_("upgratefile").value;
				if(file==''){
					alert("您没有选择升级包");
					return;
				}else{
					dataInfo="&upgratefile="+file;
					break;
				}
			case 'screenshot': 
				dataInfo="&screenshotTime="+_("ScreenshotTime1").value+","+_("ScreenshotTime2").value+","+_("ScreenshotTime3").value;
				break;
			case 'reboot':
					dataInfo="";
					break;
			case 'shutDown': 
					dataInfo='';
					break;
			case 'play':
			case 'pause':
			case 'stop':
			case 'stopInsert': 
			case 'wakeup': //远程开机
			
			default:
				dataInfo='';

		}		
		//alert(clientID.length);
		//zhangli 终端组群发
		var dataAll="clientID="+clientID.join(",")+"&command="+command+dataInfo;
		dataAll=dataAll.split("&");
		var comandData={},item=[];
		for(var i=0,n=dataAll.length; i<n; i++)
		{
			item=dataAll[i].split("=");
			comandData[item[0]]=item[1];
		}
		clientAjax(comandData,clientID.join(","));		  			  

}
function clientAjax(dataAll,str_clientID){
	tip.tip({message:"命令发送中......",stateClose:false});
	bug("向服务器提交的信息",dataAll);
		
	$.ajax({
			url:"index.php?control=socket&action=controlClients",
			type:"post",
			data:{data:dataAll},
			success:function(str){
				var result=str;
				bug("服务器返回的信息",result,"green");
	
				//_("playInfo").html(result);
				if(result.indexOf("shengpi")>=0)
				{
					var o=result.split("__#@#__")[1];
					if(o=="over") //为审批末端  --->直接发送
					{
					   // tip.tipClose();
						//if(confirm("您是顶级审批人员您是否确定发送播放计划给终端?"))
						//{  
							//alert("-----------");
							
							//updateTempPlayList(dataAll,str_clientID);
							AddClientPlayList(dataAll);
						//}
						
					}
					else
						{
							tip.tipClose();
							shengpiUI(o);
						}
				}
				else
				{
					if(result.indexOf("Register fail")>=0){
						tip.change("发送失败，服务器错误，用户可能已经登录");
						return false;
					}else{
						tip.change("命令发送成功！");
					}
				}
			},
			error:function(){
				tip.change("加载信息出错");
			}
		});
		
}
// function updateTempPlayList(dataAll,str_clientID){
	// $.ajax({
			// url:"index.php/playlist/upTemPlayList",
			// type:"post",
			// data:"PlayListId="+dataAll.split('&')[2].split('=')[1],
			// success:function(str){
				// AddClientPlayList(dataAll,str_clientID);
			// },
			// error:function(){
				// tip.change("加载信息出错");
			// }
		// });
// }
function AddClientPlayList(dataAll){
	$.ajax({
			url:"index.php?control=client&action=AddClientPlayList",
			type:"post",
			data:"PlayListId="+dataAll.shengpi+"&ClientID="+dataAll.clientID,
			success:function(str){
				controlAjax("playlist");

			},
			error:function(){
				tip.change("加载信息出错");
			}
		});
}
//---------------------------------
//-
//-  获取选中的终端ID
//-
//---------------------------------
function getClientID(){
	var clientID=new Array();
	var i=0;
	var c=_name("clientID");
	for(var a=0,n=c.length; a<n; a++)
	{
		if(c[a].checked)
		{
			
			
			if(attr(c[a],"ctype")=="0")
			{
				var info=eval("("+attr(c[a],"info")+")");
				clientID=getGroupClientID(info.clientNodeCode).concat(clientID);
				i=clientID.length-1;
			}
			else
			{
				clientID[i]=c[a].value;
				i++;
			}
		}
	}
	bug("getClientID",clientID.join(","));
	return clientID;
}
function getClientType(){
	var clientType=new Array();
	var i=0;
	var c=_name("clientID");
	for(var a=0,n=c.length; a<n; a++)
	{
		if(c[a].checked)
		{
			if(attr(c[a],"ctype")=="0")
			{
				var info=eval("("+attr(c[a],"info")+")");
				clientType=getClientType(info.clientNodeCode).concat(clientType);
				i=clientType.length-1;
			}
			else
			{
				$("#a_"+c[a].value).children("span").each(function(index,element) {
					
				  	if($(element).hasClass('c_zlxin')){
				  		clientType[i]=element.innerHTML;
				  	}
				});;
				i++;
			}
		}
	}
	bug("clientType",clientType.join(","));
	return clientType;
}
//---------------------------------
//-
//-  获取选中的终端组所包含的终端的ID
//-
//---------------------------------
function getGroupClientID(code){
	var c=userClientSouce.clientInfo;
	var clientID=new Array();
	var i=0,str_icode="";
	bug("getGroupClientID",print_r(c));
	for(var a in c)
	{
		str_icode=c[a].clientNodeCode.substring(0,code.length);
		bug("getGroupClientID 对比",str_icode+"<--------->"+code);
		if(str_icode==code)
		{
			clientID[i]=c[a].clientNum;
			i++;
		}
	}
	return clientID;
}
function getGroupClientType(code,type){
	var c=userClientSouce.clientInfo;
	var clientType=new Array();
	var i=0,str_icode="",str_type="";
	bug("getGroupClientID",print_r(c));
	for(var a in c)
	{
		str_icode=c[a].clientNodeCode.substring(0,code.length);
		str_type=c[a].clientType.indexOf(type);
		bug("getGroupClientID 对比",str_icode+"<--------->"+code);
		if(str_icode==code)
		{
			
			clientType[i]=c[a].clientType;
			i++;
		}
	}
	return clientType;
}
function setDownLoadTime(){
	var dTime=_("spesicTime").value;
	if(dTime==""){
		alert("不能为空，请输入值");
		return false;
	}else if(dTime==null){
		return false;
	}
	clientID=getClientID();//获得终端数组
	//alert(clientID);
	//alert(command);
	if(clientID==''){
		alert('您还未选择终端！');
	}else{
		
	   var ajax = new AJAXRequest();
		ajax.timeout=30000;
		ajax.ontimeout=function(e) 
		{
			alert("请求超时！");
		}
		
		ajax.onexception=function(e) 
		{
			alert("服务器错误,请稍后再试!");
		}
		ajax.post("index.php?control=client&action=setDownLoadTime",
		"clientIDs="+clientID+"&dTime="+dTime,
		function(obj)
		{
			var st=obj.responseText;
			alert("发送成功!");
			bug("定时下载服务器返回",st,"green");
			//html(_("clientTable"),result);
		}
		);
	}
}





function tab_hid(id,imgid){
    if(document.getElementById(id).style.display=='none')
	{ 
		document.getElementById(imgid).src = 'Skin/web/skin/tab_hid2.jpg';
	    document.getElementById(id).style.display='';
	}
	else
	{
	    document.getElementById(imgid).src = 'Skin/web/skin/tab_hid1.jpg';
	    document.getElementById(id).style.display = 'none';
	}
 }
//Object.prototype.tos=function(listAll,tbs){  
//    var value,ret='{\n',obj=this;  
//    tbs=tbs || 0;  
//    listAll=listAll || 0;  
//    var prefix=Math.pow(10,tbs).tos().slice(1).replace(/0/g,"    ");  
//    for(var key in obj){  
//        if ((!obj.hasOwnProperty(key)&& !listAll)||(!!listAll&&key=="tos")) continue;  
//        value=obj[key];         
//        switch(value.constructor){  
//            case String:  
//            case Date:  
//            case RegExp:  
//            case Array:  
//            case Number:  
//            case Function:  
//            case Error:  
//                value=value.tos();  
//                break;  
//            case Object:  
//                value=value.tos(listAll,++tbs);  
//                break;        
//            default:  
//                try{value=value.toString();}catch(x){value=""};  
//        }  
//        ret=ret+[prefix+key," :  ",value,"\n"].join("");  
//    }  
//    ret+=prefix+"}";  
//    return ret;  
//}  



function setFTP()
{
    var clientID=getClientID();
	if(clientID=="")
	{
	   alert('请选择终端或终端组!');
	   return false;
	}
    var ftp = document.getElementById('defaultFtp').value;
	var tdata = "clientID="+clientID+"&ftp="+ftp;
	var ajax = new AJAXRequest();
		ajax.timeout=30000;
		ajax.ontimeout=function(e) 
		{
			alert("请求超时！");
		};
		
		ajax.onexception=function(e) 
		{
			alert("服务器错误,请稍后再试!");
		};
		ajax.post("index.php?control=client&action=setclientftp",
		tdata,
		function(obj)
		{
			var st=obj.responseText;
			alert(st);
		}
		);
}

function onloadInfo()
{
    location.href = location.href;
}

//清除播放计划
// function deleteplaylist()
// {
    // var clientID=getClientID();
	// if(clientID=="")
	// {
	    // alert("请选择终端或终端组!");
	    // return false;
	// }
	// var ajax = new AJAXRequest();
		// ajax.timeout=30000;
		// ajax.ontimeout=function(e) 
		// {
			// alert("请求超时！");
		// }
// 		
		// ajax.onexception=function(e) 
		// {
			// alert("服务器错误,请稍后再试!");
		// }
		// ajax.post("index.php/client/deleteclientplaylist", 
		// "ClientID="+clientID,
		// function(obj)
		// {
			// alert("清除成功!");
		// }
		// );
// 
// }

//function selectview()
//{
//    var htmlstr = '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">';
//    htmlstr += '<tr>';
//    htmlstr += '<td>终端名称</td>';
//	htmlstr += '<td><input type="text" id="txt_clientname"/></td>';
//	htmlstr += '<td>终端IP</td>';
//	htmlstr += '<td><input type="text" id="txt_clientip"/></td>';
//	htmlstr += '<td>终端类型</td>';
//	htmlstr += '<td><input type="text" id="txt_clienttype"/></td>';
//	htmlstr += '<td>播放计划</td>';
//	htmlstr += '<td><input type="text" id="txt_clientplaylist"/></td>';
//	htmlstr += '</tr>';
//	htmlstr += '<tr>';
//	htmlstr += '<td>终端地址</td>';
//	htmlstr += '<td><input type="text" id="txt_clientaddress"/></td>';
//	htmlstr += '<td>维护人</td>';
//	htmlstr += '<td><input type="text" id="txt_clientUserName"/></td>';
//	htmlstr += '<td>显示屏尺寸</td>';
//	htmlstr += '<td><input type="text" id="txt_displaysize"/></td>';
//	//htmlstr += '<td><select id="clientstate"><option value="1">上线</option><option value="2">下线</option></select></td>';
//	htmlstr += '<td><input type="button" value = "搜索" id="but_sel" onclick="getClientInfoBySelect();"/></td>';
//	htmlstr += '</tr>';
//	htmlstr += '</table>';
//    art.dialog({
//		title:'终端查询',
//		id:'seldialog',
//		skin: 'chrome',
//		width: '800px',
//		heigth: '400px',
//		lock:true,
//		content: htmlstr
//		});
//}
// function changePlayList()
// {
	// var ajax = new AJAXRequest();
		// ajax.timeout=30000;
		// ajax.ontimeout=function(e) 
		// {
			// reqtimeout("请求超时！");
		// }
		
		// ajax.onexception=function(e) 
		// {
			// alert("服务器错误,请稍后再试!");
		// }
		// ajax.post("index.php/playlist/getPlayInfo", 
		// "playListID=" + _("playList").value,
		// function(obj)
		// {
			// var st=obj.responseText;
			
			// html(_("playInfo"),st);
		// }
		// );
// }




/*☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆
☆	
☆		终端名称修改 终端组名称修改
☆
☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆*/
//给终端表格绑定 修改 终端描述
//遗留bug 没有区分终端组的名称修改
//当天已停用
function bindClick()
{
	var trs=getClientTableTr();
	for(var i=0,n=trs.length; i<n; i++)
	{
		addListener(getChildNodes(trs[i])[3],"dblclick",createInput);
	}
}
function createInput(ev)
{
	var o=getEventObject(ev);
	var clientID = $(o).attr('clientID');
	var d = art.dialog({
		id:'new_group_dialog',
		title: '请输入分组名字',
		quickClose: true,
		content: '<input id="new_name_dialog_input" autofocus />',
		ok: function (){
			//alert($('#new_group_dialog_input').val())
			var name=$('#new_name_dialog_input').val();
			client_tree_remote_control.updateClientName(clientID,name,o);
		},
		//cancel: function(){}
	});
	//setAttr(o,"align","center");
	/*var v=txt(o);
	setAttr(o,"oldValue",v); //记录被修改之前的值
	html(o,"<input type='text' onblur=\"setValue(this)\" value='"+v+"' style='border:1px solid #eee; width:100px; margin:0px; '>");
	getFirstChild(o).focus();*/
}

function setValue(o)
{
	var td=getParentNode(o);
	var v="";
	if(trim(o.value).length>=3)
	{
		v=o.value;
		if(getAttr(td,"oldValue")==v)
		{
			html(td,getAttr(td,"oldValue"));
			return false;
		}
	}
	else
	{
		alert("您的输入有误!");
		return false;
	}
	if(!confirm("您确定要修改此终端的名称么?"))
	{
		html(td,getAttr(td,"oldValue"));
		return false;
	}
	html(td,v);
	upadteName(getUpdateData(td),v,td);
}

function getUpdateData(o)
{
	var bh = $(o).attr('clientID');
	/*var tr=getParentNode(o);
	while(tr.tagName.toLowerCase()!="tr")
	{
		tr=getParentNode(tr);
	}
	var bh=getFirstChild(getFirstChild(tr)).value;*/
	return bh;
}


function upadteName(b,v,o)
{
	var ajax = new AJAXRequest();
		ajax.timeout=30000;
		ajax.ontimeout=function(e) 
		{
			alert("修改失败,请求超时！");
		}
		
		ajax.onexception=function(e) 
		{
			alert("服务器错误,请稍后再试!");
		}
		ajax.post("index.php?control=client&action=updateClientName",
		'clientID='+b+"&Name="+v,
		function(obj)
		{
			var st=obj.responseText;
			if(st!=1)
			{
				alert("修改失败");
				html(o,getAttr(o,"oldValue"))
			}
		}
		);
}

//终端显示表格
function getClientTableTr()
{
	var dom_as=getChildNodes("clientInfo","a");
	var dom_trs=[];
	for(var i in dom_as)
	{
		dom_trs[i] = getFirstChild(getFirstChild(getFirstChild(dom_as[i])));
		bug("getClientTableTr dom_trs",dom_trs[i].tagName);
	}

	bug("getClientTableTr dom_trs",dom_trs.length);
	return dom_trs;
}
/*☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆
☆	
☆		自动跟新终端状态
☆
☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆*/
/*
function getClientStatus(st){
	if(st)
	{
		bug("清除定时器","清除定时器");
		window.clearTimeout(st);
	}

	   
	   var ajax = new AJAXRequest();
		ajax.timeout=30000;
		ajax.ontimeout=function(e) 
		{
			//alert("请求超时！");
			reqtimeout();

		}
		
		ajax.onexception=function(e) 
		{
			//alert("服务器错误,请稍后再试!");
		}
		ajax.post("index.php?control=socket&action=getClientState",
		"",
		function(obj)
		{
			
			var result=obj.responseText;
			//html(_("clientTable"),result);
			 bug("服务器返回的信息",result,"red");
			st=setTimeout("getClientStatus("+st+")",20000);
			
			if(result.indexOf("Register fail")>=0){
				alert("服务器错误，用户可能已经登录");
				bug("用户退出登录",top.location+"<br>"+self.location);
					if (top.location !== self.location) 
					{
						 top.location="index.php?control=c_login&action=loginOut";
					}
				return false;
			}
			
			if(result.indexOf("@#@#@#")>0){
				var clientStatusArr=result.split("@#@#@#");
				var clientStatus=clientStatusArr[1];
				//clientStatus.replace(/{/g,"[").replace(/}/g,"]");
				var array_onlineClient=[];
				var clientArr=window.eval("("+clientStatus+")");
				arrLen=clientArr.length;
				
				//无终端上线 arrLen 为 0
				if(!arrLen)
				{
					reqtimeout("当前没有终端上线！");
					setAllClientUnline();
					return ;
				}
				//有新终端上线,终端列表中不存在的时候, 刷新界面
				clientManage.checkNewClientOnLine(clientArr);
				var total=0,clientImg="";
				for(i=0;i<arrLen;i++)
				{
					try
					{
						client_ID=clientArr[i].clientID;
						array_onlineClient.push(client_ID);
						clientImg=_("imgID"+client_ID);
						var cstatus = html(_("clientID"+client_ID));
						if(!clientImg){continue;}
						if(clientArr[i].status==4)
						{
							bug("MK--","下线 --- "+cstatus+" ---clientID"+client_ID+" "+attr("clientID"+client_ID,"innerhtml"));
							if(attr("clientID"+client_ID,"innerHTML")=="上线"){continue;}
							html(_("clientID"+client_ID),"上线");
							html(clientImg,'<img src="Skin/web/skin/on.gif">');
							try
							{
								$("#aID"+client_ID).html("<a href=index.php?control=socket&action=getFilesInfo&client_id="+client_ID+" target=_blank>文件</a>");
							}
							catch(e){};
							//try{html(_("rz"+client_ID),"<a href=index.php/client/getClientLogs/"+client_ID+" target=_blank>日志</a>")}catch(e){};
							
							if("下线"==cstatus){
								reqtimeout("有终端上线了！");
							}
						}
					}catch(e){}
				}
				clientStatistics(array_onlineClient);
			}
		});
}
*/
//异步 获取 终端状态
/*
function getClientStatusNotAuto(){

	   var ajax = new AJAXRequest();
		ajax.timeout=60000;
		ajax.ontimeout=function(e) 
		{
			reqtimeout();

		}
		
		ajax.onexception=function(e) 
		{
			//alert("服务器错误,请稍后再试!");
		}
		ajax.post("index.php?control=socket&action=getClientState",
		"",
		function(obj)
		{
			
			var result=obj.responseText;
			
			//html(_("clientTable"),result);
			 bug("服务器返回的信息",result,"red");
			
			if(result.indexOf("Register fail")>=0){
				alert("服务器错误，用户可能已经登录");
				bug("用户退出登录",top.location+"<br>"+self.location);
					if (top.location !== self.location) 
					{
						 top.location="index.php?control=user&action=loginOut";
					}
				return false;
			}

			if(result.indexOf("@#@#@#")>0){
				var clientStatusArr=result.split("@#@#@#");
				var clientStatus=clientStatusArr[1];
				//clientStatus.replace(/{/g,"[").replace(/}/g,"]");
				var array_onlineClient=[];
				var clientArr=window.eval("("+clientStatus+")");
				arrLen=clientArr.length;
				
				//无终端上线 arrLen 为 0
				if(!arrLen)
				{
					setAllClientUnline();
				}
				var total=0,clientImg="";
				for(i=0;i<arrLen;i++)
				{
					try
					{
						
						client_ID=clientArr[i].clientID;
						array_onlineClient.push(client_ID);
						clientImg=_("imgID"+client_ID);
						var cstatus = html(_("clientID"+client_ID));
						if(!clientImg){continue;}
						if(clientArr[i].status==4)
						{
							
							html(_("clientID"+client_ID),"上线");
							html(clientImg,'<img src="Skin/web/skin/on.gif">');
							try{
									$("#aID"+client_ID).html("<a href=index.php?control=socket&action=getFilesInfo&client_id"+client_ID+" target=_blank>文件</a>");
								}
							catch(e){
								
							};
							//try{html(_("rz"+client_ID),"<a href=index.php/client/getClientLogs/"+client_ID+" target=_blank>日志</a>")}catch(e){};
							
							if("下线"==cstatus){
								reqtimeout("有终端上线了！");
							}
						}
					}catch(e){}
				}
				clientStatistics(array_onlineClient);
			}
			else
			{
				setAllClientUnline();
			}
		}
		);
}
*/
//设置终端全下线
// 2010年11月28日0:13:32 by 莫波
function setAllClientUnline()
{

	var trs=getChildNodes("clientInfo","a");
	var tds="",   
		td="";
	for(var i=0,n=trs.length; i<n; i++)
	{
		tds=$(trs[i]);
		tds=tds.children("span");
		// ctype 的值为"1"表示为终端 "0"表示为终端组
		if(attr(getFirstChild(tds[0]),"ctype")=="1")
		{
			html(getFirstChild(tds[1]),"<img src='Skin/web/skin/down.gif' />");
		}
		for(var a=1,b=tds.length; a<b; a++) 
		{
			td=tds[a];
			if(html(td)=="上线"||html(td)=="下线"){
				html(td,"下线");				
			}
			
			
			if(trim(txt(td)).indexOf("文件")>=0)
			{
				html(getChildNodes(td,"label")[1],"文件");
			}
		}
	}
}
//------------------------
//-
//-	保存 当前组的终端
//- 2011年6月23日17:57:45
//------------------------
function saveCurrentClient(str_clientInfo)
{
	if(!_("current_client"))
	{
		var dom_input=document.createElement("input");
		dom_input.type="hidden";
		dom_input.id="current_client";
		dom_input.value="";
		document.body.appendChild(dom_input);
	}
	_("current_client").value=str_clientInfo;
	
}
//终端统计
// 2010年11月27日22:59:01 by 莫波

function clientStatistics(array_onlineClient)
{
	bug("clientStatistics 上线的台数",array_onlineClient.length);
	//var array_currentClient=_("current_client").value.split(",");
	var int_total=userClientSouce["clientInfo"].length;//array_currentClient.length; //总台数
	var int_onlineTotal=array_onlineClient.length;//statisticsOnlineCount(array_currentClient,array_onlineClient);
	bug("终端上线/总台数","total:"+int_total+"<br>onlineClientTotal:"+int_onlineTotal+"<br>unlineClientTotal:"+(int_total-int_onlineTotal));
	
	html("onlineClientTotal",int_onlineTotal);
	html("clientTotal",int_total);
	html("unlineClientTotal",int_total-int_onlineTotal);
}

function statisticsOnlineCount(array_currentClient,array_onlineClient)
{
	var int_k=0;
	for(var i=0,int_onlineCount=array_onlineClient.length; i<int_onlineCount; i++)
	{
		for(var a=0,int_currentCount=array_currentClient.length; a<int_currentCount; a++)
		{
			if(array_onlineClient[i]==array_currentClient[a])
			{
				int_k++;
			}
		}
	}
	return int_k;
}

//创建上级审批UI
function shengpiUI(str)
{
	var rs=eval(str);
	var t,l,w,h,str;

	//获取播放计划名称
	var pn=selectInfo("playList").text;   
	var ui='<table width="100%" border="0" ><tr><td colspan="3" align="left">审批收信人</td></tr><tr style="font-size:12px;">';
	for(var i=0,n=rs.length; i<n; i++)
	{		
		if(i==0)
		{				
			ui+='<td><label><input name="shengpi_ui" type="radio" checked value="'+rs[i].UserID+'" />'+rs[i].UserName+'</label></td>';			
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
	ui+='</tr><tr><td colspan="3" align="left">审批标题</td></tr><tr><td colspan="3" align="left"><input type="text" value="下发节目单" id="sp_title" /></td></tr><tr><td colspan="3" align="left">审批内容</td></tr><tr><td colspan="3" align="left"><textarea id="sp_content" style="width:380px; height:80px; border:1px #ccc solid;">给终端下发节目单:'+pn+'</textarea></td></tr></table>';
		str='<table style="vertical-align:top; font-size:14px; width:100%" align="center"><tr><td id="shengpi_user">'+ui+'</td></tr><tr><td  align="center"><table align="center" border="0" cellspacing="0" cellpadding="0"><tr><td><a href="javascript:submitShengpiInfo()" id="shSubmit"   class="abtn_left"><span class="abtn_right">提  交</span></a></td></tr></table></td></tr></table><input name="shState" id="shState" value="" type="hidden" />';
	bug("审批UI","<textarea style='width:100%; height:100px;'>"+str.replace(/textarea/g,"txtarea")+"</textarea>");
	//_("shengpi_user").innerHTML=ui;
	
	art.dialog({
		id:'shengPiUiWin',
		width:420,
    content: str,
    skin: 'chrome',
	lock:true
	});
	
	
	
}
function closeShengpi()
{
	art.dialog.get("shengPiUiWin").close();
}
function changeArtInfo(id,str,img)
{
	if(img){img='<img src="'+img+'" width="50" height="50" border="0" />';}
	else{img="";}
	var st='<table width="100%" border="0" cellspacing="0" cellpadding="0">'
			  +'<tr>'
			    +'<td>&nbsp;</td>'
			    +'<td>&nbsp;</td>'
			    +'<td>&nbsp;</td>'
			  +'</tr>'
			  +'<tr>'
			    +'<td>&nbsp;</td>'
			    +'<td><table width="100%" border="0" height="50" cellspacing="0" cellpadding="0">'
			  +'<tr>'
			    +'<td>'+img+'</td>'
			    +'<td>'+str+'</td>'
			  +'</tr>'
			+'</table>'
			+'</td>'
			    +'<td>&nbsp;</td>'
			  +'</tr>'
			  +'<tr>'
			    +'<td>&nbsp;</td>'
			    +'<td align="center"  >'
				+'<table border="0"  align="center" cellspacing="0" cellpadding="0"><tr><td id="controlButtonContainer"><a href="javascript:void(0)" id="firPage1" onclick="closeArt()"  class="abtn_left"><span class="abtn_right">关闭</span></a></td></tr></table>'
			+'</td>'
			    +'<td>&nbsp;</td>'
			  +'</tr>'
			+'</table>';
			
	art.dialog.get(id).content(st);
}
function closeArt(id){art.dialog.get(id).close();}
function submitShengpiInfo()
{
	
	var collectionId=radioGroupValue("shengpi_ui").value;
	var playList=_("playList").value;
	var clientID=getClientID();
	var err=0;
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
			bug("提交审批信息","collectionId:"+collectionId+"<br>  playList:"+playList+"<br> clientID:"+clientID+"<br> title:"+sp_title+"<br>sp_content:"+sp_content);
			var info='{"playList":"'+playList+'","clientID":"'+clientID+'","collectionId":"'+collectionId+'","title":"'+sp_title+'","content":"'+sp_content+'"}';
			var ajax = new AJAXRequest();
			ajax.timeout=300000;
			ajax.ontimeout=function(e) 
			{
				changeArtInfo("shengPiUiWin","请求超时");
			}
			
			ajax.onexception=function(e) 
			{
				changeArtInfo("shengPiUiWin","您的请求失败");
				
			}
			
			ajax.post("index.php?control=remind&action=insertRemind","arg="+info, function(obj)
			{
				var st=obj.responseText;
				bug("服务器返回的信息",st,"green");
					st=eval("("+st+")");
				 if(st["state"]=="true")
				 {
					 changeArtInfo("shengPiUiWin",st["serverInfo"]);
				 }
				if(st["state"]=="false")
				 {
					 changeArtInfo("shengPiUiWin",st["errorInfo"]);
				 }
			});
	}
}
//--------------------------------
//- 远程监控 获取上线的终端的信息
//--------------------------------
function getOnlineClient(){
	var client=new Array();
	var str="",cli="",i=0;
	var c=_name("clientID");
	for(var a=0,n=c.length; a<n; a++)
	{
		if(c[a].checked)
		{
			var itmTr=getParentNode(getParentNode(c[a]));
			//alert(itmTr.tagName);
			cli=getChildNodes(itmTr);
			//alert(cli.length)
			str=html(cli[9]);
			bug("被选中的终端行信息",cli.length+"<br>上线的状态:"+str);
			if(str=="上线")
			{
				client.push({
							id:c[a].value,
							group:html(cli[2]),
							desc:html(cli[3]),
							playlist:html(cli[4]),
							screenRes:html(cli[5]).length<7? "1024x768" : html(cli[5]),
							type:html(cli[6]),
							mac:html(cli[7]),
							ip:html(cli[8]),
							state:str
							});
				bug("被选中上线的终端行信息",print_r(client[i]));
				i++;
			}
			
		}
	}
	return client;
}

/*☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆
☆	
☆		终端预览
☆
☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆*/
//获取被预览上线终端的信息
function getViewClient()
{
	var ol=getOnlineClient();
	var s="",c="";
	if(ol.length>0)
	{
		for(var i=0,n=ol.length; i<n; i++)
		{
			c=ol[i];
			s+='{"id":"'+c.ip+'","screenRes":"'+c.screenRes+'","desc":"'+c.desc+'"}';
			if(i!=n-1)
			{s+=",";}
		}
	}
	
	return '['+s+']';
}
//view online Client
function viewClient()
{
	var check=getClientID();	
	if(check.length<1)
	{
		alert("您没选择终端!");
		return false;
	}
	var str=getViewClient();
	if(str.length<3)
	{
		alert("您没选择终端或者您选择的终端没上线!");
		return false;
	}
	bug("提交监控信息",str);
	var cl=eval(str);
	
	var w=100,h=100;
	var scrn=(cl[0]).screenRes;
	wh=(scrn==""?"1024x768":scrn).split("x");
	w=wh[0]/2;
	h=wh[1]/2;
	
	art.dialog({
		title:"您正在监控终端 "+(cl[0]).desc,
		id:'viewClient',
		width:w,
		height:h+20,
    content: "信息加载中......",
    skin: 'chrome',
	lock:true
	});
	setTimeout(function(){
		with(art.dialog.list["viewClient"])
		{
			size(w,h+20);
			content('<iframe style="display:block; width:'+w+'px; height:'+h+'px; overflow:hidden"  src="index.php?control=vncView&action=viewVnc&str='+encodeURIComponent(str)+'" frameborder="0" allowtransparency="true"></iframe>');
			position();
		}
		},200);
}

/*☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆
☆	
☆		
☆
☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆*/

//*************************************************************************************************
//
// 终端筛选        开始
//
//*************************************************************************************************



function getNowGroup(userGp,gName,gNode)
{
	var info="";
	for(var a in userGp)
	{
		var skk=userGp[a]["TreeNodeCode"];
		bug("getNowGroup function",userGp[a]["TreeNodeCode"]+"-----------"+gNode);
		if(userGp[a]["TreeNodeCode"]==gNode)
		{
			bug("getNowGroup return userGp",print_r(userGp[a]));
			info= userGp[a];
			break;
		}
		else if(userGp[a]["child"])
		{
			info= getNowGroup(userGp[a]["child"],gName,gNode);
			if(info!=""){break;}
		}
	}
	return info;
}

function selectClient()
{
	var clientInfo=userClientSouce["clientInfo"];
	var j = 0,k=0;
	var clientname='';
	var clientip='';
	var clienttype='';
	var clientplaylist='';
	var clientaddress='';
	var clientUserID='';
	var displaysize='';
	var clientstate='';
	var selectFTP='';
	var selstr = new Array();
	var newClientInfo=new Array();
	if(_('txt_clientname'))
	{
	     //alert("进入:"+_('txt_clientname').value);
	     clientname=_('txt_clientname').value;
		 clientip=_('txt_clientip').value;
		 clienttype=_('txt_clienttype').value;
		 clientplaylist=_('txt_clientplaylist').value;
		 clientaddress=_('txt_clientaddress').value;
		 clientUserName=_('txt_clientUserName').value;
		 displaysize=_('txt_displaysize').value;
		 selectFTP = _('selectFTP').value;
		 //clientstate=_('clientstate').value;
		if(clientname != ''){selstr[j] = "clientname";j++;}
		if(clientip != ''){selstr[j] = "clientip";j++;}
		if(clienttype != ''){selstr[j] = "clienttype";j++;}
		if(clientplaylist != ''){selstr[j] = "clientplaylist";j++;}
		if(clientaddress != ''){selstr[j] = "clientaddress";j++;}
		if(clientUserName != ''){selstr[j] = "clientUserName";j++;}
		if(displaysize != ''){selstr[j] = "displaysize";j++;}
		if(selectFTP != '0'){selstr[j] = "selectFTP";j++;}
	}
	for(var i=0;i<clientInfo.length;i++)
	{
		var isok = 1;
		for(var p=0;p<selstr.length;p++)
		{
			if(!clientInfo[i].clientAddress)clientInfo[i].clientAddress="null"; 
			if(!clientInfo[i].clientDisPlaySize)clientInfo[i].clientDisPlaySize="null"; 
		  switch(selstr[p])
		  {
			   case "clientname":
				 if(clientInfo[i].clientName.indexOf(clientname)<0){isok=0;}
				 break;
			   case "clientip":
				 if(clientInfo[i].clientIP.indexOf(clientip)<0) {isok=0;}
				 break;
			   case "clienttype":
				 if(clientInfo[i].clientType!=clienttype) {isok=0;}
				 break;
			   case "clientplaylist":
				 if(clientInfo[i].clientPlaylistInfo.indexOf(clientplaylist)<0) { isok=0; }
				 break;
			   case "clientaddress":
				 if(clientInfo[i].clientAddress.indexOf(clientaddress)<0) {isok=0; }
				 break;
			   case "clientUserName":
				 if(clientInfo[i].clientUserName.indexOf(clientUserName)<0)
				 {  isok=0; }
				 break;
			   case "displaysize":
				 if(clientInfo[i].clientDisPlaySize.indexOf(displaysize)<0) { isok=0; }
				 break;
			   case "clientstate":
				 if(clientInfo[i].clientStatus!=clientstate) {isok=0; }
				 break;
			   case "selectFTP":
				 if(clientInfo[i].clientFTP!=selectFTP) {isok=0; }
				 break;
		  }
		 if(isok==0) {  break; }
		}
		if(isok==0){ continue;}
		newClientInfo[k]=clientInfo[i];
		k++;
	}
	
	if(_('seldialog'))
	{
	   art.dialog.get('seldialog').close();
	}
	var obj_clientInfo=createrClientList(newClientInfo);
	var str=obj_clientInfo["str_client"];
	showClientList(str,newClientInfo.length);
}

function createrGroupList(newGroupInfo){
	var str='',a=0,info="";
	for(var i in newGroupInfo)
	{
		//str='<span class="c_checkBox"><input type="checkbox"  ctype="1" info="'+info+'" name="groupID" value="'+newGroupInfo[i].TreeNodeCode+'"/>'
		str='<button  type="button"  style="width:50px;vertical-align:middle" id="checkAll" onclick=checkGroup(this,"clientID") title="全"  name="groupID" value="'+newGroupInfo[i].TreeNodeCode+'">'
		str+='选择组</button >';
	}
	return str;
}

function createrClientList(newClientInfo)
{
	
	var str='',a=0,info="";
	for(var i in newClientInfo)
	{
		//alert(newClientInfo[i].tos());
		info="{'clientNodeCode':'"+newClientInfo[i].clientNodeCode+"'}";
		pNode=newClientInfo[i].clientNodeCode.slice(0,-4);
		str=str+'<a href="javaScript:void(0);" class="'+(a%2==0?"client_list":"client_list_j")+'" id="a_'+newClientInfo[i].clientNum+'">';
		//str=str+'<div style"border:0; width:100%;cellpadding:0;cellspacing:1" class="t_ccontent">';
		newClientInfo[i].isChecked ?
		str=str+'<span class="c_checkBox"><input state="unline" checked="checked" onclick="device_checkbox_click(this)" type="checkbox" pNode="'+pNode+'" rowId="'+newClientInfo[i].clientNodeCode+'" ctype="1" info="'+info+'" name="clientID" value="'+newClientInfo[i].clientNum+'"/></span>':
		str=str+'<span class="c_checkBox"><input state="unline" type="checkbox" onclick="device_checkbox_click(this)" pNode="'+pNode+'" rowId="'+newClientInfo[i].clientNodeCode+'" ctype="1" info="'+info+'" name="clientID" value="'+newClientInfo[i].clientNum+'"/></span>';
		newClientInfo[i].isOnLine ?
		str=str+'<span class="c_bhao" id="_id_'+newClientInfo[i].clientNum+'"><span id="imgID'+newClientInfo[i].clientNum+'"><img src="Skin/web/skin/on.gif"/ border="0"></span>'+(a+1)+'</span>' :
		str=str+'<span class="c_bhao" id="_id_'+newClientInfo[i].clientNum+'"><span id="imgID'+newClientInfo[i].clientNum+'"><img src="Skin/web/skin/down.gif"/ border="0"></span>'+(a+1)+'</span>';
				//' <img onclick="tab_hid(\'div'+newClientInfo[i].clientNum+'\',\'img'+newClientInfo[i].clientNum+'\');" id="'+'img'+newClientInfo[i].clientNum+'" src="Skin/web/skin/tab_hid1.jpg"/></span>';
        str=str+'<span class="c_fzu">'+newClientInfo[i].clientGroupName+'</span>';
        str=str+'<span clientID="'+newClientInfo[i].clientNum+'" class="c_mshu" ondblclick="createInput(event)">'+newClientInfo[i].clientName+'</span>';
        str=str+'<span class="c_bbiao">'+newClientInfo[i].clientProfile+'</span>';
		str=str+'<span class="c_zfbl">'+newClientInfo[i].clientScreenResolution+'</span>';
        str=str+'<span class="c_zlxin">'+newClientInfo[i].clientType+'</span>';
        str=str+'<span class="c_zmac">'+newClientInfo[i].clientAddress+'</span>';
        str=str+'<span class="c_zip">'+newClientInfo[i].clientIP+'</span>';
		newClientInfo[i].isOnLine ?
				str=str+'<span class="c_ztai" id="clientID'+newClientInfo[i].clientNum+'">上线</span>' :
        str=str+'<span class="c_ztai" id="clientID'+newClientInfo[i].clientNum+'">下线</span>';
		//$("#aID"+client_ID).html("<a href=index.php/socket/getFilesInfo/"+client_ID+" target=_blank>文件</a>");
		newClientInfo[i].isOnLine ?
        str=str+'<span class="c_zjbcz"><label style="color:blue;" id="rz'+newClientInfo[i].clientNum+'" onclick="clientManage.readRiZhi('+newClientInfo[i].clientNum+',\''+newClientInfo[i].clientName+'\')" >日志</label>|' +
				'<label style="color:blue;" id="aID'+newClientInfo[i].clientNum+'" onclick="clientManage.readFile('+newClientInfo[i].clientNum+')">文件</label></span>': //|<label id="aID'+newClientInfo[i].clientNum+'" onclick="getScreenshotPhoto(\''+newClientInfo[i].clientFTP+'\',\''+newClientInfo[i].clientMac+'\')">屏幕截图</label>
        str=str+'<span class="c_zjbcz"><label style="color:blue;" id="rz'+newClientInfo[i].clientNum+'" onclick="clientManage.readRiZhi('+newClientInfo[i].clientNum+',\''+newClientInfo[i].clientName+'\')" >日志</label>|<label id="aID'+newClientInfo[i].clientNum+'">文件</label> </span>'; //|<label id="aID'+newClientInfo[i].clientNum+'" onclick="getScreenshotPhoto(\''+newClientInfo[i].clientFTP+'\',\''+newClientInfo[i].clientMac+'\')">屏幕截图</label>
		str=str+'<span  class="c_zspeed"  id="speed_'+newClientInfo[i].clientNum+'">'+newClientInfo[i].Extend3+'</span>';
		//str=str+'</div>';
		str=str+'</a>';
		str=str+"<div width='100%' id=\"div"+newClientInfo[i].clientNum+"\" style='display:none'>";
		str=str+'<table width="100%">';
		
		str=str+"<tr><td>播放计划: "+newClientInfo[i].clientPlaylistInfo+" </td><td> 运维人: "+newClientInfo[i].clientUserName;
		str=str+" </td><td>Mac地址: "+newClientInfo[i].clientMac+" </td><td> 显示屏尺寸: "+newClientInfo[i].clientDisPlaySize+"</td></tr><tr><td colspan='4'>备注: ";
        str=str+newClientInfo[i].clientRemark+"</td></tr></table>";
		str=str+'</div>';
		a++
	}
	return {str_client:str,int_a:a};
}
function clientInfoToTreeGrid(){
	var userGroup=userClientSouce["userGroup"];
	var clientInfo=userClientSouce["clientInfo"];
	//treeGridData

}

function getClientInfoBySelect(group,groupNode){
	//var type=_('clientType').value;

	var userGroup=userClientSouce["userGroup"];
	var clientInfo=userClientSouce["clientInfo"];
	if(!group)
	{
		var group=_('groupName').value;
		var groupNode=selectInfo('groupName');
		groupNode=attr(groupNode.obj,"title");
		
	}
	else
	{
		userGroup=[getNowGroup(userGroup,group,groupNode)];
		//if(!userGroup[0]){alert("此终端组中没有终端");return false;}
		bug("--getNowGroup--",print_r(userGroup));
	}
	var newClientInfo=new Array();
	
	var k=0;
	
	for(var i=0;i<clientInfo.length;i++)
	{
	    if(clientInfo[i].clientGroupName==group)
		{
			newClientInfo[k]=clientInfo[i];
			k++;
		}
	}
	
	var obj_clientInfo =createrClientList(newClientInfo);
	var str=obj_clientInfo["str_client"];
	var a=obj_clientInfo["int_a"];
	var str_r=getGroup(userGroup,groupNode,a);
	str+=str_r;
	//showClientList(str,newClientInfo.length);
	getClientCountOfGroup(groupNode);
}
function showClientList(str_clientList,int_clientCount)
{
	html("clientInfo",str_clientList);
	//跟新分组中的终端数
	//html("onlineClientTotal",0);
	html("clientTotal",userClientSouce["clientInfo"].length); 
	//_("clientTotalhidden").value=int_clientCount;
	//html("unlineClientTotal",int_clientCount);
	//注册双击修改名称
	//bindClick();
	//无终端返回
	if(!int_clientCount){return false;}
	//刷新终端状态
	getClientStatusNotAuto();
}

//-----------------
//- 创建终端组list
//-----------------
function getGroup(userGroup,groupNode,a)
{
	var str='';
	for(var b in userGroup)
	{
		bug("===========",userGroup[b]["TreeNodeCode"]+"======="+groupNode);
		if(userGroup[b]["TreeNodeCode"]==groupNode)
		{
			//显示当前节点名称 在节点树横向路径中
			treePathManage(groupNode,userGroup[b]["TreeName"],userGroup[b]["TreeNum"]);
			//bug("----------",userGroup[b]["child"].length);
			if(userGroup[b]["child"].length>0)
			{
				var chl=userGroup[b]["child"],info="";
				for(var c in chl)
				{
					info="{'clientNodeCode':'"+chl[c]["TreeNodeCode"]+"'}";
					str=str+'<a href="javaScript:void(0);" ondblclick="getClientInfoBySelect(\''+chl[c]["TreeName"]+'\',\''+chl[c]["TreeNodeCode"]+'\');getClientCountOfGroup(\''+chl[c]["TreeNodeCode"]+'\');" class="'+(a%2==0?"group_list":"group_list_j")+'" id="a_'+chl[c]["TreeName"]+'">';
					//str=str+'<div style"border:0px;width:100%;cellpadding:0;cellspacing:1"class="t_ccontent">';
					str=str+'<span class="c_checkBox"><input state="unline" ctype="0" info="'+info+'" type="checkbox" name="clientID" value="'+chl[c]["TreeNum"]+'"/></span>';
					str=str+'<span class="c_bhao" id="_id_'+chl[c]["TreeNum"]+'"><span id="imgID'+chl[c]["TreeNum"]+'"><img src="Skin/default/group.png" width="20" height="20" border="0"></span></span>';
					str=str+'<span class="c_fzu" >'+chl[c]["TreeName"]+'</span>';
					str=str+'<span class="c_mshu c_zhoZu">终端组</span>';
					str=str+'<span class="c_bbiao">&nbsp;</span>';
					str=str+'<span class="c_zfbl">&nbsp;</span>';
					str=str+'<span class="c_zlxin">&nbsp;</span>';
					str=str+'<span class="c_zmac">&nbsp;</span>';
					str=str+'<span class="c_zip">&nbsp;</span>';
					str=str+'<span class="c_ztai">&nbsp;</span>';
					str=str+'<span class="c_zjbcz">&nbsp;</span>';
					str=str+'<span  class="c_zspeed">&nbsp;</span>';
					//str=str+'</div>';
					str=str+'</a>';
					a++;
				}
				
			}

		}
		
	}
	return str;
}
//--------------------------
//-
//- 计算某个组下面的终端总数  郁闷目前不使用
//-
//--------------------------
function getClientCountOfGroup(groupCode)
{
	return true;
	var clientInfo=userClientSouce["clientInfo"];
	var k=0;
	var array_clientId=[];
	for(var i=0;i<clientInfo.length;i++)
	{
		bug("getClientCountOfGroup",clientInfo[i].clientNodeCode.indexOf(groupCode));
	    if(clientInfo[i].clientNodeCode.indexOf(groupCode)==0)
		{
			array_clientId.push(clientInfo[i].clientId);
			k++;
		}
	}
	//saveCurrentClient(array_clientId.join(","));
	//html("onlineClientTotal",0);
	html("clientTotal",k); 
	_("clientTotalhidden").value=k;
	html("unlineClientTotal",k);
}
//---------------------
//- 终端树横向路径
//---------------------
function treePathManage(code,name,id)
{
	//检测节点是否存在
	var ns=getChildNodes("treePath_con","a");
	var b_node=false;
	for(var i in ns)
	{
		//已存在就退出
		if(attr(ns[i],"tname")==name&&attr(ns[i],"tcode")==code)
		 {
			 return ;
		 }
	}
	var str_jianTou='<span class="treePath_jt">▶</span>';
	if(getFirstChild("treePath_con"))
	{
		var str_treePathNode='<a href="javascript:void(0)" tname="'+name+'" tcode="'+code+'" class="treePath_sty" onclick="delCurrentNodePath(this);getClientInfoBySelect(\''+name+'\',\''+code+'\')">'+str_jianTou+'<span class="treePath_nodeAame">'+name+'</span></a>';
		insertHTML(_("treePath_con"),"beforeend",str_treePathNode);
	}
	else
	{
		var str_treePathNode='<a href="javascript:void(0)" tname="'+name+'" tcode="'+code+'" onclick="delCurrentNodePath(this);getClientInfoBySelect();" class="treePath_sty"><span class="treePath_nodeAame">'+name+'</span></a>';
		insertHTML(_("treePath_con"),"beforeend",str_treePathNode);
	}
	/*<a href="javascript:void(0)" class="treePath_sty"><span class="treePath_nodeAame">分组徜徉</span><span class="treePath_jt">▶</span></a>*/
}


//点击节点路径时候,删除子节点路径 和 自身
function delCurrentNodePath(o)
{
	var ns=getChildNodes("treePath_con");
	var i_key="";
	for(var i in ns)
	{
		if(ns[i]==o)
		{
			bug("delCurrentNodePath","i_key:"+i);
			i_key=i;
		}
		else
		{
			if(i_key!=""&&i_key<i)
			{
				bug("delCurrentNodePath i_key < I","i_key: "+i_key+"<------>I: "+i);
				_("treePath_con").removeChild(ns[i]);
			}
		}
	}
	i_key==""?_("treePath_con").innerHTML="":'';
}

//共下拉选框 调用
function  changeCurrentNodePath(o)
{
	var o_info=selectInfo(o);
	var str_name=o_info.value;
	var str_code=attr(o_info.obj,"title");
	var ns=getChildNodes("treePath_con","a");
	var b_node=false;
	for(var i in ns)
	{
		 bug("changeCurrentNodePath","tname: "+attr(ns[i],"tname")+"-----str_name: "+str_name+"        tcode: "+attr(ns[i],"tcode")+"------str_code: "+str_code);
		 if(attr(ns[i],"tname")==str_name&&attr(ns[i],"tcode")==str_code)
		 {
			 b_node=true;
			 delCurrentNodePath(ns[i]);
		 }
	}
	b_node?'':delCurrentNodePath(o);getClientInfoBySelect();
	
}

function reqtimeout(str){
	if(!str)str="请求超时！";
	if(document.getElementById("_alert_id")){
		document.getElementById("_alert_id").style.display="";
		document.getElementById("_alert_id").innerHTML=str;
		var stime = setInterval(function(){document.getElementById("_alert_id").style.display="none";clearTimeout(stime);},5000);
	}
}
//*************************************************************************************************
//
// 终端筛选    结束
//
//*************************************************************************************************


function getScreenshotPhoto(str_ftpId,str_mac)
{
	if(str_ftpId=="")
	{
		alert("您的终端没有分配FTP服务器");
		return ;
	}
	str_mac=str_mac.replace(/:/g,"");
	bug("getScreenshotPhoto",str_ftpId+"\n"+str_mac);
	art.dialog({
	title:"截图文件列表",
		id:'ScreenshotPhoto',
		width:800,
    content: "加载中......",
    skin: 'chrome',
	lock:true
	});
	var ajax = new AJAXRequest();
	ajax.timeout=300000;
	ajax.ontimeout=function(e) 
	{
		changeArtInfo("ScreenshotPhoto","请求超时");
	}
	
	ajax.onexception=function(e) 
	{
		changeArtInfo("ScreenshotPhoto","您的请求失败");
		
	}
	
	ajax.post("index.php?control=c_clientControl&action=getScreenshotPhoto",'arg={"clientFTP":"'+str_ftpId+'","clientFolder":"'+str_mac+'"}', function(obj)
	{
		var st=obj.responseText;
		bug("服务器返回的信息",st,"green");
		st=eval("("+st+")");
		if(st.state=="false")
		{art.dialog.get("ScreenshotPhoto").content(st.error);return ;}
		
		var str_list='<a href="javascript:void(0)" class="screenshotList" ><table width="100%" border="0" cellspacing="0" cellpadding="0" class="screenshot_table">'
					  +'<tr valign="center"  align="left">'
						+'<td class="screenshot_checkbox" ><input type="checkbox" name="screenshot_checkbox"  /></td>'
						+'<td class="screenshot_name">文件名称</td>'
						+'<td class="screenshot_size">文件大小</td>'
						+'<td class="screenshot_time">截图时间</td>'
						+'<td class="screenshot_clientname">终端名称</td>'
						+'<td class="screenshot_toolbar">操作</td>'
					  +'</tr>'
					+'</table></a>';
		var obj_time="",str_time="",str_fileurl=st.path;
		
		st=st.files;
		for(var i=0,n=st.length; i<n; i++)
		{
			obj_time=new Date(parseInt(st[i].name.replace(/.jpg/g,""))*1000);
			str_time=obj_time.getFullYear()+"-"+(obj_time.getMonth()*1+1)+"-"+obj_time.getDate()+" "+obj_time.getHours()+":"+obj_time.getMinutes()+":"+obj_time.getSeconds();
			str_list+='<a href="javascript:void(0)" class="screenshotList" >'
					+'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="screenshot_table">'
					  +'<tr valign="center"  align="left">'
						+'<td class="screenshot_checkbox"><input type="checkbox" name="screenshot_checkbox"  /></td>'
						+'<td class="screenshot_name">'+st[i].name+'</td>'
						+'<td class="screenshot_size">'+st[i].size+'</td>'
						+'<td class="screenshot_time">'+str_time+'</td>'
						+'<td class="screenshot_clientname">'+st[i].size+'</td>'
						+'<td class="screenshot_toolbar"><label onclick="viewScreenshotPhoto(\''+str_fileurl+st[i].name+'\',\''+st[i].name+'\')">查看</label></td>'
					  +'</tr>'
					+'</table>'
					+'</a>';
		}
		art.dialog.get("ScreenshotPhoto").content(str_list);
	});
}

function viewScreenshotPhoto(str_url,str_name)
{
	art.dialog({
		id:'viewScreenshotPhoto',
		title:str_name,
		width:clientWidth(document),
		height:clientHeight(document),
    content: "<img src='"+str_url+"' border='0' />",
    skin: 'chrome',
	lock:true
	});
	window.clearTimeout(window.setTimeout(function(){art.dialog.get("viewScreenshotPhoto").position();},500));
}


var tip={
	tipInfo:{defaultState:true},
	tip:function(info){
		if(info["title"]){title=info["title"];}
		else
		{title="消息";}
		if(info["id"]){id=info["id"];}
		else
		{id="defalut_tip";}
		if(info["message"]){message=info["message"];}
		else
		{message="";}
		if(info["stateClose"]){stateClose=info["stateClose"];}
		else
		{stateClose=tip.tipInfo.defaultState;}

	
		message='<table width="300"><tr><td width="100"><img src="/CI/Skin/default/u_loading.gif" /></td><td  width="100%" id="'+id+'_con">'+message+'</td></tr></table>';
			art.dialog({
				id:id,
				title:title,
				content:message,
				width:400,
				lock:true,
				close:function(){return tip.tipInfo[stateClose];}
			});
	},
	tipClose:function(id){
		if(id==null){id="defalut_tip";}
		art.dialog.list[id].close();
	},
	change:function(mes,id){
		if(id==null){id="defalut_tip";}
		art.dialog.list[id].content(mes);
	},
	tipTime:function(tm,id){
		if(id==null){id="defalut_tip";}
		art.dialog.list[id].time(tm);
	}
};

var clientManage={
	clients:[],
	clientGroup:[],
	setClientOffLine:function(onlineArr){
		
	},
	checkNewClientOnLine:function(onlineArr){
		if(clientManage.clients.length<onlineArr.length){
			bug("checkNewClientOnLine",clientManage.clients.length+"====="+onlineArr.length);
			window.location.reload();
			return true;
		}
		var cacheClients=clientManage.clients,state=false;
		for(var i =0, n=onlineArr.length; i<n; i++){
			state=false;
			for(var a=0, b=cacheClients.length; a<b; a++){
				if(cacheClients[a]["clientNum"]==onlineArr[i]["clientID"]){
					state=true;
					clientManage.clients.online=true;
				}
			}
			if(!state){
				bug("checkNewClientOnLine",onlineArr[i]["clientID"]);
				window.location.reload();
				return true;
			}
		}
		
	},
	readRiZhi:function(clientId,clientName){
		art.dialog.open('index.php?control=client&action=getClientLogs&client_id='+clientId, {title: '终端->'+clientName+"日志",resize:false,drag:false,lock:true,width:"95%",height:"95%"});
	},
	readFile:function(clientId,clientName){
		art.dialog.open('index.php?control=socket&action=getFilesInfo&client_id='+clientId, {title: "终端文件",resize:false,drag:false,lock:true,width:"95%",height:"95%"});
	}
};

clientManage.updateUi={
	updatePlayListToClient:function(playListName){
		$("input[name='clientID']").each(function(index, element) {
            if(element.checked)
			{
				$(element).parent().parent().children(".c_bbiao").html(playListName);
			}
        });
	}
};