function $(id) {
    return document.getElementById(id);
}

function addEventHandler(target, eventType, handler) {
    if (target.addEventListener) {
        target.addEventListener(eventType, handler, false);
    }
    else if (target.attachEvent) {
        target.attachEvent("on" + eventType, handler);
    }
    else {
        target["on" + eventType] = handler;
    }
}
if (!window.attachEvent && window.addEventListener) {
    window.attachEvent = HTMLElement.prototype.attachEvent = document.attachEvent = function (en, func, cancelBubble) {
        var cb = cancelBubble ? true : false;
        this.addEventListener(en.toLowerCase().substr(2), func, cb);
    };
    window.detachEvent = HTMLElement.prototype.detachEvent = document.detachEvent = function (en, func, cancelBubble) {
        var cb = cancelBubble ? true : false;
        this.removeEventListener(en.toLowerCase().substr(2), func, cb);
    };
}

function createProfileNameUI(curTarget, curTargetId, fileId, type) {
    var sp_sty = "display:block; padding:2px;";
    var tip = "<div style='width:300px; font-size:14px; text-align:left;' id='tip_bord' >";
    tip += "<div style='text-align:left;'>提示:</div>";
    tip += "<div><label>正在准备下载环境...</label></div></div>";
    __createCoverDiv("bgImg_UI");
    __content("bgImg_UI").innerHTML = tip;
    
    var folderName = _("UserFolder").value;
    bug("函数:createProfileNameUI ", curTarget.tagName + "<br />" + curTargetId + "<br />folderName:" + folderName + "<br />" + fileId + "<br />" + type);
    checkProfileFoler(curTarget, curTargetId, folderName, fileId, type);
}

function closeProfileNameUI() {
    __closeCoverDiv(true, "bgImg_UI");
}

function closeTip_bord() {
    __closeCoverDiv(true, "tip_bord");
}

function removeInfo(fileId, curTargetId) {
    try {
        $(fileId).removeChild($(curTargetId));
        $("file_info").innerHTML = "";
    }
    catch (e) {}
}

function checkProfileFoler(curTarget, curTargetId, folderName, fileId, type) {
    if (folderName.replace(/(^\s*)|(\s*$)/g, "") == "") {
        $("tip_bord").innerHTML += "<div style='font-size:10px; color:red; padding-left:15px;'>* 初始化下载环境失败!</div>";
        $("tip_bord").innerHTML += '<input type="image" src="../../ceShi_Image/Close.gif" style="cursor:pointer; margin-top:3px;" onclick=\"closeTip_bord()\" />';
        removeInfo(fileId, curTargetId);
        return false;
    }
    $("profile_name").setAttribute("cacheName",_("UserFolder").value)
    $("tip_bord").innerHTML += "<div style='font-size:12px; color:green; padding-left:15px;'>下载环境准备完成.</div>";
    if (type != null) {
        setTimeout(function () {
            __closeCoverDiv(true, "bgImg_UI");
            majax = null;
            getMainAreaFileMD5(curTarget, curTargetId);
        }, 1000);
    }
    else {
        setTimeout(function () {
            __closeCoverDiv(true, "bgImg_UI");
            majax = null;
            downloadFile(curTarget);
            $("save_button").disabled = false;
        }, 1000);
    }
}

function areaMenue(ev) {
    ev = ev || window.event;
    var target = ev.target || ev.srcElement;
    target.style.backgroundColor = "#ff";
    var otherNodes = target.parentNode.childNodes;
    for (var i = 0; i < otherNodes.length; i++) {
        if (otherNodes[i] != target) {
            with(otherNodes[i]) {
                if (nodeName != "#text") {
                    if (getAttribute("areaType")) {
                        style.backgroundColor = getAttribute("areaColor");
                    }
                    else {
                        style.backgroundColor = getAttribute("o_bgColor");
                    }
                }
            }
        }
    }
    if ($("file_" + target.id)) {
        var fileNodes = $("file_" + target.id).parentNode.childNodes;
        for (var i = 0; i < fileNodes.length; i++) {
            if (fileNodes[i].nodeName != "#text") {
                if (fileNodes[i].id != ("file_" + target.id)) {
                    fileNodes[i].style.display = "none";
                }
                else {
                    fileNodes[i].style.display = "block";
                }
            }
        }
    }
}

