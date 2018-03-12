// JavaScript Document

var templateInfo={
					data:{areas:{},backGroundImage:{name:"",fileID:""}},
					tempGobal:{type:"0",resolution:"0",name:"",dir:"transverse"}
	};
var templateSeting={
					area:{mi_w:10,mi_h:10},
					Proportion:1,
					canvasContainer:"#conArea",
					id:"#canvasDiv",
					jqCanvas:{},
					focusArea:"",
					weiTiao:{x:'_areaX',y:'_areaY',w:'_areaW',h:'_areaH',t:'_areaType',z:'_areaZ'},
					canvasTrueReso:"1024x768",
					clientType:"X86"
				};

function templateSet(itm,info)
{
	switch(itm)
	{
		case "backGroundImage":
			templateInfo.data["backGroundImage"]=info;
			if(!$("#temp_backGroundImage").length)
			{
				var jq_area=$("#canvasDiv").children("div"),
					bool_area=jq_area.length>0?true:false,
					jq_bgImg_dv=$("<div id='temp_backGroundImage' class='temp_backGroundImage'><img src='"+info.viewpath+"' onmousedown='return false;' width='100%' height='100%' border='0' /></div>");
				if(bool_area)
				{jq_bgImg_dv.insertBefore(jq_area.first());}
				else
				{jq_bgImg_dv.appendTo("#canvasDiv");}
				jq_bgImg_dv.height($("#canvasDiv").height());
				break;
			}
			$("#temp_backGroundImage").find("img")[0].src=info.viewpath;
			break;
		case "backGroundImage_view":
			if(!$("#temp_backGroundImage_view").length)
			{
				$("#temp_backGroundImage").hide();
				var jq_area=$("#canvasDiv").children("div"),
					bool_area=jq_area.length>0?true:false,
					jq_bgImg_dv=$("<div id='temp_backGroundImage_view' class='temp_backGroundImage'><img src='"+info.viewpath+"' onmousedown='return false;' width='100%' height='100%' border='0' /></div>");
				if(bool_area)
				{jq_bgImg_dv.insertBefore(jq_area.first());}
				else
				{jq_bgImg_dv.appendTo("#canvasDiv");}
				jq_bgImg_dv.height($("#canvasDiv").height());
				break;
			}
			$("#temp_backGroundImage_view").find("img")[0].src=info.viewpath;
			break;
		case "backGroundImage_view_remove":
			$("#temp_backGroundImage").show();
			$("#temp_backGroundImage_view").remove();
			break;
		case "clearBackGroundImage":
			if(!$("#temp_backGroundImage").length)
			{
				alert("您还没有设置背景!");
			}
			$("#temp_backGroundImage").remove();
			$("#temp_backGroundImage_view").remove();
			templateInfo.data["backGroundImage"]={name:"",fileID:""};
	}
}



