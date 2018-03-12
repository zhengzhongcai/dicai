// JavaScript Document
(function(){
    var d = art.dialog.defaults;
    d.skin = [ 'chrome'];
    d.drag = true;
    d.showTemp = 100000;
})();
function initStart()
{
	var pro = gerProObj();
	if(pro.length<1)
	{
	//	art.dialog.get("creProUi").close();
		 art.dialog({
		 id:"creProUia",
		 icon:"error",
		 title:"节目创建信息",
		 content:'根据您的Excel无法生成任何的节目单和节目列表!<br>请重新上传正确地Excel文件!',
		 skin: 'chrome',
		 yesFn:function(){
			this.close();
			window.location.href=document.getElementsByTagName("base")[0].href+"index.php/playlist/addPlayListByExcel/" + goToPath;
			},noFn:true
		}
		);
	}
	else{
	 art.dialog({
		 id:"creProUia",
		 title:"节目创建信息",
		 content:'您是否开始创建节目单?',
		 skin:'chrome',
		 yesFn:function(){
			createProInCon();
			startPost();},
		 noFn:true,
		 lock:true
	 });
	}
}
function startPost()
{
			var pro = gerProObj();
			//If Variable index is equal to the total number of Variable pro,it is over
			var index=parseInt(_("ProfileIndex").value);
			if(index==pro.length)
			{
				art.dialog.get("creProUi").content("您的所有播放单元创建完成!");
				//create playlist now
				createPlaylist();
				return false;
			}
			var profileInfo=getprofileInfo();
			var globalInfo=formatProInf(profileInfo);
			if(typeof(global)=="array")
			{
				alert(global[0]);
				return false;
			}
			setTimeout(function(){postInfo(globalInfo.g,profileInfo,globalInfo.t);},2000);	
}
function showInfo(str)
{
	 art.dialog({
		    id: "creProUi",
		 title: "节目创建信息",
	   content: '您的节目单 "'+str+'" 正在创建,请稍等!',
		  skin: 'chrome'
	 });
}
//get HTMLElement container for Profile
function gerProObj()
{
	var pro=_tg("td","type=profile");
	//alert(pro.length);
	//bug("the total number of the profile container",pro.length);
	return pro;
}

function getprofileInfo()
{
	var pro = gerProObj();
	var index=parseInt(_("ProfileIndex").value);
	//get first profile information container
	var cp=pro[index];
	var p_file=decodeURIComponent((getChildNodes(cp,"p")[0]).innerHTML);
	//print profile info
	//bug("profile Info:","profile files info:"+p_file);
	//postInfo(p_gol,p_file);
	return p_file;
}

