
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
function _alert(){alert("--------");}
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
        
        _("profile_name").setAttribute("cacheName", _("UserFolder").value);
    }
    if (attr(_("profile_name"), "cacheName") != "")
    {
        if (editor)
        {
            return;
        }
        var createCkeditor_div = "<div id=\"ckeditor_div\" style='width:900px; font-size:14px;display:block;' ><p align=\"left\">";
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
        var editer=art.dialog({
            title:"网页地址输入",
            content:createCkeditor_div,
            lock:true,
            id:"editor_win"
        });
        
        
       // editor = CKEDITOR.appendTo('editor');
       //   if (editor) _("ckeditor_div").style.display = "block";
       //_("ckeditor_div").style.display = "block";
        
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
        art.dialog.alert("无法获取" + obj.value + "内容!");
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
    //__closeCoverDiv(true, "ckeditor_UI");
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
            // var ckneed = "";
            // if (_("ckbg").value != "")
            // {
                // var ckarr = _("ckbg").value.split(/\\/);
                // ckneed = ckarr[ckarr.length - 1];
                // var cka = ckneed.split(".");
                // if ("jpg gif".indexOf(cka[1]) < 0)
                // {
                    // alert("使用jpg和gif格式的图片作为背景");
                    // _("ckbgId").innerHTML = "背景图片：<input id=\"ckbg\" name=\"ckbg\" type=\"file\" />";
                    // return;
                // }
            // }
            // var myajax = new DedeAjax(_("myinfo"), true, uploadInfo);
            // myajax.rtype = "xml";
            // var Ckie = new Cookie();
            // var folderName = Ckie.Read("userName");
            // myajax.SendPostXML("./template/ajaxPHP/uploadhtml.php?areaId=" + areaID + "&floder=" + folderName + "&filename=" + _("ckfilename").value + "&scroll=" + _("ckscroll").value + "&bg=" + ckneed + "&utype=" + utype, editor.getData());
//          
        }
        else
        {
            alert("模板名跟内容不能为空!");
        }
    }
}

// function uploadInfo(obj)
// {
    // var myobj = eval("(" + obj + ")");
    // if ("success" == myobj.state)
    // {
        // var fileInfo = "'fileType':'" + myobj.file_type;
        // fileInfo += "','filePath':'" + myobj.file_path;
       // // fileInfo += "','fileFullPath':'" + myobj.full_path;
        // fileInfo += "','fileSize':'" + myobj.file_size;
        // fileInfo += "','fileName':'" + myobj.file_name;
        // fileInfo += "','modifyDate':'" + myobj.modify_date;
        // fileInfo += "','direction':'" + myobj.scroll_type;
        // fileInfo += "','strBgorURL':'" + myobj.back_ground + "'";
        // var fileareaItem = document.createElement("div");
        // fileareaItem.setAttribute("id", myobj.fileid);
        // fileareaItem.setAttribute("fileInfo", fileInfo);
        // fileareaItem.innerHTML = myobj.file_name;
        // _("file_" + myobj.areaid).appendChild(fileareaItem);
        // var setInfo = function ()
        // {
            // return updateFileInfo(myobj.file_type, null, myobj.fileid);
        // };
        // fileareaItem.attachEvent("onclick", setInfo);
        // var editFList = function ()
        // {
            // return editFileList(myobj.fileid);
        // };
        // fileareaItem.attachEvent("onclick", editFList);
        // updateFileInfo(myobj.file_type, null, myobj.fileid);
        // setDefaultInfo(_("file_info"), myobj.fileid);
        // _("file_" + myobj.areaid).style.display = "block";
       // // closeCkeditorUI();
    // }
    // else if ("false" == myobj.state)
    // {
        // _("uploaderrmessage").innerHTML = myobj.message;
        // alert(myobj.message);
    // }
    // else alert("保存失败");
// }