var templateObj={
	clientTypeInfo:[{id:"0",type:"X86",title:"X86"},{id:"1",type:"android",title:"Android"}/*,{id:"2",type:"sigma",title:"Sigma"}*/],
	clientDirInfo:[{id:"transverse",type:"transverse",title:"横向"},{id:"vertical",type:"vertical",title:"纵向",}],
	area_Type:_areasInfo_.areas,//defaultInfo.js  这是一个对象数组
	clientResolutionInfo:resolutionInfo.resolution,
	init:function(){
		templateObj.setCanvasSize();
		templateObj.setProportion();
		templateObj.resizeBgImageSize();
		templateObj.areaReZoom();
	},
	setProportion:function(){
		var arr_size=templateSeting.canvasTrueReso.split("x"),
		jq_dom_canvas=$(templateSeting.id),
		int_c_w=jq_dom_canvas.width(),
		int_c_h=jq_dom_canvas.height();
		//设置缩放比例
		var pro=1,
		pro_w=arr_size[0]*1/int_c_w,
		pro_h=arr_size[1]*1/int_c_h;
		pro=pro_w>=pro_h?pro_w:pro_h;
		templateSeting.Proportion=pro;
	},
	setCanvasSize:function(){
		var arr_size=templateSeting.canvasTrueReso.split("x"),
		//获取包含画布的div的对象，即画布父层
		jq_dom_conArea=$(templateSeting.canvasContainer),
		//原来初始化包含画布层的div的宽度和高度
		_w=jq_dom_conArea.width(),//画布父层的宽度
		_h=jq_dom_conArea.height(),//画布父层的高度

		pro=1,
		pro_w=arr_size[0]*1/_w,//
		pro_h=arr_size[1]*1/_h,//
		//alert(pro_w+"========="+;pro_h);
		pro=pro_w>=pro_h?pro_w:pro_h,//获取最大倍数

		c_w=arr_size[0]*1/pro,//同比例缩小后的宽度
		c_h=arr_size[1]*1/pro,//同比例缩小后的高度

		int_x=(_w-c_w)/2,//画布的left属性  即把画布居中
		int_y=0;//画布的top属性

		$(templateSeting.id).css({
			position:'absolute',
			'width':c_w,
			'height':c_h,
			backgroundColor:"#f00",
			'left':int_x+"px",
			'top':int_y+"px"
			});
		//初始层拖动的范围
	   templateObj.setDragInfo();
	},
	//==================================
	setDragInfo:function (){
		var c=$(templateSeting.id),
		w=c.width(),
		h=c.height(),
		p=c.offset(),
		x=p.left,
		y=p.top;
		dg.fn.setDragInfo({mi:{x:0,y:0},mx:{x:w,y:h},x:x,y:y,w:w,h:h},"_area_item_");
	},
	areaReZoom:function(old_pro){
		if(old_pro==null){old_pro=1;}
		$(templateSeting.id).find(".tempArea").each(function(index, element) {

			var _x,_y,_w,_h;
			for(var i in templateInfo.data.areas)
			{
				if(element.getAttribute("data_bx_uuid")==i)
				{
					var _wh_=[];
					_wh_[0]=$(templateSeting.id).width();
					_wh_[1]=$(templateSeting.id).height();
					_x=templateInfo.data.areas[i]["info"]["x"]=templateInfo.data.areas[i]["info"]["percentage"]["x"]*_wh_[0];
					_y=templateInfo.data.areas[i]["info"]["y"]=templateInfo.data.areas[i]["info"]["percentage"]["y"]*_wh_[1];
					_w=templateInfo.data.areas[i]["info"]["w"]=templateInfo.data.areas[i]["info"]["percentage"]["w"]*_wh_[0];
					_h=templateInfo.data.areas[i]["info"]["h"]=templateInfo.data.areas[i]["info"]["percentage"]["h"]*_wh_[1];
					element.style.left  = _x+"px";
					element.style.top   = _y+"px";
					element.style.width = _w+"px";
					element.style.height= _h+"px";
					element.style.lineHeight= _h+"px";
				}
			}
        });
	},
	setAreaTypeBar:function(){
		var type=templateObj.area_Type;//获取defaultInfo.js中_areasInfo_对象的area属性  对象
		for(var i=0,n=type.length; i<n; i++)
		{
			//$('<span class="button_item"><button class="button">'+type[i].title+'</button></span>').
			$('<span class="button_item"><button title="'+type[i].title+'" class="button'+type[i].type+'"></button></span>').
			appendTo("#areaTypeCon").
			children().
			data("extendInfo",{type:type[i].type,title:type[i].title,css:"width:80px; height:80px; line-height:80px; background-color:"+type[i].color}).
			click(function(){templateObj.addArea($(this).data("extendInfo"));});
		}
	},
	clientType:function(ev){
		// var obj=this, obj_pos=getElementPos(obj),
		// clientTypeInfo=templateObj.clientTypeInfo,
		// str_dom="";
		// if(_("clientType"))
		// {
			// _("clientType").style.display="block";
		// }
		// else{
			// str_dom="<div id='clientType' class='clientType' style='position:absolute; top:"+(obj_pos.y+obj.clientHeight)+"px; left:"+obj_pos.x+"px;'>";
			// for(var i=0,n=clientTypeInfo.length; i<n; i++)
			// {
				// str_dom+='<div class="clientType_item" onclick="templateObj.setClientType(\''+clientTypeInfo[i].id+'\',\''+clientTypeInfo[i].title+'\')"><ul><li>';
				// str_dom+='<input type="radio" style="display:none;" name="clientTypeRadio" value="'+clientTypeInfo[i].type+'" id="clientTypeRadio_'+clientTypeInfo[i].id+'" />';
				// str_dom+='</li><li><label for="clientTypeRadio_'+clientTypeInfo[i].id+'" >'+clientTypeInfo[i].title+'</label></li></ul></div>';
			// }
			// str_dom+="</div>";
			// insertHTML(_("main"),"beforeEnd",str_dom);
		// }
		// var hidClientType=function()
		// {
			// $("#clientType").hide();
			// $(document).unbind("click",hidClientType);
		// };
		// $(document).click(hidClientType);
// 
		// $(".clientType_item").mouseenter(function(){$(this).addClass("mouseOnItem");}).mouseleave(function(){$(this).removeClass("mouseOnItem");});
		// stopBubble(ev);
	},
	setClientType:function(str_clientType,str_typeTitle){
		//_("_clType").innerHTML=str_typeTitle;
		//templateInfo.tempGobal.type=str_clientType;
		//templateSeting.clientType=str_typeTitle;
		//_("clientType").style.display="none";
	},
	clientDir:function(ev){
		var obj=this, obj_pos=getElementPos(obj);
		var clientDirInfo=templateObj.clientDirInfo,str_dom="";
		if(_("clientDir"))
		{
			_("clientDir").style.display="block";
		}
		else
		{
			str_dom="<div id='clientDir' class='clientType' style='position:absolute; top:"+(obj_pos.y+obj.clientHeight)+"px; left:"+obj_pos.x+"px;'>";
			for(var i=0,n=clientDirInfo.length; i<n; i++)
			{
				str_dom+='<div class="clientType_item" onclick="templateObj.setClientDir(\''+clientDirInfo[i].type+'\',\''+clientDirInfo[i].title+'\')"><ul><li><input type="radio" style="display:none;" name="clientDirRadio" value="'+clientDirInfo[i].type+'" id="clientDirRadio_'+clientDirInfo[i].id+'" /></li><li><label for="clientDirRadio_'+clientDirInfo[i].id+'" >'+clientDirInfo[i].title+'</label></li></ul></div>';
			}
			str_dom+="</div>";
			insertHTML(_("main"),"beforeEnd",str_dom);
		}
		var hidClientDir=function()
		{
			$("#clientDir").hide();
			$(document).unbind("click",hidClientDir);
		};
		$(document).click(hidClientDir);
		$(".clientType_item").mouseenter(function(){$(this).addClass("mouseOnItem");}).mouseleave(function(){$(this).removeClass("mouseOnItem");});


		stopBubble(ev);
	},
	setClientDir:function(str_clientDir,str_dirTitle){
		_("_clDir").innerHTML=str_dirTitle;
		//alert(templateInfo.tempGobal.dir);//===========================
		templateInfo.tempGobal.dir=str_clientDir;
		//alert(templateInfo.tempGobal.dir);//===========================
		_("clientDir").style.display="none";
		//alert("========");
		templateObj.changeDir();
	},
	clientResolution:function(ev){

		var obj=this,obj_pos=getElementPos(obj);
		var type=templateInfo.tempGobal.dir;
		var clientResoInfo="",str_dom="";
		if(type=="transverse")
		{
			clientResoInfo=templateObj.clientResolutionInfo.transverse;
		}
	//	alert(JSON.stringify(clientResoInfo));
//		else
//		{
//			clientResoInfo=templateObj.clientResolutionInfo.vertical;
//		}
		if(_("clientResolution"))
		{
			_("clientResolution").style.display="block";
		}
		else
		{
			str_dom="<div id='clientResolution' class='clientType float' style='position:absolute; top:"+(obj_pos.y+obj.clientHeight)+"px; left:"+obj_pos.x+"px;'>";
			for(var i=0,n=clientResoInfo.length; i<n; i++)
			{
				str_dom+='<div class="clientType_item clientResolution" onclick="templateObj.setClientReso(\''+clientResoInfo[i][1]+'\',\''+clientResoInfo[i][0]+'\')"><ul><li>';
				str_dom+='<input type="radio" name="clientResoRadio" style="display:none;" value="'+clientResoInfo[i][1]+'" id="clientResoRadio_'+i+'" /></li><li>';
				str_dom+='<label for="clientResoRadio_'+i+'" >'+clientResoInfo[i][0]+'</label></li></ul></div>';
			}
			str_dom+="</div>";
			insertHTML(_("main"),"beforeEnd",str_dom);
		}

		var hidClientReso=function()
		{
			$("#clientResolution").hide();
			$(document).unbind("click",hidClientReso);
		};
		$(document).click(hidClientReso);
		$(".clientType_item").mouseenter(function(){$(this).addClass("mouseOnItem");}).mouseleave(function(){$(this).removeClass("mouseOnItem");});
		stopBubble(ev);
	},
	setClientReso:function(str_clientReso,str_resoTitle){
		_("_clReso").innerHTML=str_resoTitle;
		templateInfo.tempGobal.resolution=str_clientReso;
		//alert(templateInfo.tempGobal.resolution);//===================
		templateSeting.canvasTrueReso=str_resoTitle;
		_("clientResolution").style.display="none";
		var old_pro=templateSeting.Proportion;
		templateObj.setCanvasSize();
		templateObj.setProportion();
		templateObj.areaReZoom(old_pro);
		templateObj.resizeBgImageSize();

	},
	setTempName:function(o){
		templateInfo.tempGobal.name=trim(o.value);
	},
	setWeiTiao:function(){
		if(templateSeting.focusArea==""){return ;}
		var focusArea=$(templateSeting.focusArea);
		var _w=$('#'+templateSeting.weiTiao.w).val()*1,
			_h=$('#'+templateSeting.weiTiao.h).val()*1,
			_x=$('#'+templateSeting.weiTiao.x).val()*1,
			_y=$('#'+templateSeting.weiTiao.y).val()*1;
			//z=templateInfo.weiTiao.z;
			
		var c=$(templateSeting.id),
			_w_=w=c.width(),
			_h_=h=c.height();

		_w=_w<templateSeting.area.mi_w?templateSeting.area.mi_w:_w;
		_w=_w>w?w:_w;
		$('#'+templateSeting.weiTiao.w).val(_w);

		_h=_h<templateSeting.area.mi_h?templateSeting.area.mi_h:_h;
		_h=_h>h?h:_h;
		$('#'+templateSeting.weiTiao.h).val(_h);

		_x=_x<0?0:_x;
		_x=_x>w-focusArea.width()?w-focusArea.width():_x;
		$('#'+templateSeting.weiTiao.x).val(_x);

		_y=_y<0?0:_y;
		_y=_y>h-focusArea.height()?h-focusArea.height():_y;
		$('#'+templateSeting.weiTiao.y).val(_y);
		
		
		var uuid=focusArea.attr("data_bx_uuid");
		with(templateInfo.data.areas[uuid]["info"])
		{
			x=_x;
			y=_y;
			w=_w;
			h=_h;
			percentage.x=_x/_w_;
			percentage.y=_y/_h_;
			percentage.w=_w/_w_;
			percentage.h=_h/_h_;
		}
		focusArea.css({'width':_w,'height':_h,'left':_x+'px','top':_y+'px',lineHeight:_h+'px'});
	},
	deleteArea:function(){
		if(templateInfo.focusArea==""){return ;}
		var focusArea = $(templateSeting.focusArea),
		uuid = focusArea.attr("data_bx_uuid"),
        area_id = templateSeting.focusArea.id;
	    //当编辑的模板为节目正在使用的时候,调用此函数,关联节目编辑界面中的函数
		if (templateObj.edit.forProgram) {
		    if (!templateObj.edit.deleteAreaForProgram(area_id)) {
		        return false;
		    }
		}
		focusArea.remove();
		delete templateInfo.data.areas[uuid];
		templateSeting.focusArea="";

        
	},
    addArea : function(exInf){
    	//alert(dump(exInf));
		//滚动字幕只支持一个
		if(exInf.type=="Txt"){
			for(var i in templateInfo.data.areas){
				if(templateInfo.data.areas[i]["info"]["extendInfo"]["type"]=="Txt")
				{
					alert("目前滚动字幕区域只支持一个！");
					return  ;
				}
			}
		}
		//主区域只支持一个
		if(exInf.type=="Video"){
			for(var i in templateInfo.data.areas){
				if(templateInfo.data.areas[i]["info"]["extendInfo"]["type"]=="Video")
				{
					alert("目前主区域只支持一个！");
					return ;
				}
			}
		}
		var areaID="";
		if(!exInf.hasOwnProperty("id")){
			areaID=$(templateSeting.id).find(".tempArea").length;
			while(true)
			{
				if(_(areaID+"")){  //避免重复ID 的出现;
					areaID++;
				}
				else{ break ;}
			}
		}
		else
		{areaID=exInf.id;}
		var dom_area=$("<div id='"+areaID+"' class='tempArea area_unselect' style='"+exInf.css+"'>"+exInf.title+"</div>").
					 mousedown(function()
					 {
						 if(templateSeting.focusArea!="")
						 {
							 $(templateSeting.focusArea).removeClass("area_selected").addClass("area_unselect");
						 }
						 templateSeting.focusArea=$(this).addClass("area_selected").removeClass("area_unselect")[0];
						 templateObj.readAreaInfoToWeiTiao();
					 }).appendTo(templateSeting.jqCanvas)[0];
//		var _w_h_=templateSeting.canvasTrueReso.split("x");
		
			
		var defaule_wh_=[];
			defaule_wh_[0]=$(templateSeting.id).width();
			defaule_wh_[1]=$(templateSeting.id).height();
			w=80/defaule_wh_[0],
			h=80/defaule_wh_[1];
		dg(dom_area).enabled(
			{
				key:"_area_item_",
				id:areaID,
				resizeInfo:{w:10,h:10},
				percentage:{x:0,y:0,w:w,h:h},
				bfb:true,
				extendInfo:{type:exInf.type,title:exInf.title},
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
						templateSeting.focusArea=dom_area;
						templateObj.readAreaInfoToWeiTiao();
					}
				}
			});
		return dom_area;
	},
	readAreaInfoToWeiTiao:function(){
		var key=$(templateSeting.focusArea).attr("data_bx_uuid"),
		info=templateInfo.data.areas[key]["info"];
		$('#'+templateSeting.weiTiao.w).val(info.w);
		$('#'+templateSeting.weiTiao.h).val(info.h);
		$('#'+templateSeting.weiTiao.x).val(info.x);
		$('#'+templateSeting.weiTiao.y).val(info.y);
		$('#'+templateSeting.weiTiao.t).text(info.extendInfo.title);
	},
	changeAreaType:function(){},
	resizeBgImageSize:function(){
		var dom_bgHtml=_("temp_backGroundImage");
		if(dom_bgHtml)
		{
			dom_bgHtml.style.height=$(templateSeting.id).height()+"px";
			dom_bgHtml.style.width=$(templateSeting.id).width()+"px";
		}
	},
	changeTemBgColor:function(){},
	createBGImgList:function(){
		$.dialog({
			id:'bg_img_list_con',
			title:"背景图像列表",
			width:454,
			padding:'2px',
			resize: false,
			drag: true,
			button:[
				{name:'首页',callback:function(){page.firstPage("backGroundImage"); return false;}},
				{name:'上一页',callback:function(){page.prePage("backGroundImage"); return false;}},
				{name:'下一页',callback:function(){page.nextPage("backGroundImage"); return false;}},
				{name:'尾页',callback:function(){page.overPage("backGroundImage"); return false;}},
				{name:'确定',callback:function(){
													var jq_img_itm=$(this.content()).find(".bg_img_select");
													if(jq_img_itm.length)
														{
															templateSet("backGroundImage",jq_img_itm.data("imageInfo"));
														}
												}
				},
				{name:'取消'}],
			close:function(){templateSet("backGroundImage_view_remove");}
		});
		page.getDataInfo("backGroundImage");
		setTimeout(function(){
			$.dialog.list["bg_img_list_con"].position("50%","50%");
			},500);
	},
	clearTempBgGroung:function(){templateSet("clearBackGroundImage","");},
	extend:function(deep, target, options) {
		var  copy = "";
		 for (name in options)
		 {
			 copy = options[name];
			 if (deep && copy instanceof Array)
			 {
				 target[name] = templateObj.extend(deep, [], copy);
			 }
			 else if (deep && copy instanceof Object)
			 {
				target[name] = templateObj.extend(deep, {}, copy);
			 }
			 else
			 {
				target[name] = options[name];
			 }
		 }
		 return target;
	} ,
	readyTemplateInfo:function(){
		var save_info=templateObj.extend(true,{},templateInfo),
		pro=templateSeting.Proportion,
		info={};
		for(var i in save_info.data.areas)
		{
			info=save_info.data.areas[i]['info'];
			save_info.data.areas[i]['info']["w"]=info["w"]*pro;
			save_info.data.areas[i]['info']["h"]=info["h"]*pro;
			save_info.data.areas[i]['info']["x"]=info["x"]*pro;
			save_info.data.areas[i]['info']["y"]=info["y"]*pro;
			delete save_info.data.areas[i]['info']['callBack'];
			delete save_info.data.areas[i]['info']['resize'];
			delete save_info.data.areas[i]['info']['resizeInfo'];
			delete save_info.data.areas[i]['info']['m'];
			delete save_info.data.areas[i]['info']['percentage'];
			delete save_info.data.areas[i]['info']['bfb'];
			delete save_info.data.areas[i]['info']['key'];
		}
		return save_info;
	},
	saveTemplate:function(){
		var info=templateObj.readyTemplateInfo();
		$.dialog({
			id:'save_template_info',
			title:"存储模版",
			padding:'10px',
			resize: false,
			drag: true,
			lock:false,
			width:300,
			//button:[{name:'取消'}],
			close:function(){}
			});
		var area_size=$(templateSeting.id).find(".tempArea").length;
		if(area_size<=0)
		{
			$.dialog.list['save_template_info'].content('您的模版中没有任何区域!');
			return false;
		}
		if($.trim(info.tempGobal.name)=="")
		{
			$.dialog.list['save_template_info'].content('您没有填写模版名称!');
			return false;
		}


      
		$.dialog.list['save_template_info'].content(
		'<div style="display:block;  font-size:12px; text-align:left; width:300px;">模板信息:<br /><br />模板名称:'+info.tempGobal.name+
		' 类型:'+templateSeting.clientType+
		'<br />分辨率:'+templateSeting.canvasTrueReso+
		'<br />背景:'+(info.data.backGroundImage.name==""?"":info.data.backGroundImage.name)+
		'<br />区域个数:'+area_size+
		'</div>');
		$.dialog.list['save_template_info'].button({name:'确定',callback:function(){templateObj.postTempInfo(info); return false;}});
	},
	postTempInfo:function(teminf){
		//http://192.168.100.124/CI/template/ajaxPHP/insertTemplate.php
		$.post("index.php?control=c_templateManage&action=saveTemp",$.param({template_info:teminf}),function(data){

			if(data.state=="false")
			{
				$.dialog.list['save_template_info'].content("保存模板失败");
				$.dialog.list['save_template_info'].button({name:'确定',disabled: true});
				return false;
			}
			$.dialog.list['save_template_info'].content('<div style="font-size:12px; text-align:left;">保存模板成功</div>');
			$.dialog.list['save_template_info'].button(

				{name:'确定',callback:function(){
						this.close();
						location.reload(); 
						
						//templateObj.cleraTemplateInfo();
					}}
				);
			},"json");
		},
	cleraTemplateInfo:function(){
		//var hrf=document.location.href.replace("?","");
		//document.location.href=hrf+"?";
	},
	changeDir:function(){
		var obj=_("_clReso"), obj_pos=getElementPos(obj),str_dom="";
		$("#clientResolution").remove();


		//获取分辨率类型 竖向 横向
		var type=templateInfo.tempGobal.dir,
			clientResoInfo="";
		if(type=="transverse")
		{
			clientResoInfo=templateObj.clientResolutionInfo.transverse;
		}
		else
		{
			clientResoInfo=templateObj.clientResolutionInfo.vertical;
		}

		//创建分辨率选择面板
		str_dom="<div id='clientResolution' class='clientType float' style='position:absolute; top:"+(obj_pos.y+obj.clientHeight)+"px; left:"+obj_pos.x+"px;'>";
		for(var i=0,n=clientResoInfo.length; i<n; i++)
		{
			str_dom+='<div class="clientType_item clientResolution" onclick="templateObj.setClientReso(\''+clientResoInfo[i][1]+'\',\''+clientResoInfo[i][0]+'\')"><ul><li>';
			str_dom+='<input type="radio" name="clientResoRadio" style="display:none;" value="'+clientResoInfo[i][1]+'" id="clientResoRadio_'+i+'" /></li><li>';
			str_dom+='<label for="clientResoRadio_'+i+'" >'+clientResoInfo[i][0]+'</label></li></ul></div>';
		}
		str_dom+="</div>";
		insertHTML(_("main"),"beforeEnd",str_dom);

		var hidClientReso=function()
		{
			$("#clientResolution").hide();
			$(document).unbind("click",hidClientReso);
		};
		$(document).click(hidClientReso);
		$(".clientType_item").mouseenter(function(){$(this).addClass("mouseOnItem");}).mouseleave(function(){$(this).removeClass("mouseOnItem");});


		//更新分辨率显示按钮
		//alert(templateInfo.tempGobal.resolution);//======================
		var wh=templateObj.edit.getDirAndRes(templateInfo.tempGobal.resolution),str_resoTitle="",str_clientReso="";
		var tempnum;
		//alert("变换方式"+type);
		if(type=="transverse")
		{
			var  num1=parseInt(wh.w);
			var num2=parseInt(wh.h);
			if(num1<num2){
					wh.w=""+num2;
					wh.h=""+num1;
			}
			str_resoTitle=wh.w+"x"+wh.h;
		}
		else
		{
			str_resoTitle=wh.h+"x"+wh.w;
		}
		_("_clReso").innerHTML=str_resoTitle;
		//alert(wh.w+"=========="+wh.h);
		//alert("分辨率："+str_resoTitle	);//=====================================
		templateSeting.canvasTrueReso=str_resoTitle;
		//重设分辨率
		var id=resolutionInfo.getIdByRes(str_resoTitle);
		//alert("ID:"+id);//===================================
		templateObj.setClientReso(id,str_resoTitle);

	},
	save:function(){
		var tempname=document.getElementById("_temName").value,
			tempId="";
		if(templateObj.edit.editKey!="")
		{
			tempId=templateObj.edit.editKey;
		}
		$.post('index.php?control=c_templateManage&action=checkTemplateName',{data:{name:tempname,id:tempId}},function(data){
				var  obj=$.parseJSON(data);
				if(obj.state==false){
					alert("模板名已经存在，请重新输入");
				}
				else{
					if(templateObj.edit.editKey!="")
					{
						templateObj.edit.saveEdit();
						return ;
					}

					templateObj.saveTemplate();
					
				}
		});
	},
	weiTiaoClick:function(ev){
		if(templateSeting.focusArea==""){return ;}
		var c=$(templateSeting.id),
			w=c.width(),
			h=c.height();
		var dom_evTag = evTag(ev),
			str_attrDomID=attr(dom_evTag,"wtype"),
			str_state = attr(dom_evTag,"type"),
			str_attrValue="",
			str_attrDom=$('#'+str_attrDomID),
			str_arreaAttrName="";
		var focusArea=$(templateSeting.focusArea);
			uuid=focusArea.attr("data_bx_uuid");
		if(str_state=="-"){str_state=-1;}
		if(str_state=="+"){str_state=1;}
		str_attrValue=str_attrDom.val()*1+str_state;
		switch(str_attrDomID){
			case templateSeting.weiTiao.w :
			str_arreaAttrName="w";
			str_attrValue=str_attrValue<templateSeting.area.mi_w?templateSeting.area.mi_w:str_attrValue;
			str_attrValue=str_attrValue>w?w:str_attrValue;
			focusArea.css("width",str_attrValue);
			templateInfo.data.areas[uuid]["info"].percentage.w=str_attrValue/w;
			break;
			case templateSeting.weiTiao.h :
			str_arreaAttrName="h";
			str_attrValue=str_attrValue<templateSeting.area.mi_h?templateSeting.area.mi_h:str_attrValue;
			str_attrValue=str_attrValue>h?h:str_attrValue;
			focusArea.css({"height":str_attrValue,"lineHeight":str_attrValue+"px"});
			templateInfo.data.areas[uuid]["info"].percentage.h=str_attrValue/h;
			break;
			case templateSeting.weiTiao.x :
			str_arreaAttrName="x";
			str_attrValue=str_attrValue<0?0:str_attrValue;
			str_attrValue=str_attrValue>w-focusArea.width()?w-focusArea.width():str_attrValue;
			focusArea.css("left",str_attrValue);
			templateInfo.data.areas[uuid]["info"].percentage.x=str_attrValue/w;
			break;
			case templateSeting.weiTiao.y :
			str_arreaAttrName="y";
			str_attrValue=str_attrValue<0?0:str_attrValue;
			str_attrValue=str_attrValue>h-focusArea.height()?h-focusArea.height():str_attrValue;
			focusArea.css("top",str_attrValue);
			templateInfo.data.areas[uuid]["info"].percentage.y=str_attrValue/h;
			break;
		}
		
		str_attrDom.val(str_attrValue);
		templateInfo.data.areas[uuid]["info"][str_arreaAttrName]=str_attrValue;
	}
};

