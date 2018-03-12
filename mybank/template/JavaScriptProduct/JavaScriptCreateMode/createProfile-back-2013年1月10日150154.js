
function addEventHandler(target, eventType, handler)
{
    if (target.addEventListener)
    {
        target.addEventListener(eventType, handler, false);
    }
    else if (target.attachEvent)
    {
        target.attachEvent("on" + eventType, handler);
    }
    else
    {
        target["on" + eventType] = handler;
    }
}
if (!window.attachEvent && window.addEventListener)
{
    window.attachEvent = HTMLElement.prototype.attachEvent = document.attachEvent = function (en, func, cancelBubble)
    {
        var cb = cancelBubble ? true : false;
        this.addEventListener(en.toLowerCase().substr(2), func, cb);
    };
    window.detachEvent = HTMLElement.prototype.detachEvent = document.detachEvent = function (en, func, cancelBubble)
    {
        var cb = cancelBubble ? true : false;
        this.removeEventListener(en.toLowerCase().substr(2), func, cb);
    };
}

function closeProfileNameUI()
{
    __closeCoverDiv(true, "bgImg_UI");
}
function closeTip_bord()
{
    program.tip.fileDragTipClose();
}

function removeInfo(fileId, curTargetId)
{
    try
    {
        _(fileId).removeChild(_(curTargetId));
        _("file_info").innerHTML = "";
    }
    catch (e)
    {
    }
}

var editor;

function createCkeditorUI(areaID)
{
    if (!attr(_("profile_name"), "cacheName"))
    {
        
        _("profile_name").setAttribute("cacheName", _("UserFolder").value)
    }
    if (attr(_("profile_name"), "cacheName") != "")
    {
        if (editor)
        {
            return;
        }
        var createCkeditor_div = "<div id=\"ckeditor_div\" style='width:900px; font-size:14px;display:none;' ><p align=\"left\">";
        createCkeditor_div += "<div class=\"clearfix\"><span style=\"float:left;margin-right:5px;\">网页模板类型：";
        createCkeditor_div += "<select id=\"cktype\" name=\"cktype\" onchange=\"cktypechange(this);\">"; //<option value=\"0\">静态文本</option><option  value=\"1\" >超文本</option>
        createCkeditor_div += "<option selected=\"selected\" value=\"2\">网页url</option></select></span><input id=\"ckurl\" name=\"ckurl\" ";
        createCkeditor_div += "type=\"text\" style=\"display:none;float:left;margin-right: 5px;\" /><span class=\"file\"><input style='' id=\"uprofile\" name=\"uprofile\"";
        createCkeditor_div += " type=\"file\" onchange=\"loadckurl(this)\" /></span></div></p>";
        createCkeditor_div += "<p align=\"left\">滚动方向：<select id=\"ckscroll\" name=\"ckscroll\"><option value=\"0\">静态</option>";
        createCkeditor_div += "<option value=\"1\">向上</option><option value=\"2\">向左</option></select>&nbsp;&nbsp;";
        createCkeditor_div += "<span id=\"ckbgId\">背景图片：<input id=\"ckbg\" name=\"ckbg\" type=\"file\" /></span></p>";
        createCkeditor_div += "<p align=\"left\">网页模板名称:<input id=\"ckfilename\" name=\"ckfilename\" type=\"text\" />&nbsp;&nbsp;";
        createCkeditor_div += "<input checked=\"checked\" name=\"\" type=\"checkbox\" value=\"1\" disabled=\"disabled\"/>上传在线编辑</p>";
        createCkeditor_div += "<div id=\"editor\"  ></div><input type=\"button\" value=\"确定\" onclick=\"saveck(" + areaID + ")\" />&nbsp;<span id=\"uploaderrmessage\"></span></div>";
        var DW = new DivWindow();
        var table = DW.myTable("../JavaScript", "createCkeditor_window");
        __createCoverDiv("ckeditor_UI");
        __content("ckeditor_UI").innerHTML = table;
        var tb = DW.tablePart("createCkeditor_window");
        tb.WindowBody.innerHTML = createCkeditor_div;
        tb.WindowBody.align = "center";
        tb.WindowTitle.align = "right";
        tb.WindowTitle.innerHTML = "<span style='font-size:12px;float:left;margin-top:3px;'>网页模板编辑</span><img style='cursor:pointer; margin-top:3px;' src='../../ceShi_Image/Close.gif' border=0 onclick=\"closeCkeditorUI()\" title='关闭小窗口' />";
       // editor = CKEDITOR.appendTo('editor');
     //   if (editor) _("ckeditor_div").style.display = "block";
	 _("ckeditor_div").style.display = "block";
		
		document.getElementById("ckeditor_div").style.width = "400px";
        document.getElementById("ckurl").style.display = "block";
        document.getElementById("uprofile").parentNode.style.display = "none";
        document.getElementById("ckfilename").parentNode.style.display = "none";
		 _("ckbgId").style.display = "none";
    }
}

function loadckurl(obj)
{
    if (window.navigator.userAgent.indexOf("MSIE") != -1)
    {
        readFileIE(obj);
    }
    else if (window.navigator.userAgent.indexOf("Firefox") >= 1)
    {
        if (obj.files)
        {
            var temps = obj.files.item(0).getAsText("gb2312");
            var temp = obj.value;
            _("ckfilename").value = temp;
            if (editor) editor.setData(temps);
            return;
        }
        alert("无法获取" + obj.value + "内容!");
    }
}

function cktypechange(obj)
{
    if (obj.options[obj.selectedIndex].value <= 1)
    {
        document.getElementById("ckeditor_div").style.width = "900px";
        document.getElementById("ckurl").style.display = "none";
        _("uprofile").parentNode.style.display = _("ckfilename").parentNode.style.display = "block";
        _("ckbgId").style.display = "inline";
        if (!editor)
        {
            editor = CKEDITOR.appendTo('editor');
        }
    }
    else
    {
        document.getElementById("ckeditor_div").style.width = "400px";
        document.getElementById("ckurl").style.display = "block";
        document.getElementById("uprofile").parentNode.style.display = "none";
        document.getElementById("ckfilename").parentNode.style.display = "none";
        _("ckbgId").style.display = "none";
        if (editor)
        {
            editor.destroy();
            editor = null;
        }
    }
}

function readFileIE(fileBrowser)
{
    var temps;
    try
    {
        var fso = new ActiveXObject("Scripting.FileSystemObject");
        var fileName = fso.GetAbsolutePathName(fileBrowser.value);
        if (!fso.FileExists(fileName))
        {
            alert("File '" + fileName + "' not found.");
            return;
        }
        var file = fso.OpenTextFile(fileName, 1);
        temps = file.ReadAll();
        alert("Data from file: " + temps);
        var regstr = /\\/;
        var regresult = new RegExp(regstr);
        var sss = fileBrowser.value.split(regresult, '100');
        var need = sss[sss.length - 1];
        _("ckfilename").value = need;
        if (editor) editor.setData(temps);
        file.Close();
    }
    catch (e)
    {
        if (e.number == -2146827859)
        {
            alert('Unable to access local files due to browser security settings. To overcome this, go to Tools->Internet Options->Security->Custom Level. Find the setting for "Initialize and script ActiveX controls not marked as safe" and change it to "Enable" or "Prompt"');
        }
        else if (e.number == -2146828218)
        {
            alert("Unable to access local file '" + fileName + "' because of file permissions. Make sure the file and/or parent directories are readable.");
        }
        else throw e;
    }
}

function closeCkeditorUI()
{
    if (editor)
    {
        editor.destroy();
        editor = null;
    }
    __closeCoverDiv(true, "ckeditor_UI");
}

