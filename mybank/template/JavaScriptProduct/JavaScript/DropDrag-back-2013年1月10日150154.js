
var Demos = [];
var nDemos = 8;
var mouseOffset = null;
var iMouseDown = false;
var lMouseState = false;
var DragDrops = [];
var curTarget = null;
var lastTarget = null;
var dragHelper = null;
var rootParent = null;
var rootSibling = null;
var k_key = true;
var draging = false;
Number.prototype.NaN0 = function ()
{
 return isNaN(this) ? 0 : this;
}

function CreateDragContainer()
{
	DragDrops = "";
	DragDrops = [];
	var cDrag = DragDrops.length;
	DragDrops[cDrag] = [];
	for (var i = 0; i < arguments.length; i++)
	{
		for (var a = 0; a < arguments[i].length; a++)
		{
			var cObj = arguments[i][a];
			cObj.setAttribute('DropObj', cDrag);
			DragDrops[cDrag].push(cObj);
			for (var j = 0; j < cObj.childNodes.length; j++)
			{
				if (cObj.childNodes[j].nodeName == '#text') continue;
				cObj.childNodes[j].setAttribute('DragObj', cDrag);
			}
		}
	}
	
	var dragConts = DragDrops[cDrag];
	for (var i = 0; i < dragConts.length; i++)
	{
		with(dragConts[i])
		{
			var pos = getPosition(dragConts[i]);
			setAttribute('startWidth', parseInt(offsetWidth));
			setAttribute('startHeight', parseInt(offsetHeight));
			setAttribute('startLeft', pos.x);
			setAttribute('startTop', pos.y);
		}
		for (var j = 0; j < dragConts[i].childNodes.length; j++)
		{
			with(dragConts[i].childNodes[j])
			{
				if (nodeName == '#text')
				{
					continue
				};
				var pos = getPosition(dragConts[i].childNodes[j]);
				setAttribute('startWidth', parseInt(offsetWidth));
				setAttribute('startHeight', parseInt(offsetHeight));
				setAttribute('startLeft', pos.x);
				setAttribute('startTop', pos.y);
			}
		}
	}
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

function dragMouseMove(ev)
{
	ev = ev || window.event;
	var target = ev.target || ev.srcElement;
	var mousePos = mouseCoords(ev);
	var dragObj = attr(target, "DragObj");
	if (dragObj>=0&&Demos[0])
	{
		if (target.tagName == undefined) return false;
		if (!target) return false;
//		if (!draging)
//		{
//			//if(curTarget==lastTarget){return false;}
////			if (lastTarget && (target !== lastTarget))
////			{
////				var origClass = attr(lastTarget, 'origClass');
////				if (origClass)
////				{
////					lastTarget.className = origClass;
////				}
////			}
//		}
		var dragObj = attr(target, "DragObj");
		if (dragObj != null)
		{
//			if (!draging)
//			{
//				if (target != lastTarget)
//				{
//					var oClass = attr(target, 'overClass');
//					if (oClass)
//					{
//						target.setAttribute('origClass', target.className);
//						target.className = oClass;
//					}
//				}
//			}
			if (iMouseDown && !lMouseState)
			{

				curTarget = target.cloneNode(true);
				mouseOffset = getMouseOffset(target, ev);
				dragHelper.innerHTML = "";
				dragHelper.appendChild(curTarget);
				dragHelper.style.display = "block";
				var dragClass = attr(curTarget, 'dragClass');
				if (dragClass)
				{
					curTarget.className = dragClass;
				}
				curTarget.setAttribute('_dragArrayIndex',attr(curTarget, "DragObj"));
				curTarget.removeAttribute('DragObj');
				curTarget.setAttribute('startWidth', parseInt(curTarget.offsetWidth));
				curTarget.setAttribute('startHeight', parseInt(curTarget.offsetHeight));
				curTarget.setAttribute('class', dragClass);

				/*var dragConts = DragDrops[dragObj];
				for (var i = 0; i < dragConts.length; i++)
				{
					with(dragConts[i])
					{
						var pos = getPosition(dragConts[i]);
						setAttribute('startWidth', parseInt(offsetWidth));
						setAttribute('startHeight', parseInt(offsetHeight));
						setAttribute('startLeft', pos.x);
						setAttribute('startTop', pos.y);
					}
					for (var j = 0; j < dragConts[i].childNodes.length; j++)
					{
						with(dragConts[i].childNodes[j])
						{
							if ((nodeName == '#text') || (dragConts[i].childNodes[j] == target))
							{
								continue
							};
							var pos = getPosition(dragConts[i].childNodes[j]);
							setAttribute('startWidth', parseInt(offsetWidth));
							setAttribute('startHeight', parseInt(offsetHeight));
							setAttribute('startLeft', pos.x);
							setAttribute('startTop', pos.y);
						}
					}
				}*/
				target.className = "DragBox";
				draging = true;
			}
		}

		if (curTarget)
		{
			dragHelper.style.top = mousePos.y - 10 + "px";
			dragHelper.style.left = mousePos.x - 10 + "px";


			var dragConts = DragDrops[attr(curTarget, '_dragArrayIndex')];
			var activeCont = null;
			var xPos = mousePos.x - mouseOffset.x + (parseInt(attr(curTarget, 'startWidth')) / 2);
			var yPos = mousePos.y - mouseOffset.y + (parseInt(attr(curTarget, 'startHeight')) / 2);
			for (var i = 0; i < dragConts.length; i++)
			{
				with(dragConts[i])
				{
					if ((parseInt(getAttribute('startLeft')) < xPos) && (parseInt(getAttribute('startTop')) < yPos) && ((parseInt(getAttribute('startLeft')) + parseInt(getAttribute('startWidth'))) > xPos) && ((parseInt(getAttribute('startTop')) + parseInt(getAttribute('startHeight'))) > yPos))
					{
						activeCont = dragConts[i];
						//break;
					}
				}
			}
			if (activeCont)
			{
//				var beforeNode = null;
//				for (var i = activeCont.childNodes.length - 1; i >= 0; i--)
//				{
//					with(activeCont.childNodes[i])
//					{
//						if (nodeName == '#text') continue;
//						if (target != activeCont.childNodes[i] && ((parseInt(getAttribute('startLeft')) + parseInt(getAttribute('startWidth'))) > xPos) && ((parseInt(getAttribute('startTop')) + parseInt(getAttribute('startHeight'))) > yPos))
//						{
//							beforeNode = activeCont.childNodes[i];
//						}
//					}
//				}
//				if (beforeNode)
//				{
//				}
//				else
//				{
					//if (((target.nextSibling != null) || (target.parentNode.id != activeCont.id)))
					//bug(" mouse move :", "target.parentNode: "+target.parentNode.tagName+" "+target.parentNode.id+" <==> "+activeCont.id);
					//if (target.parentNode.id != activeCont.id)
					//{
						if (_("file_" + activeCont.id))
						{
							//bug("mouse move :",attr(curTarget,"fileInfo"));
							var fileInfo = eval("({" + attr(curTarget,"fileInfo") + "})");
							
							if (checkFileTypeForArea(attr(activeCont, "areaType") , fileInfo.fileType) || attr(activeCont, "mainType") == "Y")
							{
								
								_("file_" + activeCont.id).style.display = "block";
								curTarget.setAttribute("areaID", activeCont.id);
								var nodes = childs(getParentNode(_("file_" + activeCont.id)));
								for (var i = 0; i < nodes.length; i++)
								{
									if (nodes[i].nodeName != "#text" && nodes[i].id != ("file_" + activeCont.id))
									{
										nodes[i].style.display = "none";
									}
								}
								_("file_info").innerHTML = "";
								var ck = new Cookie();
								ck.Write("areaType", attr(activeCont, "mainType"), 1);
								bug("checkFileTypeForArea:","true");
							}
							else
							{
								curTarget.setAttribute("areaID", "");
								var ck = new Cookie();
								ck.Write("areaType", "", 1);
								bug("checkFileTypeForArea:","False");
							}
						}
						else
						{
							curTarget.setAttribute("areaID", "");
							var ck = new Cookie();
							ck.Write("areaType", "", 1);
							k_key = false;
							bug("mouseMove:","no found area file container");
						}
					//}
				//}
			}
		}
		lMouseState = iMouseDown;
		lastTarget = target;
	}
	lMouseState = iMouseDown;
    stopDefault(ev);
}
function checkFileTypeForArea(areaType,fileType){
	bug("checkFileTypeForArea: ","areaType: "+areaType+" fileType: "+fileType);
	var arr_fileType={Video:"Video",Img:"Img",Swf:"Swf",Txt:"Txt",Url:"Url",Url1:"Url",Url2:"Url",Audio:"Audio",LED:"LED"};
	if(areaType==arr_fileType[fileType]){return true;}
	return false;
}
function dragMouseDown(ev)
{
	curTarget = null;
	ev = ev || window.event;
	var target = ev.target || ev.srcElement;
	var dragObj = attr(target, "DragObj");

	if (dragObj != "")
	{
//		bug("dragMouseDown", "添加 dragMouseMove dragMouseUp");
//		addListener(document,"mousemove",dragMouseMove);
//		addListener(document,"mouseup",dragMouseUp);
		document.onmouseup = dragMouseUp;

	}
	else
	{
		return false;
	}

	if (target.tagName == undefined) return false;

	iMouseDown = true;
}

function dragMouseUp(ev)
{
	//bug("dragMouseUp", "清除 onmousemove onmouseup");
	//removeListener(document,"mousemove",dragMouseMove);
	//removeListener(document,"mouseup",dragMouseUp);
	document.onmouseup=function(){return false;}
	if (Demos[0])
	{

		if (curTarget)
		{
			//bug("dragMouseUp",curTarget.innerHTML);
			dragHelper.style.display = 'none';
			var areaid = attr(curTarget, "areaID");
			var curTargetId = "file_" + areaid + "_" + curTarget.id;
			curTarget.setAttribute("id", curTargetId);
			var areaObj = _(areaid);
			if (typeof(areaObj) != "object")
			{
				return false;
			}
			if (dropDragAreaCheck(areaid) && areaObj)
			{
				var fileInfo = eval("({" +  attr(curTarget,"fileInfo") + "})");
				attr(curTarget,"key",areaObj.id)
				if (checkFileTypeForArea(attr(areaObj, "areaType") , fileInfo.fileType) || attr(areaObj, "mainType") == "Y")
				{
//					if (fileInfo.fileType.toString() == "Url")
//					{
//						var itms = _("file_" + areaid).childNodes;
//						for (var i = 0; i < itms.length; i++)
//						{
//							if (itms[i].nodeName != "#text" || itms[i].tagName == "DIV")
//							{
//								curTarget = null;
//								iMouseDown = false;
//								return;
//							}
//						}
//					}
					//var fileInfo = eval("({" + attr(curTarget, "fileInfo") + "})");

					if(attr(areaObj, "mainType") == "N"){
						if (fileInfo.fileType == "Txt")
						{
							if (fileInfo.fileSize > 40 * 1024)
							{
								alert("您的txt文本文件太大!\n请不要超过8KB,即4000中文字符!");
								curTarget = null;
								iMouseDown = false;
								document.onmousemove = dragMouseMove;
								return false;
							}
							if (getChildNodes("file_" + areaid, "div").length >= 3)
							{
								alert("您的滚动字幕区域的文件个数不能超过3个,\n谢谢!");
								curTarget = null;
								iMouseDown = false;
								document.onmousemove = dragMouseMove;
								return false;
							}
						}
					}

					// 检查是否存在相同文件
					if (checkFileInArea(fileInfo.filemd5, _("file_" + areaid)))
					{
						if(!confirm("当前区域已存在此文件: " + html(curTarget) +" 是否继续添加!"))
						{
							curTarget = null;
							iMouseDown = false;
							document.onmousemove = dragMouseMove;
							return false;
						}
					}
					var ck = new Cookie();
					if (ck.Read("areaType") == "N")
					{
						downloadFile(curTarget,areaid);
					}
					else
					{
						appendToAreaFileList(curTarget,areaid);
						setDefaultInfo(_("file_info"), curTargetId);
						program.addFileCache(curTarget);
						var playInfo = eval("({" +  attr(curTarget,"playInfo") + "})");
						program.countOfPlayTime(playInfo.playTime);
					}


				}

				curTarget = null;
			}
		}
		curTarget = null;
		//bug("dragMouseUp: ","curTarget not found");
	}
	draging = false;
	curTarget = null;
	iMouseDown = false;

}

function appendToAreaFileList(curTarget,areaid){
	var curTargetId=curTarget.id,fileInfo= eval("({" + attr(curTarget, "fileInfo") + "})");
	_("file_" + areaid).appendChild(curTarget);
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
	updateFileInfo(fileInfo.fileType, areaTp, curTargetId, key);
}



function downloadFile(curTarget,areaid)
{
	program.tip.fileDragTip("<div style='display:block;'>文件下载中......</div>");
	var info = eval("({" + attr(curTarget, "fileInfo") + "})");
	var curTargetId= curTarget.id;
	var fileCacheFolder=attr("profile_name","cacheName");
	
	if(program.info.action=="edit")
	{
		fileCacheFolder=program.edit.oldInfo.programName;
	}
	var obj_info={file_name:info.fileName,folder_Name:fileCacheFolder,file_type:info.fileType};
	$.ajax({
		type:"post",
		url: "../../ajaxPHP/downLoadFile.php",
		data:{data:obj_info},
		success:function(data, textStatus, jqXHR){
			data=$.parseJSON(data);
			if(typeof(data)=="object")
			{
				if(data.state)
				{
					appendToAreaFileList(curTarget,areaid);
					setDefaultInfo(_("file_info"), curTargetId); //将文件加入区域队列中
					attr(curTarget,"key",areaid);
					program.addFileCache(curTarget); //将文件加入缓存队列
					downloadFileTip("succes");
					return ;
				}
			}
			downloadFileTip("failed");
			},
		timeout:function(){downloadFileTip("timeout");},
		error:function(){downloadFileTip("error");}
		});
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
		fileInfoArea.innerHTML = "播放时长:<input class='fileAttrbuteBtn' onkeyup=\"setTextInputValue(this)\" id='playTime_" + id + "' type='text' itmValue='20' value='20' itm='playTime' />(秒)<br> 播放次数:<input class='fileAttrbuteBtn' type='text' itmValue='1' value='1' itm='replayCount' onkeyup=\"setTextInputValue(this)\" /><div style='width:100%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
	}
	if (fileType == "Img")
	{
		fileInfoArea.innerHTML = "播放时长:<input class='fileAttrbuteBtn' type='text' itmValue='3' value='3' itm='playTime' onkeyup=\"setTextInputValue(this)\" />(秒)<br> 播放次数:<input class='fileAttrbuteBtn' type='text' itmValue='1' value='1' itm='replayCount' onkeyup=\"setTextInputValue(this)\" /> <div style='width:100%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
	}
	if (fileType == "Swf")
	{
		fileInfoArea.innerHTML = "播放时长:<input class='fileAttrbuteBtn' type='text' itmValue='20' value='20' itm='playTime' onkeyup=\"setTextInputValue(this)\" />(秒)<br> 播放次数:<input class='fileAttrbuteBtn' type='text' itmValue='1' value='1' itm='replayCount' onkeyup=\"setTextInputValue(this)\" /> <div style='width:100%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
	}
	if (fileType == "Txt" || fileType == "Url2")
	{
		var str = "字体类型:<INPUT type='button' class='fileAttrbuteBtn' id='font_type_btn' onclick=\"fontType(event)\" itm='font' itmValue='simsun.ttc' value='宋体' /><br>";
		str += "文字大小:<br>";
		str += "  <input type='radio' name='txt_f_size' id='txt_f_size_a' onfocus='setScrollFontSize(this)' checked='true' /><label for='txt_f_size_a'>自动</label>";
		str += "  <input type='radio' name='txt_f_size' id='txt_f_size_b' onfocus='setScrollFontSize(this)' /><label for='txt_f_size_b'>手动</label><input style='width:25px; height:12px;  display:none;' type='text' itmValue='1' itm='fontsize' value='1' onkeyup='setFontSize(this)' id='txt_f_size_input' /><br>";
		str += "文字颜色:<input  class='fileAttrbuteBtn'  style=' background-color:#000000;' type='button' value='#000000' itm='fontcolor' itmValue='#000000'  id='font_color_btn' onclick=\"setColor(event)\" /><br>";
		str += '背景颜色:<input  class="fileAttrbuteBtn"  style=" background-color:#ffffff;" type="button" value="#ffffff" itm="bgcolor" id="fontbg_color_btn" itmValue="#ffffff" onclick="setbggroundColor(event)" /><br>';
		str += '滚动速度:<input  class="fileAttrbuteBtn" type="button" itm="scrollamount" itmValue="3" value="3" id="scrollamount" onclick="setScrollSpeed(event)"><br>';
		str += "滚动方向:<input class='fileAttrbuteBtn' itmValue='left' type='button' value='left' itm='direction' disabled='disabled' /><br>";
		str += "播放次数:<input class='fileAttrbuteBtn'  itmValue='1' onkeyup=\"setPlayCount(this)\"  type='text' value='1' itm='replayCount' /><br>";
		str += "<div style='width:100%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
		fileInfoArea.innerHTML = str;
     
	}
/*	if (fileType == "Txt" && areaType == "LED")
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
		str += "<div style='width:100%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
		fileInfoArea.innerHTML = str;
	}
	if (fileType == "Url")
	{
		var str = "播放时长:<input class='fileAttrbuteBtn' type='text' itmValue='80' value='80' itm='playTime' onkeyup=\"setTextInputValue(this)\" />(秒)<br>";
		str += "<div style='width:100%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
		str+= "<input id='scrollType' itmValue='0' class='fileAttrbuteBtn' type='hidden' value='0' itm='direction' />";
		fileInfoArea.innerHTML=str;
	}
	if (fileType == "Url1")
	{
		var str = "播放时长:<input class='fileAttrbuteBtn' type='text' itmValue='80' value='80' itm='playTime' onkeyup=\"setTextInputValue(this)\" />(秒)<br>";
		str += "<div style='width:100%; text-align:center;'><input onclick=\"setFileInfo(event,'" + id + "')\" type='button' value='设置' /></div>";
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
		$(document).unbind("click",sssColor)
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
	var fileInfo = fileAreaObject.childNodes
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
						case "font": fi.value=Bs.fontInfo.getFontNameByFileName(playInfo[itm]); break;
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
	var NewArr =unique(areas).length;
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
//	功能: 检查一文件是否存在当前区域
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
    bug("relevanceFileListUI","area Id: "+dom_obj.id)
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
    var dom_areas=childs("apDiv1","div");
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
{
    var ID = attr(obj, "move_id");
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
		$.ajax({url:"../../ajaxPHP/deleteFile.php",data:{folder_Name:fileCacheFolder,file_name:filename},type:"POST",success: function(data){
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

