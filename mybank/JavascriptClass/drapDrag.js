// JavaScript Document
// JavaScript Document
var dropDrag = function(selector){
    if ( window == this ) return new dropDrag(selector);
    var doms = _(selector);
    var arr = [];
	if(typeof(doms)=="array")
	{
		for(var i=0; i<doms.length; i++){
			arr.push(doms[i]);
		}
	}
	else
	{
		arr.push(doms);
	}
    return this.setArray(arr);
}

dropDrag.getData=function(uuid){
	if(!dropDrag.prototype.option.data.cache.hasOwnProperty(uuid))
	{return null;
	}
	return dropDrag.prototype.option.data.cache[uuid];
}
dropDrag.setData=function(uuid,info){
	if(!dropDrag.prototype.option.data.cache.hasOwnProperty(uuid))
	{return null;}
	dropDrag.prototype.option.data.cache[uuid]=info;
}
dropDrag.fn = dropDrag.prototype={
	option:{
		data:{cache:{},uuid:0},
		dragInfo:{_default:{dragState:false,mi:{x:0,y:0},mx:{x:-1,y:-1}}},
		resizeInfo:{bar:["area_leftBar","area_rightBar","area_topBar","area_bottomBar","area_lefttopBar","area_leftbottomBar","area_righttopBar","area_rightbottomBar"]}
	},
	setDragInfo:function(info,name)
	{
		if(name)
		{
			this.option.dragInfo[name]={};
			this.extend(true,this.option.dragInfo[name],info);
		}
		else
		{
			info["key"]="_default";
			this.extend(true,this.option.dragInfo["_default"],info);
		}

	}
};
dropDrag.prototype.setArray = function( arr ) {
        this.length = 0;
        [].push.apply( this, arr );
       // alert(JSON.stringify(this));
        return this;
}

//通过递归把options里面的属性值添加给target这个对象
dropDrag.prototype.extend=function(deep, target, options)
{
	 for (var name in options)
	 {
		 copy = options[name];
		 if (deep && copy instanceof Array)
		 {
			 target[name] = this.extend(deep, [], copy);
		 }
		 else if (deep && copy instanceof Object)
		 {
			target[name] = this.extend(deep, {}, copy);
		 }
		 else
		 {
			target[name] = options[name];
		 }
	 }
	 return target;
}

window.dg = window.dropDrag =dropDrag;


dropDrag.prototype.add = function(  ) {

}

dropDrag.fn.rm=function(key){
	delete dropDrag.fn.option.data[key];
};

//插件扩展1)each
dropDrag.fn.each = function(method){
    for(var i=0,l=this.length; i<l; i++){
        method.call(this[i],i);
    }
}
//插件扩展2)show
dropDrag.fn.show = function(){
    this.each(function(i){
        alert(i+":"+this.id+":"+this.innerHTML);
    });
}

dropDrag.fn.data = function(name,value){
   	var cache = this.option.data.cache,
	expando = "data_bx_uuid",
	uuid = this.option.data.uuid,
	_this=this;
    var setData = function(elem, key, value){
            var id = elem[expando];
			if(!id)
			{
				id=elem.getAttribute(expando);
			}
            if (!id){   //第一次给元素设置缓存
                id = ++uuid;
                elem.setAttribute( expando, id);
				_this.option.data.uuid=uuid;
            }
            if (!cache[id]){   //这个元素第一次进行缓存或者缓存已被清空
                cache[id] = {};
				_this.option.data.cache[id]={};
				if(window["templateInfo"])
				{templateInfo.data.areas[id]={};}
            }
            _this.option.data.cache[id][key] = value;
			if(window["templateInfo"])
			{
				templateInfo.data.areas[id][key]=value; 
			}
    };

    var getData = function(elem, key){
        var id = elem[expando];  //取得cache里跟dom节点关联的key
		if(!id)
		{
			id=elem.getAttribute(expando);
		}
		if(window["templateInfo"])
		{
				return templateInfo.data.areas[id]&&templateInfo.data.areas[id][key]||null;
		}
        return cache[id] && cache[id][key] || null;  //如果缓存里没有, 返回null
    }

	if(name!=""&&value!=null)
	{
		this.each(function(){
		setData(this,name,value);
    	});
	}
	if(name!=""&&value==null)
	{
		return getData(this[0],name);
	}
};