function saveck(areaID)
{
    if (document.getElementById("cktype").options[document.getElementById("cktype").selectedIndex].value == 2)
    {
        createUrlDiv2(_("ckurl").value, areaID);
    }
    else
    {
        var utype = "Url2";
        if (document.getElementById("cktype").options[document.getElementById("cktype").selectedIndex].value == 1)
        {
            utype = "Url1";
        }
        if (!editor)
        {
            alert("在线编辑器不存在!");
            return;
        }
        if (editor.getData().replace(/^\s+|\s+$/g, "") && _("ckfilename").value.replace(/^\s+|\s+$/g, ""))
        {
            var ckneed = "";
            if (_("ckbg").value != "")
            {
                var ckarr = _("ckbg").value.split(/\\/);
                ckneed = ckarr[ckarr.length - 1];
                var cka = ckneed.split(".");
                if ("jpg gif".indexOf(cka[1]) < 0)
                {
                    alert("使用jpg和gif格式的图片作为背景");
                    _("ckbgId").innerHTML = "背景图片：<input id=\"ckbg\" name=\"ckbg\" type=\"file\" />";
                    return;
                }
            }
            var myajax = new DedeAjax(_("myinfo"), true, uploadInfo);
            myajax.rtype = "xml";
            var Ckie = new Cookie();
            var folderName = Ckie.Read("userName");
            myajax.SendPostXML("../../ajaxPHP/uploadhtml.php?areaId=" + areaID + "&floder=" + folderName + "&filename=" + _("ckfilename").value + "&scroll=" + _("ckscroll").value + "&bg=" + ckneed + "&utype=" + utype, editor.getData());
			
        }
        else
        {
            alert("模板名跟内容不能为空!");
        }
    }
}

function uploadInfo(obj)
{
    var myobj = eval("(" + obj + ")");
    if ("success" == myobj.state)
    {
        var fileInfo = "'fileType':'" + myobj.file_type;
        fileInfo += "','filePath':'" + myobj.file_path;
       // fileInfo += "','fileFullPath':'" + myobj.full_path;
        fileInfo += "','fileSize':'" + myobj.file_size;
        fileInfo += "','fileName':'" + myobj.file_name;
        fileInfo += "','modifyDate':'" + myobj.modify_date;
        fileInfo += "','direction':'" + myobj.scroll_type;
        fileInfo += "','strBgorURL':'" + myobj.back_ground + "'";
        var fileareaItem = document.createElement("div");
        fileareaItem.setAttribute("id", myobj.fileid);
        fileareaItem.setAttribute("fileInfo", fileInfo);
        fileareaItem.innerHTML = myobj.file_name;
        _("file_" + myobj.areaid).appendChild(fileareaItem);
        var setInfo = function ()
        {
            return updateFileInfo(myobj.file_type, null, myobj.fileid);
        };
        fileareaItem.attachEvent("onclick", setInfo);
        var editFList = function ()
        {
            return editFileList(myobj.fileid);
        };
        fileareaItem.attachEvent("onclick", editFList);
        updateFileInfo(myobj.file_type, null, myobj.fileid);
        setDefaultInfo(_("file_info"), myobj.fileid);
        _("file_" + myobj.areaid).style.display = "block";
        closeCkeditorUI();
    }
    else if ("false" == myobj.state)
    {
        _("uploaderrmessage").innerHTML = myobj.message;
        alert(myobj.message);
    }
    else alert("保存失败");
}

function createUrlDiv2(url, areaId)
{
    var pNode = _("file_" + areaId);
    if (url == null)
    {
        return false;
    }
    else if (url.replace(/^\s+|\s+$/g, "") == "")
    {
        alert("输入为空!无法新增!");
        return false;
    }
    else
    {
        var regStr = /^((https?|ftp|news):\/\/)/;
        if (regStr.test(url))
        {
            var div = document.createElement("DIV");
            var d = new Date();
            var did = "file_" + areaId + "_" + d.getUTCMilliseconds();
            div.id = did;
            div.innerHTML = url;
            div.className = "DragBox";
			div.setAttribute("key",areaId);
            var editFList = function (id)
            {
                return function (id)
                {
                    ev = id;
                    ev = ev || window.event;
                    var target = ev.target || ev.srcElement;
                    _(target.id).style.backgroundColor = "#F9FFB0";
                    _("fl_moveUp").setAttribute("move_id", target.id);
                    _("fl_moveDown").setAttribute("move_id", target.id);
                    _("fl_del").setAttribute("move_id", target.id);
                    _("file_info").innerHTML = "";
                    var nodes = target.parentNode.childNodes;
                    for (var i = 0; i < nodes.length; i++)
                    {
                        if (nodes[i].nodeName != "#text" && target != nodes[i])
                        {
                            nodes[i].style.backgroundColor = "#fff";
                        }
                    }
                };
            };
			//url=encodeURIComponent(url);
            div.setAttribute("playinfo", "'playTime':'30','direction':'" + _("ckscroll").value + "','strBgorURL':'" + url + "'");
            div.setAttribute("fileInfo", "'filePath':'" + url + "','fileViewPath':'" + url + "','fileType':'Url1','fileName':'" + url + "','fileSize':'0'");
            div.attachEvent("onclick", editFList(did));
            //pNode.appendChild(div);
			appendToAreaFileList(div,areaId);
            closeCkeditorUI();
            pNode.style.display = "block";
			program.addFileCache(div);
        }
        else
        {
            alert("您输入的网址不符合要求\n");
        }
    }
}

function setMainType(info)
{
	var target="";
	if(info["ev"])
	{
		ev = info["ev"] || window.event;
		target = ev.target || ev.srcElement;
		target = _(attr(target, "areaId"));
	}
	else
	{	target=info["area"];}
    var mainType = attr(target, "mainType");
    if (mainType == null || mainType == "N")
    {
        if (confirm("您将设置此区域为主区域!"))
        {
            bug("设置主区域", "主区域ID" + attr(target.parentNode, "areaId") + "<br>mainType:" + mainType);
            var Listener = function (ev)
            {
                return areaMenue(ev);
            }
            var ListenerMenue = function (ev)
            {
                return createAreaTypeMenue(ev);
            }
            if (attr(target, "areaType") == null)
            {
                target.style.paddingTop = parseInt(target.style.height) / 2 - 12 + "px";
                target.style.height = parseInt(target.style.height) - (parseInt(target.style.height) / 2 - 12) + "px";
            }
            if (mainType == "N")
            {
                if (_("file_" + attr(target, "id")))
                {
                    _("fileArea").removeChild(_("file_" + attr(target, "id")));
                }
            }
            createFileArea(target.id,"Video");
            target.setAttribute("mainType", "Y");
            target.setAttribute("areaType", "Video");
            target.setAttribute("o_bgColor", "#060");
            target.setAttribute("areaColor", "#060");
            target.style.backgroundColor = "#060";
            target.innerHTML = "主区域";
            target.style.textAlign = "center";
            target.style.color = "#000";
            target.style.fontSize = "14px";
            var otherNodes = target.parentNode.childNodes;
            for (var i = 0; i < otherNodes.length; i++)
            {
                if (otherNodes[i] != target)
                {
                    if (otherNodes[i].nodeName != "#text")
                    {
                        if (attr(otherNodes[i], "mainType") == "Y")
                        {
                            otherNodes[i].setAttribute("areaColor", "green");
                            otherNodes[i].innerHTML = "";
                            if (_("file_" + attr(otherNodes[i], "id")))
                            {
                                _("fileArea").removeChild(_("file_" + attr(otherNodes[i], "id")));
                            }
                        }
                        otherNodes[i].setAttribute("mainType", "N");
                        otherNodes[i].style.backgroundColor = "green";
                        otherNodes[i].setAttribute("o_bgColor", "green");
                        otherNodes[i].attachEvent("onclick", Listener);
                        otherNodes[i].attachEvent("oncontextmenu", ListenerMenue);
                    }
                }
                else
                {
                    target.attachEvent("onclick", Listener);
                    target.attachEvent("oncontextmenu", ListenerMenue);
                }
            }
        }
    }

}

