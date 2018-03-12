// JavaScript Document
(function(W,D)
{
	function resetProfileListConUI(str_id)
{
	var fun_upFun=function(){alert("fun_upFun"+_(str_id).scrollTop);}
	var fun_downFun=function(){alert("fun_downFun");}
	var dom_con=_(str_id);
	if(getChildNodes(dom_con,"div").length>=15)
	{
		var obj_pos=getElementPos(dom_con);
		var int_dom_con_width=clientWidth(dom_con);
		var int_dom_con_height=clientHeight(dom_con);
		obj_pos.x=int_dom_con_width/2-15+obj_pos.x;
		//alert(obj_pos.x+" "+obj_pos.y);
		var str_style="display:lock;position:absolute; line-height:18px; font-size:14px; text-align:center; background-color:#eee; width:30px; height:18px;";
		var dom_span_up=document.createElement("SPAN");
		with(dom_span_up)
		{
			id="up_handle_bar";
			style.cssText=str_style;
			style.top=obj_pos.y+"px";
			style.left=obj_pos.x+"px";
			//innerHTML='<img src="" width="50" height="50" border="0" />';
			innerHTML='▲';
		}
		var dom_span_down=document.createElement("SPAN");
		with(dom_span_down)
		{
			id="down_handle_bar";
			style.cssText=str_style;
			style.top=(obj_pos.y+int_dom_con_height-18)+"px";
			style.left=obj_pos.x+"px";
			//innerHTML='<img src="" width="50" height="50" border="0" />';
			innerHTML="▼";
		}
		var obj_pos=getElementPos(dom_con);
		dom_con.appendChild(dom_span_up);
		dom_con.appendChild(dom_span_down);
		
		bindLeftClick(dom_span_up,fun_upFun);
		bindLeftClick(dom_span_down,fun_downFun);
	}
	else
	{
		
	}
	
}

function createUIDiv(id,x,y,w,h,str,clas)
	{
		r=_(id)||document.createElement("DIV");
		r.setAttribute("id",id);
		clas?r.setAttribute("class",clas):" ";
		with(r.style)
		{
			width=w;
			height=h;
			position="absolute";
			left=x+"px";
			top=y+"px";
			padding="1px";
			cursor="pointer";
			display="block";
		}
		if(!_(id))
		{
			D.body.appendChild(r);
		}
		else
		{
			_(id).style.display="block";
		}

		r.innerHTML=str;
	}
	function ui_window(id,title,str,w,h)
	{
		var str='\
		<div class="window_outer" id="window_outer_'+id+'" style="height: '+(h-20)+'px;">\
		<div style="z-index: 50;" class="window_inner" id="window_inner_'+id+'">\
			<div class="window_bg_container">\
				<div class="window_bg window_center"></div>\
				<div class="window_bg window_t"></div>\
				<div class="window_bg window_rt"></div>\
				<div class="window_bg window_r"></div>\
				<div class="window_bg window_rb"></div>\
				<div class="window_bg window_b"></div>\
				<div class="window_bg window_lb"></div>\
				<div class="window_bg window_l"></div>\
				<div class="window_bg window_lt"></div>\
			</div>\
			<div class="window_content">\
				<div class="window_titleBar" id="window_titleBar_'+id+'">\
					<a hidefocus="" href="javascript:void(0);" title="关闭" class="window_close" id="window_closeButton_'+id+'" style="display: block;"></a>\
					<a hidefocus="" href="javascript:void(0);" title="最大化" class="window_max" id="window_maxButton_'+id+'" style="display: block;"></a>\
					<a hidefocus="" href="javascript:void(0);" title="还原" class="window_restore" id="window_restoreButton_'+id+'" _olddisplay="" style="display: none;"></a>\
					<a hidefocus="" href="javascript:void(0);" title="最小化" class="window_min" id="window_minButton_'+id+'" style="display: block;"></a>\
					<a hidefocus="" href="javascript:void(0);" title="退出全屏" class="window_restore_full" id="window_restorefullButton_'+id+'" _olddisplay="" style="display:none;"></a>\
					<a hidefocus="" href="javascript:void(0);" title="全屏" class="window_fullscreen" id="window_fullButton_'+id+'" style="display: block;"></a>\
					<a hidefocus="" href="javascript:void(0);" title="刷新" class="window_refresh" id="window_refreshButton_'+id+'"></a>\
					<a hidefocus="" href="javascript:void(0);" title="浮动" class="window_pinUp" id="window_pinUpButton_'+id+'"></a>\
					<a hidefocus="" href="javascript:void(0);" title="钉住" class="window_pinDown" id="window_pinDownButton_'+id+'"></a>\
					<div class="window_title titleText" id="window_title_'+id+'">'+title+'</div>\
				</div>\
				<div class="window_bodyArea" id="window_body_'+id+'" style="width: '+ (w-20)+'px; height: '+(h-41)+'px;">\
					<div class="content_area" id="container_iframeApp_'+id+'">'+str+'</div>\
				</div>\
				<div class="window_controlArea" id="window_controlArea_'+id+'">\
					<a hidefocus="" href="javascript:void(0);" title="取消" class="window_button window_cancel" id="window_cancelButton_'+id+'">取　消</a>\
					<a hidefocus="" href="javascript:void(0);" title="确定" class="window_button window_ok" id="window_okButton_'+id+'">确　定</a>\
					<a hidefocus="" href="javascript:void(0);" title="下一步" class="window_button window_next" id="window_nextButton_'+id+'">下一步</a>\
					<a hidefocus="" href="javascript:void(0);" title="上一步" class="window_button window_previous" id="window_previousButton_'+id+'">上一步</a>\
				</div>\
			</div>\
			<div id="window_1_resize_t" class="resize_t"></div>\
			<div id="window_1_resize_r" class="resize_r"></div>\
			<div id="window_1_resize_b" class="resize_b"></div>\
			<div id="window_1_resize_l" class="resize_l"></div>\
			<div id="window_1_resize_rt" class="resize_rt" ></div>\
			<div id="window_1_resize_rb" class="resize_rb"></div>\
			<div id="window_1_resize_lb" class="resize_lb"></div>\
			<div id="window_1_resize_lt" class="resize_lt"></div>\
		</div>\
	</div>\
		';
		return str;
	}
	function appUIWindow(id,title,x,y,w,h,str)
	{
		str=ui_window(id,title,str,w,h)

		createUIDiv('appWindow_'+id,x,y,w,h,str,"window window_current");
	}
	W.openWindow=appUIWindow;
	function ui_rightMenu(str)
	{
			var str='\
			<table border="0" class="rightMenue" cellspacing="0" cellpadding="0">\
			<tr>\
				<td class="tl"><i>&nbsp;</i></td>\
				<td class="tc">&nbsp;</td>\
				<td class="tr"><i>&nbsp;</i></td>\
			</tr>\
			<tr>\
				<td class="cl"><i>&nbsp;</i></td>\
				<td class="cc">'+str+'</td>\
				<td class="cr"><i>&nbsp;</i></td>\
			</tr>\
			<tr>\
				<td class="bl"><i>&nbsp;</i></td>\
				<td class="bc">&nbsp;</td>\
				<td class="br"><i>&nbsp;</i></td>\
			</tr>\
		</table>\
			';
			return str;
	}
	function uirightMenue(id,str,x,y)
	{
		str=ui_rightMenu(str);
		createUIDiv(id,x,y,"123px","auto",str);
	}
	W.rightMenue=uirightMenue;

	function lockShielding(z,id)
	{
		id="lockShieldingDiv";
		var dv=_("lockShieldingDiv")||document.createElement("DIV");
		dv.setAttribute("id",id);
		with(dv.style)
		{
			display="block";
			height=(D.documentElement.scrollTop + D.documentElement.clientHeight)+"px";
			width=(D.documentElement.scrollLeft + D.documentElement.clientWidth)+"px";
			backgroundColor="#eee";
			position="absolute";
			top="0px";
			left="0px";
			zIndex=z;
		}
		setOpacity(dv,10);

		if(!_(id))
		{
			D.body.appendChild(dv);
		}
		else
		{
			_(id).style.display="block";
		}
	}
	W.lockScreen=lockShielding;
	function unLockShielding()
	{
		_("lockShieldingDiv").style.display="none";
	};
	W.unLockScreen=unLockShielding;
})(window,document);