//模版编辑开始
templateObj.edit={
    editKey: "",
    forProgram:false,
	init:function(){

/*	templateObj.edit.editKey=1;
	templateObj.edit.getTemplateInfo();
	return ;*/
		if(window.top!=self&&window.top._BS_.temp.edit)
		{
			templateObj.edit.editKey=window.top._BS_.temp.id;
			//当是编辑节目的模板时候不能修改名称
			if(window.top._BS_.temp.hasOwnProperty("forProgram"))
			{
			    _("_temName").setAttribute("readonly", "readonly");
			    templateObj.edit.forProgram = true;
			}
			templateObj.edit.getTemplateInfo();
			
		}
	},
	getTemplateInfo:function(){
		$.dialog({
			id:'get_temp_by_id',
			title:"提示",
			content:"模板信息加载中,请稍候......",
			padding:'10px',
			resize: false,
			drag: true,
			lock:true,
			close:function(){ }
			});
		$.post("index.php?control=c_templateManage&action=getTempById",{"temp":templateObj.edit.editKey},function(data){
			if(typeof(data)=="object")
			{
				if(data.state=="true")
				{
					$.dialog.list["get_temp_by_id"].content("模板信息加载成功!<br />开始渲染!");
					templateObj.edit.rendering(data["data"]);
				}
			}
			},"json");
		if(window.top!=self){window.top._BS_.temp.edit=false;}
	},
	rendering:function(data){
		var obj_info=data[0];
		templateInfo.data.backGroundImage.name=obj_info.temBgImg;
		templateInfo.tempGobal.type=0;//obj_info.temTp;
		templateInfo.tempGobal.resolution=obj_info.lenSc;
		templateInfo.tempGobal.name=obj_info.temNm;
		var wh_dir=templateObj.edit.getDirAndRes(obj_info.lenSc);
		templateSeting.canvasTrueReso=wh_dir.wh;
		$("#_clReso").val(wh_dir.wh);
		_("_clReso").innerHTML=wh_dir.wh;
		templateObj.init();

		$("#_temName").val(obj_info.temNm);
		if(obj_info.temBgImg!="")
		{
			templateSet("backGroundImage",{name:obj_info.temBgImg,fileID:obj_info.temId,viewpath:"Material/"+obj_info.temBgImg});
		}


		var areas=obj_info.areas,
		type=templateObj.area_Type,
		area_ty="",
		pro=templateSeting.Proportion;
		for(var i =0,n=areas.length; i<n; i++)
		{
		    area_ty="";
			for(var a=0,b=type.length; a<b; a++)
			{
				if(type[a]["type"]==areas[i]["ex_a"]){area_ty=type[a];break;}
			}
            if(area_ty=="")
            {
                area_ty={};
                area_ty.type="";
                area_ty.title="未定义";
                area_ty.color="#CCC";
            }
			templateObj.addArea({type:area_ty.type,title:area_ty.title,
			css:'background-color:'+area_ty.color+'; left:'+(areas[i]["x"]/pro)+'px; top:'+(areas[i]["y"]/pro)+'px; width:'+(areas[i]["w"]/pro)+'px; height:'+(areas[i]["h"]/pro)+'px; line-height:'+(areas[i]["h"]/pro)+'px;',id:areas[i]["areaId"]
			});
		}

		//设置区域相对于模板的比例
		var _wh_=[];
			_wh_[0]=$(templateSeting.id).width();
			_wh_[1]=$(templateSeting.id).height();
		for(var i in templateInfo.data.areas)
		{
			with(templateInfo.data.areas[i].info){
				percentage.x=x/_wh_[0];
				percentage.y=y/_wh_[1];
				percentage.w=w/_wh_[0];
				percentage.h=h/_wh_[1];
			}
		}
		$.dialog.list["get_temp_by_id"].close();
		




	},
	getDirAndRes:function(res_key){
		var res=resolutionInfo.resolution.transverse.concat(resolutionInfo.resolution.vertical),w_h="",dir="";
		for(var i=0,n=res.length; i<n; i++)
		{
			if(res[i][1]==res_key)
			{
				w_h=res[i][0];
			}
		}
		var wh=w_h.split("x"),
			dir=wh[0]*1>wh[1]*1?0:1;

		return {w:wh[0],h:wh[1],wh:w_h,dir:dir};
	},


	saveEdit:function(){
		var info=templateObj.readyTemplateInfo();
		info["tempGobal"]["update"]=true;
		info["tempGobal"]["updateid"]=templateObj.edit.editKey;
		$.dialog({
			id:'save_template_info',
			title:"保存模板更改",
			padding:'10px',
			resize: false,
			drag: true,
			lock:true,
			width:300,
			close:function(){}
			});
		var area_size=$(templateSeting.id).find(".tempArea").length;
		if(area_size<=0)
		{
			$.dialog.list['save_template_info'].content('您的模版中没有任何区域!');
			return false;
		}
		if($.trim(info.tempGobal.name)=="")
		{
			$.dialog.list['save_template_info'].content('您没有填写模版名称!');
			return false;
		}

		$.dialog.list['save_template_info'].content(
		'<div style="display:block;font-size:12px; text-align:left; width:300px;">模板信息:<br /><br />模板名称:'+info.tempGobal.name+
		//' 类型:'+templateSeting.clientType+
		'<br />分辨率:'+templateSeting.canvasTrueReso+
		'<br />背景:'+(info.data.backGroundImage.name==""?"":info.data.backGroundImage.name)+
		'<br />区域个数:'+area_size+
		'</div>');
		$.dialog.list['save_template_info'].button({name:'确定',callback:function(){templateObj.edit.postEditInfo(info); return false;}});
	},
	postEditInfo:function(teminf){
		$.post("index.php?control=c_templateManage&action=saveEditTemp",$.param({template_info:teminf}),function(data){

			if(data.state=="false")
			{
				$.dialog.list['save_template_info'].content("保存模板失败");
				$.dialog.list['save_template_info'].button({name:'确定',callback:function(){}});
				return false;
			}
			$.dialog.list['save_template_info'].content("保存模板成功!");
			$.dialog.list['save_template_info'].button(
				{name:'确定',callback:function(){
						this.close();
						location.reload(); 
						templateObj.cleraTemplateInfo();
                        //如果是编辑节目模板, 完成之后需要刷新, 节目编辑界面;
						if (templateObj.edit.forProgram) {
						    art.dialog.opener.location.reload(true);
						}
					}}
				);
			},"json");
	},
    deleteAreaForProgram: function (areaID) {
        if (confirm("您确定要删除整个区域?此操作不能还原!")) {
            var open_dom = art.dialog.opener.program.templistEdit;//
            open_dom.deleteAreaForServer(areaID);
            
            return true;
        }
        else {
            return false;
        }
    }
    
};