function areaMenue(ev)
{
    ev = ev || window.event;
    var target = ev.target || ev.srcElement;
    target.style.backgroundColor = "yellow";
    var otherNodes = target.parentNode.childNodes,
        itm = "";
    for (var i = 0; i < otherNodes.length; i++)
    {
        if (otherNodes[i] != target)
        {
            itm = otherNodes[i];
            if (itm.nodeName != "#text")
            {
                if (attr(itm, "areaType"))
                {
                    itm.style.backgroundColor = attr(itm, "areaColor");
                }
                else
                {
                    itm.style.backgroundColor = attr(itm, "o_bgColor");
                }
            }
        }
        else
        {
			/********************************************
			|
			|	取消主区域文件关联功能
			|	2012年7月19日 23:03:14 by 莫波
			|
			*********************************************/
           /* itm = otherNodes[i];
            if (itm.nodeName != "#text")
            {
                if(attr(itm,"areatype")=="Video")
                {
                    _("fl_relevance").style.display="block";
                }
                else
                {
                    _("fl_relevance").style.display="none";
                }
            }*/
        }
    }
    if (_("file_" + target.id))
    {
        var fileNodes = _("file_" + target.id).parentNode.childNodes;
        for (var i = 0; i < fileNodes.length; i++)
        {
            if (fileNodes[i].nodeName != "#text")
            {
                if (fileNodes[i].id != ("file_" + target.id))
                {
                    fileNodes[i].style.display = "none";
                }
                else
                {
                    fileNodes[i].style.display = "block";
                }
            }
        }
    }
    _("file_info").innerHTML = "";

}

/**************************************
 *
 *
 *
 *
 **************************************/
function createAreaTypeMenue(ev)
{

    ev = ev || window.event;
    var target = ev.target || ev.srcElement;
    var parentObj=document.getElementById("apDiv1");
    var mainType = attr(target, "mainType"), areaType=attr(target,"areatype");
	var mainMenue="";
    if (mainType == null)
    {
        var mainMenue = "<a  areaId='"+target.id+"' class='rightmenueitm' onclick=\"setMainType({ev:event})\" href='javascript:void(0)'>主区域</a>";
        mainDIV.innerHTML = mainMenue;
    }
    if (mainType == "Y")
    {
        var mainMenue = "";
		 // mainMenue += "<div class='rightmenueitm'>图片</div>";
      //  mainMenue += "<div class='rightmenueitm'>流媒体URL</div>";
       // mainMenue += "<div class='rightmenueitm'>删除</div>";
         mainMenue += "<a areaId='"+target.id+"' href='javascript:void(0)' type='touchUrl' color='#ddd' onclick=\"setAreaType(this,true)\" class='rightmenueitm'>触摸屏页面</a>";
        //mainMenue += "<div>属性</div>";
    }

    if (mainType == "N")
    {
        var mainMenue = "<a areaId='"+target.id+"' href='javascript:void(0)' class='rightmenueitm' onclick=\"setMainType({ev:event})\">主区域</a>";
        mainMenue += "<a areaId='"+target.id+"' href='javascript:void(0)' type='Img' color='#0C0' onclick=\"setAreaType(this,false)\" class='rightmenueitm'>图片</a>";
        mainMenue += "<a areaId='"+target.id+"' href='javascript:void(0)' type='Swf' color='#63F' onclick=\"setAreaType(this,false)\" class='rightmenueitm'>动画</a>";
        mainMenue += "<a areaId='"+target.id+"' href='javascript:void(0)' type='Txt' color='#96F' onclick=\"setAreaType(this,false)\" class='rightmenueitm'>滚动字幕</a>";
       
		if( areaType=="Url" )
		{
		   mainMenue += "<a areaId='"+target.id+"' href='javascript:void(0)' type='Url' color='#69F' onclick=\"addWebUrl(this,false)\" class='rightmenueitm'>添加网址</a>";
		}
		else
		{
			 mainMenue += "<a areaId='"+target.id+"' href='javascript:void(0)' type='Url' color='#69F' onclick=\"setAreaType(this,false)\" class='rightmenueitm'>网页</a>";
		}
        mainMenue += "<a areaId='"+target.id+"' href='javascript:void(0)' type='Delete' color='#090' onclick=\"delAreaType(this,false)\" class='rightmenueitm'>删除</a>";
        mainMenue += "<a areaId='"+target.id+"' href='javascript:void(0)' type='Attribute' class='rightmenueitm'>属性</a>";
    }
	popup.open({key:"areaMenue",event:ev,content:mainMenue});
}

function setBgMusic(o)
{
    var bgMusic = _("101");
    
    if (attr(o, "option") == "Add")
    {
		
        createFileArea("101","bgMusic");
        attr(o, "option", "Del");
		
		//背景音乐区域信息加入缓存队列
		program.addPlayAreaData({id:bgMusic.id,type:attr(bgMusic,"areatype"),location:attr(bgMusic,"position")});
		var pos=getElementPos(_("apDiv1"));
		bgMusic.style.position="absolute";
		bgMusic.style.top=(pos.y+_("apDiv1").clientHeight+4)+"px";
		bgMusic.style.left=(pos.x)+"px";
		bgMusic.style.width=_("apDiv1").clientWidth+"px";
		bgMusic.style.display = "block";
		program.fileDrag.readyDragArea();
    }
    else
    {
		if(!confirm("您确定要删除背景音乐区域?"))
		{return false;}
        bgMusic.style.display = "none";
        attr(o, "option", "Add");
		removeFileArea("101");
		program.removePlayAreaData("101");
    }
}
function removeBgMusic(){
	var bgMusic = _("101");
	bgMusic.style.display = "none";
	attr(_("bgMusic"), "option", "Add");
	removeFileArea("101");
	program.removePlayAreaData("101");
}
function setLedDiv(o)
{
    var led = _("100");
    led.style.display = "";
    if (attr(o, "option") == "Add")
    {
        createFileArea("100","LED");
        attr(o, "option", "Del");
    }
    else
    {
        led.style.display = "none";
        attr(o, "option", "Add");
        try
        {
            _("fileArea").removeChild(_("file_100"));
        }
        catch (e)
        {
        }
    }
}

