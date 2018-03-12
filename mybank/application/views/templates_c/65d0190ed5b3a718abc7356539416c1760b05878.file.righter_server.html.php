<?php /* Smarty version Smarty-3.1.8, created on 2017-03-27 10:18:42
         compiled from "D:\bankSct2\BANK\application/views\basedata\righter_server.html" */ ?>
<?php /*%%SmartyHeaderCode:1257058d876829199b0-03304533%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '65d0190ed5b3a718abc7356539416c1760b05878' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\basedata\\righter_server.html',
      1 => 1489549419,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1257058d876829199b0-03304533',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'baseUrl' => 0,
    'COMMON_DEFAULT' => 0,
    'itsOrgArr' => 0,
    'row' => 0,
    'COMMON_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'optArr' => 0,
    'DATA_RIGHTER_STAFF_NUMBER' => 0,
    'DATA_RIGHTER_STAFF_NAME' => 0,
    'DATA_RIGHTER_STAFF_AGENTID' => 0,
    'DATA_RIGHTER_STAFF_POPBOX_TITLE' => 0,
    'DATA_RIGHTER_STAFF_BMNAME' => 0,
    'DATA_RIGHTER_STAFF_GWNAME' => 0,
    'DATA_RIGHTER_STAFF_PORTTRAIT' => 0,
    'COMMON_CANCEL_UPLOAD' => 0,
    'DATA_RIGHTER_STAFF_UPLOAD_TIP' => 0,
    'COMMON_BOX_SAVA' => 0,
    'COMMON_BOX_CHANGE' => 0,
    'COMMON_BOX_CANCEL' => 0,
    'DATA_RIGHTER_STAFF_POPBOX_ADD_TITLE' => 0,
    'COMMON_TIP_SAVE_SUCCESS' => 0,
    'COMMON_TIP_SAVE_FAILED11' => 0,
    'COMMON_TIP_CHOOSE_ONE_TO_EDIT' => 0,
    'DATA_RIGHTER_STAFF_POPBOX_EDIT_TITLE' => 0,
    'COMMON_TIP_EDIT_SUCCESS' => 0,
    'COMMON_TIP_EDIT_FAILED' => 0,
    'COMMON_TIP_CHOOSE_DEL_ITEM' => 0,
    'COMMON_TIP_IS_DEL' => 0,
    'COMMON_TIP_DEL_SUCCESS' => 0,
    'COMMON_TIP_DEL_FAILED' => 0,
    'COMMON_CANCEL_UPLOAD_FINISHED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58d87682ac44a8_52272285',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58d87682ac44a8_52272285')) {function content_58d87682ac44a8_52272285($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">  
		<!----title 标题栏 标签---->
		<!--
		<div class="mod_title mod_title_nonebor">
			<ul class="title_tab">
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=serialParam">业务清单</a></li>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=vipParam">VIP客户资料管理</a></li>
				<li><a href="javascript:void(0)" class="on">柜员管理</a></li>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=counterParam">柜台管理</a></li>
			</ul>
		</div>
		-->
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<select name="itsOrgId" id="itsOrgId" onchange="getServerParam()">
				<option value=""><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEFAULT']->value)===null||$tmp==='' ? "默认" : $tmp);?>
</option>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['itsOrgArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['sysno'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['sysname'];?>
</option>
				<?php } ?>
			</select>
			<a auth="c" href="javascript:showPopbox()" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_ADD']->value)===null||$tmp==='' ? "添加" : $tmp);?>
</a>
			<a auth="u" href="javascript:editParamInfo()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>
			<a auth="d" href="javascript:deleteParamInfo()" class="tool_del statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEL']->value)===null||$tmp==='' ? "删除" : $tmp);?>
</a>
		</div>
		<script>
			<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['optArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
				$('a[auth="<?php echo $_smarty_tpl->tpl_vars['row']->value['Operation'];?>
"]').css('display', 'inline-block');
			<?php } ?>
		</script>
		<!----tool 工具条 end---->
		<!----table 表格---->
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<table id="tbServerPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="30%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_STAFF_NUMBER']->value)===null||$tmp==='' ? "柜员工号" : $tmp);?>
</th>
						<th width="30%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_STAFF_NAME']->value)===null||$tmp==='' ? "柜员名称" : $tmp);?>
</th>
						<th width="35%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_STAFF_AGENTID']->value)===null||$tmp==='' ? "所属机构代码" : $tmp);?>
</th>
						<!--
						<th width="5%">星级</th>
						<th width="20%">备注</th>
						<th width="15%">添加时间</th>
						-->
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<!----table 表格 end----> 
	</div>
	<!----right end----> 
</div>
<!--content end-->
<link rel="stylesheet" href="assets/SWFUpload/default.css">
<script type="text/javascript" src="assets/SWFUpload/swfupload.js"></script>
<script type="text/javascript" src="assets/SWFUpload/plugins/swfupload.queue.js"></script>
<script type="text/javascript" src="assets/SWFUpload/fileprogress.js"></script>
<script type="text/javascript" src="assets/SWFUpload/handlers.js"></script>
<div class="pop_box" style="display:none">
	<div class="pop_title">
		<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_STAFF_POPBOX_TITLE']->value)===null||$tmp==='' ? "添加柜员资料" : $tmp);?>
</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body tbAddParamInfo">
		<table>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_STAFF_NUMBER']->value)===null||$tmp==='' ? "柜员工号" : $tmp);?>
:</th>
				<td><input name="S_no" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_STAFF_NAME']->value)===null||$tmp==='' ? "柜员名称" : $tmp);?>
:</th>
				<td><input name="S_name" type="text" style="width:160px" /></td>
			</tr>
            <tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_STAFF_BMNAME']->value)===null||$tmp==='' ? "部门名称" : $tmp);?>
:</th>
				<td><input name="S_bz" type="text" style="width:160px" /></td>
			</tr>
             <tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_STAFF_GWNAME']->value)===null||$tmp==='' ? "岗位名称" : $tmp);?>
:</th>
				<td><input name="S_gwname" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_STAFF_AGENTID']->value)===null||$tmp==='' ? "所属机构代码" : $tmp);?>
:</th>
				<td>
					<select name="S_sysno">
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['itsOrgArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['sysno'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['sysname'];?>
</option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_STAFF_PORTTRAIT']->value)===null||$tmp==='' ? "柜员头像" : $tmp);?>
:</th>
				<td>
					<div class="fieldset flash" id="fsUploadProgress"></div>
					<div>
						<span id="spanButtonPlaceHolder"></span>
						<input id="btnCancel" type="button" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_CANCEL_UPLOAD']->value)===null||$tmp==='' ? "取消上传" : $tmp);?>
" onclick="swfu.cancelQueue();" disabled="disabled"/>
					</div>
					<div><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_STAFF_UPLOAD_TIP']->value)===null||$tmp==='' ? "请上传jpg文件" : $tmp);?>
</div>
					<img id="cateLogo" style="display:block;width:300px;height:200px;border:1px solid #000;margin-top:10px;margin-bottom:10px;" src="assets/images/nopic.png"/>
				</td>
			</tr>
			
		</table>
		<div class="pop_foot">
			<input id="addParamInfo" onclick="addParamInfo()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
&nbsp;&nbsp;" class="btn_orange" />
			<input id="saveParamInfo" style="display:none" onclick="saveParamInfo()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CHANGE']->value)===null||$tmp==='' ? "修改" : $tmp);?>
&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hidePopbox()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
    </div>
</div>
<script>
	var paramInfo = {
		S_no:""
	};// 修改前保存参数原始信息
	window.onload=function(){
		//getServerParam();
	}
	// 获取公共参数数据
	function getServerParam(){
		// 获取网点id
		var orgId = $('#itsOrgId').val();
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=getServerParam";
		$.ajax({
			type: "post",
			url: url,
			data: 'orgId='+orgId,
			success: function(data) {
				//alert(data);return;
				$('#tbServerPram > tbody').html('');
				var paramObjs = eval('(' + data + ')');
				var paramStr = "";
				for (var idx in paramObjs){
					paramStr = generateParam(paramObjs[idx]);
					//alert(paramStr);
					$('#tbServerPram > tbody').append(paramStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateParam(paramInfo){
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+paramInfo.S_no+'" class="optCheck" type="checkbox"/></td>'+
						  '<td>'+paramInfo.S_no+'</td>'+
						  '<td>'+paramInfo.S_name+'</td>'+
						  '<td>'+paramInfo.S_sysno+'</td>'+
						  //'<td>'+paramInfo.S_star+'</td>'+
						  //'<td>'+paramInfo.S_bz+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	
	// 弹出添加输入框
	function showPopbox(){
		// 修改title
		$('.pop_title > h3').html('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_STAFF_POPBOX_ADD_TITLE']->value)===null||$tmp==='' ? "添加柜员资料" : $tmp);?>
');
		$('#saveParamInfo').css('display', 'none');
		$('#addParamInfo').css('display', 'inline-block');
		$('#cateLogo').attr('src', $.trim('assets/images/nopic.png'));
		var orgid = $('[name=itsOrgId]').val();
		if(orgid.length>0){
			$('.pop_box [name=S_sysno]').val(orgid);
		}
		$('.pop_box').css('display', 'block');
	}// func
	// 取消添加输入框
	function hidePopbox(){
		$('.pop_box').css('display', 'none');
		$('.pop_box .tbAddParamInfo').find('input[type="text"],input[type="number"],textarea').each(function(){
			$(this).val('');
		});
	}// func
	
	// 添加参数信息
	function addParamInfo(){
		var postData = getPostData($('.pop_box .tbAddParamInfo'));
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=addServerInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData,
			success: function(data) {
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_SUCCESS']->value)===null||$tmp==='' ? "添加成功." : $tmp);?>
');
				//	getServerParam();
					//hidePopbox();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_FAILED11']->value)===null||$tmp==='' ? "添加失败." : $tmp);?>
');
					
			}
		}); // ajax
	}// func
	
	// 修改公共参数
	function editParamInfo(){
		var checkedCnt = 0;
		var paramId;
		$('#tbServerPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
				if ('checked' == $(this).attr('checked')) 
				{
					paramId = $(this).attr('id');
					checkedCnt++;
				}// if
		});
		
		if (checkedCnt > 1 || checkedCnt < 1) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_ONE_TO_EDIT']->value)===null||$tmp==='' ? "请选择其中一个进行编辑." : $tmp);?>
');
			return;
		}// if
		
		// 显示编辑框
		$('.pop_box').css('display', 'block');
		// 修改title
		$('.pop_title > h3').html('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_STAFF_POPBOX_EDIT_TITLE']->value)===null||$tmp==='' ? "修改柜员资料" : $tmp);?>
');
		// 显示修改按钮
		$('#addParamInfo').css('display', 'none');
		$('#saveParamInfo').css('display', 'inline-block');
		
		
		paramInfo.S_no = paramId;
		// 异步获取员工信息
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=getServerInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "sno=" + paramId,
			success: function(data) {
				var sObj = JSON.parse(data);
				$('input[name="S_no"]').val(sObj.S_no);
				$('input[name="S_name"]').val(sObj.S_name);
				var orgSelect = '';
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['itsOrgArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
				if (sObj.S_sysno == '<?php echo $_smarty_tpl->tpl_vars['row']->value['sysno'];?>
')
					orgSelect += '<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['sysno'];?>
" selected><?php echo $_smarty_tpl->tpl_vars['row']->value['sysname'];?>
</option>';
				else
					orgSelect += '<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['sysno'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['sysname'];?>
</option>';
				<?php } ?>
				$('select[name="S_sysno"]').html(orgSelect);
				if ($.trim(sObj.S_photoPath) == "") $('#cateLogo').attr('src', $.trim('assets/images/nopic.png'));
				else $('#cateLogo').attr('src', $.trim(sObj.S_photoPath));
			}
		}); // ajax
	}// func
	
	// 选择全部
	function toggleChooseAll(){
		var chooseAll = $('#checkControl').attr('checked');
		if ('checked' == chooseAll)
		{
			$('#tbServerPram').find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#tbServerPram').find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func
	
	// 保存参数的修改
	function saveParamInfo(){
		//var postData = getPostData($('#tbServerPram'));
		var postData = getPostData($('.pop_box .tbAddParamInfo'));
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=saveServerInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "paramId=" + paramInfo.S_no,
			success: function(data) {
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_SUCCESS']->value)===null||$tmp==='' ? "修改成功." : $tmp);?>
');
					getServerParam();
					$('#isEdit').val(0);
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_FAILED']->value)===null||$tmp==='' ? "修改失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
	
	// 取消参数编辑
	function resetParamInfo(){
		getServerParam();
		$('#isEdit').val(0);
	}// func
	
	// 删除公共参数
	function deleteParamInfo(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbServerPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = "'"+$(this).attr('id')+"'";
				i++;
			}//
		});
		
		if (deleteItemArr.length == 0)
		{
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_DEL_ITEM']->value)===null||$tmp==='' ? "请选择需要删除的项." : $tmp);?>
');
			return;
		}// if
		
		if (!confirm('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_IS_DEL']->value)===null||$tmp==='' ? "确认删除!" : $tmp);?>
')) return;
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=deleteServerInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				//alert(data);return;
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "删除成功." : $tmp);?>
');
					getServerParam();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "删除失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
</script>

<script>
	// 文件上传对象
	var swfu;
	window.onload = function () { // Do something... 	
		// 文件上传对象初始化
		var settings = {
			upload_url : "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=uploadStaffPic",
			flash_url : "assets/SWFUpload/Flash/swfupload.swf",
			post_params: {"PHPSESSID" : ""},
			file_size_limit : "100 MB",
			file_types : "*.jpg",
			file_types_description : "All Files",
			file_upload_limit : 100,
			file_queue_limit : 1,
			custom_settings : {
				progressTarget : "fsUploadProgress",
				cancelButtonId : "btnCancel"
			},
			debug: false,

			// Button settings
			button_image_url: "assets/SWFUpload/upload_pic.png",
			button_width: "80px",
			button_height: "40px",
			button_placeholder_id: "spanButtonPlaceHolder",
			button_text: '',
			button_text_style: ".button{color:red}",
			button_text_left_padding: 12,
			button_text_top_padding: 3,
			
			// The event handler functions are defined in handlers.js
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccessRoute,
			upload_complete_handler : uploadComplete,
			queue_complete_handler : queueComplete	// Queue plugin event
		};
		swfu = new SWFUpload(settings);
	}//
	
	// 展示路线封面
	function uploadSuccessRoute(file, serverData) {
		try {
			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.setComplete();
			progress.setStatus("<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_CANCEL_UPLOAD_FINISHED']->value)===null||$tmp==='' ? "完成上传." : $tmp);?>
");
			progress.toggleCancel(false);
			$('#cateLogo').attr('src', $.trim(serverData));
		} catch (ex) {
			this.debug(ex);
		}
	}// func
</script><?php }} ?>