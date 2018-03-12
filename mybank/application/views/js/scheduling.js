(function ()
{
    var d = art.dialog.defaults;
    d.skin = ['default', 'chrome', 'facebook', 'aero'];
    d.drag = true;
    d.showTemp = 100000;
})();

function getBigC()
{
    return tb = getFirstChild(_("schedule_big_Calendar"));
}

function getRightCalendar()
{
    return getChildNodes("schedule_big_Calendar", "table");
}

function setRightCalendarHeight()
{
    reSetWeekTitle();
}

function loadWeekList()
{
    var s = getNowDate();
    var year = s.y;
    var month = s.m;
    if (month < 10)
    {
        month = "0" + month;
    }
    var ym = year + "-" + month;
    var ajax = new AJAXRequest();
    ajax.get("index.php/scheduling/getWeekPlayList/" + ym, function (obj)
    {
		bug("loadWeekList",obj.responseText);
        if (obj.responseText.length > 0)
        {
            var s_str = obj.responseText
            if (s_str.indexOf("_ERROR_") >= 0)
            {
                window.location.href = s_str.replace("_ERROR_", "");
            }
			bug("loadWeekList",obj.responseText);
            var s = eval(obj.responseText);
            var w = "",
                p = "",
                id, name, type, pro_id, po_name, rs, pro_s, ro, pro_o;
            for (var i = 0, n = s.length; i < n; i++)
            {
                var info = "";
                w = s[i];
                id = w[0];
                name = w[1];
                type = w[2];
                info += "['" + id + "','" + name + "','" + type + "',[";
                for (var a = 0, m = w[3].length; a < m; a++)
                {
                    p = w[3][a];
                    if (a == m - 1)
                    {
                        info += "['" + p[0] + "','" + p[1] + "','" + p[2] + "','" + p[3] + "','" + p[4] + "']";
                    }
                    else
                    {
                        info += "['" + p[0] + "','" + p[1] + "','" + p[2] + "','" + p[3] + "','" + p[4] + "'],";
                    }
                }
                info += "]]";
                _("playListContainer").appendChild(bindWeekList(id, info, name));
            }
			
            addListener(_("playListContainer"), "change", showEveryOne);
            getPanelTime(s[0]);
            getFirstProfileInfo(0);
        }
        else
        {
            alert("您还没有建立节目单......");
        }
    });
}

function createDomElement(obj_info)
{
	if(obj_info.tagName=="")
	{
		return false;
	}
	var dom_obj=document.createElement(obj_info.tagName);
}
function getFirstProfileInfo(st)
{
    if (st)
    {
        window.clearTimeout(st);
    }
    if (trim(html(_("profile_info"))) != "")
    {
        getProfileInfoDefault(att(getFirstChild(getFirstChild(_("profile_info"))), "pr_id").split("_")[1]);
    }
    else
    {
        var st = setTimeout(function (st)
        {
            getFirstProfileInfo(st)
        }, 100);
    }
}

function bindWeekList(id, info, name)
{
    var p = document.createElement("option");
    att(p, "id", id);
    att(p, "value", info);
    p.innerHTML = name;
    return p;
}

function showEveryOne(e)
{
    var a = getEventObject(e).value;
    bug("被显示的PlayList信息", a);
    a = eval(a);
    _("bqian").innerHTML = "";
    _("profile_info").innerHTML = "";
    _("profile_file").innerHTML = "";
    getPanelTime(a);
    getFirstProfileInfo(0);
}

