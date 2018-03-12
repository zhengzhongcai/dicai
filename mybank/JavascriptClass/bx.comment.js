// JavaScript Document
/***************************************

	功能:锁屏提示
	时间:2012年9月14日 12:12:39 by mobo
		
***************************************/
var tip={
	tipInfo:{defaultState:true},
	tip:function(info){
	   var title="消息",id="defalut_tip",stateClose="",message="",padding=10,width=400,ico='',closeFun=function(){};
	       
		if(info["title"]){title=info["title"];}
		if(info["id"]){id=info["id"];}
		if(info["message"]){message=info["message"];}
		if(info["stateClose"]){tip.tipInfo.defaultState=info["stateClose"];}
		if(info["close"]){closeFun=info["close"];}
		if(info["width"]){width=info["width"];}
		if(info["padding"]){padding=info["padding"];}
		if(info["ico"]){ico='<td><img src="'+info["ico"]+'" /></td>';}
		var content='<table width="100%"><tr>';
		content+=ico;
		content+='<td  width="100%" id="'+id+'_con">'+message+'</td></tr></table>';
			art.dialog({
				id:id,
				title:title,
				content:content,
				width:width,
				padding:padding,
				lock:true,
				close:function(){
				       closeFun();
				       console.log(tip.tipInfo.defaultState);
				        return tip.tipInfo.defaultState;
				    }
			});
	},
	tipClose:function(id){
		if(id){
					art.dialog.list[id].close();
					return;
		}else		art.dialog.list["defalut_tip"].close();
		return;
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

/***************************************

	功能:分页
	时间:2012年9月14日 12:22:39 by mobo
		
***************************************/
var page={
	pageInfo:{
	},
	newPage:function(info){
		page.setPageInfo(info);
		
	},
	setPageInfo:function(info){
		if(!info.hasOwnProperty("key")){
			info.key = "_default";
		}
		var _default = {
			key:"_default",curent: 1,pageSize:20,count:0,extend:"",url:"",keyWord:"",timeOut:function(){},error:function(){},success:function(data){}
		};
		if(typeof(info)=="object"){
			for(var a in info){
				_default[a]=info[a];
			}
			page.pageInfo[info["key"]]=_default;
		}
	},
	getPageInfo:function(){},
	nextPage:function(key){
		if(page.pageInfo[key].count==1){return ;}
		var _cunrent = page.pageInfo[key].curent + 1;
		if (_cunrent > 0 && _cunrent <= page.pageInfo[key].count) {
			page.pageInfo[key].curent = _cunrent;
			page.getDataInfo(key);
		}
	},
	prePage:function(key){
		if(page.pageInfo[key].count==1){return ;}
		var _cunrent = page.pageInfo[key].curent - 1;
		if (_cunrent > 0 && _cunrent <= page.pageInfo[key].count) {
			page.pageInfo[key].curent = _cunrent;
			page.getDataInfo(key);
		}
	},
	firstPage:function(key){
		if(page.pageInfo[key].count==1){return ;}
		page.pageInfo[key].curent = 1;
		page.getDataInfo(key);
	},
	overPage:function(key){
		if(page.pageInfo[key].count==1){return ;}
		page.pageInfo[key].curent = page.pageInfo[key].count;
		page.getDataInfo(key);
	},
	pageIndex:function(key,index){
		if(page.pageInfo[key].count==1){return ;}
		page.pageInfo[key].curent = index*1;
		page.getDataInfo(key);
		},
	getDataInfo:function(key){
		var inf=page.pageInfo[key];
		$.ajax({
			type:"post",
			url:inf.url,
			data:{data:{curent: inf.curent,pageSize:inf.pageSize,count:inf.count,extend:inf.extend,keyWord:inf.keyWord}},
			success:function(data){
				var _data=$.parseJSON(data);
				if(typeof(_data)=="object"&&_data["state"]=="true"){inf.count=_data.data.pageCount;}
				inf.success(data);
			},
			error:inf.error,
			timeout:inf.timeout
		});
	}
};


var popup={
			/*
{
    data: {
        itms: [{
            ico: "", 图标
            title: "", 标题
            ev: {}, 执行的时间
			follow: "" 位置跟随
        	}, 
			...... 多个
		],
        ev: { 事件
            click: function (ev) {}, mousedown: function (ev) {}, mouseup: function (ev) {}, mouseover: function (ev) {}, mouseout: function (ev) {}
        }
    },
	event:"" 主要是鼠标触发事件的对象 单击 或者 双击产生的  ev,
	width: 宽度
	height: 高度
	onCloseBefore:function(){} 关闭之前执行
	onCloseAfter:function(){} 关闭之后执行
	onOpenBefore:function(){} 打开之前执行
	onOpenAfter:function(){} 打开之后执行
}
		*/
	info:{_default:{}},
	ui:{
		container:function(key){
			var str_html='<div class="rightMenu" id="'+key+'">'
			+'<div class="menue_bg"></div>'
			+'<div class="menue_l"></div>'
			+'<div class="menue_r"></div>'
			+'<div class="menue_lb"></div>'
			+'<div class="menue_rb"></div>'
			+'<div class="menue_tc"></div>'
			+'<div class="menue_rc"></div>'
			+'<div class="menue_bc"></div>'
			+'<div class="menue_lc"></div>'
			+'<table class="menue_container" cellpadding="0" cellspacing="0" style="border-collapse:collapse; "><tr><td class="menue_content"></td></tr></table>'
			+'<div style="display:block; font-size:1px; clear:both;  position:absolute; left:0px; bottom:0px; rght:0px; height:1px;"></div>'
			+'</div>';
			return $(str_html);
			},
		itm:function(ev){
				var itm=$('<a class="menue_a" href="javascript:void(0);"></a>');
				if(ev){
					for(var m in ev)
					{
							itm.bind(m,ev[m]);
					}
					return itm[0];
				}
				return itm;
			},
		ico:function(ico){
				return $('<span class="menue_tu">'+ico+'</span>')[0];
			},
		title:function(title){
				return $('<span class="menue_itm">'+title+'</span>')[0];
			},
		closeBtn:function(key,hid){
			
			return $('<div key="'+key+'" hide="'+hid+'" class="closeBtn">X</div>').click(function(){
					var key=attr(this,"key"),
					hid=attr(this,"hide");
					//触发事件 关闭之前执行
					if(popup.info.hasOwnProperty("onCloseBefore"))
					{
						popup.info.onCloseBefore();
					}
					if(hid=="true")
					{
						$("#"+key).hide();
					}
					else
					{
						$("#"+key).remove();
						delete popup.info[key];
					}
					//触发事件 关闭之前执行
					if(popup.info.hasOwnProperty("onCloseAfter"))
					{
						popup.info.onCloseAfter();
					}
				})[0];
			}
	},
	open:function(info){

			var inf={key:"",data:{itms:[],ev:{}},event:"",follow:"",hidden:false,close:false}; //height:180,width:126,
			if(typeof(info)=="object"){
				//检测是否存在
				
				if(_(info["key"]))
				{ 
					_(info["key"]).style.display=""; 
					popup.bindClose($("#"+info["key"]),info);  
					return false;
				}
				
				for(var i in info)
				{
					inf[i]=info[i];
				}
				
				if(info.hasOwnProperty("data"))
				{
					
					var itms=info["data"]["itms"];
					for(var a=0,b=itms.length; a<b; a++)
					{
						var itm={ico:"",title:"",ev:{}};
						for(var i in itms[a])
						{
							itm[i]=itms[a][i];
							//检测事件
							if(i=="ev")
							{
								var ev={click:function(ev){},mousedown:function(ev){},mouseup:function(ev){},mouseover:function(ev){},mouseout:function(ev){}};
								for(var m in itms[a][i])
								{
									if(ev.hasOwnProperty(m))
									{
										ev[m]=itms[a][i][m];
									}
									else
									{
										delete ev[m];
									}
								}
								itm[i]=ev;
							}
						}
						inf["data"]["itms"][a]=itm;
					}
				}
				else if(info.hasOwnProperty("content")){
					
				}
				else{return false;}
				// 缓存信息
				inf=popup.info[inf["key"]]=inf;
				if(!popup.info.hasOwnProperty(inf["key"]))
				{
					//return 
				}
				popup.createUi(inf["key"]);
			}
		},
	createUi:function(key){
			var inf=popup.info[key];
			var jq_c=popup.ui.container(inf["key"]);  //主界面
			
			if(inf.close)
			{
				closeBtn=popup.ui.closeBtn(inf["key"],inf["hidden"].toString());
				jq_c[0].appendChild(closeBtn)
			}
			
			var jq_container=jq_c.find(".menue_content")[0];
			if(inf.hasOwnProperty("content"))
			{
				switch(typeof(inf.content))
				{
					case "string": 
						html(jq_container,inf.content);
					break;
					case "object": 
						jq_container.appendChild(inf.content);
					break;
				}
				
			}
			else
			{
				var itms=inf.data.itms;
				for(var a=0,b=itms.length; a<b; a++)
				{
					var ico="",title="",menuItm="";
					
					//检测事件
					if(inf.data.hasOwnProperty("ev"))
					{menuItm=popup.ui.itm(inf.data.ev);}
					else if(itms[a].hasOwnProperty("ev"))
					{
						menuItm=popup.ui.itm(itms[a].ev);
					}
					else
					{menuItm=popup.ui.itm();}
					if(itms[a].hasOwnProperty("ico"))
					{
						ico=popup.ui.ico(itms[a].ico);
						menuItm.appendChild(ico);
					}
					if(itms[a].hasOwnProperty("title"))
					{
						title=popup.ui.title(itms[a].title);
						menuItm.appendChild(title)
					}
					
					
					jq_container.appendChild(menuItm);
				}
			}
			document.body.appendChild(jq_c[0]);
			
			//设置显示位置
			popup.setContainerPos(inf,jq_c);
			
			popup.bindClose(jq_c,inf);

	},
	setContainerPos:function(info,jq_c){
			var w="",
				h="";
			if(info.hasOwnProperty("height"))
			{
				h=info.height.toString().split(/px/ig).length==1?info.height:info.height+"px"
			}
			else
			{ h=_(info["key"]).clientHeight;}
			if(info.hasOwnProperty("width"))
			{
				w=info.width.toString().split(/px/ig).length==1?info.width:info.width+"px"
			}
			else
			{ w=_(info["key"]).clientWidth;}
			var x=0,y=0,c_w=clientWidth(document),w_h=clientHeight(document),p_w=0,p_h=0;
			if(info["follow"]!="")
			{
				var p=getElementPos(info.follow); //位置跟随对象
				x=p.x;
				y=p.y;
				p_w=clientWidth(info.follow);
				p_h=clientHeight(info.follow);
			}
			else
			{
				var e=getMousePos(info.event);
				x=e.x;
				y=e.y;
			}
			
			if(y>=h&&c_w-x>=w){ //上方左对齐
				y=y-h;
			}
			else if(y>=h&&c_w-x<w){ //上方右对齐
				y=y-h;
				x=x-w+p_w;
			}
			else if(y<h){
				y=y+p_h;
			}
			else if(x>=w){
				x=x-w;
			}
			else if(c_w-x-p_w>=w){
				x=c_w-x-p_w;
			}
			else
			{y=y-h;}
			jq_c.css({left:x+"px",top:y+"px",width:w,height:h});
	},
	bindClose:function(jq_c,inf){
		//存在close按钮时候去掉, document 上的触发close事件
		if(inf["close"])
		{
			return false;
		}
		var closeMenu=function(){
				//alert(inf["hidden"]);
				if(!inf["hidden"])
				{jq_c.remove();}
				else
				{jq_c.hide();}
				$(document).unbind("click",closeMenu);
				
			};
		$(document).click(closeMenu);
		var info =inf;
		stopBubble(inf.event);
		stopDefault(inf.event);	
	},
	close:function(key){
		var jq_c=$("#"+key);
		if(!jq_c.length){return false;}
		//触发事件 关闭之前执行
					if(popup.info.hasOwnProperty("onCloseBefore"))
					{
						popup.info.onCloseBefore();
					}
		if(!popup.info[key]["hidden"])
		{
			jq_c.remove();
			delete popup.info[key];
		}
		else
		{jq_c.hide();}
		
		//触发事件 关闭之前执行
					if(popup.info.hasOwnProperty("onCloseAfter"))
					{
						popup.info.onCloseAfter();
					}
	}
};