dropDrag.fn.enabled=function(_userinfo_)
{                                                
	
	var _this=this;
	var _dragItm=_this[0];
	var resizeInfo={};
   
	this.start=function(ev)
	{
		stopBubble(ev);
		var ifo=dg(_dragItm).data("info"), //被拖拽对象的信息
		key=ifo["key"];
		_this.option.dragInfo[key].dragState=true;
		addListener(document,'mousemove',_this.move);
		addListener(document,'mouseup',_this.stoped);
        
		var m=getMouseOfDomPos(_dragItm,ev);
		ifo.m.x=m.x;
		ifo.m.y=m.y;
       // ifo.h=clientHeight(_dragItm);
        //ifo.w=clientWidth(_dragItm);
        
		dg(_dragItm).data("info",ifo); //重设信息,记录鼠标相对于被拖拽对象的位置
		document.body.style.cursor="move";
        _dragItm.style.cursor="move";
        if(ifo.hasOwnProperty("callBack"))
        {
            ifo.callBack.mv_start(att(_dragItm,"data_bx_uuid"),_dragItm,ifo);
        }
		
	}
	this.move=function(ev)
	{
		if(_userinfo_.hasOwnProperty("unmove")){
			return false;
		}
		stopBubble(ev);
		window.getSelection ? window.getSelection().removeAllRanges() : document.selection.empty();
		var ifo=dg(_dragItm).data("info"), //被拖拽对象的信息
		key=ifo["key"];


		if(!_this.option.dragInfo[key].dragState)
		{return ;}

		var e=getMousePos(ev), //鼠标事件 的 x,y
			p=dg(_dragItm).data("info"), //被拖拽对象的x,y
			c=_this.option.dragInfo[key], //画布相关位置和大小,即  限制了拖拽的范围
			x=e.x-p.m.x-c.x,
			y=e.y-p.m.y-c.y;
		if(x<=c.mi.x){x=c.mi.x;}
		if(y<=c.mi.y){y=c.mi.y;}
		if(x>c.mx.x-p.w){x=c.mx.x-p.w;}
		if(y>c.mx.y-p.h){y=c.mx.y-p.h;}
		//alert(JSON.stringify(ifo));
		x=parseInt(x);
		y=parseInt(y);
		_dragItm.style.top=y+"px";
		_dragItm.style.left=x+"px";
		
		
	/*	with(_dragItm.style)
		{
			top=y+"px";
			left=x+"px"
			
		}*/
		
		ifo.x=x;
		ifo.y=y;
        
        //bug("---","x:"+x+" y:"+y);
        if(ifo.hasOwnProperty("callBack"))
        {
            ifo.callBack.mv_move(att(_dragItm,"data_bx_uuid"),_dragItm,ifo);

        }
        
		
	};
	this.stoped=function()
	{
		var ifo=dg(_dragItm).data("info"), //被拖拽对象的信息
		key=ifo["key"];
		_this.option.dragInfo[key].dragState=false;
		removeListener(document,"mousemove",_this.move);
		removeListener(document,"mouseup",_this.stoped);
		//ifo.x=_dragItm.offsetLeft;
		//ifo.y=_dragItm.offsetTop;
		dg(_dragItm).data("info",ifo); //重设信息,记录鼠标相对于被拖拽对象的位置
		document.body.style.cursor="default";
        _dragItm.style.cursor="default";
        if(ifo.hasOwnProperty("callBack"))
        {
            ifo.callBack.mv_stop(att(_dragItm,"data_bx_uuid"),_dragItm,ifo);
        }
		
	};


	this.resizeStart=function(ev)
	{
		//alert("resizeStart");
		addListener(document,"mousemove",_this.resizeMove);
		addListener(document,"mouseup",_this.resizeStop);

		var ifo=dg(_dragItm).data("info"); //被拖拽对象的信息
		var m=getMouseOfDomPos(_dragItm,ev);
		ifo.m.x=m.x;
		ifo.m.y=m.y;
		dg(_dragItm).data("info",ifo); //重设信息,记录鼠标相对于被拖拽对象的位置
		var dir=_this.option.resizeInfo["enabledbar"]=attr(evTag(ev),"bar");
		var cursor="default";
		switch(dir)
		{
			case "area_leftBar":cursor="e-resize";break;
			case "area_rightBar":cursor="e-resize";break;
			case "area_topBar":cursor="n-resize";break;
			case "area_bottomBar":cursor="n-resize";break;
			case "area_lefttopBar":cursor="nw-resize";break;
			case "area_righttopBar":cursor="sw-resize";break;
			case "area_leftbottomBar":cursor="sw-resize";break;
			case "area_rightbottomBar":cursor="nw-resize";break;
		}
		document.body.style.cursor=cursor;
		stopBubble(ev);
        if(ifo.hasOwnProperty("callBack"))
        {
            ifo.callBack.re_start(att(_dragItm,"data_bx_uuid"),_dragItm,ifo);
        }
	};
	this.resizeMove=function(ev)
	{
		stopBubble(ev);
		window.getSelection ? window.getSelection().removeAllRanges() : document.selection.empty();
		var ifo=dg(_dragItm).data("info"), //被拖拽对象的信息
			key=ifo["key"],
			e=getMousePos(ev),//鼠标事件 的 x,y
			p=ifo, //被拖拽对象的x,y
			c=_this.option.dragInfo[key], //画布相关位置和大小,即  限制了拖拽的范围
			//alert(JSON.stringify(c));
			x=e.x-p.m.x-c.x,
			y=e.y-p.m.y-c.y,
			w=e.x-c.x-p.x,
			h=e.y-c.y-p.y;
		if(x<=c.mi.x){x=c.mi.x;}
		if(y<=c.mi.y){y=c.mi.y;}
		if(x>=c.mx.x){x=c.mx.x;}
		if(y>=c.mx.y){y=c.mx.y;}
		//bug("this.resizeMove","e.x:"+e.x+" c.x:"+c.x+" p.x:"+p.x+" w:"+w);


		var dir=_this.option.resizeInfo["enabledbar"];
		switch(dir)
		{
			case "area_leftBar":
				w=parseInt(p.w+p.x-x);
				if(w>=p.resize.w){_dragItm.style.width=w+"px";_dragItm.style.left=x+"px";};
			break;
			case "area_rightBar":
				w=parseInt(p.x+w>=c.w?c.w-p.x:w);
				if(w>=p.resize.w){_dragItm.style.width=w+"px";}
			break;
			case "area_topBar":
				h=parseInt(p.h+p.y-y);
				//bug("this.resizeMove","h: "+h+"<br>_h: "+p.resize.h+" "+p.h+" "+p.y+" "+y+" "+e.y);
				if(h>=p.resize.h){_dragItm.style.height=h+"px";_dragItm.style.top=y+"px";};
			break;
			case "area_bottomBar":
				h=parseInt(p.y+h>=c.h?c.h-p.y:h);
				if(h>=p.resize.h){_dragItm.style.height=h+"px";}
			break;
			case "area_lefttopBar":
				w=parseInt(p.w+p.x-x);
				if(w>=p.resize.w){_dragItm.style.width=w+"px";_dragItm.style.left=x+"px";};
				h=parseInt(p.h+p.y-y);
				if(h>=p.resize.h){_dragItm.style.height=h+"px";_dragItm.style.top=y+"px";};
			break;
			case "area_righttopBar":
				w=parseInt(p.x+w>=c.w?c.w-p.x:w);
				if(w>=p.resize.w){_dragItm.style.width=w+"px";}
				h=parseInt(p.h+p.y-y);
				if(h>=p.resize.h){_dragItm.style.height=h+"px";_dragItm.style.top=y+"px";};
			break;
			case "area_leftbottomBar":
				w=parseInt(p.w+p.x-x);
				if(w>=p.resize.w){_dragItm.style.width=w+"px";_dragItm.style.left=x+"px";};
				h=parseInt(p.y+h>=c.h?c.h-p.y:h);
				if(h>=p.resize.h){_dragItm.style.height=h+"px";}
			break;
			case "area_rightbottomBar":
			//bug("area_rightbottomBar","w:"+w+" p.x:"+p.x+" c.w:"+c.w);
				w=parseInt(p.x+w>=c.w?c.w-p.x:w);

				if(w>=p.resize.w){_dragItm.style.width=w+"px";}
				h=parseInt(p.y+h>=c.h?c.h-p.y:h);
				if(h>=p.resize.h){_dragItm.style.height=h+"px";}
			break;
		}
        if(ifo.hasOwnProperty("callBack"))
        {
            ifo.callBack.re_resize(att(_dragItm,"data_bx_uuid"),_dragItm,ifo);
        }
	};
	this.resizeStop=function()
	{
		removeListener(document,"mousemove",_this.resizeMove);
		removeListener(document,"mouseup",_this.resizeStop);
		var ifo=dg(_dragItm).data("info"); //被拖拽对象的信息
		ifo.x=_dragItm.offsetLeft;
		ifo.y=_dragItm.offsetTop;
		ifo.w=_dragItm.clientWidth;
		ifo.h=_dragItm.clientHeight;
		dg(_dragItm).data("info",ifo); //重设信息,记录鼠标相对于被拖拽对象的位置
		document.body.style.cursor="default";
		//alert(typeof(_this.option.callBack.re_stop));
        if(ifo.hasOwnProperty("callBack"))
        {
            ifo.callBack.re_stop(att(_dragItm,"data_bx_uuid"),_dragItm,ifo);
        }
		

	};
	var _call_back={
		mv_start_begin:function(){},
		mv_start:function(){},
		mv_move:function(){},
		mv_stop:function(){},
		re_start:function(){},
		re_resize:function(){},
		re_stop:function(){}},
		extendInfo={},
		key="_default";
	var _itm_info_={};
	if(typeof(_userinfo_)=="object")
	{
		for(var i in _userinfo_)
		{
			if(i=="callback") //_userinfo_["callback"]
			{
				_itm_info_["callBack"]=this.extend(false,_call_back,_userinfo_["callback"]);
				continue;
			}
			if(i=="resize"&&_userinfo_[i]) //_userinfo_["resize"]
			{
				_itm_info_["resize"]=this.extend(true,resizeInfo,_userinfo_["resizeInfo"]);
				var arr_bar=_this.option.resizeInfo.bar;
				for(var i in arr_bar)
				{
					_dragItm.appendChild(createTag("div",{bar:arr_bar[i],className:arr_bar[i],event:{mousedown:_this.resizeStart}}));
				}
				continue;
			}
			if(i=="extendInfo") //_userinfo_["extendInfo"]
			{
				_itm_info_["extendInfo"]=_userinfo_["extendInfo"];
				continue;
			}
			if(i=="key") //_userinfo_["key"]
			{
				_itm_info_["key"]=_userinfo_["key"];
				continue;
			}
			_itm_info_[i]=_userinfo_[i];
		}
	}
	addListener(_this[0],"mousedown",_this.start);
	//addListener(_this[0],"mouseout",_this.stoped);
	_itm_info_["x"]=_dragItm.offsetLeft;
	_itm_info_["y"]=_dragItm.offsetTop;
	_itm_info_["w"]=_dragItm.clientWidth;
	_itm_info_["h"]=_dragItm.clientHeight;
	_itm_info_["m"]={x:0,y:0};
	this.data("info",_itm_info_);
}