function getPanelTime(a)
{
	/*
	 * ['8','市场经营部_Excel','X86',
	 * 		[
	 * 			['85','市场经营部-20110428','2011-04-28,00:00:00','2011-04-28,23:59:59','_CA_D0_B3_A1_BE_AD_D3_AA_B2_BF-20110428'],
	 * 			['86','市场经营部-20110429','2011-04-29,00:00:00','2011-04-29,23:59:59','_CA_D0_B3_A1_BE_AD_D3_AA_B2_BF-20110429'],
	 * 			['87','市场经营部-20110430','2011-04-30,00:00:00','2011-04-30,23:59:59','_CA_D0_B3_A1_BE_AD_D3_AA_B2_BF-20110430']
	 * 		]
	 * ]
	 * */
    var t = a[3],
        m = "",
        s = "",
        o = "",
        k = "",
        v = "";
        state = "";
    for (var i = 0, n = t.length; i < n; i++)
    {
        m = t[i];
        k = parseInt(m[2].replace(/[-,:]/g, ""));
        v = parseInt(m[3].replace(/[-,:]/g, ""));
        st = m[5];
        if (i != n - 1)
        {
            s += k + ",";
            o += v + ",";
            state += st + ",";
        }
        else
        {
            s += k;
            o += v;
            state += st;
        }
    }
    bug("PlayList时间组", "开始时间组: " + s + "<br>结束时间组: " + o);
    s = eval("Math.min(" + s + ")").toString();
    o = eval("Math.max(" + o + ")").toString();
    bug("PlayList时间", "开始时间: " + s + "<br>结束时间: " + o);
    t = s.substring(0, 4);
    m = o.substring(0, 4);
    s = s.substring(4, 6);
    o = o.substring(4, 6);
    bug("向服务器提交PlayList时间", "开始时间: " + t + " " + s + "<br>结束时间: " + m + " " + o);
    createPanel(t, s, m, o, a);
}

function createPanel(t, s, m, o, a)
{
    _("schedule_big_Calendar").innerHTML = '  ';
    var ajax = new AJAXRequest();
    ajax.get("index.php/scheduling/getMoreCalendar/" + t + "/" + s + "/" + m + "/" + o, function (obj)
    {
        bug("服务器返回的月历", "<textarea style='width:100%; height:300px; border:0px; font-size:12px;'>" + obj.responseText + "</textarea>", "green");
        _("schedule_big_Calendar").innerHTML = obj.responseText;
        reSetWeekTitle();
        drow(a);
    });
}

function reSetWeekTitle()
{
    var tb = getRightCalendar();
    var tbody = "",
        mtr = "",
        tbHeight = document.documentElement.clientHeight,
        tdHeight = 0,
        trCount = 0;
    for (var i = 0, n = tb.length; i < n; i++)
    {
        mtr = getChildNodes(getFirstChild(tb[i]))
        if (browser.ie == "6.0" || browser.ie == "7.0")
        {
            mtr[0].style.cssText = "font-size:14px; height:18px; color:#00cc00;";
            mtr[1].style.cssText = "font-size:14px; height:18px; color:#00cc00;";
            tb[i].style.cssText = "height:" + tbHeight + "px; font-size:20px; color:#993300; font-weight:800; ";
            trCount = mtr.length;
            tdHeight = tbHeight / trCount;
            for (var a = 2, b = trCount; a < b; a++)
            {
                mtr[a].style.cssText = "font-size:20px; height:" + tdHeight + "px; color:#993300;";
            }
        }
        else
        {
            mtr[0].setAttribute("style", "height:18px; font-size:14px; color:#00cc00;");
            mtr[1].setAttribute("style", "height:18px; font-size:14px; color:#00cc00;");
            tb[i].setAttribute("style", "height:" + tbHeight + "px; font-size:20px; color:#993300; font-weight:800; ");
        }
    }
}

