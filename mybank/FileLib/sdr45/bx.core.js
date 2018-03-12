(function (W, D) {
    var _Boolean = false;
    var _infoState = false;
    /*************************************************************
    |
    |	函数名:getById
    |	功能:返回一个DOM对象,或者 在获取的DOM上执行用户的方法
    |	返回值:对象的x,y轴的坐标
    |	参数: element -> html对象 event->鼠标事件, fun->鼠标事件触发的方法
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月24日0:19:45 
    |	修改时间:
    |
    **************************************************************/
    function getById(element, ev, fun) {
        try {
            if ("string" == typeof (element)) {
                if (fun) {
                    D.getElementById(element)["on" + ev] = fun;
                }
                else {
                    return D.getElementById(element);
                }
            }
            else { return element; }
        }
        catch (e) { errMessage(e); }
    }
    //针对于table
    function getTableChildElement(tbl) {

    }
    function getByTag(g, where) {
        var tgs = D.getElementsByTagName(g);
        if (where == null) {
            return tgs;
        }
        else {
            var itms = [];
            //alert(where);
            where = where.split("=");
            for (var i = 0, n = tgs.length; i < n; i++) {
                if (domAttribute(tgs[i], where[0]) == where[1]) {
                    itms.push(tgs[i]);
                }
            }
            return itms;
        }
    }
    function getByName(n) { return D.getElementsByName(n); }
    /*************************************************************
    |
    |	函数名:domReady
    |	功能:DOM结构绘制完毕后就执行，不必等到加载完毕。
    |	返回值:无
    |	参数: readyCall->将要执行的函数
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月17日10:19:27
    |	修改时间:
    -----------------------------------------
    | 		Jquery中$(document).ready()的作用类似于传统JavaScript中的window.onload方法，不过与window.onload方法还是有区别的。
    |
    |		1.执行时间：
    |			window.onload必须等到页面内包括图片的所有元素加载完毕后才能执行。
    |			$(document).ready()是DOM结构绘制完毕后就执行，不必等到加载完毕。
    |
    |		2.编写个数不同
    |	 		window.onload不能同时编写多个，如果有多个window.onload方法，只会执行一个
    |	 		$(document).ready()可以同时编写多个，并且都可以得到执行
    |
    |		3.简化写法
    |	 		window.onload没有简化写法
    |	 		$(document).ready(function(){})可以简写成$(function().{});
    **************************************************************/
    function domReady(readyCall) {
        if (D.addEventListener) {
            D.addEventListener("DOMContentLoaded", function () {
                D.removeEventListener("DOMContentLoaded", arguments.callee, false);
                readyCall();
            }, false);
        }
        else if (document.attachEvent) { //for IE
            if (D.documentElement.doScroll && W.self == W.top) {
                (function () {
                    try {
                        D.documentElement.doScroll("left");
                        clearTimeout(arguments.callee.timer);
                        arguments.callee.timer = null;
                    }
                    catch (ex) {
                        arguments.callee.timer = setTimeout(arguments.callee, 5);
                        return;
                    }
                    readyCall();
                })();
            }
            else { //maybe late but also for iframes
                D.attachEvent("onreadystatechange", function () {
                    if (D.readyState === "complete") {
                        D.detachEvent("onreadystatechange", arguments.callee);
                        readyCall();
                    }
                });
            }
        }
    }
    /*★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    ★
    ★
    ★			对象位置 光标位置
    ★
    ★
    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★*/
    /*************************************************************
    |
    |	函数名:getElementPosition
    |	功能:获取html对象相对于document的位置
    |	返回值:对象的x,y轴的坐标
    |	参数: element -> html对象
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月16日19:16:01
    |	修改时间:
    |
    **************************************************************/
    function getElementPosition(element, _borderLeftWidth, _borderTopWidth) {
        var left = 0;
        var top = 0;
        while (element.offsetParent) {
            if (element.currentStyle) {
                _borderLeftWidth = isNaN(parseInt(element.currentStyle.borderLeftWidth));
                _borderTopWidth = isNaN(parseInt(element.currentStyle.borderTopWidth));
                _borderLeftWidth ? _borderLeftWidth = 0 : _borderLeftWidth;
                _borderTopWidth ? _borderTopWidth = 0 : _borderTopWidth;
            }
            left += element.offsetLeft + (element.currentStyle ? _borderLeftWidth : 0);
            top += element.offsetTop + (element.currentStyle ? _borderTopWidth : 0);
            element = element.offsetParent;
        }
        if (element.currentStyle) {
            _borderLeftWidth = isNaN(parseInt(element.currentStyle.borderLeftWidth));
            _borderTopWidth = isNaN(parseInt(element.currentStyle.borderTopWidth));
            _borderLeftWidth ? _borderLeftWidth = 0 : _borderLeftWidth;
            _borderTopWidth ? _borderTopWidth = 0 : _borderTopWidth;
        }
        left += element.offsetLeft + (element.currentStyle ? _borderLeftWidth : 0);
        top += element.offsetTop + (element.currentStyle ? _borderTopWidth : 0);
        return { x: left, y: top };
    }
    /*************************************************************
    |
    |	函数名:getMousePosition
    |	功能:获取光标相对于document的位置
    |	返回值:
    |	参数:
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月16日19:18:12
    |	修改时间:
    |
    **************************************************************/
    function getMousePosition(e) {
        var e = e ? e : event;
        if (e.pageX || e.pageY) {
            return {
                x: e.pageX,
                y: e.pageY
            }
        }
        else {
            return {
                x: e.clientX + document.documentElement.scrollLeft - document.body.clientLeft,
                y: e.clientY + document.documentElement.scrollTop - document.body.clientTop
            }
        }
    }
	/*************************************************************
    |
    |	函数名:getMousePosition
    |	功能:获取鼠标指针位置相对于触发事件的对象的 x ,y坐标。
    |	返回值:x 坐标， y坐标
    |	参数:target  发事件的对象,ev  触发的事件对象
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间：2012年3月20日 13:26:30
    |	修改时间:
    |
    **************************************************************/
	function getMouseOfDomOffset(target, ev)
	{
		ev = ev || window.event;
		var docPos    = getElementPosition(target);
		var mousePos  = getMousePosition(ev);
		return {x:mousePos.x - docPos.x, y:mousePos.y - docPos.y};
	}
    /*★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    ★
    ★
    ★			DOM 节点操作
    ★
    ★
    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★*/
    //获取HtmlElement 即时宽度
    function getDomClientWidth(el) {
        try {
            el = getById(el);
            if (el == D) {
                return D.documentElement.clientWidth;
            }
            else {
                return el.clientWidth;
            }
        }
        catch (e) {
            errMessage(e);
        }
    }
    //获取HtmlElement 即时高度
    function getDomClientHeight(el) {
        try {
            el = getById(el);
            if (el == D) {
                return D.documentElement.clientHeight;
            }
            else {
                return el.clientHeight;
            }
        }
        catch (e) {
            errMessage(e);
        }
    }
    /*************************************************************
    |
    |	函数名:insertDomHTML
    |	功能:在指定的位置插入 html (string)
    |	返回值: 被插入的对象 (IE 未返回)
    |	参数:
    |			el    = HTMLElement 对象
    |			where = beforeBegin、afterBegin、beforeEnd、afterEnd 中之一
    |				beforeBegin  ==> 在 el 的前面插入 html
    |				afterBegin   ==> 在 el 中的第一个节点 前插入 html
    |				beforeEnd    ==> 在 el 中的最后的节点 后插入 html
    |				afterEn      ==> 在 el 的后面插入 html
    |			html = string格式的 html文本
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年11月27日20:34:33
    |	修改时间:
    |
    **************************************************************/
    function insertDomHTML(el, where, html) {
        if (!el) {
            return false;
        }
        where = where.toLowerCase();

        if (el.insertAdjacentHTML) {

            //IE
            el.insertAdjacentHTML(where, html);
        }
        else {
            var range = el.ownerDocument.createRange(), frag = null;
            switch (where) {
                case "beforebegin":
                    range.setStartBefore(el);
                    frag = range.createContextualFragment(html);
                    el.parentNode.insertBefore(frag, el);
                    return el.previousSibling;
                case "afterbegin":
                    if (el.firstChild) {
                        range.setStartBefore(el.firstChild);
                        frag = range.createContextualFragment(html);
                        el.insertBefore(frag, el.firstChild);
                    }
                    else {
                        el.innerHTML = html;
                    }
                    return el.firstChild;
                case "beforeend":
                    if (el.lastChild) {
                        range.setStartAfter(el.lastChild);
                        frag = range.createContextualFragment(html);
                        el.appendChild(frag);
                    }
                    else {
                        el.innerHTML = html;
                    }
                    return el.lastChild;
                case "afterend":
                    range.setStartAfter(el);
                    frag = range.createContextualFragment(html);
                    el.parentNode.insertBefore(frag, el.nextSibling);
                    return el.nextSibling;
            }
        }
    }
    /*************************************************************
    |
    |	函数名:getDomLastChild
    |	功能:获取制定对象的最后一个 有用的 htnl 节点
    |	返回值: HtmlElement
    |	参数: o-> html对象
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月28日20:40:30
    |	修改时间:2010年11月27日20:52:28
    |
    **************************************************************/
    function getDomLastChild(o) {
        typeof (o) == "string" ? o = getById(o) : o;
        try {
            var node = objt.lastChild;
            while (node.nodeType != 1) {
                node = getDomPreviousChild(node);
            }
            return node;
        }
        catch (e) {
            errMessage(e);
        }
    }
    /*************************************************************
    |
    |	函数名:removeDomChild
    |	功能:删除指定的子节点
    |	返回值:bool 值
    |	参数: o-> html对象
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月28日20:40:30
    |	修改时间:2010年11月27日20:51:14
    |
    **************************************************************/
    function removeDomChild(o, n) {
        typeof (o) == "string" ? o = getById(o) : o;
        try {
            var c = o.removeChild(n);
            c = null;
        }
        catch (e) {
            errMessage(e);
        }
    }
    /*************************************************************
    |
    |	函数名:removeAllChildNodes
    |	功能:删除所有的子节点
    |	返回值:bool 值
    |	参数: o-> html对象
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月28日20:40:30
    |	修改时间:
    |
    **************************************************************/
    function removeAllChildNodes(o) {
        typeof (o) == "string" ? o = getById(o) : o;
        try {
            while (o.firstChild) {
                o.removeChild(o.firstChild);
            }
        }
        catch (e) {
            errMessage(e);
        }
    }
    /*************************************************************
    |
    |	函数名:getDomAttribute
    |	功能:获取DOM对象的一个属性
    |	返回值:string  属性的值
    |	参数: o-> html对象 , atr-> 被获取的属性名称
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月28日20:45:39
    |	修改时间:
    |
    **************************************************************/
    function getDomAttribute(o, atr) {
        return typeof (o) == "string" ? getById(o).getAttribute(atr) : o.getAttribute(atr);
    }
    /*************************************************************
    |
    |	函数名:setDomAttribute
    |	功能:修改或者添加DOM对象的属性和值
    |	返回值:string  属性的值
    |	参数: o-> html对象 , atr1-> 被获取的属性名称 , art2-> 属性值
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月28日20:52:30
    |	修改时间:
    |
    **************************************************************/
    function setDomAttribute(o, atr1, atr2) {
        typeof (o) == "string" ? getById(o).setAttribute(atr1, atr2) : o.setAttribute(atr1, atr2);
    }
    /*************************************************************
    |
    |	函数名:domAttribute
    |	功能:修改,添加,设置DOM对象的属性和值
    |	返回值:string  属性的值
    |	参数: o-> html对象 , atr1-> 被获取的属性名称 , art2-> 属性值
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月30日20:52:30
    |	修改时间:2011年7月29日 11:24:59
    |
    **************************************************************/

    function domAttribute(o, atr1, atr2) {
        if (typeof(o) == "string") {
            o = getById(o);
        }
        if(!o){return false;}
        try {
            if (atr2 != null && typeof(atr2) == "string") {
                o.setAttribute(atr1, atr2);
            }
            else {
                if (_infoState) {
                    bug("bx.core.js->domAttribute", "o.tagName:" + o.tagName + "<br>o.getAttribute:" + o.getAttribute(atr1) + "<br>o[atr1]:" + o[atr1], "#006");
                }
                return o.getAttribute(atr1) == "" ? o[atr1] : o.getAttribute(atr1);
            }
        }
        catch (e) {
            errMessage(e);
        }
    }
    /*************************************************************
    |
    |	函数名:getDomParentNode
    |	功能:获取父节点
    |	返回值:返回当前节点的父节点
    |	参数: o-> html对象
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月23日10:37:48
    |	修改时间:
    |
    **************************************************************/
    function getDomParentNode(o) {
		return o.parentNode?o.parentNode:o.parent;
        
    }
	/*************************************************************
    |
    |	函数名:getParentUserDesignatedNode
    |	功能:获取父节点
    |	返回值:返回当前节点符合条件的父节点
    |	参数: o-> html对象, 
	|         w-> int类型: 获取当前节点的第w级父节点;
	|             key=value键值对类型: 获取当前节点的父节点中有属性键值对为 key=value的父节点;
	|             tagName 标签名称: 获取当前节点的父节点中的tag标签名称为tagName的父节点;
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月23日10:37:48
    |	修改时间:
    |
    **************************************************************/
    function getParentUserDesignatedNode(o, w) {
        var n = "";
		if(!w){
			return getDomParentNode(o);
		}
		if(typeof(w)=="number")
		{
			n=o;
			
			for(var i=1; i<=w; i++)
			{
				n = getDomParentNode(n);
			}
			return n;
		}
        w = w.split("=");
        if (w.length == 2) {
			n = getDomParentNode(o);
            while(w[1]!=domAttribute(n, w[0]))
			{
				n = getDomParentNode(n);
			}
        }
		if(w.length==1)
		{
			n = getDomParentNode(o);
			while (n.tagName!=w[0].toUpperCase()) 
			{
				n=getDomParentNode(n);
			}
		}
        return n
    }

    /*************************************************************
    |
    |	函数名:getDomNextChild
    |	功能:获取同级节点的下一个节点
    |	返回值:同级节点的下一个节点
    |	参数: node-> 当前节点
    |	函数关联:
    |		-被调用:getFirstChild
    |		-主动调用:
    |	创建时间:2010年9月10日11:37:57
    |	修改时间:
    |
    **************************************************************/
    function getDomNextChild(node, _node) {
        try {
            _node = node;
            node = node.nextSibling;
            if (node != null) {
                while (node.nodeType != 1) {
                    node = node.nextSibling;
                    if (!node) { break; }
                }
            }
            if (!node) {
                node = _node;
            }
            return node;
        }
        catch (e) {
            errMessage(e);
        }
    }
    /*************************************************************
    |
    |	函数名:getDomPreviousChild
    |	功能:获取同级节点的上一个节点
    |	返回值:同级节点的上一个节点
    |	参数: node-> 当前节点
    |	函数关联:
    |		-被调用:getDomLastChild
    |		-主动调用:
    |	创建时间:2010年9月10日11:37:57
    |	修改时间:
    |
    **************************************************************/
    function getDomPreviousChild(node, _node) {
        try {
            _node = node;
            node = node.previousSibling;
            if (node != null) {
                while (node.nodeType != 1) {
                    node = node.previousSibling;
                    if (!node) { break; }
                }
            }
            if (!node) {
                node = _node;
            }
            return node;
        }
        catch (e) {
            errMessage(e);
        }
    }
    /*************************************************************
    |
    |	函数名:getDomFirstChild
    |	功能:获取一个DOM对象的第一个子节点
    |	返回值:DOm对象的第一个nodeType为1 的子节点
    |	参数: o-> DOM对象; c-> 形式参数
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月18日13:51:31
    |	修改时间:
    |
    **************************************************************/
    function getDomFirstChild(o, c) {
        typeof (o) == "string" ? o = getById(o) : o;
        try {
            c = o.firstChild;
            if (c) {
                while (c.nodeType != 1) {
                    c = c.nextSibling;
                    if (!c) { c = null; break; }
                }
            }
            return c;
        }
        catch (e) {
            errMessage(e);
        }
    }
    /*************************************************************
    |
    |	函数名:getDomChildNodes
    |	功能:DOM一个对象的所有子节点
    |	返回值:同级节点的上一个节点
    |	参数: id-> DOM对象的ID; tg-> 筛选条件返回子节点类型的tagName; pr-> 筛选条件匹配节点的属性;
    |	函数关联:
    |		-被调用:
    |		-主动调用:getById()
    |	创建时间:2010年9月10日11:43:45
    |	修改时间:2010年9月17日13:02:44
    |
    **************************************************************/
    function getDomChildNodes(id, tg, pr, ns, cns) {

        //判断属性值是否传入
        if (pr) { pr = pr.split("="); }
        typeof (id) == "string" ? ns = getById(id) : ns = id;
        try {
            ns = ns.childNodes;

            if (_infoState) {
                if (!ns) {
                    createDeBug("bx.core.js-->函数名:getDomChildNodes", "id:" + typeof (id) + " tg:" + tg + " pr:" + pr, "#006");
                }
                createDeBug("bx.core.js-->函数名:getDomChildNodes", "id:" + typeof (id) + " tg:" + tg + " pr:" + pr + " ns.length: " + ns.length + " id->tag: " + id.tagName, "#006");
            }

            cns = new Array();
            for (var i = 0, n = ns.length; i < n; i++) {
                if (ns[i].nodeType == 1) {

                    if (tg && pr) {
                        //alert(ns[i].tagName.toLowerCase()+"->"+tg+"\n"+ns[i].getAttribute(pr[0])+"->"+pr[1]);
                        if (pr[0] == "class") {
                            if (document.all) {
                                pr[0] = "className";
                                if (!ns[i].getAttribute(pr[0])) {
                                    pr[0] = "class";
                                }
                            }

                        }
                        //alert(ns[i].getAttribute(pr[0]));
                        if (ns[i].tagName.toLowerCase() == tg && ns[i].getAttribute(pr[0]) == pr[1]) {
                            cns.push(ns[i]);
                        }
                    }
                    else if (pr || tg) {

                        if (ns[i].tagName.toLowerCase() == tg) {
                            cns.push(ns[i]);
                        }

                        if (pr && ns[i].getAttribute(pr[0]) == pr[1]) {
                            cns.push(ns[i]);
                        }
                    }
                    else {
                        cns.push(ns[i]);
                    }
                }
            }
            return cns;
        }
        catch (e) {
            errMessage(e);
        }
    }
    /*************************************************************
    |
    |	函数名:htmlDomText
    |	功能:获取/设置dom对象的txt值
    |	返回值:
    |	参数: o-> dom对象,value->背赋给dom对象的值
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月17日12:33:06
    |	修改时间:
    |
    **************************************************************/
    function htmlDomText(o, value) {
        o = getById(o);
        try {
            if (o.innerText) {
                if (value) { o.innerText = value; }
                else
                { return o.innerText; }
            }
            else {
                if (value) { o.textContent = value; }
                else
                { return o.textContent; }
            }
        }
        catch (e) {
            errMessage(e);
        }
    };
    /*************************************************************
    |
    |	函数名:getDomHtml
    |	功能:获取/设置dom对象的InnerHTML值
    |	返回值:
    |	参数: o-> dom对象,v->背赋给dom对象的值
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月17日12:33:06
    |	修改时间:
    |
    **************************************************************/
    function getDomHtml(o, v) {
        if (v == null) {
            return getById(o).innerHTML;
        }
        else {
            getById(o).innerHTML = v;
        }
    }
	/*************************************************************
    |
    |	函数名:createDomElement
    |	功能:创建一个dom对象
    |	返回值:
    |	参数: str_name(string) tagname, object_attribute(object) 对象属性
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2011年12月27日11:49:37
    |	修改时间:
    |
    **************************************************************/
	// {id:"aa",style:"width:100px;height:100px;",className:"sss",event:{nousemove:func1,mouseout:fun2,}}
	function createDomElement(str_name,object_attribute)
	{
		var dom_ele=document.createElement(str_name);
		if(typeof(object_attribute)=="object")
		{
			for(var i in object_attribute)
			{
				if(i!="event")
				{
					if(i=="className")
					{
						addDomClassName(dom_ele,object_attribute[i]);
					}
					else
					{	
						if(i=="innerHTML")
						{
							dom_ele.innerHTML=object_attribute[i];
							continue;
						}
						if(i=="href")
						{
							dom_ele.href=object_attribute[i];
							continue;
						}
						if(i=="src")
						{
							dom_ele.src=object_attribute[i];
							continue;
						}
						dom_ele.setAttribute(i,object_attribute[i]);
					}
				}
				else
				{
					for (var a in object_attribute[i])
					{
						elementAddEventListener(dom_ele,a,object_attribute[i][a]);
					}
					
				}
			}
		}
		return dom_ele;
	}
    /*★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    ★
    ★
    ★			DOM 样式操作
    ★
    ★
    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★*/
    /*************************************************************
    |
    |	函数名:addDomClassName
    |	功能:为DOM对象添加class属性
    |	返回值:同级节点的上一个节点
    |	参数: ele-> DOM对象; className->要添加的Class名称;
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月10日11:58:38
    |	修改时间:
    |
    **************************************************************/
    function addDomClassName(ele, className) {
        if (!ele || !className || (ele.className && ele.className.search(new RegExp("\\b" + className + "\\b")) != -1))
        { return; }
        ele.className += (ele.className ? " " : "") + className;
    };
    /*************************************************************
    |
    |	函数名:removeDomClassName
    |	功能:为DOM对象删除class属性
    |	返回值:同级节点的上一个节点
    |	参数: ele-> DOM对象; className->要删除的Class名称;
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月10日11:58:38
    |	修改时间:
    |
    **************************************************************/
    function removeDomClassName(ele, className) {
        if (!ele || !className || (ele.className && ele.className.search(new RegExp("\\b" + className + "\\b")) == -1))
        { return; }
        ele.className = ele.className.replace(new RegExp("\\s*\\b" + className + "\\b", "g"), "");
    };
    /*************************************************************
    |
    |	函数名:getCssStyleValue
    |	功能:获取html对象的class属性指定的css样式
    |	返回值:获取样式属性的值
    |	参数: o-> html对象; styleName-> styleSheet 的属性名称
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月17日11:38:20
    |	修改时间:
    |
    **************************************************************/
    function getCssStyleValue(o, styleName) {
        if (o.currentStyle) {
            return o.currentStyle[styleName];
        }
        else {
            return document.defaultView.getComputedStyle(o, null).getPropertyValue(styleName);

        }
    }
    /*************************************************************
    |
    |	函数名:setDomTranslucence
    |	功能:设置透明度
    |	返回值:获取样式属性的值
    |	参数: o-> html对象; n-> 透明度
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月17日11:38:20
    |	修改时间:
    |
    **************************************************************/
    function setDomTranslucence(o, n) {
        if (!document.all) {
            o.style.opacity = n / 100;
        }
        else {
            o.style.filter = "alpha(opacity=" + n + ")";
        }
    }
	/*************************************************************
    |
    |	函数名:changeDomClass
    |	功能: 修改Dom对象的Class属性
    |	返回值: 布尔
    |	参数: o-> html对象; a_s-> 要添加的class name; d_s->要删除的class name
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2012年3月8日 17:32:20
    |	修改时间:
    |
    **************************************************************/
	function changeDomClass(o,a_s,d_s)
	{
		o=typeof(o)=="string"?getById(o):o;
		typeof(a_s)=="string"?addDomClassName(o,a_s):"";
		typeof(a_s)=="string"?removeDomClassName(o,d_s):"";
	}
	/*************************************************************
    |
    |	函数名:domHasClass
    |	功能: 检查DOM对象是否存在某个class
    |	返回值: 布尔
    |	参数: obj-> html对象; cName-> 要检查的class name;
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2012年3月17日19:05:19
    |	修改时间:
    |
    **************************************************************/
	function domHasClass(o,cName)
	{ 
		return (!o || !o.className)?false:(new RegExp("\\b"+cName+"\\b")).test(o.className);
	}

    /*★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    ★
    ★
    ★			数据结构转换 , 数据处理
    ★
    ★
    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★*/


    /*************************************************************
    |
    |	函数名:getArgumentsFromHref
    |	功能:从当前窗口中的href中截取参数
    |	返回值:截取的参数值
    |	参数:sHref -> URL; sArgName->被截取的参数
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月11日12:41:47
    |	修改时间:
    |
    **************************************************************/
    function getArgumentsFromHref(sHref, sArgName) {
        var args = sHref.split("?");
        var retval = "";
        if (args[0] == sHref) /*  参数为空   */
        {
            return retval; /*  无需做任何处理  */
        }
        var str = args[1];
        args = str.split("&");
        for (var i = 0; i < args.length; i++) {
            str = args[i];
            var arg = str.split("=");
            if (arg.length <= 1) continue;
            if (arg[0] == sArgName) retval = arg[1];
        }
        return retval;
    }
    /*************************************************************
    |
    |	函数名:convertObjArrToJson
    |	功能:将数组转化为json数据格式
    |	返回值:返回json格式字符串
    |	参数: array-> 数组;
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月11日12:13:24
    |	修改时间:2011年12月26日14:46:20
    |
    **************************************************************/
    function convertObjArrToJson(array, json) {
        json == null ? json = "{" : json += "{";
		var k=0;
		for (var i in array) 
		{
			k++;
		}
		var n=k;
		var m=0;
        for (var i in array) 
		{
            if (typeof (array[i]) == "object") {
                var s = convertObjArrToJson(array[i], json+'"'+i+'":');
                json = s;
            }
            else {
                json += "\"" + i + "\":\"" + array[i] + "\"";
				if(m<n-1)
				{
                	json += ",";
				}
			  // temp.push("\"" + i + "\":\"" + array[i] + "\"");
            }
			m++;
        }
		//json += temp.join(",");
        json += "}";
        return json;
    }
    /*************************************************************
    |
    |	函数名:getIntMin
    |	功能: 获取一组数字中最小的数字
    |	返回值:最小的数字
    |	参数: s-> 由逗号隔开的数字字符串 或者 独立的数组;
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月11日12:13:24
    |	修改时间:2010年11月27日20:48:25
    |
    **************************************************************/
    function getIntMin(s) {
        if (typeof (s) == "string") {
            return eval("Math.min(" + s + ")").toString()
        }
        if (typeof (s) == "array") {
            return eval("Math.min(" + s.join(',') + ")").toString()
        }
        return null;
    }
    /*************************************************************
    |
    |	函数名:getIntMax
    |	功能: 获取一组数字中最大的数字
    |	返回值:最大的数字串
    |	参数: s-> 由逗号隔开的数字字符串 或者 独立的数组;;
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月11日12:13:24
    |	修改时间:2010年11月27日20:48:22
    |
    **************************************************************/
    function getIntMax(s) {
        if (typeof (s) == "string") {
            return eval("Math.max(" + s + ")").toString();
        }
        if (typeof (s) == "array") {
            return eval("Math.max(" + s.join(',') + ")").toString();
        }
        return null;
    }
    /*************************************************************
    |
    |	函数名:Trim
    |	功能: 去除字符串两端的空格
    |	返回值:字符串
    |	参数: str -> 被去空格的字符串
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月11日12:13:24
    |	修改时间:2010年11月27日20:48:17
    |
    **************************************************************/
    function Trim(str) {

        return str.replace(/(^\s*)|(\s*$)/g, "");

    }
    /*************************************************************
    |
    |	函数名:LTrim
    |	功能: 去除字符串左端的空格
    |	返回值:字符串
    |	参数: str -> 被去空格的字符串
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月11日12:13:24
    |	修改时间:2010年11月27日20:49:14
    |
    **************************************************************/
    function LTrim(str) {

        return str.replace(/(^\s*)/g, "");

    }


    /*************************************************************
    |
    |	函数名:RTrim
    |	功能: 去除字符串右端的空格
    |	返回值:字符串
    |	参数: str -> 被去空格的字符串
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月11日12:13:24
    |	修改时间:2010年11月27日20:49:42
    |
    **************************************************************/
    function RTrim(str) {

        return str.replace(/(\s*$)/g, "");

    }

    function stringLength(str) {
        var len = 0;
        for (i = 0, n = str.length; i < n; i++) {
            if (str.charCodeAt(i) > 256) {
                len += 2;
            }
            else {
                len++;
            }
        }
        return len;
    }
	/** 
	* 判断一个Javascript对象是什么样的object类型 
	* 调用示例： 
	* var a = new Date(); 
	* var b = document.createElement("table"); 
	* var c = []; 
	* alert("表达式：isType(a,"Date") 返回值为：" + isType(a,"Date"); // 返回true 
	* alert("表达式：isType(b,"Object") 返回值为：" +isType(b,"Object") ;  // 返回true 
	* alert("表达式：isType(c,"Array") 返回值为：" + isType(c,"Array");  // 返回true 
	* @type 
	*/
	function isType(obj,type)
	{
		var is = {   
			types : ["Array", "RegExp", "Date", "Number", "String", "Object", "HTMLDocument"]   
		};   
		if(type.toUpperCase()=="HTMLDocument".toUpperCase())
		{
			var res=Object.prototype.toString.call(obj).toUpperCase();
			return /\[object HTML.*Element\]/i.test(res);
		}
		var ty=Object.prototype.toString.call(obj).toUpperCase(),uty="";
		for(var i =0,n=is.types.length; i<n; i++)
		{
			uty=("[object " + is.types[i] + "]").toUpperCase();
			if(ty == uty)
			{
				return true;
			}
		}
		return false;
	}
	/** 
	* 判断一个Javascript对象是什么样的object类型 
	* 调用示例： 
	* var a = new Date(); 
	* var b = document.createElement("table"); 
	* var c = []; 
	* alert("表达式：is[\"Date\"](a) 返回值为：" + is["Date"](a)); // 返回true 
	* alert("表达式：is[\"Object\"](b) 返回值为：" + is["Object"](b));  // 返回true 
	* alert("表达式：is[\"Array\"](c) 返回值为：" + is["Array"](c));  // 返回true 
	* @type 
	
	var is = {   
		types : ["Array", "RegExp", "Date", "Number", "String", "Object", "HTMLDocument"]   
	};   
	for(var i = 0, c; c = is.types[i++]; ){   
		is[c] = (function(type){   
			return function(obj){   
				return Object.prototype.toString.call(obj) == "[object " + type + "]";   
			}   
		})(c);   
	} */ 
	 
    /*★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    ★
    ★
    ★			Cookie 操作
    ★
    ★
    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★*/

    function Cookies() {
        //构造函数
    }

    /*******************************************
    *
    *	功能:
    *		写入Cookie
    *	参数:
    *		name cookie的名称
    *		value cookie的值
    *		hours 保存的时间 单位为小时
    *
    ********************************************/
    Cookies.prototype.Write = function (name, value, hours) {
        try {
            var expire = "";
            if (hours != null) {
                expire = new Date((new Date()).getTime() + hours * 3600000);
                expire = "; expires=" + expire.toGMTString();
            }
            document.cookie = name + "=" + escape(value) + expire;
            return true;
        }
        catch (e) {
            return false
        }
    }
    /*******************************************
    *
    *	功能:
    *		读取Cookie
    *	参数:
    *		name cookie的名称
    *	返回:
    *		cookie的值
    *
    ********************************************/
    Cookies.prototype.Read = function (name) {
        var cookieValue = "";
        var search = name + "=";
        if (document.cookie.length > 0) {
            offset = document.cookie.indexOf(search);
            if (offset != -1) {
                offset += search.length;
                end = document.cookie.indexOf(";", offset);
                if (end == -1) end = document.cookie.length;
                cookieValue = unescape(document.cookie.substring(offset, end))
            }
        }
        return cookieValue;
    }
    /*******************************************
    *
    *	功能:
    *		通过cookie的起始位置读取Cookie
    *	参数:
    *		offset cookie的起始位置
    *	返回:
    *		cookie的值
    *
    ********************************************/
    Cookies.prototype.GetCookieVal = function (offset) {
        var endstr = document.cookie.indexOf(";", offset);
        if (endstr == -1)
            endstr = document.cookie.length;
        return unescape(document.cookie.substring(offset, endstr));
    }
    /*******************************************
    *
    *	功能:
    *		读取Cookie
    *	参数:
    *		name cookie的名称
    *	返回:
    *		cookie的值
    *
    ********************************************/
    Cookies.prototype.GetCookie = function (name) {
        var arg = name + "=";
        var alen = arg.length;
        var clen = document.cookie.length;
        var i = 0;
        while (i < clen) {
            var j = i + alen;
            if (document.cookie.substring(i, j) == arg)
                return this.GetCookieVal(j);
            i = document.cookie.indexOf(" ", i) + 1;
            if (i == 0) break;
        }
        return null;
    }
    /*******************************************
    *
    *	功能:
    *		删除Cookie
    *	参数:
    *		name cookie的名称
    *	返回:
    *		无
    *
    ********************************************/
    Cookies.prototype.DeleteCookie = function (name) {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval = this.GetCookie(name);
        document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString();
    }
    /*******************************************
    *
    *	功能:
    *		清除所有的Cookie
    *	参数:
    *		无
    *	返回:
    *		无
    *
    ********************************************/
    Cookies.prototype.ClearCookies = function () {
        var temp = document.cookie.split(";");
        var ts;
        for (var i = 0; ; i++) {
            if (!temp[i]) break;
            ts = temp[i].split("=")[0];
            this.DeleteCookie(ts);
        }
    }
    /*★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    ★
    ★
    ★			Event操作以及鼠标按键捕获
    ★
    ★
    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★*/

    /*---------------------------
    功能:停止事件冒泡
    ---------------------------*/
    function stopEventBubble(e) {
        //如果提供了事件对象，则这是一个非IE浏览器
        if (e && e.stopPropagation) {
            //因此它支持W3C的stopPropagation()方法
            e.stopPropagation();
        }
        else {
            //否则，我们需要使用IE的方式来取消事件冒泡
            window.event.cancelBubble = true;
        }
    }
	/*************************************************************
    |
    |	函数名:runEventInArea
    |	功能: 去除字符串右端的空格
    |	返回值:字符串
    |	参数:e->event,o->HTMLDom 对象或者HTML ID,fun->指定要执行的方法
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2012年3月8日 18:25:25
    |	修改时间:
    |
    **************************************************************/
	function runEventInArea(e,o,fun){
		o=typeof(o)=="string"?getById(o):o;
		if(!o){return false;}
		e = e || window.event, relatedTarget = e.toElement || e.relatedTarget;
		var k=false;
		while(relatedTarget!=D)
		{
			if(o==relatedTarget)
			{
				k=true;
				break ;
			}
			relatedTarget = relatedTarget.parentNode;
		}
		if(k)
		{
			if(fun){fun();}
			
		}
	}
    //阻止浏览器的默认行为
    function stopEventDefault(e) {
        //阻止默认浏览器动作(W3C)
        if (e && e.preventDefault)
        {    
			e.preventDefault();
		}
        else
		{
			//IE中阻止函数器默认动作的方式
            window.event.returnValue = false;
		}
        return false;
    }


    function arrayAppend(array, obj, nodup) {
        var result = -1,
			length = array.length,
			i = length - 1;
        for (; i >= 0; i--) {
            if (array[i] == obj) {
                result = i;
                break;
            }
        }
        var idx = result >= 0 ? true : false;

        if (!(nodup && idx)) {
            array[array.length] = obj;
        }
        return array;
    }
    function arrayRemove(array, obj) {
        var result = -1,
			length = array.length,
			i = length - 1;
        for (; i >= 0; i--) {
            if (array[i] == obj) {
                result = i;
                break;
            }
        }

        var index = result >= 0 ? true : false;
        if (!index) return;
        return array.splice(index, 1);
    };

    /*************************************************************
    |
    |	函数名:elementAddEventListener
    |	功能:给Dom对象注册事件
    |	返回值:
    |	参数: element->dom对象, type->事件类型, fun->事件触发的函数
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月17日13:00:42
    |	修改时间:
    |
    **************************************************************/
    function elementAddEventListener(element, type, fun) {
        if (!element.events) element.events = {};
        var handlers = element.events[type];

        if (!handlers) {
            handlers = element.events[type] = [];
            if (element['on' + type]) {
                handlers[0] = element['on' + type];
            }
        }
        handlers = arrayAppend(handlers, fun, true);
        element['on' + type] = handle_Event;
    }
    /*************************************************************
    |
    |	函数名:elementRemoveEventListener
    |	功能:给DOM注销事件
    |	返回值:
    |	参数: element->dom对象, type->事件类型, fun->事件触发的函数
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月17日13:02:16
    |	修改时间:
    |
    **************************************************************/
    function elementRemoveEventListener(element, type, fun) {
        if (element.events && element.events[type]) {
            element.events[type] = arrayRemove(element.events[type], fun);
        }
    }

    function handle_Event(event) {
        var returnValue = true,
			i = 0;
        event = event || fixEvent(window.event);
        var handlers = this.events[event.type],
			length = handlers.length;
        for (; i < length; i++) {
            if (handlers[i].call(this, event) === false) {
                returnValue = false;
            }
        }
        return returnValue;
    }

    function fixEvent(event) {
        event.preventDefault = fixEvent.preventDefault;
        event.stopPropagation = fixEvent.stopPropagation;
        return event;
    }
    fixEvent.preventDefault = function () {
        this.returnValue = false;
    };
    fixEvent.stopPropagation = function () {
        this.cancelBubble = true;
    };
    /*************************************************************
    |
    |	函数名:addRightClick
    |	功能:捕获鼠标右键
    |	返回值:
    |	参数: id-> dom对象 或者 dom的id; userFun->用户要执行的方法
    |	函数关联:
    |		-被调用:
    |		-主动调用:getById
    |	创建时间:2010年9月17日14:50:26
    |	修改时间:
    |
    **************************************************************/
    function addRightClick(id, userFun) {
        elementAddEventListener(getById(id), "contextmenu", userFun);
        elementAddEventListener(document, "contextmenu", function () { return false; });
    }
    /*************************************************************
    |
    |	函数名:addLeftClick
    |	功能:捕获鼠标右键
    |	返回值:
    |	参数: id-> dom对象 或者 dom的id; userFun->用户要执行的方法
    |	函数关联:
    |		-被调用:
    |		-主动调用:getById
    |	创建时间:2010年9月17日14:50:26
    |	修改时间:
    |
    **************************************************************/
    function addLeftClick(id, userFun) {
        elementAddEventListener(getById(id), "click", userFun);
    }


    /*************************************************************
    |
    |	函数名:addMouseOver
    |	功能:当用户将鼠标指针移动到对象内时触发。
    |	返回值:
    |	参数: id-> dom对象 或者 dom的id; userFun->用户要执行的方法
    |	函数关联:
    |		-被调用:
    |		-主动调用:getById
    |	创建时间:2010年9月19日11:46:35
    |	修改时间:
    |
    **************************************************************/
    function addMouseOver(id, userFun) {
        elementAddEventListener(getById(id), "mouseover", userFun);
    }
    /*************************************************************
    |
    |	函数名:addMouseOut
    |	功能:当用户将鼠标指针移出对象边界时触发。。
    |	返回值:
    |	参数: id-> dom对象 或者 dom的id; userFun->用户要执行的方法
    |	函数关联:
    |		-被调用:
    |		-主动调用:getById
    |	创建时间:2010年9月19日11:47:24
    |	修改时间:
    |
    **************************************************************/
    function addMouseOut(id, userFun) {
        elementAddEventListener(getById(id), "mouseout", userFun);
    }
    /*************************************************************
    |
    |	函数名:addSelectstart
    |	功能:当鼠标选择的时候出发
    |	返回值:
    |	参数: id-> dom对象 或者 dom的id; userFun->用户要执行的方法
    |	函数关联:
    |		-被调用:
    |		-主动调用:getById
    |	创建时间:2010年9月25日22:36:40
    |	修改时间:
    |
    **************************************************************/
    function addSelectstart(id, userFun) {
        if (id) {
            elementAddEventListener(getById(id), "select", userFun);
        }
        else { elementAddEventListener(document, "selectstart", function () { return false; }); }
    }
    /*************************************************************
    |
    |	函数名:getDomEventObject
    |	功能:获取鼠标事件触发的对象
    |	返回值:
    |	参数: ev -> event事件
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月17日17:21:05
    |	修改时间:
    |
    **************************************************************/
    function getDomEventObject(ev) {
        ev = ev || window.event;
        return ev.srcElement ? ev.srcElement : ev.target;
    }


    /*★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    ★
    ★
    ★			form 元素操作
    ★
    ★
    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★*/
    /*************************************************************
    |
    |	函数名:getRadioGroup
    |	功能:获取单选按钮组的信息
    |	返回值:
    |	参数:name 单选按钮组的名称 或者 单选按钮组
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月23日17:40:10
    |	修改时间:
    |
    **************************************************************/
    function getRadioGroup(name) {
        var r = typeof (name) == "object" ? name : getByName(name);
        for (var i = 0, n = r.length; i < n; i++) {
            if (r[i].checked) {
                return { value: r[i].value, id: r[i].id };
            }
        }
        return null;
    }
    /*************************************************************
    |
    |	函数名:getSelectInfo
    |	功能:获取单选按钮组的信息
    |	返回值:
    |	参数:name 单选按钮组的名称 或者 单选按钮组
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月23日17:40:10
    |	修改时间:
    |
    **************************************************************/
    function getSelectInfo(name) {
        var r = typeof (name) == "object" ? name : getById(name);
        var c = getDomChildNodes(r)
        for (var i = 0, n = r.length; i < n; i++) {
            if (r[i].selected) {
                return { obj:r[i], value: r[i].value, id: r[i].id, text: htmlDomText(r[i]) };
            }
        }
        return null;
    }
	/*************************************************************
    |
    |	函数名:domCheckboxCheckedAll
    |	功能: checkbox 全选功能
    |	返回值:
    |	参数:name checkbox按钮组的名称 或者 checkbox对象
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2011年12月23日12:40:10
    |	修改时间:
    |
    **************************************************************/
	function domCheckboxCheckedAll(name)
	{
		var r = typeof (name) == "object" ? name : _name(name);
		for(var i in r)
		{
			r[i].checked=true;
		}
	}
	/*************************************************************
    |
    |	函数名:domCheckboxCheckedOther
    |	功能: checkbox 反选功能
    |	返回值:
    |	参数:name checkbox按钮组的名称 或者 checkbox对象
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2011年12月23日13:50:10
    |	修改时间:
    |
    **************************************************************/
	function domCheckboxCheckedOther(name)
	{
		var r = typeof (name) == "object" ? name : _name(name);
		for(var i in r)
		{
			if(r[i].checked)
			{
				r[i].checked=false;
			}
			else
			{
				r[i].checked=true;
			}
		}
	}
    /*★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    ★
    ★
    ★			浏览器相关
    ★
    ★
    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★*/
    function getBrowser() {
        var ua = navigator.userAgent.toLowerCase();
        var _ie = ua.match(/msie ([\d.]+)/),
		_firefox = ua.match(/firefox\/([\d.]+)/),
		_chrome = ua.match(/chrome\/([\d.]+)/),
		_opera = ua.match(/opera.([\d.]+)/),
		_safari = ua.match(/version\/([\d.]+).*safari/);
        return { ie: _ie ? _ie[1] : null, firefox: _firefox ? _firefox[1] : null, chrome: _chrome ? _chrome[1] : null, opera: _opera ? _opera[1] : null, safari: _safari ? _safari[1] : null }
    }
    /*★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    ★
    ★
    ★			DeBug 调试信息
    ★
    ★
    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★*/
    /*************************************************************
    |
    |	函数名:createDeBug
    |	功能:输出debug信息
    |	返回值:
    |	参数: title-->信息头,message-->信息内容,c-->信息头颜色,id-->debu显示界面
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年9月17日17:21:05
    |	修改时间:
    |
    **************************************************************/
    function createDeBug(title, message, c, id) {

        if (!_Boolean) { return false; }

        c ? c : c = "#000";
        //alert("您已经开启调试信息");
        var ID = id || "D";
        var console = "";
        if (!getById("debug_" + ID)) {

            var tb = '<table border="0" style="background-color:#ccc; width:99%;  border:1px solid red;" cellspacing="3" cellpadding="0">'+
						'<tr><td style="background-color:#036; height:20px; color:#fff; "><b>开始Debug信息</b></td></tr>'+
						'<tr><td  valign="top"><span style="display:block; height:400px; overflow:auto; " id="debug_' + ID + '"></span></td></tr>'+
						'<tr><td style="background-color:#036; height:20px;"><button onclick="html(\'debug_' + ID + '\',\'\');">清空</button></td></tr>'+
					'</table>';
            insertDomHTML(D.getElementsByTagName("body")[0], "beforeEnd", tb);
            console = getById("debug_" + ID);
        }
        else {
            console = getById("debug_" + ID);
        }
        var d = new Date();
        var ds = d.getMinutes() + ":" + d.getSeconds();
        var str = "<b style='margin-top:5px; display:block; width:98%; color:" + c + ";'>" + title + " @ " + ds + "</b><span style='display:block; width:98%;  padding-left:15px;'>" + message + "</span>";

        insertDomHTML(console, "beforeEnd", str);

        console.scrollTop = console.scrollHeight - console.clientHeight;
    }


    function errMessage(e) {
        var err = "";
        for (var i in e) {
            err += i + ":" + e[i] + "<br>";
        }
        createDeBug("JavaScript Error:", "<span style='background-color:red;  color:#0F0'>" + err + "</span>", "red");
    }
    W.browser = new getBrowser;
    W._ = getById;
    W._tg = getByTag;
    W._name = getByName;

    //等待载入操作
    W.ready = domReady;

    //数据结构转换 , 数据处理
    W.arrayToJson = convertObjArrToJson;
	W.objectToJson = convertObjArrToJson;
    W.getArgsFromHref = getArgumentsFromHref;
    W.getMin = getIntMin;
    W.getMax = getIntMax;
    W.trim = Trim;
    W.ltrim = LTrim;
    W.rtrim = RTrim;
    W.strLen = stringLength;
	W.isType = isType;

    //cookie操作
    W.Cookie = Cookies;

    //位置操作
    W.getElementPos = getElementPosition;
    W.getMousePos = getMousePosition;
	W.getMouseOfDomPos=getMouseOfDomOffset;

    //css操作
    W.addClassName = addDomClassName;
	W.addClass = addDomClassName;
    W.removeClassName = removeDomClassName;
	W.rmClass = removeDomClassName;
	W.hasClass = domHasClass;
    W.getCorentStyle = getCssStyleValue;
    W.setOpacity = setDomTranslucence; //设置半透明
	W.changeClass= changeDomClass; 

    //Dom操作
	W.getSpecificParent=getParentUserDesignatedNode;
    W.getParentNode = getDomParentNode;
    W.parentNode = getDomParentNode;
    W.getNextChild = getDomNextChild;
    W.getPrevChild = getDomPreviousChild;
    W.getFirstChild = getDomFirstChild;
    W.getChildNodes = getDomChildNodes;
    W.childs = getDomChildNodes;
    W.txt = htmlDomText;
    W.getAttr = getDomAttribute;
    W.setAttr = setDomAttribute;
    W.rmChild = removeDomChild;
    W.rmAllChild = removeAllChildNodes;
    W.getLastChild = getDomLastChild; //获取最后一个nodeType=1的节点
    W.html = getDomHtml;
    W.att = domAttribute;
	W.attr = domAttribute;
    W.insertHTML = insertDomHTML;
    W.width = getDomClientWidth;
    W.height = getDomClientHeight;
    W.clientHeight = getDomClientHeight;
	W.clientWidth = getDomClientWidth;
	W.createTag=createDomElement;
    //----------------------
    //event操作
    //----------------------
    W.addListener = elementAddEventListener;
    W.removeListener = elementRemoveEventListener;
    W.getEventObject = getDomEventObject;
    W.evTag = getDomEventObject;
    W.stopBubble = stopEventBubble;
    W.stopDefault = stopEventDefault;
	W.runEvInArea=runEventInArea;
    //鼠标按键操作
    W.bindRightClick = addRightClick;
    W.bindLeftClick = addLeftClick;
    W.bindMouseOver = addMouseOver;
    W.bindMouseOut = addMouseOut;
    W.bindSelect = addSelectstart;


    //form元素操作
    W.radioGroupValue = getRadioGroup;
    W.selectInfo = getSelectInfo;
	W.checkedAll = domCheckboxCheckedAll;
	W.checkedOther = domCheckboxCheckedOther;

    
    //Debug
    W.bug = createDeBug;
    W._Bool_ = _Boolean;


    /*★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    ★
    ★
    ★			工具函数
    ★
    ★
    ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    ★★★★★★★★*/
    /*************************************************************
    |
    |	函数名:printObjectSouce
    |	功能:输出遍历之后的Array和Object的信息
    |	返回值:
    |	参数: o->Array 或者 Object 对象
    |	函数关联:
    |		-被调用:
    |		-主动调用:
    |	创建时间:2010年12月24日18:09:29
    |	修改时间:
    |
    **************************************************************/
    function printObjectSouce(o) {
        var s = "";
        if (typeof (o) == "array" || typeof (o) == "object") {
            s = '<ul>';
            for (var i in o) {
                if (typeof (o[i]) == "array" || typeof (o[i]) == "object") {
                    s += '<li>[' + i + '] => ' + typeof (o[i]) + '</li>';
                    s += '<ul>';
                    s += printObjectSouce(o[i]);
                    s += '</ul>';
                } else {
                    s += '<li>[' + i + '] => ' + o[i] + '</li>';
                }
            }
            s += '</ul>';
        }
        return s;
    }
	
    W.print_r = printObjectSouce;
    //function findDimensions() //函数：获取尺寸
    //{
    //	var winHeight=0,winWidth=0;
    //	//获取窗口宽度
    //	if (window.innerWidth)
    //	{winWidth = window.innerWidth;}
    //	else if ((document.body) && (document.body.clientWidth))
    //	{winWidth = document.body.clientWidth;}
    //	//获取窗口高度
    //	if (window.innerHeight)
    //	{winHeight = window.innerHeight;}
    //	else if ((document.body) && (document.body.clientHeight))
    //	{winHeight = document.body.clientHeight;}
    //	//通过深入Document内部对body进行检测，获取窗口大小
    //	if (document.documentElement && document.documentElement.clientHeight && document.documentElement.clientWidth)
    //	{
    //		winHeight = document.documentElement.clientHeight;
    //		winWidth = document.documentElement.clientWidth;
    //	}
    //	return {h:winHeight,w:winWidth};
    //}

})(window, document);