/***************************************

		背景图片分页

***************************************/

page.newPage({key:"backGroundImage",keyWord:{my_comm:"0",type:"3"},url:"index.php?control=c_fileManage&action=getImageFileListToTemp",success:function(data){
		var data=$.parseJSON(data);
		if(typeof(data)=="object"&&data["state"]=="true"){insertContainer(data.data);}
	},error:function(){$.dialog.list['bg_img_list_con'].content('对不起您的信息加载失败');}});



function insertContainer(data){
		var img_con=$.dialog.list['bg_img_list_con'].content();
		img_con.innerHTML="<div style='display:block;' id='pageContent'></div><div style='display:block;'></div>";
		var imgInfo=data.bgImgInfo,str_bg="";
		for(var i=0,n=imgInfo.length; i<n; i++)
		{
			str_bg='<a class="bg_img_list" href="javascript:void(0)">';
				str_bg+='<ul>';
					str_bg+='<li class="f_img"><img src="'+imgInfo[i].viewpath+'" border="0"/></li>';
					str_bg+='<li class="f_name">'+imgInfo[i].name+'</li>';
				str_bg+='</ul>';
			str_bg+='</a>';
			$(str_bg).data("imageInfo",imgInfo[i])
			.appendTo(img_con)
			.click(function()
					{
						$(img_con).find("a").removeClass("bg_img_select");
						$(this).addClass("bg_img_select");
						templateSet("backGroundImage_view",$(this).data("imageInfo"));
					});
		}
}


/***************************************

		程序初始化

***************************************/

$(document).ready(function(e) {
    document.onselectstart=function(){return false;};
	templateObj.setAreaTypeBar();
	templateSeting.jqCanvas=$("#canvasDiv");

	$("#area_weiTiao").click(templateObj.setWeiTiao);
	$("#area_del").click(templateObj.deleteArea);
	$("#tem_save").click(templateObj.save);
	$("#_tmpBgImg").click(templateObj.createBGImgList);
	//$("#_clType").click(templateObj.clientType);
	$("#_clReso").click(templateObj.clientResolution);
	$("#_clDir").click(templateObj.clientDir);
	$("#_cleartmpBgImg").click(templateObj.clearTempBgGroung);
	var arr_weiBtn=_("areaAttr").getElementsByTagName("b");
	for(var i=0,n=arr_weiBtn.length; i<n; i++)
	{
		$(arr_weiBtn[i]).click(templateObj.weiTiaoClick);
	}
	s();
	window.onresize=function()
	{
		s();
		templateObj.init();
	};
	templateObj.init();
	window.onload=function(){templateObj.edit.init();};
});
function s()
{
	_("main").style.height=clientHeight(document)+"px";
}