function drow(array)
{
    var color = ['c66', '03f', '06c', '09f', '0cc', '0ff', '3c0', '3c9', '399', '3f9', '6c9', '6cc', 'f0f', 'f3c', 'f6f', 'f9c', 'fcf', 'ffc', 'f00', 'f90', 'fc3', 'f09', 'f99', 'fc9', '900', 'cc0', 'c96', 'f96', 'fcc', '9cc', '00c'];
    var w = "",
        p = "",
        id, name, type, pro_id, po_name, rs, pro_s, ro, pro_o, tmp = "";
    var w = array;
    var id = w[0];
    var name = w[1];
    var type = w[2];
    var info = "";
    for (var a = 0, m = w[3].length; a < m; a++)
    {
        p = w[3][a];
        pro_id = p[0];
        pro_name = p[1];
        rs = p[2].split(",");
        pro_s = [rs[0].split("-"), rs[1].split(":")];
        ro = p[3].split(",");
        pro_o = [ro[0].split("-"), ro[1].split(":")];
        if(p[5]=='1')
        {
        	info = "<span style=' display:block;display:block;width:100%; font-size:12px; background-color:#" + color[a] + "; font-weight:bold;' title='此节目单元还在审核中!'>" + pro_name + "</span>";
        }
        else
        {
        	info = "<span style=' display:block;display:block;width:100%; font-size:12px; background-color:#" + color[a] + "; font-weight:bold;' title='Profile 名称!'>" + pro_name + "</span>";
        }
        
        bug("开始绘画播放列表中的Profile", "ProfileName: " + pro_name + "<br>未还原的Profile名称:" + p[4] + "<br>时间: " + rs[0] + " ~ " + ro[0]);
        drawPanle(pro_id + "--" + id + "__", pro_s, pro_o, info, color[a],p[5]);
        profileName(pro_id, pro_name, p[4]);
    }
	//-- 解决播放列表中的Profile数量超过15个的时候 撑破容器的问题
	resetProfileListConUI("profile_info");
	 //重新加载颜色----
    //-- 为了让使用Excel导入(移动的要求)的Profile表现的,像非导入方式生成的,播放列表中的profile表现得一样
	setProColor(name);
	
}
function resetProfileListConUI(str_id)
{
	var dom_con=_(str_id);
	var fun_upFun=function(ev)
	{
		//alert(clientHeight(dom_con)+" "+dom_con.scrollHeight);
		var dom_h=getEventObject(ev);
		if(dom_con.scrollTop==0)
		{
			dom_h.style.display="none";
		}
		else
		{
			dom_con.scrollTop-=30;
			_(att(dom_h,"handel")).style.display="block";
		}
	}
	var fun_downFun=function(ev)
	{
		var dom_h=getEventObject(ev);
		if(dom_con.scrollTop==att(dom_h,"scrollTp"))
		{
			dom_h.style.display="none";
		}
		else
		{
			dom_h.setAttribute("scrollTp",dom_con.scrollTop);
			dom_con.scrollTop+=30;
			
			//att(dom_h,"scrollTp",dom_con.scrollTop);
			_(att(dom_h,"handel")).style.display="block";
		}
	}
	var str_id="_"+(new Date()).getTime().toString().replace(/[32]/g,"");
	
	if(dom_con.scrollHeight-clientHeight(dom_con))
	{
		var obj_pos=getElementPos(dom_con);
		var int_dom_con_width=clientWidth(dom_con);
		var int_dom_con_height=clientHeight(dom_con);
		obj_pos.x=int_dom_con_width/2-15+obj_pos.x;
		//alert(obj_pos.x+" "+obj_pos.y);
		var str_style="display:lock;position:absolute; cursor:pointer; line-height:18px; font-size:14px; text-align:center; background-color:#eee; width:30px; height:18px;";
		var dom_span_up=document.createElement("SPAN");
		with(dom_span_up)
		{
			id=str_id;
			style.cssText=str_style;
			style.top=obj_pos.y+"px";
			style.left=obj_pos.x+"px";
			style.display="none";
			//innerHTML='<img src="" width="50" height="50" border="0" />';
			innerHTML='▲';
		}
		var dom_span_down=document.createElement("SPAN");
		with(dom_span_down)
		{
			id=str_id+"5";
			style.cssText=str_style;
			style.top=(obj_pos.y+int_dom_con_height-18)+"px";
			style.left=obj_pos.x+"px";
			//innerHTML='<img src="" width="50" height="50" border="0" />';
			innerHTML="▼";
		}
		att(dom_span_up,"handel",str_id+"5");
		att(dom_span_down,"handel",str_id);
		var obj_pos=getElementPos(dom_con);
		dom_con.appendChild(dom_span_up);
		dom_con.appendChild(dom_span_down);
		addListener(dom_span_up,"mousedown",fun_upFun);
		//bindLeftClick(dom_span_up,fun_upFun);
		bindLeftClick(dom_span_down,fun_downFun);
	}
	else
	{
		
	}
	
}
function profileName(id, str, Path)
{
    var dv = document.createElement("a");
    dv.style.cssText = "display:block; width:100%;";
    var d = document.createElement("span");
    d.style.cssText = "display:block; width:172px;  overflow:hidden; font-size:12px; float:left;";
    d.innerHTML = str;
    setAttr(d, "id", id + "__kk");
    setAttr(d, "pr_id", "pr_" + id);
    var d2 = document.createElement("span");
    d2.style.cssText = "display:block; cursor:pointer; width:24px; overflow:hidden; font-size:12px;  float:left;";
    att(d2, "ph", "FileLib/" + Path + "/" + Path + "_view.html");
    att(d2, "proName", str);
	att(d2, "proId", id);
    d2.innerHTML = "查看";
    bindLeftClick(d2, viewProfile);
    dv.appendChild(d);
    dv.appendChild(d2);
    _("profile_info").appendChild(dv);
}

