$(document).ready(function(){
	templateManage.init();
});
var templateManage={
	init:function(){
		$("#template_list_panel")
		.height($(document).height()-32-$("#template_list_toolBar").height())
		.width($(document).width()-2)
		.panel({});
		$("#create_temp").click(templateManage.createTemplate);
		$("#del_temp").click(templateManage.delTemplate);
		$("#edit_temp").click(templateManage.editTemplate);

		templateManage.loadData(10,1);
	}
	,loadData:function(rows,page){
		$.messager.progress({title:"数据在路上马上就到!"});
		$.ajax({
			type : "post",
			url : "index.php?control=c_templateManage&action=getTempList",
			data : {
				data : {rows:rows,page:page}
			},
			success : function(obj_result) {
				$.messager.progress("close");
				if (!obj_result.state) {
					
					$.messager.alert("提示","您还没有创建模板,请点击新建模板按钮来创建!");
				}
				if ( obj_result.state) {
					
					templateManage.parserTempList(obj_result.data.rows);
					//分页工具条
					$("#template_list_pageBar").pagination({
						total: obj_result.data.total,
						pageSize:10,
						onSelectPage: function(pageNumber, pageSize){
			                templateManage.loadData(pageSize,pageNumber);
			            }
					});
					
				}
			},
			dataType : "json"
		});
	}
	,parserTempList:function(obj_info){
		var temp_container=$($("#template_list_panel").panel("body"));
		temp_container.html("");
		var bl = 1, bla = 1, w = 120, h = 120, wh = {}, areas = [], dom_gridItem = [];
		//	var  imgurl=" ";
		for (var i = 0, n = obj_info.length; i < n; i++) {
			wh = resolutionInfo.getResById(obj_info[i]["LengthScale"]);
			if ( typeof (wh) != "object") {
				break ;
			}
			var temType = Bs.template.getTypeNameByKey(obj_info[i]["TemplateType"]);
			bl = wh.h / 110, bla = wh.w / 120, bl = bl > bla ? bl : bla, w = wh.w / bl, h = wh.h / bl, str = "",

			dv_dom=$("<div id='"+obj_info[i]["TemplateID"] + "_tmp' class='temp_sample' style='text-align:center;  display:block;width:165px; height:160px;  margin-left:5px; margin-top:5px; float:left;'></div>");
			var str = "<a href='javascript:/*www.sharp-i.net*/;' style='display:block; height:160px;'>";
			str += "<div class='div'  style=' height:150px; '>";
			str += "<div style='display:block; height:16px; font-size:12px;'>" + obj_info[i]["TemplateName"] + "</div>";
			str += "<DIV STYLE='display:block; height:110px;padding:0px;'>";
			str += "<DIV STYLE='font-size:1px;display:block; width:" + w + "px; height:" + h + "px; background-color:#bdbdbd; padding:0px;  margin:0px auto;'>";
			str += "<div style='position:relative; display:block;width:" + w + "px; height:" + h + "px;'>";
			areas = obj_info[i]["areas"];
			for (var a = 0, b = areas.length; a < b; a++) {
				str += "<div style='position:absolute; background-color:red; border:1px solid; ";
				str += "width:" + ((areas[a]["Width"]) / bl - 2) + "px; ";
				str += "height:" + ((areas[a]["Height"]) / bl - 2) + "px; ";
				str += "left:" + ((areas[a]["X"]) / bl) + "px; ";
				str += "top:" + ((areas[a]["Y"]) / bl) + "px;'>";
				str += "</div>";
			}
			str += "</div>";
	
			str += "</DIV>";
			str += "</DIV>";
			str += "<div style='display:block; height :16px; font-size:12px; line-height:16px;'><input type='checkbox'  value='" + obj_info[i]["TemplateID"] + "' id='" + obj_info[i]["TemplateID"] + "_ckbox' name='template_checkbox' style='vertical-align:middle;' /><label>" + wh.w + "x" + wh.h + "</label></div>";
			str += "</div>";
			str += "</a>";
			$(str).click(templateManage.checkeTheTemp).appendTo(dv_dom);
			temp_container.append(dv_dom);
		}
	
	}
	, checkeTheTemp:function() {

		$(this).find("input").each(function(index,item){
			if(item.checked){
				item.checked=false;
			}
			else{
				item.checked=true;
			}
		});
		
	}
	,createTemplate:function(){
		art.dialog.open('index.php?control=c_templateManage&action=createTemp', {
			title : '新建模版',
			width : "90%",
			height : "90%",
			opacity : 0.5,
			resize : false,
			 close: function() {
            	document.location.reload();
                //window.parent.document.getElementById("getProfileInfo").contentWindow.location.reload();
            }
		});
	}
	,editTemplate:function(){
		var str_tempId = templateManage.getTempID();
		if (str_tempId.length > 1) {
			$.messager.alert("提示","一次性只能编辑一个模板!");
			return;
		}
		if (str_tempId.length > 0) {
			window.top._BS_.temp.edit = true;
			window.top._BS_.temp.id = str_tempId[0];
			art.dialog.open('index.php?control=c_templateManage&action=createTemp', {
				title : '编辑模版',
				width : "90%",
				height : "90%",
				opacity : 0.5,
				resize : false,
				 close: function() {
            	document.location.reload();
                //window.parent.document.getElementById("getProfileInfo").contentWindow.location.reload();
            }
			});
		} else {
			$.messager.alert("提示","您未选择任何模板!");
		}
	}
	,getTempID:function() {
		var tempID = [];
		var dom_checkbox = $("input[name=template_checkbox]");
		for (var i = 0, n = dom_checkbox.length; i < n; i++) {
			if (dom_checkbox[i].checked) {
				tempID.push(dom_checkbox[i].value);
			}
		}
		return tempID;
	}
	//------------------------------------------
	//-
	//- 删除 播放模板 删除多条
	//------------------------------------------
	,delTemplate:function() {
		var tempID = templateManage.getTempID();
		if(tempID.length<=0){
			$.messager.alert("提示","您未选择任何模板!");
			return true;
		}
		$.messager.confirm("提示","您确定要删除此模板吗?",function(state){
			if(state){
				
				$.ajax({
						type : "post",
						url : "index.php?control=c_templateManage&action=deleteMulpTemp",
						data : {
							tempIDs : tempID.join(",")
						},
						success : function(obj_result) {
							if (!obj_result.state) {
								$.messager.alert("提示","删除模板失败!");
							}
							if ( obj_result.state) {
								$.messager.alert("提示","删除模板成功!");
								for(var i in tempID){
									$("#"+tempID[i]+"_tmp").fadeOut(500,function(){
										$(this).remove();
									});	
								}
							}
						},
						dataType : "json"
					});
			}
		});
		
	}
};