function setLedDiv() {
    var ledID = document.getElementById("100");
    ledID.style.display = "";
    $("led_1").style.display = "none";
    $("led_2").style.display = "";
    createFileArea("100");
}

function closeLEDArea() {
    var ledID = document.getElementById("100");
    ledID.style.display = "none";
    $("led_1").style.display = "";
    $("led_2").style.display = "none";
    try {
        $("fileArea").removeChild($("file_100"));
    } catch (e) {}
}

function removeAllChildNodes(objt) {
    while (objt.firstChild) {
        objt.removeChild(objt.firstChild);
    }
}

function createFileArea(areaId) {
    var filesArea = document.createElement("div");
    filesArea.setAttribute("id", "file_" + areaId);
    filesArea.style.cssText = "display:none;height:260px;width:100%;";
    $("fileArea").appendChild(filesArea);
}

function closeAreaTypeMenue() {
    document.body.removeChild($("areaTypeMenue"));
}

function fileMoveDown(obj) {
    var movedId = obj.getAttribute("move_id");
    if (movedId == null) {
        return false;
    }
    var movedObject = $(movedId);
    var fileArea = movedObject.parentNode;
    var movedObjectBeforItm = movedObject.nextSibling;
    if (movedObjectBeforItm != null) {
        movedObject.parentNode.insertBefore(movedObject, (movedObject.nextSibling).nextSibling);
    }
    else {
        movedObject.parentNode.insertBefore(movedObject, fileArea.firstChild);
    }
}

function fileMoveUp(obj) {
    var movedId = obj.getAttribute("move_id");
    if (movedId == null) {
        return false;
    }
    var movedObject = $(movedId);
    var fileArea = movedObject.parentNode;
    var movedObjectBeforItm = movedObject.previousSibling;
    if (fileArea.lastChild != movedObjectBeforItm) {
        fileArea.insertBefore(movedObject, movedObjectBeforItm);
    }
    else {
        fileArea.insertBefore(movedObject, fileArea.firstChild);
    }
}

function fileDelte(obj) {
    var ID = obj.getAttribute("move_id");
    if (ID == null) {
        return false;
    }
    var mainType = $(ID.split("_")[1]).getAttribute("mainType");
    if (mainType == "N") {
        var info = eval("({" + $(ID).getAttribute("title") + "})");
        var filename = info.fileName;
        var myinfo = $("loadMessage");
        var myajax = new DedeAjax(myinfo, true, function (string) {
            string = string.split("_@_@@_@_");
            if (string[0] == "OK") {
                if ($(ID).parent) {
                    $(ID).parent.removeChild($(ID));
                }
                else {
                    $(ID).parentNode.removeChild($(ID));
                }
                alert(string[1]);
            }
            if (string[0] == "NO") {
                alert(string[1]);
            }
            if (string[0] == "NULL") {
                if ($(ID).parent) {
                    $(ID).parent.removeChild($(ID));
                }
                else {
                    $(ID).parentNode.removeChild($(ID));
                }
                alert(string[1]);
            }
        });
        myajax.AddKey("folder_Name", $("profile_name").value);
        myajax.AddKey("file_name", filename);
        myajax.SendPost("../../ajaxPHP/deleteFile.php");
    }
    else {
        if ($(ID).parent) {
            $(ID).parent.removeChild($(ID));
        }
        else {
            $(ID).parentNode.removeChild($(ID));
        }
    }
}
Number.prototype.NaN0 = function () {
    return isNaN(this) ? 0 : this;
}