function viewProfile(e)
{
    var o = getEventObject(e);
    var h = (document.documentElement.clientHeight) - 100;
    var w = (document.documentElement.clientWidth) - 100;
    var path = document.getElementsByTagName("base")[0].href + att(o, "ph");
    art.dialog(
    {
        title: "您正在预览节目单元 " + att(o, "proName"),
        id: 'viewPro',
        content: '信息加载中.....',
        skin: 'chrome',
        width: w,
        height: h,
        lock: true
    });
    setTimeout(function ()
    {
        art.dialog.get("viewPro").content('<iframe id="viewProWin" name="viewProWin" style="display:block; width:' + w + 'px; height:' + h + 'px; overflow:hidden"  src="' + path + '" frameborder="0" allowtransparency="true" onload="resizeViewPro(this.id)"></iframe>');
    }, 500);
}

function resizeViewPro(o)
{
    var p = getIframe_WH(o);
    _(o).style.width = p.w + "px";
    _(o).style.height = p.h + "px";
    art.dialog.get("viewPro").size(p.w, parseInt(p.h) + 10);
    setTimeout(function ()
    {
        art.dialog.get("viewPro").position();
    }, 500);
}

function getIframe_WH(iframeObj)
{
    var _w = 0,
        _h = 0;
    var iframeHeight = 0;
    if (navigator.userAgent.indexOf("Firefox") > 0)
    {
        _w = (_(iframeObj).contentDocument.body.style.width).replace("px", "");
        _h = (_(iframeObj).contentDocument.body.style.height).replace("px", "");
    }
    else if (navigator.userAgent.indexOf("MSIE") > 0)
    {
        _w = ((document.frames[iframeObj].document.getElementsByTagName("body")[0]).style.width).replace("px", "");
        _h = ((document.frames[iframeObj].document.getElementsByTagName("body")[0]).style.height).replace("px", "");
    }
    return {
        w: _w,
        h: _h
    }
}

function gettr(tb)
{
    tb == null ? getBigC() : tb;
    var tbody = getFirstChild(tb);
    return getChildNodes(tbody);
}

function formartTime(s, o)
{
    bug("格式化时间", "开始格式化时间");
    sy = s[0][0] * 1;
    oy = o[0][0] * 1;
    sm = s[0][1] * 1;
    om = o[0][1] * 1;
    s = s[0][2] * 1;
    o = o[0][2] * 1;
    var tm = new Array();
    if (sy == oy)
    {
        if (om == sm)
        {
            tm.push([sy, duiZhao(sm), s, o]);
        }
        if (om > sm)
        {
            for (var i = 0, n = om - sm + 1; i < n; i++)
            {
                if (i == 0)
                {
                    tm.push([sy, duiZhao(sm + i), s, 0]);
                }
                if (i < n - 1 && i > 0)
                {
                    tm.push([sy, duiZhao(sm + i), 1, 0]);
                }
                if (i == n - 1)
                {
                    tm.push([sy, duiZhao(sm + i), 1, o]);
                }
            }
        }
        return tm
    }
    if (sy < oy)
    {
        for (var i = 0, n = 12 - sm; i <= n; i++)
        {
            if (i == 0)
            {
                tm.push([sy, duiZhao(sm + i), s, 0]);
                continue;
            }
            if (i < n - 1 && i > 0)
            {
                tm.push([sy, duiZhao(sm + i), 1, 0]);
            }
            if (i == n)
            {
                tm.push([sy, duiZhao(sm + i), 1, 0]);
            }
        }
        for (var i = 0, n = om; i < n; i++)
        {
            if (i == 0)
            {
                tm.push([oy, duiZhao(1 + i), s, 0]);
            }
            else if (i != n - 1)
            {
                tm.push([oy, duiZhao(1 + i), 1, 0]);
            }
            if (i == n - 1)
            {
                tm.push([oy, duiZhao(1 + i), 1, o]);
            }
        }
        return tm;
    }
}