function createUrlDiv2(url, areaId)
{
    var pNode = _("file_" + areaId);
    if (url == null)
    {
        return false;
    }
    else if (url.replace(/^\s+|\s+$/g, "") == "")
    {
        art.dialog.alert("输入为空!无法新增!");
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
        //cheng
            //url=encodeURIComponent(url);
            div.setAttribute("playinfo", "'playTime':'30','direction':'" + _("ckscroll").value + "','strBgorURL':'" + url + "'");
            div.setAttribute("fileInfo", "'filePath':'" + url + "','fileViewPath':'" + url + "','fileType':'Url1','fileName':'" + url + "','fileSize':'0'");
            div.attachEvent("onclick", editFList(did));
            //pNode.appendChild(div);
            appendToAreaFileList(div,areaId);
           // closeCkeditorUI();
            pNode.style.display = "block";
            program.addFileCache(div);
            art.dialog.list['editor_win'].close();
        }
        else
        {
            art.dialog.alert("您输入的网址不符合要求! 正确地址格式如下:<br/>http://www.baidu.com<br />或者https://www.xx.com");
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
    {   target=info["area"];}
    var areaId = attr(target, "id");
    _("fileArea_a_" +areaId).innerHTML='区域文件：</br>';
    var mainType = attr(target, "mainType");
    if (mainType == null || mainType == "N")
    {
        if (confirm("您将设置此区域为主区域!"))
        {
            
            bug("设置主区域", "主区域ID" + attr(target, "areaId") + "<br>mainType:" + mainType);
            var Listener = function (ev)
            {
                return areaMenue(ev);
            };
            var ListenerMenue = function (ev)
            {
                return createAreaTypeMenue(ev);
            };
            if (attr(target, "areaType") == null)
            {
                target.style.paddingTop = parseInt(target.style.height) / 2 - 12 + "px";
                target.style.height = parseInt(target.style.height) - (parseInt(target.style.height) / 2 - 12) + "px";
            }
            if (mainType == "N")
            {
                if (_("file_" + attr(target, "id")))
                {    // var targetId=$(target).attr('id');
               
                    _("fileArea").removeChild(_("file_" + attr(target, "id")));
                }
            }
            createFileArea(target.id,"Video");
            target.setAttribute("mainType", "Y");
            target.setAttribute("areaType", "Video");
            target.setAttribute("o_bgColor", "#060");
            target.setAttribute("areaColor", "#060");
            target.style.backgroundColor = "#060";
            target.firstChild.nodeValue = "主区域";
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
                            otherNodes[i].firstChild.nodeValue = "";
                            if (_("file_" + attr(otherNodes[i], "id")))
                            {  
                                _("fileArea_a_" +attr(otherNodes[i], "id")).innerHTML='区域文件：</br>';    
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

            //pNode.unbind("mousedown");
            program.info.playAreaInfo[areaId].type="Video";
            program.info.playAreaInfo[areaId].files={};
            areaId=parseInt(areaId)+1;
            templateInfo.data.areas[areaId]["info"]["extendInfo"]["type"]="Video";
            templateInfo.data.areas[areaId]["info"]["extendInfo"]["title"]="主区域";
        }
    }

}

function areaMenue(ev)
{
    ev = ev || window.event;
    var target = ev.target || ev.srcElement;
   // target.style.backgroundColor = "yellow";
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
            |   取消主区域文件关联功能
            |   2012年7月19日 23:03:14 by 莫波
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
    var parentObj=document.getElementById("canvasDiv");
    var mainType = attr(target, "mainType"), areaType=attr(target,"areatype");
    var mainMenue="";
    if (mainType == null)
    {
        var mainMenue = "<a  areaId='"+target.id+"' class='rightmenueitm' onclick=\"setMainType({ev:event,obj:this})\" href='javascript:void(0)'>主区域</a>";
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
       
       if( areaType=="Weather"){
           mainMenue += "<a areaId='"+target.id+"' href='javascript:void(0)' type='Url' color='#69F' onclick=\"addCityWeather(this)\" class='rightmenueitm'>添加城市</a>";
       }
       
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
function addCityWeather(evItem){
    art.dialog.open('/CI/index.php/c_weatherEdit/index',{title: '编辑天气信息',padding:0,width:"800px",height:"99%", lock:true,opacity:0.5 });
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
            art.dialog.alert("输入为空!无法新增!");
            return false;
        }
        else
        {
            //var inp = document.createElement("INPUT");
//            inp.type = "hidden";
//            inp.setAttribute("id", "touthUrl");
//            inp.setAttribute("value", ret);
//           document.body.appendChild(inp);
            program.info.touchJumpUrl=ret;
        }
    }
    if (!touth)
    {   //alert('sdgds');
        var target = obj;
        var areaId = attr(target, "areaId");
        var pNode = _(areaId);
        var _areaType = attr(target, "type");
       _("fileArea_a_" +areaId).innerHTML='区域文件：</br>';
        if (_areaType == "Url")
        {
            pNode.style.backgroundColor = attr(target, "color");
            pNode.setAttribute("areaColor", attr(target, "color"));
            pNode.firstChild.nodeValue = target.innerHTML;
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
                    pNode.firstChild.nodeValue = target.innerHTML;
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
                pNode.firstChild.nodeValue = target.innerHTML;

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
     
       //pNode.unbind("mousedown");
      program.info.playAreaInfo[areaId].type=_areaType;
        program.info.playAreaInfo[areaId].files={};
      //program.addPlayAreaData({id:areaId,type:_areaType});
     // delete pNode['events']; 
     // alert(JSON.stringify(parseInt(areaId)+1));
      areaId=parseInt(areaId)+1;
        templateInfo.data.areas[areaId]["info"]["extendInfo"]["type"]=_areaType;
        templateInfo.data.areas[areaId]["info"]["extendInfo"]["title"]=target.innerHTML;
       
    }
}

function checkOnlyAreaType(nowtype)
{
    var Areas = _("canvasDiv").childNodes;
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
};

function getPosition(e)
{
    var left = 0;
    var top = 0;
    while (e.保存)
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
        art.dialog.alert("您还没有填写节目名称!");
        _("profile_name").focus();
        return false;
    }
    if (pn.length > 10)
    {
        art.dialog.alert("您的节目名称长度超过10个中文字符的限制!");
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
    
    bug("保存profile后服务器返回的信息", obj);

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
        _("canvasDiv").innerHTML = "";
        _("profile_name").value = "";
        templateObj.cleraTemplateInfo();
        try
        {
            with(document.body)
            {
                removeChild(_("bgDIV"));
            };
            _("canvasDiv").style.backgroundImage = "url(BG.png)";
        }
        catch (e)
        {
        }
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
        return (ev);
    };
    var ListenerMenue = function (ev)
    {
        return createAreaTypeMenue(ev);
    };
    
    var target=info["area"];
    if(target!=""){
        createFileArea(target.id,"Video");
        target.setAttribute("mainType", "Y");
        target.setAttribute("o_bgColor", "#060");
        target.setAttribute("areaColor", "#060");
        target.innerHTML = "主区域";
        target.style.textAlign = "center";
        target.style.fontSize = "14px";
    }
    var otherNodes =$("#canvasDiv").children("div");
    //cheng add
 /* areaId=info["areaId"];
    var defaule_wh_=[];
            defaule_wh_[0]=$(templateSeting.id).width();
            defaule_wh_[1]=$(templateSeting.id).height();
            w=80/defaule_wh_[0],
            h=80/defaule_wh_[1];
for(var j=0;j<otherNodes.length;j++){
 var tem_area=$(otherNodes[j]).mousedown(function()
                     {   
                         if(templateSeting.focusArea!="")
                         {
                             $(templateSeting.focusArea).removeClass("area_selected").addClass("area_unselect");
                         }
                         templateSeting.focusArea=$(this).addClass("area_selected").removeClass("area_unselect")[0];
                             templateObj.readAreaInfoToWeiTiao();
                       
                     }).appendTo(templateSeting.jqCanvas)[0];
    dg(tem_area).enabled(
            {
                key:"_area_item_",
                id:areaId,
                resizeInfo:{w:10,h:10},
                percentage:{x:0,y:0,w:w,h:h},
                bfb:true,
                extendInfo:{type:otherNodes[j].getAttribute("areatype"),title:otherNodes[j].innerHTML},
                resize:true,
                callback:{
                    re_resize:function(key,_dragItm,info){_dragItm.style.lineHeight=_dragItm.clientHeight+"px";},
                    mv_stop:function(key,_dragItm,info){

                        var _wh_=[];
                        _wh_[0]=$(templateSeting.id).width();
                        _wh_[1]=$(templateSeting.id).height();
                        info.percentage.x=info.x/_wh_[0];
                        info.percentage.y=info.y/_wh_[1];
                       templateInfo.data.areas[key]={"info":info};
                       templateObj.readAreaInfoToWeiTiao();
                    },
                    re_stop:function(key,_dragItm,info){
                        var _wh_=[];
                        _wh_[0]=$(templateSeting.id).width();
                        _wh_[1]=$(templateSeting.id).height();
                        info.percentage.x=info.x/_wh_[0];
                        info.percentage.y=info.y/_wh_[1];
                        info.percentage.w=info.w/_wh_[0];
                        info.percentage.h=info.h/_wh_[1];
                        templateInfo.data.areas[key]={"info":info};
                        templateSeting.focusArea=tem_area;
                        templateObj.readAreaInfoToWeiTiao();
                    }
                }
            });
            
}*/
  
   
    for (var i = 0; i < otherNodes.length; i++)
    {
        if (otherNodes[i] != target)
        {
            otherNodes[i].setAttribute("mainType", "N");
            otherNodes[i].setAttribute("o_bgColor", "green");
            otherNodes[i].attachEvent("onclick", Listener);
            otherNodes[i].attachEvent("oncontextmenu", ListenerMenue);
            otherNodes[i].setAttribute("class", "tempArea area_unselect");
            }     
        else
        {  
            target.attachEvent("onclick", Listener);
            target.attachEvent("oncontextmenu", ListenerMenue);
            target.setAttribute("class", "tempArea area_unselect");
            
        }
    }
}

      
var program={
    canvas:"#canvasDiv",
    info:{action:"add",em:"",profileName:"",profileOldName:"",profileType:"X86",profilePeriod:0,templateID:"",touchJumpUrl:"",tempWidth:"",tempHeight:"",tempBgGround:"",playAreaInfo:{},profileTemplateInfo:{}},
    clearDataCache:function(){
        program.info="";
        program.info={action:"add",em:"",profileName:"",profileOldName:"",profileType:"X86",profilePeriod:0,templateID:"",touchJumpUrl:"",tempWidth:"",tempHeight:"",tempBgGround:"",playAreaInfo:{}};
        _("profile_name").value="";
    },
    clearCreateProgramErrorInfo:function(){///bank/index.php?control=fastProfile&action=createProfile
        $.post("/bank/index.php?control=c_profileInfo&action=clearCreateProgramErrorInfo",function(data){
                if(data.state){
                    program.tip.tip({message:"节目创建环境重建成功!"});
                    return ;
                }
                program.tip.tip({message:"节目创建环境重建失败,您需要刷新页面!",closeFun:function(){window.location.reload();}});
                
            },"json");
    },
    addPlayAreaData:function(info){
       // alert(JSON);
        if(program.info.playAreaInfo.hasOwnProperty(info.id)){return true;}
        var inf={id:"",type:"",location:"",files:{}};
        for(var i in info)
        {
            inf[i]=info[i];
        }
        program.info.playAreaInfo[inf.id]=inf;
    },
    //cheng
    changePlayAreaData:function(info){
       
           program.info.playAreaInfo[info.id].location=info.location;
    },
    removePlayAreaData:function(areaId){
        if(program.info.playAreaInfo.hasOwnProperty(areaId))
        {
            delete program.info.playAreaInfo[areaId];
        }
    }
    ,clearPlayAreaData:function(){
        program.info.playAreaInfo={};
        //cheng
        templateInfo.data.areas={};
    }
    ,addFileCache:function(element){
         var key=attr(element,"key"),
             fileInfo=eval("({"+attr(element,"fileInfo")+"})"),
             playInfo=eval("({"+attr(element,"playInfo")+"})");
         
         var inf={key:key,fileInfo:fileInfo,playInfo:playInfo};

            if(fileInfo.fileType=="Txt"){
                inf.playInfo.fontName=Bs.fontInfo.getFontNameByFileName(inf.playInfo.font);
            }
            program.info.playAreaInfo[key]["files"][element.id]=inf;
            
    }

    ///

    ,addDireFileCache:function(element){
         var key=element.key,
             fileInfo=element.fileInfo,
             playInfo="0";
         var inf={key:key,fileInfo:fileInfo,playInfo:playInfo};
            if(fileInfo.fileType=="Txt"){
                inf.playInfo.fontName=Bs.fontInfo.getFontNameByFileName(inf.playInfo.font);
            }
            program.info.playAreaInfo[key]["files"][element.id]=inf;
            
    },
    delFileCache:function(key,fileId){
        delete program.info.playAreaInfo[key]["files"][fileId];
    },
    restAreaFileListIndex:function(areaKey){
        program.info.playAreaInfo[areaKey]["files"]={};
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
    
    addBgMusic:function(){
        var bgMusic = _("101");
        createFileArea("101","bgMusic");
        //背景音乐区域信息加入缓存队列
        program.addPlayAreaData({id:bgMusic.id,type:attr(bgMusic,"areatype"),location:eval("({"+attr(bgMusic,"position")+"})")});
        var pos=getElementPos(_("canvasDiv"));
        bgMusic.style.position="static";
        bgMusic.style.top=(pos.y+_("canvasDiv").clientHeight+4)+"px";
        bgMusic.style.left=10+"px";
        bgMusic.style.width=_("canvasDiv").clientWidth+"px";
        bgMusic.style.display = "block";
    },
    delBgMusic:function(){
        var bgMusic = _("101");
        bgMusic.style.display = "none";
        removeFileArea("101");
        program.removePlayAreaData("101");
    },
    setBgMusic:function (o)
    {
        if($(program.canvas).children("div").length<=0){
            tip.tip({message:"您好,只有选择模板后才能使用此功能!"});
            return false;
        }
        
        if (attr(o, "option") == "Add")
        {
            attr(o, "option", "Del");
            program.addBgMusic();
            program.fileDrag.addBgMusicAreaToDragContainer();
        }
        else
        {
            if(!confirm("您确定要删除背景音乐区域?"))
            {return false;}
            attr(o, "option", "Add");
            program.delBgMusic();
        }
    },
    removeBgMusic:function (){
        var bgMusic = _("101");
        bgMusic.style.display = "none";
        attr(_("bgMusic"), "option", "Add");
        removeFileArea("101");
        program.removePlayAreaData("101");
    },
    checkProgramInfo:function(){
        var areas_div=$(program.canvas).children("div");
        if(areas_div.length<=0){
            tip.tip({message:"您好,您没有添加任何区域!"});
            return false;
        }
        if(program.info.profileName=="")
        {
            tip.tip({message:"您好,您还未填写节目名称!"});
            return false;
        }
        var playAreaInfo = program.info.playAreaInfo;
        var c=0;
        for(var i in playAreaInfo){
            if(playAreaInfo[i].type=="Video"){
                for(var a in playAreaInfo[i].files){
                    c++;
                }   
            }
        }
        if(c==0){
            tip.tip({message:"您好,您主区域还未添加任何播放文件!"});
            return false;
        }
        return true;
    },
save_as:function(){
         program.info.profileName=prompt("输入节目名称","");  
        if(program.info.profileName)
        {
           // alert(program.info.profileName);
        program.info.action="add";
         bug("save ",print_r(program.info),"#0f0");
            if(!program.checkProgramInfo())
            {
                return false;
            }
            
        program.create.save();  
        }else if(program.info.profileName==="")
        {
            tip.tip({message:"您好,您还未填写节目名称!"});
            return false;
        }else{
            return false; 
        }
      
    },
    save:function(){
        //templateObj.save();
        //alert(program.info.action);

        
        bug("save ",print_r(program.info),"#0f0");
        if(!program.checkProgramInfo())
        {
            return false;
        }
        if(program.info.action=="add")
        {   
          
            program.create.save();
            
        }
        else if(program.info.action=="edit")
        {program.edit.save();}
    },
    saveInfo:function(){
        //alert(JSON.stringify(program.info));//bank/index.php?control=playlist&action=addPlayList
        $.ajax({
            type:"POST",
            url:"index.php?control=fastProfile&action=createProfile",
            data:{data:program.info},
            error: function(){
             //alert(JSON.stringify(res));
                var jq_area=$("#canvasDiv").children("div"),
                jq_bgImg_dv=$("<div id='temp_backGroundImage' class='temp_backGroundImage'><img src='"+program.info.profileTemplateInfo['data']["backGroundImage"]['viewpath']+"' onmousedown='return false;' width='100%' height='100%' border='0' /></div>");
                jq_bgImg_dv.insertBefore(jq_area.first());
                program.clearCreateProgramErrorInfo();
               //还原背景图片
            
               
             },
            success: function(res){
          // alert(JSON.stringify(res.split('\n\n')[0]));//
             //保存成功生成一个默认播放列表
          var programID = res.split("\n\n")[1];
             // alert(res);        
               program.fastCreatePlayList(programID);
               res = "\n\n"+res.split('\n\n')[2]+"\n\n"+res.split('\n\n')[3];
               
             getResult(res);
           }
        });
    }
    ,fastCreatePlayList:function(programID){

         
        if(program.info.action=="add"){
            var date = new Date(),
            year = date.getFullYear(),
            month = (date.getMonth()+1),
            month2 = (date.getMonth()+2),
            day = date.getDate(),
            hours = date.getHours(),
            minutes = date.getMinutes(),
            seconds = date.getSeconds();
        if(month < 10){month = "0"+month;}
        if(month2 < 10){month2 = "0"+month2;}
        if(day < 10){day = "0"+day;}
        if(hours<10){hours="0"+hours;}
        if(minutes<10){minutes="0"+minutes;}
        if(seconds<10){seconds="0"+seconds;}
        var showDate = year +"-"+ month+"-"+ day,
        showDate2 = year +"-"+ month2+"-"+ day,
            showTime = hours +":"+ minutes +":"+ seconds;
        playList.info.golbal.startDateTime=showDate+" 00:00:00";
        playList.info.golbal.endDateTime=showDate2+" 23:59:59";
        playList.info.golbal.playListType=program.info.profileType;
        playList.info.golbal.playListName=program.info.profileName;
        playList.info.golbal.playlistModel="0";
        var info={startDate:showDate,
                      endDate:showDate2,
                      startTime:" 00:00:00",
                      endTime:" 23:59:59",
                      programId:programID,
                      programName:program.info.profileName
                      };
            playList.setDayCycleProgram(info);
            playList.save();
           // alert(JSON.stringify(playList.info));
       
           }
      
    }
    ,changeProgramType:function(){
        $("#program_type").children("option").each(function(index,item){
            
            if(item.selected)
            {
                program.info.profileType=item.value;
            }
        });
        
    }
};
program.create={
    save:function(){
        program.tip.saveTip("<div style='width:100%;'>节目创建中</div>");
        //alert(JSON.stringify(program.info));
        //cheng_add   修改后的模板值
        //program.clearPlayAreaData();
        //获取分辨率
        tempInfo=$("#_clReso").val();
        //alert(tempInfo);
        program.info.tempWidth = tempInfo.split('x')[0];
        program.info.tempHeight = tempInfo.split('x')[1];
       // alert(JSON.stringify(tempInfo));
        var arr_size=tempInfo.split('x'),
        jq_dom_canvas=$(templateSeting.id),
        int_c_w=jq_dom_canvas.width(),
        int_c_h=jq_dom_canvas.height();
        //设置缩放比例
        var pro=1,
        pro_w=arr_size[0]*1/int_c_w,
        pro_h=arr_size[1]*1/int_c_h;
        pro=pro_w>=pro_h?pro_w:pro_h;
      // templateSeting.Proportion=pro;
      // var pro=templateSeting.Proportion;jiemu
      // alert(JSON.stringify(pro));
      // program.info.tempBgGround=tempInfo.BgImageName;
       program.info.profileTemplateInfo=templateObj.readyTemplateInfo();
       program.info["tempBgGround"]=program.info.profileTemplateInfo['data']["backGroundImage"]["name"];
       //alert(JSON.stringify(program.info.profileTemplateInfo['data']["backGroundImage"]['viewpath'])); 
       
       // $("#temp_backGroundImage").remove();
       //alert(program.info.profileTemplateInfo["backGroundImage"]["name"]);
        program.info.em=pro.em;
        //重新获取画布中的区域，更改传输到服务器的数据
       
        //var area =childs("canvasDiv","div");
        //alert(area.length);
        var area =$("#canvasDiv").children("div").not('#temp_backGroundImage');
        //alert(area.length);
        var oldW, oldH, oldX, oldY, style,mainArea="";
        for (var i = 0; i < area.length; i++)
        {//alert(area.length);s.TrimEnd(',')
              
                var p=eval("({"+attr(area[i],"position")+"})");
                p.width = Math.round(area[i].style.width.replace('px',''),2)*pro;
                p.left = Math.round(area[i].style.left.replace('px',''),2)*pro;
                p.height = Math.round(area[i].style.height.replace('px',''),2)*pro;
                p.height  = Math.round(area[i].style.lineHeight.replace('px',''),2)*pro;
                p.top = Math.round(area[i].style.top.replace('px',''),2)*pro;
            
            var type = attr(area[i],"areaType"),areaInfo="";
            if(type!=null)
            {
                areaInfo=_areasInfo_.getAreaInfo({"type":type});
                area[i].innerHTML=areaInfo.title;
                area[i].style.backgroundColor=areaInfo.color;
            }
            if(type=="Video"){mainArea=area[i];}

            program.changePlayAreaData({id:area[i].id,location:p});
              
        }
        
       program.info.templateID=1091;
       
        program.saveInfo();
    }
};
program.edit={
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
        window.top._BS_.temp.forProgram=true; 
        art.dialog.open('/BANK/index.php?control=c_templateManage&action=createTemp',{title: '编辑节目'+program.edit.oldInfo.programName+'模版',width:"90%",height:"99%", id:"editTemplateForProgram", lock:true,opacity:0.5,resize:false });
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
            $.ajax({url:"./template/ajaxPHP/getProfileInfo.php",type:"POST",data:{profileid:profileid},success: function(data){program.edit.resetTemp(data);}});

        }

        //导入profile
        if(type=="load")
        {
            $.ajax({url:"./template/ajaxPHP/readXml.php",type:"POST",data:{profilename:profileName},success: function(data){program.edit.resetTemp(data);}});
        }
        $("#getTempListBtn").remove();
    },
    resetTemp:function(obj){
        var info=obj.split("_@_@@_@_");
        var tempInfo=eval("({"+info[0]+"})");
        var profileInfo=eval("({"+info[1].toString()+"})");
        if(tempInfo.TempType=="")
        {
            art.dialog.alert("抱歉!\n您的节目包，已经损坏,导致无法编辑！\n请删除后重新建立,谢谢!");
            return ;
        }
        
        var Proportion = new templateProportion(tempInfo.W + "x" + tempInfo.H, tempInfo.TempType);
        var pro = Proportion.checkPro();
        with(_("canvasDiv").style)
        {
            display = "none";
            width = tempInfo.W / pro.c + "px";
            height = tempInfo.H / pro.c + "px";
        }
        _("canvasDiv").innerHTML = info[3].toString();
        with(program.info)
        {
            
            em=pro.em;
            profileName="";
            profileType=profileInfo.profileType;//
            profilePeriod=0;
            templateID=tempInfo.TempID;
            touchJumpUrl="";
            tempWidth=tempInfo.W;
            tempHeight=tempInfo.H;
            tempBgGround=tempInfo.BgImageName;
        }
        $("#program_type").children("option").each(function(index,itm){
            if(itm.value==program.info.profileType)
            {
                itm.selected=true;
            }
        });
        var area =childs("canvasDiv","div");
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

        _("canvasDiv").style.display = "block";
        setTimeout(function(){
            setDefaultMainArea({area:mainArea});
        },500);
        //如果存在背景音乐
        if(profileInfo['hasBackgroundAudio'])
        {
            program.addBgMusic(); //初始化背景音乐 区域缓存
        }
        //加载模板背景
        if (_("bgDIV"))
        {
           document.body.removeChild(_("bgDIV"));
           _("canvasDiv").style.backgroundImage = "url(BG.png)";
        }
        if(tempInfo.TempPic!=0)
        {
            loadBgPhoto(tempInfo.TempPic,tempInfo.BgImageFullPath);
            _("bgImg").setAttribute("BgImageFullPath",tempInfo.BgImageFullPath);
            _("bgImg").setAttribute("BgImagePath",tempInfo.BgImagePath);
            _("bgImg").setAttribute("BgImageName",tempInfo.BgImageName);
        }
        //开始文件区域
        program.edit.createFilesArea(info[2].toString());
        //alert(info[2].toString());
        //初始化文件数据
        program.edit.fileArea();
        //显示Profile 属性
        
        _("profile_name").value=program.edit.oldInfo.programName= program.info.profileName=program.info.profileOldName=profileInfo.profileName;
        program.info['profileID']=profileInfo.ProfileID; //编辑节目的时候需要添加节目ID, 创建的时候不需要.
        //解锁屏幕
        program.tip.tipInfo["defaultState"]=true;
        program.tip.tipClose("start_loading_tip");
        
        //生成拖拽/模板 操作界面
        program.fileDrag.readyDragArea();
        //将背景音乐加入可接收文件的拖动区域
        program.fileDrag.addBgMusicAreaToDragContainer();
    
    },
    //创建区域文件存放UI
    createFilesArea:function(fileString){
        bug("resdTemp ",'<textarea style="border:1px; width:100%; height:100px;">'+fileString+'</textarea>');
        _("fileArea").innerHTML=fileString;
      
       var childs =_("fileArea").childNodes; 
       //在区域显示区域文件
       for(var i = childs.length - 1; i >= 0; i--) {
        //alert(childs[i].innerHTML);

          for(var j=0;j <=$(childs[i].innerHTML).length-1; j++) {
            var fileDiv=$(childs[i].innerHTML).get(j); 
            var areaId = $(fileDiv).attr('key');
            var fileName=$(childs[i].innerHTML).get(j).innerHTML+"<br>";
           // alert(areaId);
            _("fileArea_a_" +areaId).innerHTML=_("fileArea_a_" + areaId).innerHTML+fileName;
          }
        
          
  }  
        
        
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
       
       //cheng_add   修改后的模板值
        //program.clearPlayAreaData();
        //获取分辨率
        //$("div#temp_backGroundImage").remove();
        tempInfo = $("#_clReso").val();
        //alert(tempInfo);
        program.info.tempWidth = tempInfo.split('x')[0];
        program.info.tempHeight = tempInfo.split('x')[1];
        var arr_size=tempInfo.split('x'),
        jq_dom_canvas=$(templateSeting.id),
        int_c_w=jq_dom_canvas.width(),
        int_c_h=jq_dom_canvas.height();
        //设置缩放比例
        var pro=1,
        pro_w=arr_size[0]*1/int_c_w,
        pro_h=arr_size[1]*1/int_c_h;
        pro=pro_w>=pro_h?pro_w:pro_h;
       // templateSeting.Proportion=pro;
      // var pro=templateSeting.Proportion;
       // alert(JSON.stringify(pro));
        program.info.em=pro.em;
       program.info.profileTemplateInfo=templateObj.readyTemplateInfo();
       program.info.tempBgGround=program.info.profileTemplateInfo['data']["backGroundImage"]["name"];
       //$("div#temp_backGroundImage").remove();
        //重新获取画布中的区域，更改传输到服务器的数据
       var area =$("#canvasDiv").children("div").not('#temp_backGroundImage');
        //alert(area.length);
        var oldW, oldH, oldX, oldY, style,mainArea="";
        for (var i = 0; i < area.length; i++)
        {//alert(area.length);s.TrimEnd(',')
                   
            var p=eval("({"+attr(area[i],"position")+"})");
                p.width = Math.round(area[i].style.width.replace('px',''),2)*pro;
                p.left = Math.round(area[i].style.left.replace('px',''),2)*pro;
                p.height = Math.round(area[i].style.height.replace('px',''),2)*pro;
                p.height  = Math.round(area[i].style.lineHeight.replace('px',''),2)*pro;
                p.top = Math.round(area[i].style.top.replace('px',''),2)*pro;
            
            var type = attr(area[i],"areaType"),areaInfo="";
            if(type!=null)
            {
                areaInfo=_areasInfo_.getAreaInfo({"type":type});
                area[i].innerHTML=areaInfo.title;
                area[i].style.backgroundColor=areaInfo.color;
            }
            if(type=="Video"){mainArea=area[i];}

            program.changePlayAreaData({id:area[i].id,location:p});
        }
        
       //program.info.templateID=1091;
        //alert(JSON.stringify(program.info.profileTemplateInfo));

        program.saveInfo();
    }
};


program.fileList={
    fileListInfo:{filelist:{},fileTypeList:{},type:""},
    init:function(){
        program.tip.tip({title:"消息",id:"start_loading_tip",message:"资源信息正在努力加载中......",stateClose:"defaultState"});
        program.tip.tipInfo["defaultState"]=false;
        $("#file_final_page,#file_first_page,#file_next_page,#file_pre_page").click(program.fileList.pageAction);
        $.ajax({
            type:"post",
            url:"index.php?control=c_fileManage&action=getFileListToProfileCreate",
            dataType:"json",
            success:function(data, textStatus){
                if(typeof(data)=="object"&&data.state=="true")
                {
                    program.fileList.fileListInfo.filelist=data.data.fileListInfo;
                    program.fileList.fileListInfo.fileTypeList=data.data.fileType;
                    program.fileList.rendering();
                    program.fileList.fileListPage(); //文件列表分页
                    program.tip.tipInfo["defaultState"]=true;
                    program.tip.tipClose("start_loading_tip");
                    // 尝试加在编辑信息
                    program.edit.init();
                   
                    

                    
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
                $("<div title='"+itm.fileName+"' playinfo=\"'playTime':'"+itm.playTime+"','replayCount':'1'\" fileInfo=\"'fileID':'"+itm.fileID+"','fileType':'"+list[i].type+"','filePath':'"+itm.filePath+"','fileViewPath':'"+itm.fileViewPath+"','fileSize':'"+itm.fileSize+"','fileName':'"+itm.fileName+"','modifyDate':'"+itm.lastUpdateTime+"','filemd5':'"+itm.fileMD5+"'\" id=\"VIDEO"+i+"_"+a+"\" dragclass=\"DragDragBox\" overclass=\"OverDragBox\" class=\"DragBox\" dragobj=\"0\" origclass=\"DragBox\">"+itm.fileName+"</div>").appendTo("#f_list_"+i)

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
        var typeList=program.fileList.fileListInfo.fileTypeList,
            typeKey="",
            list=program.fileList.fileListInfo.filelist,pageCount=1;
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
                url:"index.php?control=c_fileManage&action=getOneTypeFileList",
                success:function(data){
                    var data=$.parseJSON(data);
                    if(typeof(data)=="object"&&data["state"]=="true"){
                        
                        $("#f_list_"+this.key)[0].innerHTML="";
                        var listItm=data.data.fileInfo, itm="";
                        for(var a=0,n=listItm.length; a<n; a++)
                        {
                            itm=listItm[a];
                            $("<div title='"+itm.fileName+"' playinfo=\"'playTime':'"+itm.playTime+"','replayCount':'1'\" fileInfo=\"'fileID':'"+itm.fileID+"','fileType':'"+itm.fileType+"','filePath':'"+itm.filePath+"','fileViewPath':'"+itm.fileViewPath+"','fileSize':'"+itm.fileSize+"','fileName':'"+itm.fileName+"','modifyDate':'"+itm.lastUpdateTime+"','filemd5':'"+itm.fileMD5+"'\" id=\""+this.key+"_"+a+"\" dragclass=\"DragDragBox\" overclass=\"OverDragBox\" class=\"DragBox\" dragobj=\"0\" origclass=\"DragBox\">"+itm.fileName+"</div>")
                            .appendTo("#f_list_"+this.key);
                            //.mouseenter(function(){addClass(this,"OverDragBox");})
                            //.mouseleave(function(){rmClass(this,"OverDragBox");});
                            
                        }
                        program.fileDrag.updateOneDragArea("f_list_"+this.key);
                    }
                }
            });
        }
    }
};

program.fileDrag={
    guid:"",
    readyDragArea:function(){
        var areas = new Array();
        $("#fileList_menu").children(".right").children("div").each(function(index, domEle){areas.push(domEle);});
        areas.push(_("100"));
        areas.push(_("101"));
        var templateAreas = _("canvasDiv").childNodes;
      // alert(templateAreas);
       
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
       //$("#canvasDiv").children("div").children("div").each(function(index, domEle){areas.push(domEle);});
    //      //createDrag(templateAreas);
   // alert(JSON.stringify(areas));
        program.fileDrag.createDrag(areas);

    },
    updateOneDragArea:function(id){
        
        dgFactory.addDragItem(program.fileDrag.guid,_(id),"div");
    },
    updateDragContainer:function(id){
        dgFactory.updateDragContainer(program.fileDrag.guid,_(id));
    },
    createDrag:function(arr_dgCon){
       
        var guid = dgFactory.init({
                clone:true,
                dragMultiple:true,
                events:{
                    mouseUp:function(info){
                        
                        fileDragMouseUp(info);
                    },
                    mouseMove:function(info){
                bug("mouseMove extend","---");
                    }
                }
            });
 
        dgFactory.newDrag(guid,arr_dgCon,"div");
        program.fileDrag.guid=guid;
        
    },
    addBgMusicAreaToDragContainer:function(){
        program.fileDrag.updateDragContainer("101");
    }
};

//模版选择列表分页
page.newPage({
            key:"temp_view",
            keyWord:"",
            pageSize:8,
            url:"index.php?control=c_templateManage&action=getTempListPage",
            success:function(data){//alert(JSON.stringify(data));
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
program.templist={
    getTemp:function(id){
        //cheng
        program.clearPlayAreaData();
        _("canvasDiv").innerHTML = ""; 
        _("101").style.display="none";
        _("fileArea").innerHTML="";
        templateObj.edit.editKey=id;
        templateObj.edit.getTemplateInfo();

            
    /*  $.ajax({
            url:"./template/ajaxPHP/getTemplateToProfile.php",
            data:{TempID:id},
            type:"POST",
            success: function(str){
               //alert(str);
                program.templist.rendering(str);
            }
        });*/
    },
    rendering:function(obj){
        //切换模板后清理掉原有的模板区域数据缓存
      
        program.clearPlayAreaData();
        _("canvasDiv").innerHTML = ""; 
        _("101").style.display="none";
        _("fileArea").innerHTML="";
        var info = obj.split("_@_@@_@_");
        //alert(info);
        var tempInfo = eval("({" + info[0].toString() + "})");
         
        var Proportion = new templateProportion(tempInfo.W + "x" + tempInfo.H, tempInfo.TempType);
         
        var pro = Proportion.checkPro();
         _("_clReso").innerHTML = tempInfo.W + "x" + tempInfo.H;
       // alert(JSON.stringify(pro));
    with(_("canvasDiv").style)
        {    
            display = "none";
            width = tempInfo.W / pro.c + "px";
            height = tempInfo.H / pro.c + "px";
        }

        _("canvasDiv").innerHTML = info[1].toString();

        with(program.info)
        {
            //action="";
            em=pro.em;
            profileName="";
            profileType=$("#program_type").val();
            profilePeriod=0;
            templateID=tempInfo.TempID;
            touchJumpUrl="";
            tempWidth=tempInfo.W;
            tempHeight=tempInfo.H;
            tempBgGround=tempInfo.BgImageName;
        }
        
        //var area =childs("canvasDiv","div");
        var area =$("#canvasDiv").children("div").not('#temp_backGroundImage');
        var oldW, oldH, oldX, oldY, style,mainArea="";
        for (var i = 0; i < area.length; i++)
        {
            var p=eval("({"+attr(area[i],"position")+"})");

            //alert(JSON.stringify(attr(area[i],"position")));
            setOpacity(area[i],70);
            with(area[i].style)
            {   
                cursor = 'default';
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
        _("canvasDiv").style.display = "block";
        setTimeout(function(){
            
                setDefaultMainArea({area:mainArea});
            
        },500);
        if (_("bgDIV"))
        {
           document.body.removeChild(_("bgDIV"));
           _("canvasDiv").style.backgroundImage = "url(BG.png)";
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
       
       program.removeBgMusic();
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
        //  var  imgurl=" ";
            for(var i=0,n=obj_info.length; i<n; i++)
            {   
               
                 //判断模板是否是快速创建节目创建的模板
                  //wh=resolutionInfo.getResById(obj_info[i]["LengthScale"]);
                if(obj_info[i]["WidthScale"]){ 
                    wh.w=obj_info[i]["LengthScale"];
                    wh.h=obj_info[i]["WidthScale"]; 
                 
                }else{
                    wh=resolutionInfo.getResById(obj_info[i]["LengthScale"]); 
                
                }


                if(typeof(wh)!="object")
                {
                    break;
                }
                var temType=Bs.template.getTypeNameByKey(obj_info[i]["TemplateType"]);
                bl=wh.h/110,
                bla=wh.w/120,
                bl=bl>bla?bl:bla,
                w=wh.w/bl,
                h=wh.h/bl,
                str="",
        //      if(obj_info[i]["extend1"]){
        //              imgurl=obj_info[i]["extend1"];
        //      }
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
                                        str+="<div style='position:absolute; background-color:red; border:1px solid; ";
                                        str+="width:"+((areas[a]["Width"])/bl-2)+"px; ";
                                        str+="height:"+((areas[a]["Height"])/bl-2)+"px; ";
                                        str+="left:"+((areas[a]["X"])/bl)+"px; ";
                                        str+="top:"+((areas[a]["Y"])/bl)+"px;'>";
                                        str+="</div>";
                                    }
                                str+="</div>";
        
                            str+="</DIV>";
                        str+="</DIV>";
                        str+="<div style='display:block; height:16px; font-size:12px; line-height:16px;'><label>"+wh.w+"x"+wh.h+"("+temType+")</label></div>";
                    str+="</div>";
                str+="</a>";
                str=$(str).click(function(){
                      // templateObj.edit.init(attr(this,"tempId"));
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

program.templistEdit = {

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
                url: "index.php/c_profileInfo/removeAreaFiles",
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
        
    }
};

program.tip={
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
    
    $("#profile_name").change(function(){program.setProfileName(this.value);});
    $("#save_button").click(program.save);
    $("#save_as_button").click(program.save_as);
    $("#getTempListBtn").click(program.templist.getTempList);
    $("#program_type").change(program.changeProgramType);
});




/*****************************************
 *
 * @discription 当用户正在移动文件时候出发的调用
 * @param info Object 用户拖拽时候的信息
 * @author bobo 2013年1月10日 18:25:24
 * 
 *  *****************************************/
function fileDragMouseMove(info){
    var dom_area=info.focusArea.domItem, 
        str_areaID=dom_area.id;
        changeFileAreaPanel(str_areaID);
}
/*****************************************
 *
 * @discription 更改文件区域容器中, 显示对应区域的文件容器界面
 * @param str_areaID string 区域 ID
 * @author bobo 2013年1月10日 18:25:24
 * 
 *  *****************************************/
function changeFileAreaPanel(str_areaID){
    str_areaID=str_areaID.toString();
    //alert(JSON.stringify( str_areaID));
    bug("changeFileAreaPanel: ","Template Area ID: "+str_areaID);
    _("file_" + str_areaID).style.display="block";
    var nodes = childs(getParentNode(_("file_" + str_areaID)),"div");
    for (var i = 0; i < nodes.length; i++)
    {
        if (nodes[i].id != ("file_" + str_areaID))
        {
            nodes[i].style.display = "none";
        }
    }
}
/*****************************************
 *
 * @discription 用户拖拽文件到相应的区域中后,执行的函数
 * @param info Object 用户拖拽时候的信息结构体{focusArea:当前的区域HTMLDom,dragItem: 第一个被选中的文件HTMLDom,dragItemArray: 当开启多选时候,被选中的HTMLDom 数组,...... 等等}
 * @author bobo 2013年1月10日 18:23:45
 * 
 *  *****************************************/
function fileDragMouseUp(info){
        //检测具体的区域, 解决区域重叠时候出现的无法拖拽到区域的BUG问题
       // alert(nodeToString(info));
    var obj_focusArea=getUserSleectArea(info.focusArea);
       
       if(!obj_focusArea){
           return false;
       }
       
        dom_area=obj_focusArea.dom.domItem, 
        str_areaID=dom_area.id,
        string_areaType=attr(dom_area,"areaType");
        dom_dragItem=info.dragItem,
        fileInfo=eval("({"+attr(dom_dragItem,"fileInfo")+"})");
        if(!isType(fileInfo,"Object")){
            alert("您的文件信息不对!");
            return false;
        }
        //检测  文件类型和区域类型是否匹配 主区域不用检测
        //alert(attr(dom_area, "mainType")+" "+checkFileTypeForArea(string_areaType , fileInfo.fileType))
        if((attr(dom_area, "mainType") != "Y")&&(checkFileTypeForArea(string_areaType , fileInfo.fileType)!=true))
        {
            return false;
        }
         // alert(JSON.stringify(obj_focusArea.dom.domItem.id));
        //显示当前区域的对应的文件列表界面
        changeFileAreaPanel(str_areaID);
        var dom_fileItem="",arr_notMainAreaFiles=[];
        for(var i =0, n=info.dragItemArray.length; i<n; i++)
        {
            //_("apDiv3").appendChild(info.dragItemArray[i]);
            //bug("----",print_r(info));
            dom_fileItem=info.dragItemArray[i];
            dom_fileItem.setAttribute("id", "file_" + str_areaID + "_" + dom_fileItem.id);
            var fileInfo = eval("({" +  attr(dom_fileItem,"fileInfo") + "})");
            attr(dom_fileItem,"key",str_areaID);
            // 检查是否存在相同文件
            if (checkFileInArea(fileInfo.filemd5, _("file_" + str_areaID)))
            {
                if(!confirm("当前区域已存在此文件: \"" + html(dom_fileItem) +"\" 是否继续添加!"))
                {
                    continue;
                }
                else
                {
                    // 当有重复文件存在时候, 解决 新HTMLDom节点的ID重复问题
                    dom_fileItem.setAttribute("id", "file_" + str_areaID + "_" + dom_fileItem.id + "_"+(new Date()).getMilliseconds());
                }
            }
            if (attr(dom_area, "mainType") == "Y") //主区域文件处理
            {
                appendToAreaFileList(dom_fileItem,str_areaID);
                setDefaultInfo(_("file_info"), dom_fileItem.id);
                program.addFileCache(dom_fileItem);
                var playInfo = eval("({" +  attr(dom_fileItem,"playInfo") + "})");
                program.countOfPlayTime(playInfo.playTime);
            }
            if(attr(dom_area, "mainType") == "N"){//非主区域
                
                if(attr(dom_area, "areatype")=="Txt"&&fileInfo.fileSize>2048)
                {
                    art.dialog({
                        content: '滚动字幕的文本文件的大小不能超过2Kb!',
                        ok: function () {
                            this.close();
                        }
                    });
                    return ;
                }
                arr_notMainAreaFiles.push(dom_fileItem);
            }
            
        }
        
        if(arr_notMainAreaFiles.length){
            downloadFiles(arr_notMainAreaFiles,str_areaID);
        }
}
/*****************************************
 *
 * @discription 当区域重叠时候,找出正确的区域
 * @param arr_focusAreas array 包含鼠标位置的区域
 * @author bobo 2013年1月10日 21:20:18
 * 
 *  *****************************************/
function getUserSleectArea(arr_focusAreas){
    //首先检测 HTMLDom 的顺序
    /*
     * 注释 在建立模板时候, 顺序号越小, 则此区域越接近地层,
     *      顺序号越大,越接近顶层 
     *
     */
    var obj_OrderAreas=[],order=0, 
        arr_areas= $("#canvasDiv").children("div");
    for(var i=0, n=arr_areas.length; i<n; i++){
        for(var a=0, b=arr_focusAreas.length; a<b; a++){
            if(arr_focusAreas[a].domItem==arr_areas[i])
            {
                obj_OrderAreas.push({order:order,dom:arr_focusAreas[a]});
            }
        }
    }
    //背景音乐区域
    var bgMusic_dom=_("101");
    for(var a=0, b=arr_focusAreas.length; a<b; a++){
            if(arr_focusAreas[a].domItem==bgMusic_dom)
            {
                obj_OrderAreas.push({order:order,dom:arr_focusAreas[a]});
            }
    }
    return obj_OrderAreas[obj_OrderAreas.length-1];
}
/*****************************************
 *
 * @discription 将用户选择的文件, 拷贝一份到用户节目缓存文件夹中
 * @param arr_files array 用户选择的文件队列 HTMLDocument list
 * @param str_areaID string 区域 ID
 * @author bobo 2013年1月10日 18:10:21
 * 
 *  *****************************************/
 //文本对象转化为字符串
 function nodeToString ( node ) {  
   var tmpNode = document.createElement( "div" );  
   tmpNode.appendChild( node.cloneNode( true ) );  
   var str = tmpNode.innerHTML;  
   tmpNode = node = null; // prevent memory leaks in IE  
   return str;  
} 
function downloadFiles(arr_files,str_areaID){
   // alert(arr_files);
  //cheng
    program.tip.fileDragTip("<div style='display:block;'>文件下载中......</div>");
    var fileCacheFolder=attr("profile_name","cacheName");
    //alert(fileCacheFolder);
    if(program.info.action=="edit")
    {
        fileCacheFolder=program.edit.oldInfo.programName;
    }
    //
    if(typeof(arr_files) == "object"){
       var arr_fileName=[],_arr_files=[];
      for(var i =0, n=arr_files.length; i<n; i++){
        
        arr_fileName.push(arr_files[i].innerHTML);
        _arr_files[_arr_files.length]=$("<p></p>").append(arr_files[i]).html(); 
    }
//alert(JSON.stringify(fileCacheFolder));
    var obj_info={file_name:arr_fileName,folder_Name:fileCacheFolder}; 
    }else{
         var arr_fileName=[],_arr_files=[];

       
        arr_fileName.push(arr_files);
        var obj_info={file_name:arr_fileName,folder_Name:fileCacheFolder};
    }
      //alert(JSON.stringify(obj_info));   
    $.ajax({
        type:"post",
        url: "index.php?control=c_profileInfo&action=copyFilesToCacheFolder",
        data:{data:obj_info},
        success:function(data, textStatus, jqXHR){
           // alert(JSON.stringify(data));
            data=$.parseJSON(data);
            if(typeof(data)=="object")
            {
                if(data.state)
                {
                    var arr_files=_arr_files;
                    for(var i =0, n=arr_files.length; i<n; i++){

                        arr_files[i]=$(arr_files[i])[0];
                        
                       appendToAreaFileList(arr_files[i],str_areaID);
                        setDefaultInfo(_("file_info"), arr_files[i].id); //将文件加入区域队列
                        program.addFileCache(arr_files[i]); //将文件加入缓存队列

                    }
                    
                    downloadFileTip("succes");

                    return ;
                }
                else
                {
                    if(data.hasOwnProperty("extend")){
                        var arr_files=_arr_files;
                        program.tip.fileDragTip("<div style='display:block;'>"+data.extend+"</div>");
                        for(var i =0, n=arr_files.length; i<n; i++){
                            arr_files[i]=$(arr_files[i])[0];
                            for(var a=0,b=data.data.length; a<b; a++){
                                if(data.data[a]==arr_files[i].innerHTML){
                                    continue ;

                                    appendToAreaFileList(arr_files[i],str_areaID);
                                    setDefaultInfo(_("file_info"), arr_files[i].id); //将文件加入区域队列中
                                    program.addFileCache(arr_files[i]); //将文件加入缓存队列
                                }
                            }
                            
                        }
                    }
                    else
                    {downloadFileTip("failed");}
                }
            }
            downloadFileTip("failed");
            },
        timeout:function(){downloadFileTip("timeout");},
        error:function(){downloadFileTip("error");}
        });
}

/*****************************************
 *
 * @discription 检测文件类型是否符合, 指定的区域类型;
 * @param areaType string 区域类型
 * @param fileType string 文件类型
 * @author bobo 2013年1月10日 18:14:21
 * 
 *  *****************************************/
function checkFileTypeForArea(areaType,fileType){
    bug("checkFileTypeForArea: ","areaType: "+areaType+" fileType: "+fileType);
    var arr_fileType={Video:"Video",Img:"Img",Swf:"Swf",Txt:"Txt",Url:"Url",Url1:"Url",Url2:"Url",Audio:"Audio",LED:"LED"};
    if(areaType==arr_fileType[fileType]){return true;}
    return false;
}


function appendToAreaFileList(curTarget,areaid){
    
    var curTargetId=curTarget.id,fileInfo= eval("({" + attr(curTarget, "fileInfo") + "})");
    //alert(JSON.stringify($(curTarget)));
    //alert(areaid); 
    _("file_" + areaid).appendChild(curTarget);
  
  _("fileArea_a_" + areaid).innerHTML=_("fileArea_a_" + areaid).innerHTML+fileInfo.fileName+"<br>";
  
   curTarget.className="areaFileItem";
    var areaTp = attr(_(areaid), "ledType");
    var key =curTarget.getAttribute("key");
    var setInfo = function ()
    {
        return updateFileInfo(fileInfo.fileType, areaTp, curTargetId, key);
    };
    curTarget.attachEvent("onclick", setInfo);
    var editFList = function ()
    {
        return editFileList(curTargetId);
    };
    curTarget.attachEvent("onclick", editFList);
    
    // $(curTarget).click(function(){
        // var fileInfo=eval("({" + $(this).attr("fileInfo") + "})");
        // console.log("%O",fileInfo)
        // updateFileInfo(fileInfo.fileType, areaTp, curTargetId, key);
        // editFileList(curTargetId);
    // });
    updateFileInfo(fileInfo.fileType, areaTp, curTargetId, key);
}




function downloadFileTip(state)
{
    if (state=="succes")
    {
        program.tip.fileDragTip("<div style='display:block; color:green;'>文件处理成功！</div>");
        window.setTimeout(function(){program.tip.fileDragTipClose();}, 1000);
    }
    else if(state=="faild")
    {
        program.tip.fileDragTip("<div style='display:block; color:red;'>文件下载失败！</div>");
    }
    else if(state=="timeout")
    {
        program.tip.fileDragTip("<div style='display:block; color:red;'>您的请求超时,请重试！</div>");
    }
    else
    {
        program.tip.fileDragTip("<div style='display:block; color:red;'>无法下载您指定的文件,请到资源管理中删除此文件,<br />重新上传重试！</div>");
    }

}

function createCoverDIV()
{
    try
    {
        _("coverDIV").innerHTML = "";
        document.body.removeChild(_("coverDIV"));
    }
    catch (e)
    {
    }
    var css = "position:absolute; top:0px; left:0px;display:block; background-color:#ccc;z-index:100;";
    var cover = document.createElement("div");
    cover.id = "coverDIV";
    var w = "";
    var h = "";
    if (document.all)
    {
        oty = "filter:alpha(opacity=30)";
        w = document.documentElement.scrollWidth;
        h = document.documentElement.clientHeight;
    }
    else
    {
        oty = "opacity:0.3;";
        w = document.documentElement.scrollWidth;
        h = document.documentElement.clientHeight;
    }
    cover.style.cssText = css + "height:" + h + "px; width:" + w + "px;" + oty;
    cover.innerHTML = "<table style=\"height:" + h + "px; width:" + w + "px;font-size:20px; color:green;\"><tr><td align=center valign=middle id=\"message\">信息加载中......</td></tr></table>";
    document.body.appendChild(cover);
}

function updateFileInfo(fileType, areaType, id, key)
{
    var fileInfoArea = _("file_info");
    if (fileType == "Video")
    {
        fileInfoArea.innerHTML = "播放时长:<input class='fileAttrbuteBtn' onkeyup=\"setTextInputValue(this)\" id='playTime_" + id + "' type='text' itmValue='20' value='20' itm='playTime' />(秒)<br> 播放次数:<input class='fileAttrbuteBtn' type='text' itmValue='1' value='1' itm='replayCount' onkeyup=\"setTextInputValue(this)\" /><div style='width:20%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
    }
    if (fileType == "Img")
    {
        fileInfoArea.innerHTML = "播放时长:<input class='fileAttrbuteBtn' type='text' itmValue='3' value='3' itm='playTime' onkeyup=\"setTextInputValue(this)\" />(秒)<br> 播放次数:<input class='fileAttrbuteBtn' type='text' itmValue='1' value='1' itm='replayCount' onkeyup=\"setTextInputValue(this)\" /> <div style='width:20%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
    }
    if (fileType == "Swf")
    {
        fileInfoArea.innerHTML = "播放时长:<input class='fileAttrbuteBtn' type='text' itmValue='20' value='20' itm='playTime' onkeyup=\"setTextInputValue(this)\" />(秒)<br> 播放次数:<input class='fileAttrbuteBtn' type='text' itmValue='1' value='1' itm='replayCount' onkeyup=\"setTextInputValue(this)\" /> <div style='width:20%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
    }
    if (fileType == "Txt" || fileType == "Url2")
    {
        var str = "播放时长:<input class='fileAttrbuteBtn' type='text' itmValue='20' value='20' itm='playTime' onkeyup=\"setTextInputValue(this)\" />(秒)<br>字体类型:<INPUT type='button' class='fileAttrbuteBtn' id='font_type_btn' onclick=\"fontType(event)\" itm='font' itmValue='simsun.ttc' value='宋体' />";
        str+="<INPUT type='hidden' id='font_typeName_btn' itm='fontName' itmValue='宋体' value='宋体' /><br>";
        str += "文字大小:<br>";
        str += "  <input type='radio' name='txt_f_size' id='txt_f_size_a' onfocus='setScrollFontSize(this)' checked='true' /><label for='txt_f_size_a'>自动</label>";
        str += "  <input type='radio' name='txt_f_size' id='txt_f_size_b' onfocus='setScrollFontSize(this)' /><label for='txt_f_size_b'>手动</label><input style='width:25px; height:12px;  display:none;' type='text' itmValue='1' itm='fontsize' value='1' onkeyup='setFontSize(this)' id='txt_f_size_input' /><br>";
        str += "文字颜色:<input  class='fileAttrbuteBtn'  style=' background-color:#000000;' type='button' value='#000000' itm='fontcolor' itmValue='#000000'  id='font_color_btn' onclick=\"setColor(event)\" /><br>";
        str += '背景颜色:<input  class="fileAttrbuteBtn"  style=" background-color:#ffffff;" type="button" value="#ffffff" itm="bgcolor" itmValue="#ffffff"  id="fontbg_color_btn"  onclick="setbggroundColor(event)" /><br>';
        str += '滚动速度:<input  class="fileAttrbuteBtn" type="button" itm="scrollamount" itmValue="3" value="3" id="scrollamount" onclick="setScrollSpeed(event)"><br>';
        str += "滚动方向:<input class='fileAttrbuteBtn' itmValue='left' type='button' value='left' itm='direction' disabled='disabled' /><br>";
        str += "播放次数:<input class='fileAttrbuteBtn'  itmValue='1' onkeyup=\"setPlayCount(this)\"  type='text' value='1' itm='replayCount' /><br>";
        str += "<div style='width:20%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
        fileInfoArea.innerHTML = str;
     
    }
/*  if (fileType == "Txt" && areaType == "LED")
    {
        var str = "字体类型:<button class='font_type_btn' id='fontTPUI' onclick=\"fontType_Font(event)\">宋体</button><INPUT type='hidden' style=\"width:55px;\" itm='font' id='fontTP' value='%E5%AE%8B%E4%BD%93' /><br>";
        str += "文字大小:<input class='fileAttrbuteBtn' type='text' value='14' itm='fontsize' /><input style=\"display:none;\" type='text' value='#000000' itm='bgcolor' /><br>";
        str += "字体颜色:<input class='fileAttrbuteBtn' type='hidden' value='0' id='fontcolor_id' itm='fontcolor' />";
        str += "<select onchange=\"setFontColor(this)\">";
        str += "<option value='0' selected>红色</option>";
        str += "<option value='1' >绿色</option>";
        str += "<option value='1' >蓝色</option>";
        str += "</select><br>";
        str += "字体样式:<input type='checkbox' value='400' itm='fontB' id='fontB'/><label for='fontB' onclick=\"setFontDisplay('fontB',700)\">粗体</label>";
        str += "<input type='checkbox' value='0' itm='fontI' id='fontI'/><label for='fontI' onclick=\"setFontDisplay('fontI',1)\">斜体</label>";
        str += "<input type='checkbox' value='0' itm='fontU' id='fontU'/><label for='fontU' onclick=\"setFontDisplay('fontU',1)\">下划线</label><br>";
        str += "Y  坐标:<input class='fileAttrbuteBtn' type='text' value='0' itm='top' /> ";
        str += "X  坐标:<input class='fileAttrbuteBtn' type='text' value='0' itm='left' /><br>";
        str += "LED宽:<input class='fileAttrbuteBtn' type='text' value='64' itm='width' />";
        str += "LED高:<input class='fileAttrbuteBtn' type='text' value='16' itm='height' /><br>";
        str += "滚动速度:<input class='fileAttrbuteBtn' type='text' value='1' itm='scrollamount' /><br>";
        str += "滚动方向:<input class='fileAttrbuteBtn' type='hidden' value='0' id='direction' itm='direction' />";
        str += "<select onchange=\"setDisplayType(this)\">";
        str += "<option value='0' selected>随机</option>";
        str += "<option value='1' >直接显示</option>";
        str += "<option value='2' >向上移入</option>";
        str += "<option value='3' >向左移入</option>";
        str += "<option value='4' >溶入</option>";
        str += "<option value='5' >中心向四周展开</option>";
        str += "<option value='6' >向下移入</option>";
        str += "<option value='7' >向右移入</option>";
        str += "<option value='8' >水平百叶窗</option>";
        str += "<option value='9' >垂直百叶窗</option>";
        str += "<option value='10' >闪烁</option>";
        str += "</select><br>";
        str += "播放次数:<input class='fileAttrbuteBtn' type='text' value='1' itm='replayCount' disabled='disabled'/>";
        str += "停留时间:<input class='fileAttrbuteBtn' type='text' value='1' itm='delayTime' /><br>";
        str += "<div style='width:100%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
        fileInfoArea.innerHTML = str;
    }*/
    if (fileType == "Audio")
    {
        var str = "播放时长:<input class='fileAttrbuteBtn' type='text' itmValue='80' value='80' itm='playTime' onkeyup=\"setTextInputValue(this)\" />(秒)<br>";
        str += "播放次数:<input class='fileAttrbuteBtn' type='text' itmValue='1' value='1' itm='replayCount' onkeyup=\"setTextInputValue(this)\" /><br>";
        str += "声音大小:<input class='fileAttrbuteBtn' type='text' itmValue='100' value='100' itm='volume' onkeyup=\"setTextInputValue(this)\" /><br>";
        str += "<div style='width:20%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
        fileInfoArea.innerHTML = str;
        //alert(str);
    }
    if (fileType == "Url")
    {
        var str = "播放时长:<input class='fileAttrbuteBtn' type='text' itmValue='80' value='80' itm='playTime' onkeyup=\"setTextInputValue(this)\" />(秒)<br>";
        str += "<div style='width:20%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
        str+= "<input id='scrollType' itmValue='0' class='fileAttrbuteBtn' type='hidden' value='0' itm='direction' />";
        fileInfoArea.innerHTML=str;
        //alert(str);
    }
    if (fileType == "Url1")
    {
        var str = "播放时长:<input class='fileAttrbuteBtn' type='text' itmValue='80' value='80' itm='playTime' onkeyup=\"setTextInputValue(this)\" />(秒)<br>";
        str += "<div style='width:20%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
        str+= "<input id='scrollType' itmValue='0' class='fileAttrbuteBtn' type='hidden' value='0' itm='direction' />";
        fileInfoArea.innerHTML=str;
    }
    
    if (_(id) && attr(_(id), "playInfo"))
    {
        readFileInfo(id, fileType);
    }
}
//--滚动字幕大小自适应


function setScrollFontSize(o)
{
    if (o.id == "txt_f_size_a")
    {
        _("txt_f_size_input").style.display = "none";
    }
    else
    {
        _("txt_f_size_input").style.display = "";
    }
}

function setFontColor(obj)
{
    _("fontcolor_id").value = obj.value;
}

function setDisplayType(obj)
{
    _("direction").value = obj.value;
}

function setFontDisplay(obj, string)
{
    _(obj).value = string;
}



/*function fontType_Font(ev)
{
    $("#bgcolor_c").remove();
    var cs = "display:block; width:80px; padding:2px; border:#999 solid 1px; margin:2px;float:left;";
    var font = "<LABEL  style='" + cs + "' value='%E5%AE%8B%E4%BD%93' onClick=\"setFontType(this)\">宋体</LABEL><LABEL  style='" + cs + "' value='%E4%BB%BF%E5%AE%8B' onClick=\"setFontType(this)\">仿宋</LABEL><LABEL  style='" + cs + "' value='%E9%BB%91%E4%BD%93' onClick=\"setFontType(this)\">黑体</LABEL><LABEL  style='" + cs + "' value='%E6%A5%B7%E4%BD%93_GB2312' onClick=\"setFontType(this)\">楷体</LABEL><LABEL  style='" + cs + "' value='%E9%9A%B6%E4%B9%A6' onClick=\"setFontType(this)\">隶书</LABEL><LABEL  style='" + cs + "' value='%E5%B9%BC%E5%9B%AD' onClick=\"setFontType(this)\">幼园</LABEL><LABEL  style='" + cs + "' value='%E6%96%B9%E6%AD%A3%E8%88%92%E4%BD%93' onClick=\"setFontType(this)\">方正舒体</LABEL><LABEL  style='" + cs + "' value='%E6%96%B9%E6%AD%A3%E5%A7%9A%E4%BD%93' onClick=\"setFontType(this)\">方正姚体</LABEL><LABEL  style='" + cs + "' value='%E5%8D%8E%E6%96%87%E9%9A%B6%E4%B9%A6' onClick=\"setFontType(this)\">华文隶书</LABEL><LABEL  style='" + cs + "' value='%E5%8D%8E%E6%96%87%E6%96%B0%E9%AD%8F' onClick=\"setFontType(this)\">华文新魏</LABEL><LABEL  style='" + cs + "' value='%E5%8D%8E%E6%96%87%E8%A1%8C%E6%A5%B7' onClick=\"setFontType(this)\">华文行楷</LABEL><LABEL  style='" + cs + "' value='Arial' onClick=\"setFontType(this)\">Arial</LABEL>";
    var DW = new DivWindow();
    var myWD = DW.createContainer(ev, "fontType_", null, null, "../JavaScript");
    if (myWD != false)
    {
        myWD.WindowBody.innerHTML = font;
        myWD.WindowBody.style.width = "180px";
    }
}*/

function setTextInputValue(obj)
{
    attr(obj,"itmValue", obj.value);
}


/******************Txt文件属性设置**********************************************************************************/

//设置滚动速度
function setScrollSpeed(ev)
{
    var itm="";
    for(var i =1; i<7; i++)
    {
        itm+="<a href='javascript:void(0)' class='scrollSpeed_label' value='"+i+"' onClick=\"setScrollSpeedValue(this)\">"+i+"</a>";
    }
    popup.open({key:"scrollSpeed",event:ev,content:itm,width:121,height:70,follow:_("scrollamount")});
}
function setScrollSpeedValue(obj){
    _("scrollamount").value = obj.innerHTML;
    attr("scrollamount","itmValue", attr(obj, "value"));
}

//设置字体类型
function fontType(ev)
{
    var itm="";
    for(var i in Bs.fontInfo.font)
    {
        itm+="<a href='javascript:void(0)' class='font_label' value='"+Bs.fontInfo.font[i][0]+"' onClick=\"setFontType(this)\">"+Bs.fontInfo.font[i][1]+"</a>";
    }
    popup.open({key:"fontMenu",event:ev,content:itm,width:140,height:130,follow:_("font_type_btn")});

}
function setFontType(obj)
{
    _("font_type_btn").value = obj.innerHTML;
    attr("font_type_btn","itmValue", attr(obj, "value"));
    attr("font_typeName_btn","itmValue", obj.innerHTML);
    attr("font_typeName_btn","value", obj.innerHTML);
}



//设置文字颜色
function setColor(ev)
{
    
     var cm = new colorMap("font");
     var color=document.createElement("div");
     color.innerHTML=cm.getColorTable();
     color.appendChild(cm.ColorTable(setfontcolor));
     popup.open({key:"fontColorMenu",event:ev,content:color,width:210,height:182,follow:_("font_color_btn")});

}
function setfontcolor(obj)
{
    _("font_color_btn").style.backgroundColor = obj;
    _("font_color_btn").value = obj;
    attr("font_color_btn","itmValue", obj);
}



//设置背景颜色
function setbggroundColor(ev)
{
    $("#fontType_").remove();
    $("#m_k").remove();
    var cm = new colorMap("bg");
     var color=document.createElement("div");
     color.innerHTML=cm.getColorTable();
     color.appendChild(cm.ColorTable(setbgColor));
     popup.open({key:"fontBgColorMenu",event:ev,content:color,width:210,height:182,follow:_("fontbg_color_btn")});
    var sssColor=function(){
        $("#bgcolor_c").remove();
        $(document).unbind("click",sssColor);
    };
    $(document).click(sssColor);
    stopBubble(ev);
}
function setbgColor(obj)
{
    _("fontbg_color_btn").style.backgroundColor = obj;
    _("fontbg_color_btn").value = obj;
    attr("fontbg_color_btn","itmValue", obj);
}



// 设置播放次数
function setPlayCount(obj)
{
    attr(obj,"itmValue", obj.value);
}


//设置字体大小
function setFontSize(obj){
    attr(obj,"itmValue", obj.value);
}
/****************************************************************************************************************/





/*************************************
  功能:
      设置文件件播放属性
  参数:
      参数1 ev ---> 事件对象,参数2 string --> 文件UI id
  返回值: 
  时间: 2012年9月7日 13:53:32 by bobo
*************************************/
function setFileInfo(ev, id)
{
    var key=attr(id,"key");
    var obj_playInfo = program.info.playAreaInfo[key].files[id].playInfo;
    
    ev = ev || window.event;
    var target = ev.target || ev.srcElement;
    var fileAttrUi = childs(target.parentNode.parentNode,"input"),
        itm = "";
    var playInfo = "";
    for (var i = 0; i < fileAttrUi.length; i++)
    {
        
        itm = fileAttrUi[i];
        if(itm.type=="radio"){continue;}
        playInfo += "'" + attr(itm, "itm") + "':\'" + attr(itm,"itmValue")+ "\',";
        obj_playInfo[attr(itm, "itm")]=attr(itm,"itmValue");
    }
    playInfo = playInfo.substring(0, playInfo.length - 1);
    _(id).setAttribute("playInfo", playInfo);
    popup.open({key:"setFileAttr",event:ev,content:"设置成功",width:100,height:26,follow:target});
}

function setDefaultInfo(fileAreaObject, id)
{
    
    bug("设置之前的值id:", id);
    bug("读取被设置之前的播放属性", attr(id, "playInfo"));
    var fileInfo = fileAreaObject.childNodes;
    var playInfoStr = "",
        itm = "";
    for (var i = 0; i < fileInfo.length; i++)
    {
        itm = fileInfo[i];
        if (itm.nodeName != "#text")
        {
            if (itm.tagName == "INPUT")
            {
                playInfoStr += "'" + attr(itm, "itm") + "':\'" + attr(itm,"itmValue") + "\',";
            }
        }
    }
    playInfoStr = playInfoStr.substring(0, playInfoStr.length - 1);
    bug("被设置的播放属性", playInfoStr);
    attr(id, "playInfo", playInfoStr);
    bug("读取被设置的播放属性", attr(id, "playInfo"));
}

/*************************************
  功能:
      读取文件的播放信息,显示到界面
  参数:
      参数1 string --> 文件对象的ID,参数2 string --> 文件类型 Txt Video....
  返回值: 
  时间: 2012年9月6日 17:22:55 by bobo
*************************************/
function readFileInfo(id, fileType)
{
    var fileInfoArea = _("file_info");
    var fileDom = childs(fileInfoArea,"input");
    var playInfo = attr(_(id), "playInfo");
    playInfo = eval("({" + playInfo + "})");
    var fi = "";
    for (var itm in playInfo)
    {
        for (var i = 0; i < fileDom.length; i++)
        {
            fi = fileDom[i];
            if (itm.toString() == attr(fi, "itm"))
            {
                
                if (fileType == "Txt")
                {
                    switch(itm)
                    {
                        case "font": 
                            fi.value=Bs.fontInfo.getFontNameByFileName(playInfo[itm]);
                            //设置字体名称
                            _("font_typeName_btn").value=fi.value; 
                            attr(_("font_typeName_btn"),"itmValue",fi.value);
                            break; 
                        break;
                        
                        case "fontsize": fi.value=playInfo[itm]; if(fi.value=="1"){_("txt_f_size_a").checked=true;} break;
                        case "fontcolor": fi.value=playInfo[itm]; fi.style.backgroundColor=playInfo[itm]; break;
                        case "bgcolor": fi.value=playInfo[itm]; fi.style.backgroundColor=playInfo[itm]; break;
                        case "scrollamount": fi.value=playInfo[itm]; break;
                        case "direction": fi.value=playInfo[itm]; break;
                        case "replayCount": fi.value=playInfo[itm]; break;
                    };
                }
                else
                {fi.value = playInfo[itm].toString();}
                attr(fi,"itmValue",playInfo[itm]); 
            }
        }
    }
}

function editFileList(fileItemDivId)
{
    var itms = _(fileItemDivId).parentNode.childNodes,
        itm = "";
    for (var i = 0; i < itms.length; i++)
    {
        itm = itms[i];
        if (itm.nodeName != "#text" || itm.tagName == "DIV")
        {
            if (itm.id == fileItemDivId)
            {

                itm.style.backgroundColor = "#F9FFB0";
                bindId(itm.id);
            }
            else
            {
                itm.style.backgroundColor = "#fff";

            }
        }
    }
}

function closeCoverDIV()
{
    _("coverDIV").style.display = "none";
    try
    {
        _("coverDIV").innerHTML = "";
        document.body.removeChild(_("coverDIV"));
    }
    catch (e)
    {
    }
}
/*************************************
  功能:
      给区域文件列表中文件的操作按钮,
      绑定文件ID
  参数:
      id string: 文件ID
  返回值: 无返回值
  时间: 2011-10-19 16:13:01
  作者: BOBO
*************************************/
function bindId(id)
{
    _("fl_moveUp").setAttribute("move_id", id);
    _("fl_moveDown").setAttribute("move_id", id);
    _("fl_del").setAttribute("move_id", id);
    if(_("fl_relevance")){_("fl_relevance").setAttribute("relevance_id", id);}

}

function dropDragAreaCheck(obj)
{

    var unique=function(arr){
            var a ={};
            for (var i = 0; i < arr.length; i++)
            {
                if (typeof(a[arr[i]]) == "undefined")
                {
                     a[arr[i]] = 1;
                };
            }
            arr=[];
            for (var b in a)
            {
                arr[arr.length] = b;
            }
            return arr;
        };
    var areas = ["DragContainer_shipin", "DragContainer_tupian", "DragContainer_wenben", "DragContainer_Audio", "DragContainer_Swf", "DragContainer_Url"];
    var OldArr = areas.length;
    areas.push(obj);
    var NewArr = unique(areas).length;
    if (OldArr == NewArr)
    {
        return false;
    }
    else
    {
        return true;
    }
}

//-----------------------------
//  功能: 检查一文件是否存在当前区域
//  str_file_info    文件MD5
//  obj_file_area    文件区域
//
//-----------------------------


function checkFileInArea(str_file_info, obj_file_area)
{
    var domArr = getChildNodes(obj_file_area, "div");
    var int_len = domArr.length;
    //此区域中没有文件
    if (domArr.length == 0)
    {
        return false;
    }

    //此区域中有文件,则检查
    var obj_att = "";
    for (var i = 0, n = int_len; i < n; i++)
    {
        bug("checkFileInArea", typeof(domArr[i]));
        obj_att = eval("({" + attr(domArr[i], "fileInfo") + "})");
        if (obj_att["filemd5"] == str_file_info)
        {
            return true;
        }
    }
    return false;
    
}
/*************************************
    功能:
        为指定的文件关联其他文件
    参数:
        dom_obj:dom对象
    返回值: string
    时间: 2011-10-19 15:29:17
    作者: BOBO
*************************************/
function setRelevanceFile(dom_obj)
{
    var str_id=attr(dom_obj,"relevance_id");
    var str_title=attr(str_id,"fileInfo");
    var obj_title=eval("({"+str_title+"})");
    var str_fileMd5=obj_title["filemd5"];
    bug("setRelevanceFile",str_id+" "+str_title);
    //获取可以关联的区域;
    areaDisplayState("areatype=Img",
                    function(dom_obj){
                        bindLeftClick(dom_obj,relevanceFileListUI);
                        attr(dom_obj,"relevanceFileMd5",str_fileMd5);
                        attr(dom_obj,"relevanceFileId",str_id);
                    },
                    function(dom_obj)
                    {

                       dom_obj.style.display="none";
                    });
}

/*************************************
  功能:
      显示用户所选择的区域中的文件列表
  参数:
      参数1 string ,参数2 int
  返回值: string
  时间:
  作者: BOBO
*************************************/
function relevanceFileListUI(ev)
{
    var dom_obj=evTag(ev);
    var relevanceFileMd5=attr(dom_obj,"relevanceFileMd5");
    var relevanceFileId=attr(dom_obj,"relevanceFileId");
    bug("relevanceFileListUI","area Id: "+dom_obj.id);
    var domArr_fileList=childs("file_"+dom_obj.id,"div");
    if(domArr_fileList.length>0)
    {

        var str_temp='<div style="display:block;line-height:16px;"><input type="checkbox" value="md5" filepath="fpath" />textName</div>';
        var str_ui="";
        var obj_title;
        for(var i=0,n=domArr_fileList.length; i<n; i++)
        {
            obj_title = eval("({"+attr(domArr_fileList[i],"fileInfo")+"})");
            str_ui += str_temp.replace("md5",obj_title["filemd5"]).replace("fpath",obj_title["filePath"]).replace("textName",obj_title["fileName"]);
        }
        str_ui='<div id="relevanceFileListUI_">'+str_ui+'</div><div style="display:block; width:40px; margin-left:auto; margin-right:auto;"><a href="javascript:void(0)" class="abtn_left" onClick="getRelevanceFile(\''+relevanceFileMd5+'\',\''+relevanceFileId+'\')" id="relevance_ok"><span class="abtn_right">确定</span></a></div>';
        bug("relevanceFileListUI","<textarea style='width:100%; height:100px;'>UI: "+str_ui+"</textarea");
        art.dialog({
        title:'请选择您要关联的文件',
        id:'_relevanceFileListUI',
        skin: 'chrome',

        lock:true,
        content: str_ui
    });
    }

}
/*************************************
  功能:
      获取选择的文件的信息
      绑定到要关联的文件
  参数:
      relevanceFileMd5 string ->关联文件的MD5,
      relevanceFileId string  ->关联文件的ID
  返回值: string
  时间: 2011-10-20 16:55:47
  作者: BOBO
*************************************/
function getRelevanceFile(relevanceFileMd5,relevanceFileId)
{
    var dom_dv=childs("relevanceFileListUI_","div");
    var dom_ipt,arr_fileName=[],str_fileName="";
    for(var i=0,n=dom_dv.length; i<n; i++)
    {
        dom_ipt=getFirstChild(dom_dv[i]);
        //alert(dom_ipt.checked);
        if(dom_ipt.checked)
        {
            arr_fileName.push("'"+attr(dom_ipt,"filepath")+"'");
        }
    }
    str_fileName=arr_fileName.join(",");
    var relevanceFileInfo="'relevancefileinfo':{'relevanceFileMd5':'"+relevanceFileMd5+"','relevanceFile':["+str_fileName+"]}";
    attr(relevanceFileId,"relevanceFileInfo",relevanceFileInfo);
    //显示已经隐藏的区域的
    areaDisplayState("mkl=div",function(){},function(dom_obj){
        dom_obj.style.display="block";
        removeListener(dom_obj,"click",relevanceFileListUI);
    });
    art.dialog.get('_relevanceFileListUI').close();
}
/*************************************
  功能:
      显示或者隐藏指定条件的区域
      并且为指定的区域绑定相关事件
  参数:
      str_info string -> 筛选条件,
      fun_dis  function -> 符合条件的将要执行的方法
      fun_non  function -> 不符合条件的将要执行的方法
  返回值: 无
  时间: 2011-10-20 16:50:21
  作者: BOBO
*************************************/
function areaDisplayState(str_info,fun_dis,fun_non)
{
     //获取可以关联的区域;
    var dom_areas=childs("canvasDiv","div");
   // alert(JSON.stringify(dom_areas));
    var dom_bgMusic=_("101").style.display;
    //如果画布中的区域大于一个或者存在背景音乐区域
    //就开始选在关联区域
    if(dom_areas.length>1||dom_bgMusic=="block")
    {
        var arr_info=str_info.split("=");
        for(var i=0,n=dom_areas.length; i<n; i++)
        {
            if(attr(dom_areas[i],arr_info[0])==arr_info[1])
            {

                if(typeof(fun_dis)=="function"){fun_dis(dom_areas[i]);}

            }
            else
            {

                if(typeof(fun_non)=="function"){fun_non(dom_areas[i]);}
            }
        }

    }
}

function fileMoveDown(obj)
{
    var movedId = attr(obj, "move_id");
    if(movedId==null){return ;}
    var movedObject = _(movedId);
    var fileArea = movedObject.parentNode;
    var movedObjectBeforItm = movedObject.nextSibling;
    if (movedObjectBeforItm != null)
    {
        movedObject.parentNode.insertBefore(movedObject, (movedObject.nextSibling).nextSibling);
    }
    else
    {
        movedObject.parentNode.insertBefore(movedObject, fileArea.firstChild);
    }
    program.restAreaFileListIndex(fileArea.getAttribute("key"));
}

function fileMoveUp(obj)
{
    var movedId = attr(obj, "move_id");
    if(movedId==null){return ;}
    var movedObject = _(movedId);
    var fileArea = movedObject.parentNode;
    var movedObjectBeforItm = movedObject.previousSibling;
    if (fileArea.lastChild != movedObjectBeforItm)
    {
        fileArea.insertBefore(movedObject, movedObjectBeforItm);
    }
    else
    {
        fileArea.insertBefore(movedObject, fileArea.firstChild);
    }
    program.restAreaFileListIndex(fileArea.getAttribute("key"));
}

function fileDelte(obj)
{//
        
    var ID = attr(obj, "move_id");
    //删除区域文件
    //alert(ID);
    if(ID.split("_")[0]=='file'){
        //alert('tydert5df');
      var areaId = attr(_(ID.split("_")[1]), "id");
    }else{
        var areaId = ID.split("_")[0];
    }
    
   //删除播放区域内区域文件
    var info = eval("({" + attr(_(ID), "fileInfo") + "})");
    var filename = info.fileName;
    var el= $("#fileArea_a_"+areaId+"");
    el.html(el.html().replace(filename+"<br>", ''));

    if(ID==null){return ;}
    var mainType = attr(_(ID.split("_")[1]), "mainType");
    if (mainType == "N")
    {
        var info = eval("({" + attr(_(ID), "fileInfo") + "})");
        var filename = info.fileName;
        
       
       
        var fileCacheFolder=attr("profile_name","cacheName");
        if(program.info.action=="edit")
        {
            fileCacheFolder=program.edit.oldInfo.programName;
        }
        $.ajax({url:"./template/ajaxPHP/deleteFile.php",data:{folder_Name:fileCacheFolder,file_name:filename},type:"POST",success: function(data){
            bug("删除文件服务器返回的消息", data, "green");
           var string = data.split("_@_@@_@_");
            if (string[0] == "OK")
            {
                program.delFileCache(attr(ID,"key"),ID);
                parentNode(_(ID)).removeChild(_(ID));
                alert(string[1]);

            }
            if (string[0] == "NO")
            {
                alert(string[1]);
            }
            if (string[0] == "NULL")
            {
                program.delFileCache(attr(ID,"key"),ID);
                parentNode(_(ID)).removeChild(_(ID));
                alert(string[1]);
            }

            }});
         var info = eval("({" + attr(_(ID), "fileInfo") + "})");
        var filename = info.fileName;
       
    }
    else
    { 
        program.delFileCache(attr(ID,"key"),ID);
        parentNode(_(ID)).removeChild(_(ID));
     
    }
    

}

function reflashProgramList(){
    var parentobj=window.parent.document.getElementById("getProfileInfo");
    if(parentobj){
        if(parentobj.contentWindow){
            parentobj.contentWindow.location.reload();
        }else{
            parentobj.contentDocument.location.reload();
        }
    }
}
