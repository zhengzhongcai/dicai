// JavaScript Document
ready(function(){
	//alert("---"+_("_main_").style.height);
	s();
	createLeftmenu();
	createToptmenu();
	});
function s()
{
	_("desktop").style.height=clientHeight(document)+"px";
//	_("desktopBgground").innerHTML='<img src="skin/backGround.jpg" border="0" width="100%" height="100%" />';
}
window.onresize=function(){s();};



function leftmenuItmClick(str_keyId)
{
	bug("leftmenuItmClick","str_keyId: "+str_keyId);
	var _leftMenu=menue_obj.leftMenu;
	for(var i =0,n=_leftMenu.length; i<n; i++)
	{
		if(_leftMenu[i].id==str_keyId)
		{
			createTabmenuItem(_leftMenu[i]);
		}
	}
}

function createTabmenuItem(obj_info)
{
	var str_keyId=obj_info.id;
	if(checkTabIsSet(str_keyId))
	{
		return false;
	};
	var dom_rowitm_cn=createTag("div",{className:"tab_rowitm_cn",keyid:str_keyId});
	var dom_itm_scroll_l=createTag("div",{className:"tab_itm_scroll_l",event:{click:tabItmScrollClick},innerHTML:"&nbsp;"});
	var dom_itm_scroll_r=createTag("div",{className:"tab_itm_scroll_r",event:{click:tabItmScrollClick},innerHTML:"&nbsp;"});
	var dom_itm_con=createTag("div",{className:"tab_itm_con"});
	dom_rowitm_cn.appendChild(dom_itm_scroll_l);
	dom_rowitm_cn.appendChild(dom_itm_con);
	dom_rowitm_cn.appendChild(dom_itm_scroll_r);
	var arr_tabButton=obj_info.tabItm.array;
	for(var i =0, n=arr_tabButton.length; i<n; i++)
	{
		dom_itm_con.appendChild(aButton(arr_tabButton[i]));
	}
	_("tab_menu_con").appendChild(dom_rowitm_cn);
	showmLeftMenuClickTablist(str_keyId);
}
function checkTabIsSet(str_keyId)
{
	var bool_state=false;
	var dom_tabCons=childs(_("tab_menu_con"),"div");
	for(var i=0,n=dom_tabCons.length; i<n; i++)
	{
		if(attr(dom_tabCons[i],"keyid")==str_keyId)
		{
			dom_tabCons[i].style.display="block";
			bool_state=true;
			continue;
		}
		dom_tabCons[i].style.display="none";
	}
	return bool_state;
}
function showmLeftMenuClickTablist(str_keyId)
{
	var dom_tabCons=childs(_("tab_menu_con"),"div");
	for(var i=0,n=dom_tabCons.length; i<n; i++)
	{
		if(attr(dom_tabCons[i],"keyid")==str_keyId)
		{
			dom_tabCons[i].style.display="block";
			continue;
		}
		dom_tabCons[i].style.display="none";
		
	}
}
function aButton(obj_info)
{
	
	var  showTabCont=function(ev)
		{
			checkTabPresence(ev);
			if(checkIframePresence(obj_info.id))
			{
				return false;
			};
			var dom_ifame=createTag("iframe",{id:obj_info.id,src:obj_info.src,className:"iframe_itm",event:{click:tabItmScrollClick}});
			_("iframe_container").appendChild(dom_ifame);
		};
	var dom_a=createTag("a",{className:"abtn_left",href:"javascript:void(0)"});
	var dom_button=createTag("span",{className:"abtn_right",event:{click:showTabCont},innerHTML:obj_info.title});
	dom_a.appendChild(dom_button);
	return dom_a;
}

function checkTabPresence(ev)
{
	var dom_click=getSpecificParent(evTag(ev),"a");
	var dom_tabCons=childs(getParentNode(dom_click),"a");
	for(var i=0,n=dom_tabCons.length; i<n; i++)
	{
		removeClassName(dom_tabCons[i],"abtn_left_selected");
	}
	addClassName(dom_click,"abtn_left_selected");
	
}
function checkIframePresence(str_id)
{
	var bool_state=false;
	var dom_iframeCons=childs(_("iframe_container"),"iframe");
	
	for(var i=0,n=dom_iframeCons.length; i<n; i++)
	{
		if(dom_iframeCons[i].id==str_id)
		{
			dom_iframeCons[i].style.display="block";
			bool_state=true;
			continue;
		}
		dom_iframeCons[i].style.display="none";
	}
	bug("checkIframePresence","bool_state: "+bool_state+" <br> str_id: "+str_id+"<br>dom_iframeCons: "+dom_iframeCons.length);
	return bool_state;
}
function tabItmScrollClick(){alert("lll")}