//-------------------------------------
//	format profile information
//-------------------------------------
function formatProInf(p_file)
{
	var pro_info=eval("("+p_file+")");
	//bug("profile object info",print_r(pro_info));
	var p_wh=pro_info["screen"].split("x");
	var Proportion=new templateProportion(p_wh[0]+"x"+p_wh[1],"X86");
	//获取缩放比例
	var pro=Proportion.checkPro();
	if(!pro){ return ["您的分辨率不对!"];}
	var profilePeriod=0,fls=pro_info["files"];
	
	for(var i=0,n=fls.length; i<n ; i++ )
	{
		profilePeriod+=parseInt(fls[i]["playTime"]);
	}
	var global='{"action":"import","em":"'+pro.em+'","profileName":"'+pro_info["name"]+'","profileType":"X86","profilePeriod":"'+profilePeriod+'","templateID":"3","touchJumpUrl":"","tempWidth":"'+p_wh[0]+'","tempHeight":"'+p_wh[1]+'","tempBgGround":"0"}';
	//bug("profile file information",global);
	var tempInfo='{"Scale":"'+pro.em+'","Type":"0","BgImg":"","Area":[{"BlockId":"1","left":"0","top":"0","width":"'+p_wh[0]+'","height":"'+p_wh[1]+'"}]}';
	return {g:global,t:tempInfo};
}
//------------------------------------
// post profile information to server
//------------------------------------
function postInfo(g,f,t)
{
	
			//测试使用
			// var str="__profileID__0__profileID__null";
			// var index=parseInt(_("ProfileIndex").value);
			// setpliInfo(str);
			// _("ProfileIndex").value=index+1;
			// return ;
			var pro = gerProObj();
			var index=parseInt(_("ProfileIndex").value);
			var p=getChildNodes(pro[index],"b")[0].innerHTML;
			if(art.dialog.get("creProUi"))
			{
				art.dialog.get("creProUi").content('您的节目单 "'+p+'" 正在创建,请稍等!');
			}
			else
			{
				showInfo(p);
			}
			
	//bug("创建Profile时候提交服务器的信息","global="+g+"<br>areaFile="+f+"<br>tempInfo="+t);
	var ajax = new AJAXRequest();
		ajax.timeout=300000;
		ajax.ontimeout=function(e) 
		{
			art.dialog({
				skin: 'chrome',
			id: 'timeOutUi',
			content: '你指定的信息,加载失败!<br>请求超时......'});
			ajax=null;
		}
		
		ajax.onexception=function(e) 
		{
			art.dialog({
				skin: 'chrome',
			id: 'serverError',
			content: '无法加载您需要的信息!'});
			ajax=null;
			
		}
		ajax.post("index.php/creProFroExc/getProfileInfo", 
		"global="+g+"&areaFile="+f+"&tempInfo="+t,
		function(obj)
		{
			var st=obj.responseText;
			var index=parseInt(_("ProfileIndex").value);
			//bug("服务器返回的Profile的详细信息",st+"<br>"+index,"green");
			var info=st.split("__profileID__");
			if(info.length>1)
			{
				var pro = gerProObj();
				var p=getChildNodes(pro[index],"b")[0].innerHTML;
				
				art.dialog.get("creProUi").content('您的播放单元"'+p+'"创建完成');
				setpliInfo(info[1]);
				_("ProfileIndex").value=index+1;
				ajax=null;
				setTimeout(function(){startPost();},1000);
			}
			else{ajax=null;}
		});
}
//------------------------------------
//store the profile id
//------------------------------------
function setpliInfo(id)
{
	var pro = gerProObj();
	var index=parseInt(_("ProfileIndex").value);
	var cp=pro[index];
	var lb=getChildNodes(cp,"label");
	html(lb[0],html(lb[0])+',"profileID":"'+id+'","prior":"1"');
	bug("lable",html(lb[0]));
	
}
//------------------------------------
//create HTMLElement store Profile index
//------------------------------------
function createProInCon()
{
	//Check hidden field exists, the container used to store the index of profile information
	if(!_("ProfileIndex"))
	{
		var d=document.createElement("INPUT");
		d.type="text";
		d.id="ProfileIndex";
		d.value=0;
		document.body.appendChild(d);
	}
}
//------------------------------------
// 
//------------------------------------
function getPlaylist()
{
	var pro = gerProObj();
	var lb="";
	var playListInfo="";
	for(var i=0,n=pro.length; i<n; i++)
	{
		lb=getChildNodes(pro[i],"label");
		playListInfo+='{'+html(lb[0])+'}';
		if(i!=n-1)
		{playListInfo+=",";}
	}
	return '['+playListInfo+']';
}
//------------------------------------
//create playList
//------------------------------------
function createPlaylist()
{
	art.dialog.get("creProUi").content("开始创建播放计划!");
	var playListInfo=getPlaylist();
	var ajax = new AJAXRequest();
		ajax.timeout=300000;
		ajax.ontimeout=function(e) 
		{
			art.dialog({
				skin: 'chrome',
			id: 'timeOutUi',
			content: '你指定的信息,加载失败!<br>请求超时......'});
			
		}
		
		ajax.onexception=function(e) 
		{
			art.dialog({
				skin: 'chrome',
			id: 'serverError',
			content: '无法加载您需要的信息!'});
			
		}
		ajax.post("index.php/creProFroExc/createplaylistinfo", 
		"playlistinfo="+playListInfo,
		function(obj)
		{
			var st=obj.responseText;
			bug("服务器返回的播放计划的详细信息",st,"green");
			if(trim(st)=="0")
			{
				art.dialog.get("creProUi").close();
				art.dialog({
				skin: 'chrome',
			id: 'errorInfo',
			content: '您的播放计划创建成功!',yesFn:function(){this.close();
			window.location.href=document.getElementsByTagName("base")[0].href+"index.php/playlist/addPlayListByExcel/"+goToPath;
			},noFn:true});	
			}
			else
			{
				art.dialog.get("creProUi").content("您的播放计划创建失败!");
			}
		});
}
ready(function(){
	initStart();
	});
	

