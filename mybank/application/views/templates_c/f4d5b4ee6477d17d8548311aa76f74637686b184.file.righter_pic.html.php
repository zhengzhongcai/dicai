<?php /* Smarty version Smarty-3.1.8, created on 2017-03-27 17:27:24
         compiled from "D:\bankSct2\BANK\application/views\resource\righter_pic.html" */ ?>
<?php /*%%SmartyHeaderCode:2178758d8dafc4af748-85707092%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f4d5b4ee6477d17d8548311aa76f74637686b184' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\resource\\righter_pic.html',
      1 => 1390443086,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2178758d8dafc4af748-85707092',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RES_RIGHTER_PIC_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'optArr' => 0,
    'row' => 0,
    'RES_RIGHTER_TABLE_ID' => 0,
    'RES_RIGHTER_STATUS' => 0,
    'RES_RIGHTER_TABLE_FILENAME' => 0,
    'RES_RIGHTER_TABLE_FILESIZE' => 0,
    'RES_RIGHTER_TABLE_FILEPATH' => 0,
    'RES_RIGHTER_TABLE_ADDTIME' => 0,
    'RES_RIGHTER_TABLE_ADDUSER' => 0,
    'COMMON_CANCEL_UPLOAD' => 0,
    'RES_RIGHTER_PIC_UPLOAD' => 0,
    'COMMON_BOX_CHANGE' => 0,
    'COMMON_BOX_SAVA' => 0,
    'COMMON_BOX_CANCEL' => 0,
    'baseUrl' => 0,
    'RES_RIGHTER_CHECKED' => 0,
    'RES_RIGHTER_NOCHECK' => 0,
    'COMMON_CLICK_TO_PREVIEW' => 0,
    'COMMON_CANCEL_UPLOAD_FINISHED' => 0,
    'COMMON_TIP_CHOOSE_ONE_TO_EDIT' => 0,
    'RES_RIGHTER_TIP1' => 0,
    'COMMON_TIP_SAVE_SUCCESS' => 0,
    'COMMON_TIP_SAVE_FAILED' => 0,
    'COMMON_TIP_CHOOSE_DEL_ITEM' => 0,
    'COMMON_TIP_IS_DEL' => 0,
    'COMMON_TIP_DEL_SUCCESS' => 0,
    'COMMON_TIP_DEL_FAILED' => 0,
    'COMMON_TIP_EDIT_SUCCESS' => 0,
    'COMMON_TIP_EDIT_FAILED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58d8dafc594a46_27320855',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58d8dafc594a46_27320855')) {function content_58d8dafc594a46_27320855($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="javascript:showPopbox('addRes')" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_PIC_ADD']->value)===null||$tmp==='' ? "添加图片" : $tmp);?>
</a>
			<a auth="u" href="javascript:showPopbox('editRes')" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>
			<a auth="d" href="javascript:deleteRes()" class="tool_del statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEL']->value)===null||$tmp==='' ? "删除" : $tmp);?>
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
			<table id="tbCommonPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TABLE_ID']->value)===null||$tmp==='' ? "编号" : $tmp);?>
</th>
						<th width="5%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_STATUS']->value)===null||$tmp==='' ? "状态" : $tmp);?>
</th>
						<th width="15%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TABLE_FILENAME']->value)===null||$tmp==='' ? "文件名称" : $tmp);?>
</th>
						<th width="15%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TABLE_FILESIZE']->value)===null||$tmp==='' ? "文件大小" : $tmp);?>
</th>
						<th width="20%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TABLE_FILEPATH']->value)===null||$tmp==='' ? "文件路径" : $tmp);?>
</th>
						<th width="15%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TABLE_ADDTIME']->value)===null||$tmp==='' ? "录入时间" : $tmp);?>
</th>
						<th width="15%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TABLE_ADDUSER']->value)===null||$tmp==='' ? "录入用户代码" : $tmp);?>
</th>
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
		<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_PIC_ADD']->value)===null||$tmp==='' ? "添加图片" : $tmp);?>
</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body tbAddParamInfo">
		<table>
			<tr>
				<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TABLE_FILENAME']->value)===null||$tmp==='' ? "文件名称" : $tmp);?>
：</td>
				<td><input type="text" name="resname" /></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="fieldset flash" id="fsUploadProgress"></div>
					<div>
						<span id="spanButtonPlaceHolder"></span>
						<input id="btnCancel" type="button" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_CANCEL_UPLOAD']->value)===null||$tmp==='' ? "取消上传" : $tmp);?>
" onclick="swfu.cancelQueue();" disabled="disabled"/>
					</div>
					<div><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_PIC_UPLOAD']->value)===null||$tmp==='' ? "请上传jpg文件" : $tmp);?>
</div>
				</td>
			</tr>
		</table>
		<div class="pop_foot">
			<input id="editRes" onclick="editRes()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CHANGE']->value)===null||$tmp==='' ? "修改" : $tmp);?>
&nbsp;&nbsp;" class="btn_orange" />
			<input id="addRes" onclick="addRes()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hidePopbox()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
    </div>
</div>
<script>
	// 文件上传对象
	var swfu;
	window.onload = function () { // Do something... 	
		getResList();
		// 文件上传对象初始化
		var settings = {
			upload_url : "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=uploadRes",
			flash_url : "assets/SWFUpload/Flash/swfupload.swf",
			post_params: {"PHPSESSID" : "", "res_type":"2"},
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
			button_image_url: "assets/SWFUpload/upload.png",
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
	}
	
	// 获取资源列表
	function getResList(){
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=getResList";
		$.ajax({
			type: "post",
			url: url,
			data: 'res_type=2',
			success: function(data) {
				$('#tbCommonPram > tbody').html('');
				var resObjs = eval('(' + data + ')');
				var resStr = "";
				for (var idx in resObjs){
					resStr = generateRes(resObjs[idx]);
					$('#tbCommonPram > tbody').append(resStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateRes(res){
		var status;
		if (res.status == 1){
			status = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_CHECKED']->value)===null||$tmp==='' ? "已审核" : $tmp);?>
';
		}else{
			status = '<span style="color:red"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_NOCHECK']->value)===null||$tmp==='' ? "未审核" : $tmp);?>
<span>';
		}
	
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+res.id+'" type="checkbox" class="item"/></td>'+
						  '<td>'+res.id+'</td>'+
						  '<td>'+status+'</td>'+
						  '<td title="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_CLICK_TO_PREVIEW']->value)===null||$tmp==='' ? "点击预览" : $tmp);?>
"><span style="cursor:pointer" onclick="showRes(\''+res.name+'\',\'<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=checkRes&resid='+res.id+'\')">'+res.name+'</span></td>'+
						  '<td>'+res.size+'</td>'+
						  '<td>'+res.path+'</td>'+
						  '<td>'+res.create_time+'</td>'+
						  '<td>'+res.username+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	 
	// 展示路线封面
	function uploadSuccessRoute(file, serverData) {
		try {
			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.setComplete();
			progress.setStatus("<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_CANCEL_UPLOAD_FINISHED']->value)===null||$tmp==='' ? "完成上传." : $tmp);?>
");
			progress.toggleCancel(false);
		} catch (ex) {
			this.debug(ex);
		}
	}
	// 弹出添加输入框
	function showPopbox(type){
		$('#editRes').hide();
		$('#addRes').hide();
		$('#'+type).show();
		
		if ('editRes' == type){
			var checkedCnt = 0;
			var resid;
			$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
				if ('checked' == $(this).attr('checked')) 
				{
					resid = $(this).attr('id');
					checkedCnt++;
				}// if
			});
			
			if (checkedCnt > 1 || checkedCnt < 1) {
				alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_ONE_TO_EDIT']->value)===null||$tmp==='' ? "请选择其中一个进行编辑." : $tmp);?>
');
				return;
			}// if
			// 异步获取资源信息
			var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=getResInfo";
			$.ajax({
				type: "post",
				url: url,
				data: 'resid='+resid,
				success: function(data) {
					var resObj = eval('(' + data + ')');
					$('input[name="resname"]').val(resObj.name);
				}
			}); // ajax
		}
		
		$('.pop_box').css('display', 'block');
		// 删除临时资源
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=deleteTmpRes";
		$.ajax({
			type: "post",
			url: url,
			data: '',
			success: function(data) {}
		}); // ajax
		
	}// func
	// 取消添加输入框
	function hidePopbox(){
		$('.pop_box').css('display', 'none');
		$('.pop_box .tbAddParamInfo').find('input[type="text"],textarea').each(function(){
			$(this).val('');
		});
	}// func
	
	// 添加资源
	function addRes(){
		// 检查文件名是否填写
		var resname = $('input[name="resname"]').val();
		if ('' == resname) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TIP1']->value)===null||$tmp==='' ? "请输入文件名" : $tmp);?>
');
			return;
		}// if
		
		// 异步添加资源
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=storeRes";
		$.ajax({
			type: "post",
			url: url,
			data: 'res_type=2&res_name='+resname,
			success: function(data) {
				if (data > 0) {
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_SUCCESS']->value)===null||$tmp==='' ? "添加成功." : $tmp);?>
');
					getResList();
					hidePopbox();
				}
				else alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_FAILED']->value)===null||$tmp==='' ? "添加失败." : $tmp);?>
');		
			}
		}); // ajax
	}// func
	// 选择全部
	function toggleChooseAll(){
		var chooseAll = $('#checkControl').attr('checked');
		if ('checked' == chooseAll)
		{
			$('#tbCommonPram').find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#tbCommonPram').find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func
	
	// 删除资源
	function deleteRes(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = $(this).attr('id');
				i++;
			}
		});
		
		if (deleteItemArr.length == 0) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_DEL_ITEM']->value)===null||$tmp==='' ? "请选择需要删除的项." : $tmp);?>
');
			return;
		}// if
		
		if (!confirm('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_IS_DEL']->value)===null||$tmp==='' ? "确认删除!" : $tmp);?>
')) return;
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=deleteRes";
		$.ajax({
			type: "post",
			url: url,
			data: "resids=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data == '')
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "删除成功." : $tmp);?>
');
					getResList();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "删除失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
	
	// 修改资源
	function editRes(){
		// 检查文件名是否填写
		var resname = $('input[name="resname"]').val();
		if ('' == resname) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TIP1']->value)===null||$tmp==='' ? "请输入文件名" : $tmp);?>
');
			return;
		}// if
		
		var checkedCnt = 0;
		var resid;
		$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
			if ('checked' == $(this).attr('checked')) 
			{
				resid = $(this).attr('id');
				return;
			}
		});
		
		// 异步修改资源
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=updateRes";
		$.ajax({
			type: "post",
			url: url,
			data: 'res_type=2&res_name='+resname+'&resid='+resid,
			success: function(data) {
				if (data > 0) {
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_SUCCESS']->value)===null||$tmp==='' ? "修改成功." : $tmp);?>
');
					getResList();
					hidePopbox();
				}
				else alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_FAILED']->value)===null||$tmp==='' ? "修改失败." : $tmp);?>
');		
			}
		}); // ajax
	}// func
</script><?php }} ?>