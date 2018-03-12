<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?php echo base_url(); ?>" />
<title>文件上传</title>



<!--script src="JavascriptClass/jquery-1.7.2.js" type="text/javascript"></script-->

<script src="JavascriptClass/bx.core.js" type="text/javascript"></script>
<script src="JavascriptClass/bx.ui.js" type="text/javascript"></script>
<script src="JavascriptClass/bx.ajax.js" type="text/javascript"></script>
<script  src="JavascriptClass/artDialog/artDialog.js?skin=blue" type="text/javascript"></script>
<script  src="JavascriptClass/artDialog/plugins/iframeTools.js" type="text/javascript"></script>
<script src="application/views/js/fileManage.js" type="text/javascript"></script>

<script src="JavascriptClass/bx.comment.js" type="text/javascript"></script>

<link id="easyuiTheme" rel="stylesheet" type="text/css" href="JavascriptClass/jquery-easyui/themes/default/easyui.css"/>
<link rel="stylesheet" type="text/css" href="JavascriptClass/jquery-easyui/themes/icon.css"/>
<script type="text/javascript" src="JavascriptClass/jquery-easyui/jquery.easyui.min.js"></script>
<script id="easy-lang" type="text/javascript" src="JavascriptClass/jquery-easyui/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="application/views/javaScript/p_filemanage.js"></script>
<script type="text/javascript" src="JavascriptClass/jquery-easyui/jquery.datagrid-ext.js"></script>

<script src="application/views/js/fileManage.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="Skin/default/default.css" />


<link rel="stylesheet" type="text/css" href="Skin/default/default.css" />

<!--link rel="stylesheet" type="text/css" href="swfUpload/default.css" /-->
<link rel="stylesheet" type="text/css" href="Skin/web/index.css" />
<style>


input, label {vertical-align:middle;font-family:tahoma;}
input { margin:0px; padding:0px; }
.label { margin:2px;}
.label input{ margin-right:2px;}

/*********************  顶部工具栏  *********************/
.topToolBar, .topToolBar_left, .topToolBar_right { display:block; height:100%; overflow:auto; }
.topToolBar { }
/**************topToolBar_left****************/


	.topToolBar_left { width:150px; float:left;  }
/**************topToolBar_right****************/
	.topToolBar_right { float:left; }


/*********************  Grid  *************************/
.fileListContainer { font-size:12px; width:100%;}
 .listContent {  width:100%; height:100%; overflow:auto; }