function getDrowTable(s, o)
{
    bug("格式化之前的时间", s + "<br>" + o);
    var tm = formartTime(s, o);
    bug("被格式化之后的时间", tm.toString());
    var c = getRightCalendar();
    var tb = new Array();
    var title = "";
    bug("月历界面总个数", "月历界面个数:" + c.length);
    for (var t = 0, n = tm.length; t < n; t++)
    {
        for (var m = 0, mn = c.length; m < mn; m++)
        {
            tr = gettr(c[m]);
            title = getChildNodes(tr[0])[1].innerHTML;
            if (title.indexOf(tm[t][0]) >= 0 && title.indexOf(tm[t][1]) >= 0)
            {
                bug("月历索引", "月历索引:" + m + " <br>月历:" + title, "red");
                tb.push([c[m], tm[t][2], tm[t][3]]);
            }
        }
    }
    return tb;
}

function drawPanle(id, s, o, str, colorStr, proState)
{
    var s_e = "",
        tr = "",
        p = "",
        t = 0,
        l = 0,
        n_id = "",
        mh = 0;
    var tb = getDrowTable(s, o);
    bug("profile显示的区域 包括的table总数", "<b style='font-size:25px;'>" + tb.length + "</b>");
    bug("写入的Profile", "<textarea style='width:100%; height:100px; border:0px; font-size:12px;'>" + str + "</textarea>");
    var d = new Date();
    for (var tbl = 0, tn = tb.length; tbl < tn; tbl++)
    {
        tr_id = id;
        s_e = "";
        tr = gettr(tb[tbl][0]);
        p = "";
        t = 0,
        l = 0;
        s = tb[tbl][1];
        o = tb[tbl][2];
        bug("开始画界面", "月历索引:" + tbl + " 月历:" + txt(tr[0]) + " 开始时间:" + s + " 结束时间:" + o);
        bug("公用界面属性", "起始点的x左边:" + s_e + " t: " + t + " l:" + l);
        for (var i = 2, n = tr.length; i < n; i++)
        {
            for (var a = 0, c = getChildNodes(tr[i]), m = c.length; a < m; a++)
            {
                if (a == 0 && s_e != "")
                {
                    p = getElementPos(c[a]);
                    t = p.y + 25;
                    l = p.x;
                    s_e = p.x;
                    n_id = tr_id + tbl + i + a + "_" + t;
                    createLayer(n_id, t, l, str, colorStr);
                    proStateCo(c[a],proState);
                }
                if (parseInt(txt(c[a])) == s)
                {
                    p = getElementPos(c[a]);
                    t = p.y + 25;
                    l = p.x;
                    s_e = p.x;
                    n_id = tr_id + tbl + i + a + "_" + t;
                    createLayer(n_id, t, l, str, colorStr);
                    proStateCo(c[a],proState);
                }
                if (o == 0)
                {
                    if (s_e != "" && i == n - 1)
                    {
                        if (txt(c[a]).replace(/\s/g, "") == "")
                        {
                            h = mh ? mh : c[a - 1].clientHeight / 2;
                            p = getElementPos(c[a - 1]);
                            with(_(n_id).style)
                            {
                                width = (p.x + c[a - 1].clientWidth - s_e - 2) + "px";
                                height = h + "px";
                            }
                            s_e = "";
                            proStateCo(c[a],proState);
                        }
                        if (txt(c[a]).replace(/\s/g, "") != "" && a == m - 1)
                        {
                            h = mh ? mh : c[a - 1].clientHeight / 2;
                            p = getElementPos(c[a]);
                            with(_(n_id).style)
                            {
                                width = (p.x + c[a].clientWidth - s_e - 2) + "px";
                                height = h + "px";
                            }
                            s_e = "";
                            proStateCo(c[a],proState);
                        }
                    }
                    if (s_e != "" && a == m - 1 && i != n - 1)
                    {
                        h = mh ? mh : c[a].clientHeight / 2;
                        p = getElementPos(c[a]);
                        with(_(n_id).style)
                        {
                            width = (p.x + c[a].clientWidth - s_e - 2) + "px";
                            height = h + "px";
                        }
                        proStateCo(c[a],proState);
                    }
                    
                }
                if (o != 0)
                {
                    if (parseInt(txt(c[a])) == o)
                    {
                        h = mh ? mh : c[a].clientHeight / 2;
                        p = getElementPos(c[a]);
                        with(_(n_id).style)
                        {
                            width = (p.x + c[a].clientWidth - s_e - 2) + "px";
                            height = h + "px";
                        }
                        s_e = "";
                        proStateCo(c[a],proState);
                    }
                    if (s_e != "" && a == m - 1)
                    {
                        h = mh ? mh : c[a].clientHeight / 2;
                        p = getElementPos(c[a]);
                        with(_(n_id).style)
                        {
                            width = (p.x + c[a].clientWidth - s_e - 2) + "px";
                            height = h + "px";
                        }
                        proStateCo(c[a],proState);
                    }
                    
                }
                
            }
        }
    }
}
function proStateCo(o,state)
{
	//state 
	//     0--> 已通过
	//		1-->审核中
	//		2-->未审核
	//还没审核通过的Profile的td背景颜色为 #ccc
	var c="#ccc";
	switch(state)
	{
		case '0':break;
		case '1':o.style.backgroundColor=c;break;
		case '2':c="#0f0";break;
	}
	
}
function duiZhao(k)
{
    var o = [
        ["1", "一月"],
        ["2", "二月"],
        ["3", "三月"],
        ["4", "四月"],
        ["5", "五月"],
        ["6", "六月"],
        ["7", "七月"],
        ["8", "八月"],
        ["9", "九月"],
        ["10", "十月"],
        ["11", "十一月"],
        ["12", "十二月"]
    ];
    for (var i = 0, n = o.length; i < n; i++)
    {
        if (k == o[i][0])
        {
            return o[i][1];
        }
    }
}