function getPosition(e) {
    var left = 0;
    var top = 0;
    while (e.offsetParent) {
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

function mouseCoords(ev) {
    if (ev.pageX || ev.pageY) {
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

function getMouseOffset(target, ev) {
    ev = ev || window.event;
    var docPos = getPosition(target);
    var mousePos = mouseCoords(ev);
    return {
        x: mousePos.x - docPos.x,
        y: mousePos.y - docPos.y
    };
}

function readyProfileInfo() {
    var profileName = "";
    var profileType = "";
    var profilePeriod = 0;
    var templateID = "";
    var touchJumpUrl = "";
    var global = "";
    var tempBgGround = "";
    var tempWidth = "";
    var tempHeight = "";
    var em = "";
    em = 0;
    if ($("touthUrl")) {
        showInfo("<div style='width:100%;'>获取触摸屏URL......</div>");
        touchJumpUrl = $("touthUrl").value;
    }
    showInfo("<div style='width:100%;'>获取profile名称.....</div>");
    profileName = $("profile_name").value;
    showInfo("<div style='width:100%;'>获取profile 类型.....</div>");
    profileType = "LED";
    showInfo("<div style='width:100%;'>播放时长总时长......</div>");
    var v = false;
    var fileArea = $("file_" + 100).childNodes;
    for (var itm = 0; itm < fileArea.length; itm++) {
        if (fileArea[itm].nodeName != "#text") {
            if (fileArea[itm].tagName == "DIV") {
                v = true;
                var p = eval("({" + fileArea[itm].getAttribute("playInfo") + "})");
                if (p.playTime) {
                    profilePeriod = parseInt(profilePeriod) + parseInt(p.playTime * p.replayCount);
                }
            }
        }
    }
    if (!v) {
        showInfo("<div style='width:100%; font-size:20px; font-weight:bold; color:red; '>收集获取区域信息失败,请查看主区域文件.</div>");
        return false;
    }
    global += "'action':'add',";
    global += "'em':'" + em + "',";
    global += "'profileName':'" + profileName + "','profileType':'" + profileType + "','profilePeriod':'" + profilePeriod + "',";
    global += "'templateID':'" + templateID + "','touchJumpUrl':'" + touchJumpUrl + "',";
    global += "'tempWidth':'0','tempHeight':'0','tempBgGround':'0'";
    showInfo("<div style='width:100%;'>收集获取区域信息......</div>");
    var fileArea = "";
    var areasInfo = "{<BR>";
    var d = 0;
    var PlayFiles = $("fileArea").childNodes;
    for (var i = 0; i < PlayFiles.length; i++) {
        fileArea = PlayFiles[i];
        if (fileArea.nodeName != "#text") {
            if (fileArea.tagName == "DIV") {
                var filesInfo = new Array();
                var areaInfo = "";
                var area = $(fileArea.id.split("_")[1]);
                areaInfo = "{<BR>'id':'" + area.id + "',";
                if (area.getAttribute("ledType")) {
                    areaInfo += "'type':'" + area.getAttribute("ledType") + "',";
                }
                else {
                    areaInfo += "'type':'" + area.getAttribute("areaType") + "',";
                }
                areaInfo += "'location':{" + area.getAttribute("position") + "},";
                var fa = fileArea.childNodes;
                for (var itm = 0; itm < fa.length; itm++) {
                    if (fa[itm].nodeName != "#text") {
                        if (fa[itm].tagName == "DIV") {
                            filesInfo.push(fa[itm].getAttribute("playInfo") + "," + fa[itm].getAttribute("title"));
                        }
                    }
                }
                var fileInfo = "";
                for (var b = 0; b < filesInfo.length; b++) {
                    fileInfo += "<BR>{" + filesInfo[b] + "},";
                }
                fileInfo = fileInfo.substring(0, fileInfo.length - 1);
                areaInfo += "<BR>'files':[" + fileInfo + "<BR>]<BR>";
                areaInfo += "}";
                areasInfo += "<BR>'" + d + "':" + areaInfo + ",";
                d++;
            }
        }
    }
    showInfo("<div style='width:100%;'>收集文件信息......</div>");
    areasInfo = areasInfo.substring(0, areasInfo.length - 1);
    areasInfo += "}";
    var c = areasInfo.replace(/\'/g, "\"");
    global = global.replace(/\'/g, "\"");
    areasInfo += "<br>profile名称: " + profileName + "<BR>profile类型: " + profileType + "<BR>profile时长: " + profilePeriod + "<BR>templateID: " + templateID + "<BR>触摸屏页面: " + touchJumpUrl;
    areasInfo += "<br>背景图路径:" + tempBgGround + "<br>模板宽度:" + tempWidth + " <br>模板高度:" + tempHeight + "<br>";
    bug("LED Profile Post Info", global + areasInfo.replace(/\'/g, "\""));
    return c + "__@_@@_@__" + global;
}

function saveProfile() {
    if (!__content("save_info")) {
        __createCoverDiv("save_info");
        __content("save_info").innerHTML = "<div id='info_div' style='display:block; font-size:12px; text-align:left;'></div>";
    }
    saveNowProfile();
}

function saveNowProfile() {
    var info = readyProfileInfo();
    if (!info) {
        showInfo("<div style='width:100%; color:red;'>收集区域信息出错......</div>");
        getResult(".....");
        return false;
    }
    info = info.split("__@_@@_@__");
    var myinfo = $("apDiv6");
    var myajax = new DedeAjax(myinfo, true, getResult, true, errorFun, timoutting, timeouted);
    profileInfo = info[0].replace(/<BR>/g, "");
    global = "{" + info[1].replace(/<BR>/g, "") + "}";
    myajax.AddKey("profileTemplateInfo", "");
    myajax.AddKey("profileInfo", profileInfo);
    myajax.AddKey("profileGlobalInfo", global);
    myajax.SendPost("/CI/index.php/profile/createLedProfile");
    showInfo("<div style='width:100%; '>信息保存中.....</div>");
}

function timoutting(m) {
    if (!$("timouttingContainer")) {
        showInfo("<div style='width:100%; color:red;' id='timouttingContainer'>等待中......" + m + "......</div>");
    }
    else {
        $("timouttingContainer").innerHTML = "等待中......" + m + "......";
    }
}

function timeouted(string) {
    $("timouttingContainer").innerHTML = string;
    showInfo("<div style='font-size:18px; font-weight:bold; color:red;'>Profile生成失败！</div>");
    showInfo("<div style='font-size:14px; text-align:center;'><button onclick=\"closeInfoDivA()\">确　定</button></div>");
}

function errorFun(errorInfo) {
    if (errorInfo == 0) {
        showInfo("<div style='width:100%; color:red;'>程序错误，未被初始化。</div>");
        showInfo("<div style='font-size:18px; font-weight:bold; color:red;'>Profile生成失败！</div>");
        showInfo("<div style='font-size:14px; text-align:center;'><button onclick=\"closeInfoDivA()\">确　定</button></div>");
    }
}

function showInfo(message) {
    var info = $("info_div").innerHTML;
    $("info_div").innerHTML = info + message;
}

function getResult(obj) {
    bug("LED Create Info From Server", obj, "#0f0");
    var zt = obj.indexOf("执行成功");
    if (zt > -1) {
        showInfo("<div style='font-size:18px; font-weight:bold; color:green;'>Profile生成成功！</div>");
        showInfo("<div style='font-size:14px; text-align:center;'><button onclick=\"closeInfoDivA()\">确　定</button></div>");
        $("fileArea").innerHTML = "";
        $("fileArea").innerHTML = "<div id='file_100'></div>";
        $("profile_name").value = "";
        try {
            with(document.body) {
                removeChild($("bgDIV"));
            };
            $("apDiv1").style.backgroundImage = "url(BG.png)";
        } catch (e) {}
    }
    else {
        showInfo("<div style='font-size:18px; font-weight:bold; color:red;'>Profile生成失败！</div>");
        showInfo("<div style='font-size:14px; text-align:center;'><button onclick=\"closeInfoDivA()\">确　定</button></div>");
    }
}

function closeInfoDivA() {
    __closeCoverDiv(true, "save_info");
}

function startUI() {
    document.onmousedown = dragMouseDown;
    document.onmousemove = dragMouseMove;
    document.onmouseup = dragMouseUp;
    var areas = new Array();
    areas.push($('DragContainer_wenben'));
    areas.push($("100"));
    createDrag(areas);
}

function createDrag(areasObject) {
    document.onmousedown = dragMouseDown;
    document.onmousemove = dragMouseMove;
    document.onmouseup = dragMouseUp;
    Demos[0] = $("content");
    if (Demos[0]) {
        CreateDragContainer(areasObject);
    }
    if (Demos[0]) {
        dragHelper = document.createElement('DIV');
        dragHelper.style.cssText = 'position:absolute;display:none; z-index:1000;';
        document.body.appendChild(dragHelper);
    }
    var ck = new Cookie();
    if (!ck.Read("FY")) {
        ck.Write("FY", true, 1);
        fenye();
    }
}

function fenye() {
    var wenben_pg = new PagingClass($("DragContainer_wenben").innerHTML, 12, $("DragContainer_wenben"), "w", null, null, null, "height:270px;", false);
    wenben_pg.start(wenben_pg);
    var wenben_pg_nextBarClick = function () {
        return wenben_pg.nextPage($("w_N"))
    };
    $("w_N").attachEvent("onclick", wenben_pg_nextBarClick);
    var wenben_pg_lastBarClick = function () {
        return wenben_pg.lastPage()
    };
    $("w_L").attachEvent("onclick", wenben_pg_lastBarClick);
}