function createLeftmenu()
{
	var _leftMenu=menue_obj.leftMenu;
	if(_leftMenu.length>0)
	{
		var dom_left_menu=_("left_menu");
		var dom_menu_itm="";
		
		for(var i =0,n=_leftMenu.length; i<n; i++)
		{
			var obj_itm=_leftMenu[i];
			var fun_click=function(id)
			{
				return function()
				{
					leftmenuItmClick(id);
					var str_id="lc_menuitm_"+id;
					var str_s_id=attr(parentNode(_(str_id)),"selected_id");
					if(str_s_id)
					{
						changeClass(str_s_id,"lc_menu_itm_d","lc_menu_itm_c");
					}
					attr(parentNode(_(str_id)),"selected_id",str_id);
					changeClass(str_id,"lc_menu_itm_c","lc_menu_itm_d");
				};
			};
			var fun_over=function(id,ev)
			{
				return function(ev)
				{
					var str_id="lc_menuitm_"+id;
					changeClass(str_id,"lc_menu_itm_over","lc_menu_itm_d");
//					runEvInArea(ev,id,function(){changeClass(id,"lc_menu_itm_over","lc_menu_itm_d");});
				};
			};
			var fun_out=function(id,ev)
			{
				return function(ev)
				{
					var str_id="lc_menuitm_"+id;
					
					changeClass(str_id,"lc_menu_itm_d","lc_menu_itm_over");
					//id="lc_menuitm_"+id;
					//runEvInArea(ev,id,function(){alert("fun_out");changeClass(id,"lc_menu_itm_d","lc_menu_itm_over");});
				};
			};
			dom_menu_itm=createTag("div",{className:"lc_menu_itm lc_menu_itm_d",id:"lc_menuitm_"+obj_itm.id,keyId:obj_itm.id,event:{click:fun_click(obj_itm.id),mouseover:fun_over(obj_itm.id),mouseout:fun_out(obj_itm.id)}});
			dom_menu_itm.appendChild(createTag("div",{className:"lc_m_itm_ico cl_"+obj_itm.id}));
			dom_menu_itm.appendChild(createTag("div",{className:"lc_m_itm_txt",innerHTML:obj_itm.title}));
			dom_left_menu.appendChild(dom_menu_itm);
		}
	}
	
}




function createToptmenu()
{
	var _topMenu=menue_obj.topMenu;
	if(_topMenu.length>0)
	{
		var dom_left_menu=_("rtc_bar_r");
		var dom_menu_itm="";
		
		for(var i =0,n=_topMenu.length; i<n; i++)
		{
			var obj_itm=_topMenu[i];
			var fun_click=function(id)
			{
				return function()
				{
					topmenuItmClick(id);
					var str_id="rtcb_"+id;
					var dom_dv=parentNode(parentNode(_(str_id)));
					var str_s_id=attr(dom_dv,"selected_id");
					if(str_s_id)
					{
						changeClass(str_s_id,"lc_menu_itm_d","lc_menu_itm_c");
					}
					attr(dom_dv,"selected_id",str_id);
					changeClass(str_id,"lc_menu_itm_c","lc_menu_itm_d");
				};
			};
			var fun_over=function(id,ev)
			{
				return function(ev)
				{
					//var str_id="lc_menuitm_"+id;
					//changeClass(str_id,"lc_menu_itm_over","lc_menu_itm_d");
				};
			};
			var fun_out=function(id,ev)
			{
				return function(ev)
				{
					//var str_id="lc_menuitm_"+id;
					//changeClass(str_id,"lc_menu_itm_d","lc_menu_itm_over");
				};
			};
			dom_menu_itm=createTag("span",{className:"rtcb_"+obj_itm.id,id:"rtcb_"+obj_itm.id,keyId:obj_itm.id,event:{click:fun_click(obj_itm.id),mouseover:fun_over(obj_itm.id),mouseout:fun_out(obj_itm.id)}});
			var dom_btn=createTag("button",{className:"button"});
			dom_btn.appendChild(createTag("label",{className:"ico "+obj_itm.id,innerHTML:"&nbsp;"}));
			dom_btn.appendChild(document.createTextNode(obj_itm.title));
			dom_menu_itm.appendChild(dom_btn);
			dom_left_menu.appendChild(dom_menu_itm);
		}
	}
	
}

function topmenuItmClick(str_keyId)
{
	bug("topmenuItmClick","str_keyId: "+str_keyId);
	var _topMenu=menue_obj.topMenu;
	for(var i =0,n=_topMenu.length; i<n; i++)
	{
		var obj_info=_topMenu[i];
		if(obj_info.id==str_keyId)
		{
			if(obj_info.tabItm)
			{createTabmenuItem(obj_info);}
		}
	}
}