function delAreaType(ev, BooleanType)
{
    ev = ev || window.event;
    var target = ev.target || ev.srcElement;
    var areaId = attr(target.parentNode, "areaId");
    _(areaId).setAttribute("mainType", "N");
    _(areaId).innerHTML = "";
    _("fileArea").removeChild(_("file_" + areaId));
    _(areaId).style.backgroundColor = attr(target, "color");
    _(areaId).setAttribute("areaColor", attr(target, "color"));

}
/*************************************
  功能:
	  网页模板中添加网址
  参数:
	  str_info string -> 筛选条件,
  时间: 2012年9月1日 18:24:02 by BOBO
*************************************/
function addWebUrl(obj){
    var target = obj;
    var areaId = attr(obj, "areaId");
	createCkeditorUI(areaId);
}
function setAreaType(obj, touth)
{
    if (touth)
    {
        var ret = prompt("请输入URL的地址！格式如下:\nhttp://www.xxx.com", "");
        if (ret == null)
        {
            return false;
        }
        else if (ret.replace(/^\s+|\s+$/g, "") == "")
        {
            alert("输入为空!无法新增!");
            return false;
        }
        else
        {
            //var inp = document.createElement("INPUT");
//            inp.type = "hidden";
//            inp.setAttribute("id", "touthUrl");
//            inp.setAttribute("value", ret);
//            document.body.appendChild(inp);
			program.info.touchJumpUrl=ret;
        }
    }
    if (!touth)
    {
        var target = obj;
        var areaId = attr(target, "areaId");
        var pNode = _(areaId);
		var _areaType = attr(target, "type");
        if (_areaType == "Url")
        {
            pNode.style.backgroundColor = attr(target, "color");
            pNode.setAttribute("areaColor", attr(target, "color"));
            pNode.innerHTML = target.innerHTML;
            if (attr(pNode, "areaType") == null)
            {
                pNode.style.paddingTop = parseInt(pNode.style.height) / 2 - 12 + "px";
                pNode.style.height = parseInt(pNode.style.height) - (parseInt(pNode.style.height) / 2 - 12) + "px";
            }
            else
            {
                if (_("file_" + areaId))
                {
                    removeAllChildNodes(_("file_" + areaId));
                    _("fileArea").removeChild(_("file_" + areaId));
                }
            }
            pNode.style.textAlign = "center";
            pNode.setAttribute("areaType", attr(target, "type"));
            pNode.style.color = "#000";
            pNode.style.fontSize = "14px";
            createFileArea(areaId,attr(target, "type"));
            
        }
        
        if (_areaType != "Url")
        {
            if (_areaType == "Txt")
            {
                if (checkOnlyAreaType(_areaType))
                {
                    return false;
                }
                else
                {
                    pNode.style.backgroundColor = attr(target, "color");
                    pNode.setAttribute("areaColor", attr(target, "color"));
                    pNode.innerHTML = target.innerHTML;
                    if (attr(pNode, "areaType") == null)
                    {
                        pNode.style.paddingTop = parseInt(pNode.style.height) / 2 - 12 + "px";
                        pNode.style.height = parseInt(pNode.style.height) - (parseInt(pNode.style.height) / 2 - 12) + "px";
                    }
                    else
                    {
                        if (_("file_" + areaId))
                        {
                            removeAllChildNodes(_("file_" + areaId));
                            _("fileArea").removeChild(_("file_" + areaId));
                        }
                    }
                    pNode.style.textAlign = "center";
                    pNode.setAttribute("areaType", attr(target, "type"));
                    pNode.style.color = "#000";
                    pNode.style.fontSize = "14px";
                    createFileArea(areaId,attr(target, "type"));
                }
            }
            else
            {
                pNode.style.backgroundColor = attr(target, "color");
                pNode.setAttribute("areaColor", attr(target, "color"));
                pNode.innerHTML = target.innerHTML;
                if (attr(pNode, "areaType") == null)
                {
                    pNode.style.paddingTop = parseInt(pNode.style.height) / 2 - 12 + "px";
                    pNode.style.height = parseInt(pNode.style.height) - (parseInt(pNode.style.height) / 2 - 12) + "px";
                }
                else
                {
                    if (_("file_" + areaId))
                    {
                        removeAllChildNodes(_("file_" + areaId));
                        _("fileArea").removeChild(_("file_" + areaId));
                    }
                }
                pNode.style.textAlign = "center";
                pNode.setAttribute("areaType", attr(target, "type"));
                pNode.style.color = "#000";
                pNode.style.fontSize = "14px";
                createFileArea(areaId,attr(target, "type"));
            }
        }
		program.info.playAreaInfo[areaId].type=_areaType;
    }
}

function checkOnlyAreaType(nowtype)
{
    var Areas = _("apDiv1").childNodes;
    for (var i = 0; i < Areas.length; i++)
    {
        if (Areas[i].nodeName != "#text")
        {
            if (Areas[i].tagName == "DIV")
            {
                type = attr(Areas[i], "areaType");
                if (type == nowtype)
                {
                    return true;
                }
                else
                {
                    if (i == Areas.length - 1)
                    {
                        return false;
                    }
                }
            }
        }
    }
}

function removeAllChildNodes(objt)
{
    while (objt.firstChild)
    {
        objt.removeChild(objt.firstChild);
    }
}

function createFileArea(areaId,type)
{
    var filesArea = document.createElement("div");
    if (_("file_" + areaId)) return;
    filesArea.setAttribute("id", "file_" + areaId);
	filesArea.setAttribute("areaType", "file_" + type);
    filesArea.style.cssText = "display:none;height:240px;width:100%;";
    _("fileArea").appendChild(filesArea);
}
function removeFileArea(areaId)
{
    if (_("file_" + areaId))
	{
		getParentNode(_("file_" + areaId)).removeChild(_("file_" + areaId));
	}
}
function closeAreaTypeMenue()
{
    document.body.removeChild(_("areaTypeMenue"));
}


Number.prototype.NaN0 = function ()
{
    return isNaN(this) ? 0 : this;
}

function getPosition(e)
{
    var left = 0;
    var top = 0;
    while (e.offsetParent)
    {
        left += e.offsetLeft + (e.currentStyle ? (parseInt(e.currentStyle.borderLeftWidth)).NaN0() : 0);
        top += e.offsetTop + (e.currentStyle ? (parseInt(e.currentStyle.borderTopWidth)).NaN0() : 0);
        e = e.offsetParent;
    }
    left += e.offsetLeft + (e.currentStyle ? (parseInt(e.currentStyle.borderLeftWidth)).NaN0() : 0);
    top += e.offsetTop + (e.currentStyle ? (parseInt(e.currentStyle.borderTopWidth)).NaN0() : 0);
    return {
        x: left,
        y: top
    };
}

function mouseCoords(ev)
{
    if (ev.pageX || ev.pageY)
    {
        return {
            x: ev.pageX,
            y: ev.pageY
        };
    }
    return {
        x: ev.clientX + document.body.scrollLeft - document.body.clientLeft,
        y: ev.clientY + document.body.scrollTop - document.body.clientTop
    };
}

function getMouseOffset(target, ev)
{
    ev = ev || window.event;
    var docPos = getPosition(target);
    var mousePos = mouseCoords(ev);
    return {
        x: mousePos.x - docPos.x,
        y: mousePos.y - docPos.y
    };
}