function cnNumber(k)
{
    var o = [
        ["1", "一月"],
        ["2", "二月"],
        ["3", "三月"],
        ["4", "四月"],
        ["5", "五月"],
        ["6", "六月"],
        ["7", "七月"],
        ["8", "八月"],
        ["9", "九月"],
        ["10", "十月"],
        ["11", "十一月"],
        ["12", "十二月"]
    ];
    for (var i = 0, n = o.length; i < n; i++)
    {
        if (k == o[i][1])
        {
            return o[i][0];
        }
    }
}

function createLayer(id, t, l, str, colorStr)
{
    var d = document.createElement("DIV");
    setAttr(d, "id", id);
    with(d.style)
    {
        position = "absolute";
        width = "1px";
        height = "1px";
        top = t + "px";
        left = l + "px";
        display = "block";
        backgroundColor = "#" + colorStr;
        border = "1px solid #000";
        zIndex = 1000;
        fontSize = "1px";
        cursor = "pointer";
    }
    d.innerHTML = str;
    setOpacity(d, 60);
    _("bqian").appendChild(d);
    bindLeftClick(d, getProfileInfo);
}

function getProfileInfo(e)
{
    var o = getEventObject(e);
    if (o.tagName != "DIV")
    {
        o = getParentNode(o);
    }
    var pro_id = getAttr(o, "id").split("--")[0];
    var ajax = new AJAXRequest();
    ajax.get("index.php/scheduling/getProfileInfo/" + pro_id, function (obj)
    {
    	if(typeof obj!= "object")
    	{
    		bug("从后台获取profile 信息", "点击过快！！", "green");	
    		return false;
    	}
    	else
    	{
    		try
    		{
    			bug("从后台获取profile 信息", obj.responseText, "green");
                showProfileInfo(obj.responseText);	
    		}catch(e)
    		{
    			bug("从后台获取profile 信息", "数据为空！", "green");
    			return false;
    		}
    		
    	}
        
    });
}