.title_item, .lisContent_item { border-left: 1px solid #c8d3db ; border-bottom:#c8d3db 1px solid;  cursor:pointer; }
.final_item { border-right:solid 1px #c8d3db; }

/*****GRID 右边的其他信息*****/
.fileOtherInfo { display:block; font-size:12px; }
.fileOtherInfo li { list-style-type:none; padding:2px; margin:0px; width:120px; float:left;}
.li_itm{ border-right:#c8d3db 1px solid;}

/**************title****************/
.titleContainer { height:26px; }



/**************listContent**********/
.listContent { padding:3px 0px 3px 0px;  }
.listContent_Over { background-color:#0F9; color:#006;}
.listContent_Out { background-color:#FFF; color:#000;}
.lisContent_item { height:20px; line-height:20px; background-color:transparent; }

/**************bottomBarContent******/
.bottomBarContainer { text-align:center; height:30px; }

/* flv播放器  */
.flv_container {  width:252px; height:182px; padding:0px;}



.fl_nm ,.fl_state{font-size:12px;}
.fl_nm { display:inline-block; margin-left:5px; margin-right:5px;  width:240px;}
.fl_state {}

.file_toolbar input,select {
	border: 1px solid #ccc;
	padding: 2px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}
input ,label { font-family:Tahoma,Verdana, Geneva, sans-serif; vertical-align:middle; font-size:12px; }
</style>
<link href="thirdModel/swfUpload/default.css" rel="stylesheet" type="text/css" />
<link href="skin/blue/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="thirdModel/swfUpload/swfupload.js" ></script>
<script type="text/javascript" src="thirdModel/swfUpload/swfupload.swfobject.js"></script>
<script type="text/javascript" src="thirdModel/swfUpload/swfupload.queue.js"></script>
<script type="text/javascript" src="thirdModel/swfUpload/fileprogress.js"></script>
<script type="text/javascript" src="thirdModel/swfUpload/handlers.js"></script>
</head>

<!--	<tr>
		<td class="titleContainer">
			顶部工具栏开
<div class="topToolBar">
	<div class="topToolBar_left"><span>文件分类</span></div>
	<div class="topToolBar_right">
		<a href="javascript:void(0)" id="" onclick="" class="blue_left"><span class="blue_right">上传文件</span></a>
	</div>
</div>
顶部工具栏结束
		</td>
	</tr>-->
	
		
			<table style="margin:0px;width:85%; height:60%; " border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" width="1">
					<!--tree开始-->
					<div class="treeContainer">
					    
						
						<a class="itm all'" href="javascript:void(0)"   id="tre_all" fatherId="all" suffix="all"><span class="itm_tu"><img src="Skin/default/all.png" /></span><span class="itm_tu">- </span>全部</a>
						<div id="mainTree" class="mainTree"></div>
					</div>
					<!--tree结束-->
					</td>
					<td valign="top">
					<!-- 搜索栏,已移至datagrid
						<div id="file_toolbar" class="file_toolbar" style="display:block;">
						    <table width="100%" height="25px" border="0" cellspacing="0" cellpadding="0" style="font-size:12px">
								<tr>
								   <td>
								   	文件名 <input type="text" id="txt_FileName" size="10" maxlength="20"	border-radius="3px";/>
								   文件大小 <input type="text"  id="txt_sFileSize" size="5" maxlength="10"/> 
								   到 <input type="text" size="5" maxlength="10"  id="txt_eFileSize"/>
								   备注 <input type="text" size="10" maxlength="50" id="txt_FileNotes"/>
								   <input type="button" id="but_selfie" onclick="selectFileList()"  value="查 询"/></td>
								</tr>
							 </table>
					</div> -->
					<!--Grid开始-->
					<div id="gridContainer" toolbar="#toolbar"></div>
					<div id="toolbar" style="padding:3px">
	
	    				<a id="add" class="easyui-linkbutton" plain="true" iconCls="icon-add" onclick="resources.update()">上传</a>
					    <a id="cut" class="easyui-linkbutton" plain="true" iconCls="icon-cut" onclick="program.deleteFiles()">删除</a>
					     <a id="save" class="easyui-linkbutton" plain="true" iconCls="icon-save" onclick="program.verify()">审核通过</a>
						 <a id="save" class="easyui-linkbutton" plain="true" iconCls="icon-save" onclick="program.verifyBack()">还原审核</a>
						<a id="save" class="easyui-linkbutton" plain="true" iconCls="icon-save" onclick='program.common()'>完全公开</a>
						<a id="save" class="easyui-linkbutton" plain="true" iconCls="icon-save" onclick='program.private()'>设为私有</a>
					    <!--<a id="save" class="easyui-linkbutton" plain="true" iconCls="icon-save" onclick='program.group()'>只向组员公开</a-->
					    <br>
						<span >|</span>
						<span>文件名</span>
					    <input id="txt_FileName" size="20">
					    <span>文件大小</span>
					    <input id="txt_sFileSize" size="6">
					    <span>到</span>
					    <input id="txt_eFileSize" size="6" >
					    <span>备注</span>
					    <input id="txt_FileNotes" size="10">
					    <a id="search"  class="easyui-linkbutton" plain="true" iconCls="icon-search" onclick="program.selectFileList()">查询</a>
					    
				</div>
					<!--Grid结束-->
					</td>
					<td class="flv_container" valign="top"><div id="flv_container" class="flv_container">
					
					<iframe class="flv_container" frameborder="0" id="flashIframe" oladPath="index.php?conbtrol=viewFile&action=index&tp=N&url='loadView.png'" src='index.php?control=viewFile&action=index&tp=N&url=loadView.png'></iframe>
					</div>
					<div class="fileOtherInfo" style="display:none"> 
						<li class="li_itm">播放时长:</li><li>300秒</li>
						<li class="li_itm">上传时间:</li><li>2010-9-25 19:36:31</li>
						<li class="li_itm">权限:</li><li>300秒</li>
						
						<li class="li_itm">备注:</li><li>300秒</li>
					</div>
					</td>
				</tr>
			</table>
		
	
	<!-- <tr>
		<td  class="bottomBarContainer">
			<div class="bottomBarContainer">
					<div class="topToolBar_left"><span></span></div>
					<div class="topToolBar_right">
							<a href="javascript:void(0)" id="upload_bt" class="blue_left"><span class="blue_right">上传</span></a>
							<a href="javascript:void(0)" id="delete_btn"  class="blue_left"><span class="blue_right">删除</span></a>
							<a href="javascript:void(0)" id="firPage" onclick="pageAtion(this)"  page="1" class="blue_left"><span class="blue_right">首页</span></a>
							<a href="javascript:void(0)" id="prvPage" onclick="pageAtion(this)"  page="-1" class="blue_left"><span class="blue_right">上一页</span></a>
							<a href="javascript:void(0)" id="nxtPage" onclick="pageAtion(this)"  page="1" class="blue_left"><span class="blue_right">下一页</span></a>
							<a href="javascript:void(0)" id="finPage" onclick="pageAtion(this)"  page="3000" class="blue_left"><span class="blue_right">尾页</span></a>
							<a href="javascript:void(0)"  page="3000" class="blue_left"><span class="blue_right">总页数:<strong id="totalpage"></strong></span></a>
							<a href="javascript:void(0)" id="verify" class="blue_left"><span class="blue_right">审核通过</span></a>
							<a href="javascript:void(0)" id="reverify" class="blue_left"><span class="blue_right">还原审核</span></a>
							
							<a href="javascript:void(0)" id="finPage" onclick="checkFtpSerAndFile()"  class="blue_left"><span class="blue_right">发送指定FTP</span></a>	
					</div>			
			</div>
		</td>
	</tr--> 


<script type="text/javascript">


var swfu;
/*
 
 * 
 * @description 加载上传组件
 * @param info Object {typeSuffix:"*.avi;*.mpg;*.mpeg;*.wmv;....",typeDescription:"Video",nodeId:"类型树节点ID"}
 * @author 2013-1-17 11:38:27 by bobo
 * 
 * 
 * 
 * */
function uploadUI(info){
	//alert("start upload")
	var str_type_Multitude="全部:*.avi;*.mpg;*.mpeg;*.wmv;*.vob;*.mov;*.mp4;*.asf;*.dat;*.ppt;*.flv;*.mkv;*.ts;*.rmvb;*.mp3;*.wma;*.midi;*.wav;*.gif;*.png;*.bmp;*.jpg;*.swf;*.htm;*.html;*.txt;*.bz2;*.bin;-??:*.avi;*.mpg;*.mpeg;*.wmv;*.vob;*.mov;*.mp4;*.asf;*.dat;*.ppt;*.flv;*.mkv;*.ts;*.rmvb;-??:*.mp3;*.wma;*.midi;*.wav;-??:*.gif;*.png;*.bmp;*.jpg;-??:*.swf;-???:*.htm;*.html;-Txt??:*.txt;-???:*.bz2;*.bin;",
		str_fileSuffix ="*.*",
		str_typeDescription = "All Files",
		str_nodeId="all",
		str_typeMultitude="";
	bug("uploadUI",print_r(info));
	if(info.hasOwnProperty("typeSuffix")){
		str_fileSuffix=info.typeSuffix;
	}
	if(info.hasOwnProperty("typeDescription")){
		str_typeDescription=info.typeDescription;
	}
	if(info.hasOwnProperty("nodeId")){
		str_nodeId=info.nodeId;
	}
	if(str_nodeId=="all"){
		str_typeMultitude=str_type_Multitude;
	}
	
		var _width=document.getElementById("btnUpload").clientWidth,
			_heith=document.getElementById("btnUpload").clientHeight;
			//alert(_width+" "+_heith)
		var settings = {
			flash_url : "thirdModel/swfUpload/flashUpload.swf",
			upload_url: "../../index.php?control=uploadfile&action=upFile&Uid=1&nodeId="+str_nodeId,
			file_size_limit : "2048 MB",
			file_post_name : "resume_file",
			file_types : str_fileSuffix,
			file_types_description : str_typeDescription,
			file_types_Multitude : str_typeMultitude,
			file_upload_limit : 0 ,
			file_queue_limit : 0,
			custom_settings : {
				progressTarget : "fsUploadProgress",
				cancelButtonId : "btnCancel"
			},
			debug: _Bool_,
	
			// Button Settings
			button_placeholder_id : "spanButtonPlaceholder",
			button_width: _width,
			button_height: _heith,
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,
			preserve_relative_urls:true,
	
			// The event handler functions are defined in handlers.js
			swfupload_loaded_handler : swfUploadLoaded,
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,
			queue_complete_handler : queueComplete,	// Queue plugin event
			
			// SWFObject settings
			minimum_flash_version : "11.1",
			swfupload_pre_load_handler : swfUploadPreLoad,
			swfupload_load_failed_handler : swfUploadLoadFailed
		};
	
		swfu = new SWFUpload(settings);
		
		
	
}
ready(function() {
	loadTree();
	//loadGrid();
	
});
</script>

</html>