/**       
 * 对Date的扩展，将 Date 转化为指定格式的String       
 * 月(M)、日(d)、12小时(h)、24小时(H)、分(m)、秒(s)、周(E)、季度(q) 可以用 1-2 个占位符       
 * 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)       
 * eg:       
 * (new Date()).pattern("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423       
 * (new Date()).pattern("yyyy-MM-dd E HH:mm:ss") ==> 2009-03-10 二 20:09:04       
 * (new Date()).pattern("yyyy-MM-dd EE hh:mm:ss") ==> 2009-03-10 周二 08:09:04       
 * (new Date()).pattern("yyyy-MM-dd EEE hh:mm:ss") ==> 2009-03-10 星期二 08:09:04       
 * (new Date()).pattern("yyyy-M-d h:m:s.S") ==> 2006-7-2 8:9:4.18       
 */          
Date.prototype.format=function(fmt) {           
    var o = {           
    "M+" : this.getMonth()+1, //月份           
    "d+" : this.getDate(), //日           
    "h+" : this.getHours()%12 == 0 ? 12 : this.getHours()%12, //小时           
    "H+" : this.getHours(), //小时           
    "m+" : this.getMinutes(), //分           
    "s+" : this.getSeconds(), //秒           
    "q+" : Math.floor((this.getMonth()+3)/3), //季度           
    "S" : this.getMilliseconds() //毫秒           
    };           
    var week = {           
    "0" : "日",           
    "1" : "一",           
    "2" : "二",           
    "3" : "三",           
    "4" : "四",           
    "5" : "五",           
    "6" : "六"          
    };           
    if(/(y+)/.test(fmt)){           
        fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));           
    }           
    if(/(E+)/.test(fmt)){           
        fmt=fmt.replace(RegExp.$1, ((RegExp.$1.length>1) ? (RegExp.$1.length>2 ? "星期" : "周") : "")+week[this.getDay()+""]);           
    }           
    for(var k in o){           
        if(new RegExp("("+ k +")").test(fmt)){           
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));           
        }           
    }           
    return fmt;           
}