function checkProfileName()
{
    var reg = /[\~\!\@\#\$\%\^\&\*\(\)\_\+\`\=\～\！\＠\＃\＄\％\＾\＆\＊\\（\）\＿\＋\＝\－\｀\[\]\\'\;\/\.\,\<\>\?\:\"\{\}\|\，\．\／\；\＇\［\］\＼\＜\＞\？\：\＂\｛\｝\｜'\。\r+\n+\t+\s]/g;
    var profileName = _("profile_name").value.replace(reg, "");
    var pn = profileName.replace(/(^[\s]*)|([\s]*$)/g, "");
    _("profile_name").value = pn;
    if (pn == "")
    {
        alert("您还没有填写节目名称!");
        _("profile_name").focus();
        return false;
    }
    if (pn.length > 10)
    {
        alert("您的节目名称长度超过10个中文字符的限制!");
        _("profile_name").focus();
        return false;
    }
    return true;
}


function showInfo(message)
{
    var info = _("info_div").innerHTML;
    _("info_div").innerHTML = info + message;
}

function getResult(obj)
{
    
//	bug("---",print_r(eval("("+obj+")")));
    bug("保存profile后服务器返回的信息", obj);
	//alert(obj);
    if (obj.indexOf("存在同名") >= 0)
    {
        program.tip.saveTip("<div style='font-size:18px; font-weight:bold; color:green;'>节目重名！</div>");
        program.tip.saveTip("<a href='javascript:void(0)' class='blue_left'  onclick='closeInfoDivA()'><span class='blue_right'>确　定</span></a>");
        return false;
    }
    else if ((obj.indexOf("重命名") >= 0) || obj.indexOf("创建新目录") >= 0)
    {
        program.tip.saveTip("<div style='font-size:18px; font-weight:bold; color:red;'>对不起,您对管理系统目录没有'重命名'或者'创建新目录'的权限！</div>");
        program.tip.saveTip("<a href='javascript:void(0)' class='blue_left'  onclick='closeInfoDivA()'><span class='blue_right'>确　定</span></a>");
        return false;
    }
    var zt = obj.indexOf('执行成功');
    if (zt > -1)
    {
        program.tip.saveTip("<div style='font-size:18px; font-weight:bold; color:green;'>节目生成成功！</div>");
        program.tip.saveTip("<a href='javascript:void(0)' class='blue_left'  onclick='closeInfoDivA(true)'><span class='blue_right'>确　定</span></a>");
        _("fileArea").innerHTML = "";
        _("apDiv1").innerHTML = "";
        _("profile_name").value = "";
        try
        {
            with(document.body)
            {
                removeChild(_("bgDIV"));
            };
            _("apDiv1").style.backgroundImage = "url(BG.png)";
        }
        catch (e)
        {
        }
        document.onmousedown = null;
        document.onmousemove = null;
        document.onmouseup = null;
    }
    else
    {
        program.tip.saveTip("<div style='font-size:18px; font-weight:bold; color:red;'>节目生成失败！</div>");
        program.tip.saveTip("<a href='javascript:void(0)' class='blue_left'  onclick='closeInfoDivA()'><span class='blue_right'>确　定</span></a>");
		program.clearCreateProgramErrorInfo();
    }
}

function closeInfoDivA(close)
{
   // __closeCoverDiv(true, "save_info");
   program.tip.saveTipClose();
   if(close){
		reflashProgramList();
	}
}



function setAreaDefault(info){
	var type=info["type"],
		areaId=info["areaId"],
		areaColor=info["areaColor"],
		pNode=info["area"];
        
			if(type == "Video")
			{
				pNode.setAttribute("mainType","Y");
			}
			else
			{
				pNode.setAttribute("mainType","N");
			}
	pNode.setAttribute("areaColor", areaColor);
	pNode.style.textAlign = "center";
	pNode.style.color = "#000";
	pNode.style.fontSize = "14px";
	createFileArea(areaId,type);
	
}
function setDefaultMainArea(info){
	var Listener = function (ev)
	{
		return areaMenue(ev);
	}
	var ListenerMenue = function (ev)
	{
		return createAreaTypeMenue(ev);
	}
	var target=info["area"];
	createFileArea(target.id,"Video");
	target.setAttribute("mainType", "Y");
	target.setAttribute("o_bgColor", "#060");
	target.setAttribute("areaColor", "#060");
	target.innerHTML = "主区域";
	target.style.textAlign = "center";
	target.style.fontSize = "14px";
	var otherNodes = target.parentNode.childNodes;
	for (var i = 0; i < otherNodes.length; i++)
	{
		if (otherNodes[i] != target)
		{
			if (otherNodes[i].nodeName != "#text")
			{

				otherNodes[i].setAttribute("mainType", "N");
				otherNodes[i].setAttribute("o_bgColor", "green");
				otherNodes[i].attachEvent("onclick", Listener);
				otherNodes[i].attachEvent("oncontextmenu", ListenerMenue);
			}
		}
		else
		{
			target.attachEvent("onclick", Listener);
			target.attachEvent("oncontextmenu", ListenerMenue);
		}
	}
}

function createDrag(areasObject)
{
    document.onmousedown = dragMouseDown;
    document.onmousemove = dragMouseMove;
    //document.onmouseup = dragMouseUp;
    Demos[0] = _("content");
    if (Demos[0])
    {
        CreateDragContainer(areasObject);
    }
    if (Demos[0])
    {
        dragHelper = document.createElement('DIV');
        dragHelper.style.cssText = 'position:absolute;display:none; z-index:1000;';
        document.body.appendChild(dragHelper);
    }
   // var ck = new Cookie();
   // if (!ck.Read("FY"))
   // {
   //     ck.Write("FY", true, 1);
   //     fenye();
   // }
}


var program={
	info:{action:"add",em:"",profileName:"",profileOldName:"",profileType:"",profilePeriod:0,templateID:"",touchJumpUrl:"",tempWidth:"",tempHeight:"",tempBgGround:"",playAreaInfo:{}},
	clearDataCache:function(){
		program.info="";
		program.info={action:"add",em:"",profileName:"",profileOldName:"",profileType:"",profilePeriod:0,templateID:"",touchJumpUrl:"",tempWidth:"",tempHeight:"",tempBgGround:"",playAreaInfo:{}};
		_("profile_name").value="";
	},
	clearCreateProgramErrorInfo:function(){
		$.post("/CI/index.php/c_profileInfo/clearCreateProgramErrorInfo",function(data){
				if(data.state){
					program.tip.tip({message:"节目创建环境重建成功!"});
					return ;
				}
				program.tip.tip({message:"节目创建环境重建失败,您需要刷新页面!",closeFun:function(){window.location.reload();}});
				
			},"json");
	},
    addPlayAreaData:function(info){
		if(program.info.playAreaInfo.hasOwnProperty(info.id)){return true;}
        var inf={id:"",type:"",location:"",files:{}};
        for(var i in info)
        {
            inf[i]=info[i];
        }
        program.info.playAreaInfo[inf.id]=inf;
    },
	removePlayAreaData:function(areaId){
		if(program.info.playAreaInfo.hasOwnProperty(areaId))
		{
			delete program.info.playAreaInfo[areaId];
		}
	},
	addFileCache:function(element){
		 var key=attr(element,"key"),
		 	 fileInfo=eval("({"+attr(element,"fileInfo")+"})"),
			 playInfo=eval("({"+attr(element,"playInfo")+"})");
			var inf={key:key,fileInfo:fileInfo,playInfo:playInfo};
			program.info.playAreaInfo[key]["files"][element.id]=inf;
	},
	delFileCache:function(key,fileId){
		delete program.info.playAreaInfo[key]["files"][fileId];
	},
	restAreaFileListIndex:function(areaKey){
		program.info.playAreaInfo[key]["files"]={};
		$("#fileArea").children("div").each(function(index, element) {
            if(element.getAttribute("key")==areaKey)
			{
				$(element).children("div").each(function(index, element) {program.addFileCache(element);});
			}
        });
	},
	setProfileName:function(name){
		var reg = /[\~\!\@\#\$\%\^\&\*\(\)\_\+\`\=\～\！\＠\＃\＄\％\＾\＆\＊\\（\）\＿\＋\＝\－\｀\[\]\\'\;\/\.\,\<\>\?\:\"\{\}\|\，\．\／\；\＇\［\］\＼\＜\＞\？\：\＂\｛\｝\｜'\。\r+\n+\t+\s]/g;
		program.info.profileName=name.replace(reg, "");	
	},
	countOfPlayTime:function(time){
		program.info.profilePeriod+=time*1;
	},
	deleteFileForSever: function (arr_fileNames, folderName) {
	    
	},
	save:function(){
		bug("save ",print_r(program.info),"#0f0");
		
		if(program.info.action=="add")
		{
			program.create.save();
			
		}
		else if(program.info.action=="edit")
		{program.edit.save();}
	},
	saveInfo:function(){
		$.ajax({
			type:"POST",
			url:"../../../index.php/profile/createProfile",
			data:{data:program.info},
			error: function(){program.clearCreateProgramErrorInfo();},
			success: function(res){getResult(res);}
		});
	}
};
program["create"]={
	save:function(){
		program.tip.saveTip("<div style='width:100%;'>节目创建中</div>");
		program.saveInfo();
	}
};
program["edit"]={
	oldInfo:{programName:""},
	editInfo:{},
	init:function(){
		if(getArgsFromHref(window.location.href,"edit_type")!="")
		{
			program.tip.tip({title:"消息",id:"start_loading_tip",message:"节目信息正在努力加载中......",stateClose:"defaultState"});
			program.tip.tipInfo["defaultState"]=false;
			program.info.action="edit";
			$("#editTempBtn").click(program.edit.editTemplate).css("display","inline-block");
			program.edit.start();
		}
	},
	editTemplate:function(){
		window.top._BS_.temp.edit=true;
		window.top._BS_.temp.id=program.info.templateID;
		window.top._BS_.temp.forProgram=true; //编辑节目模板的时候标志
		art.dialog.open('/CI/index.php/c_templateManage/createTemp',{title: '编辑节目'+program.edit.oldInfo.programName+'模版',width:"90%",height:"99%", id:"editTemplateForProgram", lock:true,opacity:0.5 });
	},
	start:function(){
		var type=getArgsFromHref(window.location.href,"edit_type");
		var profileid=getArgsFromHref(window.location.href,"profile_id");
		var profileName=getArgsFromHref(window.location.href,"profileName");
		_("profile_name").setAttribute("cacheName",profileName);
		var myinfo=_("public_message_box");
		_("operatingType").innerHTML=type;

		//修改profile
		if(type=="edit")
		{
			$.ajax({url:"../../ajaxPHP/getProfileInfo.php",type:"POST",data:{profileid:profileid},success: function(data){program.edit.resetTemp(data);}});

		}

		//导入profile
		if(type=="load")
		{
			$.ajax({url:"../../ajaxPHP/readXml.php",type:"POST",data:{profilename:profileName},success: function(data){program.edit.resetTemp(data);}});
		}
		$("#getTempListBtn").remove();
	},
	resetTemp:function(obj){
		var info=obj.split("_@_@@_@_");
		var tempInfo=eval("({"+info[0]+"})");
		var profileInfo=eval("({"+info[1].toString()+"})");
		if(tempInfo.TempType=="")
		{
			alert("抱歉!\n您的节目包，已经损坏,导致无法编辑！\n请删除后重新建立,谢谢!");
			return ;
		}
		
		var Proportion = new templateProportion(tempInfo.W + "x" + tempInfo.H, tempInfo.TempType);
		var pro = Proportion.checkPro();
		with(_("apDiv1").style)
		{
			display = "none";
			width = tempInfo.W / pro.c + "px";
			height = tempInfo.H / pro.c + "px";
		}
		_("apDiv1").innerHTML = info[3].toString();
		with(program.info)
		{
			//action="";
			em=pro.em;
			profileName="";
			profileType=Proportion.templateType(tempInfo.TempType).type;
			profilePeriod=0;
			templateID=tempInfo.TempID;
			touchJumpUrl="";
			tempWidth=tempInfo.W;
			tempHeight=tempInfo.H;
			tempBgGround=tempInfo.BgImageName;
		}
		var area =childs("apDiv1","div");
		var oldW, oldH, oldX, oldY, style,mainArea="";
		for (var i = 0; i < area.length; i++)
		{
			var p=eval("({"+attr(area[i],"position")+"})");
			setOpacity(area[i],70);
			with(area[i].style)
			{
				width = p.width / pro.c + "px";
				left = p.left / pro.c + "px";
				height = p.height / pro.c + "px";
				lineHeight = p.height / pro.c + "px";
				top = p.top / pro.c + "px";
			}
			
			var type = attr(area[i],"areaType"),
				position=eval("({"+attr(area[i],"position")+"})");
			program.addPlayAreaData({id:area[i].id,type:type,location:position});
			if(type=="Video"){mainArea=area[i];}
		}

		_("apDiv1").style.display = "block";
		setTimeout(function(){
			setDefaultMainArea({area:mainArea});
		},500);
		//如果存在背景音乐
		if(profileInfo['hasBackgroundAudio'])
		{
			setBgMusic(_("bgMusic")); //初始化背景音乐 区域缓存
		}
		//加载模板背景
		if (_("bgDIV"))
		{
		   document.body.removeChild(_("bgDIV"));
		   _("apDiv1").style.backgroundImage = "url(BG.png)";
		}
		if(tempInfo.TempPic!=0)
		{
			loadBgPhoto(tempInfo.TempPic,tempInfo.BgImageFullPath);
			_("bgImg").setAttribute("BgImageFullPath",tempInfo.BgImageFullPath);
			_("bgImg").setAttribute("BgImagePath",tempInfo.BgImagePath);
			_("bgImg").setAttribute("BgImageName",tempInfo.BgImageName);
		}


		//生成拖拽/模板 操作界面
		program.fileDrag.readyDragArea();

		//开始文件区域
		program.edit.createFilesArea(info[2].toString());
		//初始化文件数据

		program.edit.addFileInfoToArea();
		//显示Profile 属性
		
		_("profile_name").value=program.edit.oldInfo.programName= program.info.profileName=program.info.profileOldName=profileInfo.profileName;
		program.info['profileID']=profileInfo.ProfileID; //编辑节目的时候需要添加节目ID, 创建的时候不需要.
		//解锁屏幕
		program.tip.tipInfo["defaultState"]=true;
		program.tip.tipClose("start_loading_tip");
	},
	//创建区域文件存放UI
	createFilesArea:function(fileString){
		bug("resdTemp ",'<textarea style="border:1px; width:100%; height:100px;">'+fileString+'</textarea>');
		_("fileArea").innerHTML=fileString;
	},
	addFileInfoToArea:function(){
		$("#fileArea").children("div").each(function(index, element) {
			
          	if(attr(_(element.id.split("_")[1]),"areaType")=="Video")
			{
				$(this).children("div").each(function(index, element) {
                   var playInfo= eval("({"+attr(element,"playInfo")+"})");
				   program.info.profilePeriod+=playInfo.playTime*1;
                });
			}
        })
		.children("div").each(function(index, element) {
           program.addFileCache(element);
        });
	},
	save:function(){
		program.tip.saveTip("<div style='width:100%;'>节目正在更新中,请稍等!</div>");
		program.saveInfo();
	}
};


program["fileList"]={
	fileListInfo:{filelist:{},fileTypeList:{},type:""},
	init:function(){
		$("#file_final_page,#file_first_page,#file_next_page,#file_pre_page").click(program.fileList.pageAction);
		$.ajax({
			type:"post",
			url:"/CI/index.php/c_fileManage/getFileListToProfileCreate",
			dataType:"json",
			success:function(data, textStatus){
				if(typeof(data)=="object"&&data.state=="true")
				{
					program.fileList.fileListInfo.filelist=data.data.fileListInfo;
					program.fileList.fileListInfo.fileTypeList=data.data.fileType;
					program.fileList.rendering();
					program.fileList.fileListPage(); //文件列表分页
				}
			},
			error :function(XMLHttpRequest, textStatus, errorThrown){}},"json");
	},
	pageAction:function(){
		switch(this.id){
			case "file_final_page" : page.overPage(program.fileList.fileListInfo.type); break;
			case "file_first_page": page.firstPage(program.fileList.fileListInfo.type); break;
			case "file_next_page": page.nextPage(program.fileList.fileListInfo.type); break;
			case "file_pre_page": page.prePage(program.fileList.fileListInfo.type); break;
		}
			
	},
	rendering:function(){
		var leftView=$("#fileList_menu").children(".left"),
			rightView=$("#fileList_menu").children(".right"),
			rightItm="",
			listItm="",
			itm="",
			
			list=program.fileList.fileListInfo.filelist,
			typeList=program.fileList.fileListInfo.fileTypeList,
			defaultLSelect="",defaultRSelect="";
		for(var f =0,g=typeList.length; f<g; f++)
		{
			
			if(f!=0)
			{
				defaultRSelect="hidden";
				defaultLSelect="unselect";
			}
			else{
				defaultRSelect="";
				defaultLSelect="select";
				program.fileList.fileListInfo.type=typeList[f].key;
			}
			$("<div class='leftItm "+defaultLSelect+"' type='"+typeList[f].key+"'>"+typeList[f].title+"</div>").appendTo(leftView).click(function(){program.fileList.fileListInfo.type=$(this).attr("type");});
			$("<div class='rightItm DragContainer "+defaultRSelect+"' id='f_list_"+typeList[f].key+"'></div>").appendTo(rightView);
			
		}
		for(var i in list)
		{
			listItm=list[i].list;
			for(var a=0,n=listItm.length; a<n; a++)
			{
				itm=listItm[a];
				$("<div title='"+itm.fileName+"' playinfo=\"'playTime':'"+itm.playTime+"','replayCount':'1'\" fileInfo=\"'fileType':'"+list[i].type+"','filePath':'"+itm.filePath+"','fileViewPath':'"+itm.fileViewPath+"','fileSize':'"+itm.fileSize+"','fileName':'"+itm.fileName+"','modifyDate':'"+itm.lastUpdateTime+"','filemd5':'"+itm.fileMD5+"'\" id=\"VIDEO"+i+"_"+a+"\" dragclass=\"DragDragBox\" overclass=\"OverDragBox\" class=\"DragBox\" dragobj=\"0\" origclass=\"DragBox\">"+itm.fileName+"</div>").appendTo("#f_list_"+i)
				
				.mouseenter(function(){addClass(this,"OverDragBox");})
				.mouseleave(function(){rmClass(this,"OverDragBox");});
				//.mousedown(dragMouseDown)
			}
			
		}	
		program.fileList.fileListInit();
	},
	fileListInit:function(){
		var l_ctrols=$("#fileList_menu").find("div.left").children("div"),
			r_cons  =$("#fileList_menu").find("div.right").children("div");
		l_ctrols.click(
		function(){
				
				var n=l_ctrols.length,
				key=0;
				for(var i=0; i<n; i++)
				{
					if(this==l_ctrols[i])
					{
						$(r_cons[i]).removeClass("hidden");
						$(r_cons[i]).addClass("show");
						$(l_ctrols[i]).addClass("select").removeClass("unselect").removeClass("mouseenter");;
						
					}
					else
					{
						$(r_cons[i]).removeClass("show");
						$(l_ctrols[i]).removeClass("select").addClass("unselect").removeClass("mouseenter");;
						$(r_cons[i]).addClass("hidden");
						
					}
				}
			}
		);
		l_ctrols.mouseenter(function(){
				if($(this).hasClass("select")){return false;}
				$(this).addClass("mouseenter");
			});
		l_ctrols.mouseleave(function(){
			if($(this).hasClass("select")){return false;}
			$(this).removeClass("mouseenter");
			});
	},
	fileListPage:function(){
		var typeList=program.fileList.fileListInfo.fileTypeList,typeKey="",list=program.fileList.fileListInfo.filelist,pageCount=1;
		for(var f =0,g=typeList.length; f<g; f++)
		{
			typeKey=typeList[f].key;
			if(list.hasOwnProperty(typeList[f].key))
			{
				pageCount=list[typeList[f].key]["pageCount"];
			}
			page.newPage({
				key:typeKey,
				keyWord:{my_comm:"0",type:typeKey},
				count:pageCount,
				url:"/CI/index.php/c_fileManage/getOneTypeFileList",
				success:function(data){
					var data=$.parseJSON(data);
					if(typeof(data)=="object"&&data["state"]=="true"){
						
						$("#f_list_"+this.key)[0].innerHTML="";
						var listItm=data.data.fileInfo, itm="";
						for(var a=0,n=listItm.length; a<n; a++)
						{
							itm=listItm[a];
							$("<div title='"+itm.fileName+"' playinfo=\"'playTime':'"+itm.playTime+"','replayCount':'1'\" fileInfo=\"'fileType':'"+itm.fileType+"','filePath':'"+itm.filePath+"','fileViewPath':'"+itm.fileViewPath+"','fileSize':'"+itm.fileSize+"','fileName':'"+itm.fileName+"','modifyDate':'"+itm.lastUpdateTime+"','filemd5':'"+itm.fileMD5+"'\" id=\""+this.key+"_"+a+"\" dragclass=\"DragDragBox\" overclass=\"OverDragBox\" class=\"DragBox\" dragobj=\"0\" origclass=\"DragBox\">"+itm.fileName+"</div>").appendTo("#f_list_"+this.key);
							
						}
					}
				}
			});
		}
	}
};

program["fileDrag"]={
	readyDragArea:function(){
		var areas = new Array();
		rightView=$("#fileList_menu").children(".right").children("div").each(function(index, domEle){areas.push(domEle);});
		areas.push(_("100"));
		areas.push(_("101"));
		var templateAreas = _("apDiv1").childNodes;
		for (var i = 0; i < templateAreas.length; i++)
		{
			if (templateAreas[i].nodeName != "#text")
			{
				if (templateAreas[i].tagName == "DIV")
				{
					areas.push(templateAreas[i]);
				}
			}
		}
		createDrag(areas);
	}
};

//模版选择列表分页
page.newPage({
			key:"temp_view",
			keyWord:"",
			pageSize:8,
			url:"/CI/index.php/c_templateManage/getTempListPage",
			success:function(data){
				var data=$.parseJSON(data);
				if(typeof(data)=="object"&&data["state"]=="true")
				{
					program.templist.insertContainer(data.data.templateInfo);
				}
			},
			error:function(){
				$.dialog.list['temp_view'].content('对不起您的信息加载失败');
			}
		});
program["templist"]={
	getTemp:function(id){
		$.ajax({
			url:"../../ajaxPHP/getTemplateToProfile.php",
			data:{TempID:id},
			type:"POST",
			success: function(str){
				program.templist.rendering(str);
			}
		});
	},
	rendering:function(obj){
		_("apDiv1").innerHTML = ""; 
		_("101").style.display="none";
		_("fileArea").innerHTML="";
		var info = obj.split("_@_@@_@_");
		var tempInfo = eval("({" + info[0].toString() + "})");
		var Proportion = new templateProportion(tempInfo.W + "x" + tempInfo.H, tempInfo.TempType);
		var pro = Proportion.checkPro();
		with(_("apDiv1").style)
		{
			display = "none";
			width = tempInfo.W / pro.c + "px";
			height = tempInfo.H / pro.c + "px";
		}
		_("apDiv1").innerHTML = info[1].toString();
		with(program.info)
		{
			//action="";
			em=pro.em;
			profileName="";
			profileType=Proportion.templateType(tempInfo.TempType).type;
			profilePeriod=0;
			templateID=tempInfo.TempID;
			touchJumpUrl="";
			tempWidth=tempInfo.W;
			tempHeight=tempInfo.H;
			tempBgGround=tempInfo.BgImageName;
		}
		
		var area =childs("apDiv1","div");
		var oldW, oldH, oldX, oldY, style,mainArea="";
		for (var i = 0; i < area.length; i++)
		{
			var p=eval("({"+attr(area[i],"position")+"})");
			setOpacity(area[i],70);
			with(area[i].style)
			{
				width = p.width / pro.c + "px";
				left = p.left / pro.c + "px";
				height = p.height / pro.c + "px";
				lineHeight = p.height / pro.c + "px";
				top = p.top / pro.c + "px";
			}
			var type = attr(area[i],"areaType"),areaInfo="";
			if(type!=null)
			{
				areaInfo=_areasInfo_.getAreaInfo({"type":type});
				area[i].innerHTML=areaInfo.title;
				area[i].style.backgroundColor=areaInfo.color;
			}
			if(type=="Video"){mainArea=area[i];}
			setAreaDefault({area:area[i],type:type,areaId:area[i].id,areaColor:areaInfo.color});
			program.addPlayAreaData({id:area[i].id,type:type,location:p});
		}
		_("apDiv1").style.display = "block";
		setTimeout(function(){
			setDefaultMainArea({area:mainArea});
		},500);
		if (_("bgDIV"))
		{
		   document.body.removeChild(_("bgDIV"));
		   _("apDiv1").style.backgroundImage = "url(BG.png)";
		}
		if (tempInfo.TempPic != "")
		{
			loadBgPhoto(tempInfo.TempPic, tempInfo.BgImageFullPath);
			_("bgImg").setAttribute("BgImageFullPath", tempInfo.BgImageFullPath);
			_("bgImg").setAttribute("BgImagePath", tempInfo.BgImagePath);
			_("bgImg").setAttribute("BgImageName", tempInfo.BgImageName);
		}
		_("profile_name").value = "";
	   program.fileDrag.readyDragArea();
	   
	   removeBgMusic();
	},
	getTempList:function(){
		$.dialog({
			id:'temp_view',
			title:"模板列表",
			width:660,
			padding:'0px',
			resize: false,
			drag: true,
			button:[
				{name:'首页',callback:function(){page.firstPage("temp_view"); return false;}},
				{name:'上一页',callback:function(){page.prePage("temp_view"); return false;}},
				{name:'下一页',callback:function(){page.nextPage("temp_view"); return false;}},
				{name:'尾页',callback:function(){page.overPage("temp_view"); return false;}}],
			close:function(){}
		});
		//defaultPageStart();
		page.getDataInfo("temp_view");
		
	},
	insertContainer:function(obj_info){
		var dom_con=$.dialog.list['temp_view'].content();
			dom_con.innerHTML="";
		if(obj_info.length<=0){$.dialog.list['temp_view'].content("对不起,您还没有创建模板!<br>请在'模板管理'中创建模板!");}
		var bl=1,bla=1,w=120,h=120,wh={},areas=[];
		//	var  imgurl=" ";
			for(var i=0,n=obj_info.length; i<n; i++)
			{
				wh=resolutionInfo.getResById(obj_info[i]["LengthScale"]);
				if(typeof(wh)!="object")
				{
					break;
				}
				bl=wh.h/110,
				bla=wh.w/120,
				bl=bl>bla?bl:bla,
				w=wh.w/bl,
				h=wh.h/bl,
				str="",
		//		if(obj_info[i]["extend1"]){
		//				imgurl=obj_info[i]["extend1"];
		//		}
				dv_dom=createTag("div",{id:obj_info[i]["TemplateID"]+"_tmp",className:"temp_sample",style:"text-align:center;  display:block;width:160px; height:160px;  margin-left:5px; margin-top:5px; float:left;"});
		
				str+="<a href='javascript:/*www.sharp-i.net*/;' tempId='"+obj_info[i]["TemplateID"]+"'  style='display:block; height:160px;'>";
					str+="<div class='div'  style=' height:150px; '>";
						str+="<div style='display:block; height:16px; font-size:12px;'>"+obj_info[i]["TemplateName"]+"</div>";
						str+="<DIV STYLE='display:block; height:110px;padding:0px;'>";
							str+="<DIV STYLE='font-size:1px;display:block; width:"+w+"px; height:"+h+"px; background-color:#bdbdbd; padding:0px;  margin:0px auto;'>";
								str+="<div style='position:relative; display:block;width:"+w+"px; height:"+h+"px;'>";
								areas=obj_info[i]["areas"];
									for(var a=0, b=areas.length; a<b; a++)
									{
										str+="<div style='position:absolute; background-color:green; border:1px solid; ";
										str+="width:"+((areas[a]["Width"])/bl-2)+"px; ";
										str+="height:"+((areas[a]["Height"])/bl-2)+"px; ";
										str+="left:"+((areas[a]["X"])/bl)+"px; ";
										str+="top:"+((areas[a]["Y"])/bl)+"px;'>";
										str+="</div>";
									}
								str+="</div>";
		
							str+="</DIV>";
						str+="</DIV>";
						str+="<div style='display:block; height:16px; font-size:12px; line-height:16px;'><label>"+wh.w+"x"+wh.h+"</label></div>";
					str+="</div>";
				str+="</a>";
				str=$(str).click(function(){
						program.templist.getTemp(attr(this,"tempId"));
						$.dialog.list['temp_view'].close();
					})[0];
				dv_dom.appendChild(str);
				//dom_gridItem.push(dv_dom);
				dom_con.appendChild(dv_dom);
			}
		$.dialog.list['temp_view'].position("50%","50%");
	}
};

program["templistEdit"] = {

    deleteArea: function (areaID) {
        //删除区域界面节点
        $("#" + areaID).remove();
        //清除区域数据缓存
        program.removePlayAreaData(areaID);
        //清除区域文件界面节点
        removeFileArea(areaID);
    },
     /*****************************************
    *@description 此函数是在用户编辑节目模板时候,删除一个区域时调用. 用来清除某一个区域及其相关的所有信息
    *@param areaID int 模板区域的ID
    *@author 2012-12-30 12:36:15 by bobo
    ******************************************/
    //清除区域中的文件 for 服务器
    deleteAreaForServer: function (areaID) {
        var fileNames = [];
        $("#file_" + areaID).find("div").each(function (index, element) {
            fileNames.push(element.innerHTML);
        });
        if (fileNames.length) {
            $.ajax({
                type: "post",
                url: "/CI/index.php/c_profileInfo/removeAreaFiles",
                data: {
                    data: { fileArray: fileNames, folder: program.edit.oldInfo.programName, programId: program.info['profileID'], areaId: areaID }
                },
                success: function (data) {
                    var res = $.parseJSON(data);
                    if (res.state) {
                        program.templistEdit.deleteArea(areaID);
                        art.dialog.tips(res.data,3);
                    }
                    else {
                        art.dialog.alert(res.error);
                    }
                },
                error: function () {
                    art.dialog.alert("数据请求失败,请检测您的网络");
                }
            });
        }
        
    },
};

program["tip"]={
	saveTip:function(message){
		if(_("save_art_info_con"))
		{
			_("save_art_info_con").innerHTML=_("save_art_info_con").innerHTML+message;
		}
		else
		{
			message='<table width="400"><tr><td width="100"><img src="/CI/Skin/default/u_loading.gif" /></td><td  width="100%" id="save_art_info_con">'+message+'</td></tr></table>';
			art.dialog({
				id:"save_art_info",
				title:"节目保存",
				content:message,
				width:400,
				lock:true
			});
		}
	},
	saveTipClose:function(){
		art.dialog.list["save_art_info"].close();
	},
	fileDragTip:function(message){
		if(_("fileDrag_art_info_con"))
		{
			_("fileDrag_art_info_con").innerHTML=_("fileDrag_art_info_con").innerHTML+message;
		}
		else
		{
			message='<table width="400"><tr><td width="100"><img src="/CI/Skin/default/u_loading.gif" /></td><td  width="100%" id="fileDrag_art_info_con">'+message+'</td></tr></table>';
			art.dialog({
				id:"fileDrag_art_info",
				title:"文件处理",
				content:message,
				width:400,
				lock:true
			});
		}
	},
	fileDragTipClose:function(){
		art.dialog.list["fileDrag_art_info"].close();
	},
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
		{stateClose=program.tip.tipInfo.defaultState;}
		if(info["close"]){closeFun=info["close"];}
		else
		{closeFun=function(){};}
	
		message='<table width="300"><tr><td width="100"><img src="/CI/Skin/default/u_loading.gif" /></td><td  width="100%" id="'+id+'_con">'+message+'</td></tr></table>';
			art.dialog({
				id:id,
				title:title,
				content:message,
				width:400,
				lock:true,
				close:function(){ closeFun(); return program.tip.tipInfo[stateClose];}
			});
	},
	tipClose:function(id){
		art.dialog.list[id].close();
	},
	change:function(mes,id){
		if(id==null){id="defalut_tip";}
		art.dialog.list[id].content(mes);
	}
};



$(document).ready(function(e) {
    program.fileList.init();
	program.edit.init();
	$("#profile_name").keyup(function(){program.setProfileName(this.value);});
	$("#save_button").click(program.save);
	$("#getTempListBtn").click(program.templist.getTempList);
	
});