function getProfileInfoDefault(pro_id)
{
    var ajax = new AJAXRequest();
    ajax.get("index.php/scheduling/getProfileInfo/" + pro_id, function (obj)
    {
        bug("从后台获取profile 信息", obj.responseText, "green");
        showProfileInfo(obj.responseText);
    });
}

function showProfileInfo(str)
{
	var s='';
    try
    { s = eval(str);}
    catch (e)
    {
    	//alert("获取Profile信息失败");
        bug("获取Profile信息失败", e, "red");
        return false;
    }
    if(s ==undefined)
    {
    	// alert("获取Profile信息失败");
         bug("获取Profile信息失败","", "red");
         return false;
    }
    if (s.length > 0)
    {
        _("profile_file").innerHTML = "";
        var d = "",d1,d2,dom_dcon;
        for (var i = 0, n = s.length; i < n; i++)
        {
            bug("Profile中文件信息", s[i][0] + " --> " + s[i][1]);
			dom_dcon=document.createElement("A");
			with(dom_dcon)
			{
				href="javaScript:void(0)";
				title=s[i][0];
			}
            d = document.createElement("span");
            d.style.cssText = " display:block; overflow:hidden; line-height:12px; height:12px; width:75%; padding:0px;  font-size:12px; float:left;";
            d.innerHTML = s[i][0];
            d1 = document.createElement("span");
            d1.style.cssText = " width:13%; padding:0px; overflow:hidden;  font-size:12px; float:left; color:#bfbfbf;";
            d1.innerHTML = s[i][1];
            d2 = document.createElement("span");
            d2.style.cssText = "cursor:pointer;  padding:0px;  font-size:12px; float:left; color:#0011ee;";
            d2.innerHTML = "查看";
            att(d2, "type", s[i][2]);
            att(d2, "viewUrl", s[i][3]);
            dom_dcon.appendChild(d);
            dom_dcon.appendChild(d1);
			dom_dcon.appendChild(d2);
            _("profile_file").appendChild(dom_dcon);
            bindLeftClick(d2, viewPlayFile);
        }
		resetProfileListConUI("profile_file");
        //bug("Profile中的文件信息", _("profile_file").innerHTML);
    }
    else
    {
        alert("您的Profile创建不正确");
    }
}

function viewPlayFile(e)
{
    var o = getEventObject(e);
    art.dialog(
    {
        content: '<iframe style="display:block; width:255px; height:175px; overflow:hidden"  src="index.php/viewFile/index/' + att(o, "type") + '/' + att(o, "viewUrl") + '" frameborder="0" allowtransparency="true"></iframe>',
        skin: 'chrome',
        lock: true
    });
}

function getNowDate()
{
    var str = html(getNextChild(getFirstChild(getFirstChild(getFirstChild(getFirstChild(_("schedule_Small_Calendar")))))));
    str = str.split("&nbsp;");
    return {
        y: str[1],
        m: cnNumber(str[0])
    };
}
//------------------------------------------
//-
//- 获取所有的Profile Name
//-
//------------------------------------------
function getAllProfile() {
    var tagA = '';
    var proNameArray = [];
    var proDiv = getChildNodes(_("profile_info"), "a");
    for (var i = 0, n = proDiv.length; i < n; i++) 
    {
        tagA = getChildNodes(proDiv[i], "span")[1];
        //proNameArray.push((att(tagA, "ph").split("/"))[1]);
        proNameArray.push(att(tagA, "proId"));
    }
    bug("获取所有的Profile ID", print_r(proNameArray));
    return proNameArray;
}
//------------------------------------------
//-
//- 获取所有的Profile 中间的文件
//-
//------------------------------------------
function getProfileFile(proID) {
    //--------> profile的个数小于2，就不需要去重设背景色
   if (proID.length < 2) { return false; }
   //var data = convertToJson(proID);
   var data = proID.join(',');
   bug("getProfileFile data",data);
   // var proArray = [];
    //var fileArray = [];
    art.dialog({
        title: '节目单元信息',
        id: 'proBiDui',
        skin: 'chrome',
        lock: true,
        content: '正在加载节目单元信息,请稍等!'
    });

    var ajax = new AJAXRequest();
    ajax.timeout = 300000;
    ajax.ontimeout = function (e) {
        art.dialog({
            skin: 'chrome',
            id: 'timeOutUi',
            content: '你指定的信息,加载失败!<br>请求超时......'
        });
        art.dialog.get('proBiDui').close();
    }

    ajax.onexception = function (e) {
        art.dialog({
            skin: 'chrome',
            id: 'serverError',
            content: '无法加载您需要的信息!'
        });
        art.dialog.get('proBiDui').close();
    }
    ajax.post("index.php/profileOther/getProfileFiles",
		"info=" + data,
		function (obj) {
    	  if(obj)
		  {
    		 var st = obj.responseText;
		     bug("服务器返回的播放列表中profile的详细信息", st, "green");
		     art.dialog.get('proBiDui').close();
            //--> 开始重设背景颜色
		     setAllDivBgColor(st);
		  }
		});

 }

 //------------------------------------------
 //-
 //- 重设所有的Profile 的浮动DIV 背景颜色 入口
 //-
 //------------------------------------------
function setProColor(playName) 
{
    playName = playName.split("_");
    //------> 判断是否是由,Excel导入(移动)的,播放列表
    if (playName.lenght < 1 || playName[1] != "Excel") { return false; }
    var proId = getAllProfile();
	
    getProfileFile(proId);
}

//------------------------------------------
//-
//- 获取所有的Profile 的浮动DIV
//-
//------------------------------------------
function getAllProDiv() {
    return getChildNodes(_("bqian"), "div");
 }
 //------------------------------------------
 //-
 //- 重设所有的Profile 的浮动DIV的背景颜色
 //- params pro(strng) 服务器返回的file info
 //------------------------------------------
 function setAllDivBgColor(pro) {
     var allDiv = getAllProDiv();
     try {
		 bug("setAllDivBgColor pro",pro);
         pro = eval(pro);
         var fileSouce = [], fileNSouce = [], dvLen = allDiv.length, proLen = pro.length;
         if (dvLen > 0 && proLen > 0) {
             for (var i = 0, n = proLen; i < n; i++) {
                if (i < dvLen-1&&i+1<proLen) {
                    fileSouce = pro[i].files;
                    fileNSouce = pro[i + 1].files;
                    if(fileSouce.length == fileNSouce.length){
                        proComparison(fileSouce, fileNSouce) == true ?
                        //---> 开始重置 background color
                        changeProDivBGColor(allDiv[i], allDiv[i+1]) : '';
                    }
                }
            }
         }
     } catch (e) {bug("setAllDivBgColor",e); alert("您的节目单元的文件信息,不正确!\n无法重新分组,节目单元!"); }

  }
 //------------------------------------------
 //-
 //- 连续两个profile文件比对
 //- params fPro(array) nPro(array)
 //------------------------------------------
  function proComparison(fPro, nPro) {
    var state=0;
    for (var v in fPro) {
        for (var i = 0, n = nPro.length; i < n; i++) {
            if (nPro[i].FileViewURL == fPro[v].FileViewURL) {
                bug("文件对比", nPro[i].FileViewURL + " <br /> " + fPro[v].FileViewURL);
                state++;
                i = n;
            }
        }
    }
    return state == fPro.length ? true : false;
  }
 //------------------------------------------
 //-
 //- 重设浮动DIV的背景颜色
 //- params fDiv(dom) nDiv(dom)
 //------------------------------------------
  function changeProDivBGColor(fDiv,nDiv) {
      nDiv.style.backgroundColor = fDiv.style.backgroundColor;
	  getFirstChild(nDiv).style.backgroundColor = fDiv.style.backgroundColor;
  }