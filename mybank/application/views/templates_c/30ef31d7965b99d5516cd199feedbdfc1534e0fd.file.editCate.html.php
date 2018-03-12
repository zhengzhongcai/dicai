<?php /* Smarty version Smarty-3.1.8, created on 2013-10-24 12:21:26
         compiled from "G:\WWW\webmark\application/views\resource\editCate.html" */ ?>
<?php /*%%SmartyHeaderCode:250525268a0468293d5-09522507%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '30ef31d7965b99d5516cd199feedbdfc1534e0fd' => 
    array (
      0 => 'G:\\WWW\\webmark\\application/views\\resource\\editCate.html',
      1 => 1376882141,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '250525268a0468293d5-09522507',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RES_RIGHTER_EDIT_CATE_NAME' => 0,
    'RES_RIGHTER_EDIT_CATE_SORT' => 0,
    'RES_RIGHTER_EDIT_CATE_COVER' => 0,
    'COMMON_CANCEL_UPLOAD' => 0,
    'RES_RIGHTER_PIC_UPLOAD' => 0,
    'cateid' => 0,
    'COMMON_ADD' => 0,
    'COMMON_EDIT' => 0,
    'baseUrl' => 0,
    'COMMON_CANCEL_UPLOAD_FINISHED' => 0,
    'RES_RIGHTER_EDIT_CATE_TIP1' => 0,
    'RES_RIGHTER_EDIT_CATE_TIP2' => 0,
    'COMMON_TIP_SAVE_SUCCESS' => 0,
    'COMMON_TIP_SAVE_FAILED' => 0,
    'COMMON_TIP_EDIT_SUCCESS' => 0,
    'COMMON_TIP_EDIT_FAILED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5268a046b063a9_09278413',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5268a046b063a9_09278413')) {function content_5268a046b063a9_09278413($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">
		<div style="margin-left:50px;margin-top:20px;">
			<div class="newsarea">
				<span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_CATE_NAME']->value)===null||$tmp==='' ? "名称" : $tmp);?>
：</span>
				<input type="text" name="cate_name">
			</div>
			<div>
				<span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_CATE_SORT']->value)===null||$tmp==='' ? "排序" : $tmp);?>
：</span>
				<input type="text" class="sortno" name="sortno" value="1">
			</div>
			<div style="margin-bottom:10px;"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_CATE_COVER']->value)===null||$tmp==='' ? "封面" : $tmp);?>
：</div>
			<div class="fieldset flash" id="fsUploadProgress"></div>
			<div>
				<span id="spanButtonPlaceHolder"></span>
				<input id="btnCancel" type="button" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_CANCEL_UPLOAD']->value)===null||$tmp==='' ? "取消上传" : $tmp);?>
" onclick="swfu.cancelQueue();" disabled="disabled"/>
			</div>
			<div><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_PIC_UPLOAD']->value)===null||$tmp==='' ? "请上传jpg文件" : $tmp);?>
</div>
			<img id="cateLogo" style="display:block;width:300px;height:200px;border:1px solid #000;margin-top:10px;margin-bottom:10px;" src="assets/images/nopic.png"/>
			<?php if (''==$_smarty_tpl->tpl_vars['cateid']->value){?>
			<button onclick="storeCate()" class="btn_orange"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_ADD']->value)===null||$tmp==='' ? "添加" : $tmp);?>
</button>
			<?php }else{ ?>
			<button onclick="updateCate(<?php echo $_smarty_tpl->tpl_vars['cateid']->value;?>
)" class="btn_orange"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "修改" : $tmp);?>
</button>
			<?php }?>
		</div>
	</div>
	<script>

	</script>
	<!----right end----> 
</div>
<!--content end-->
<link rel="stylesheet" href="assets/SWFUpload/default.css">
<script type="text/javascript" src="assets/SWFUpload/swfupload.js"></script>
<script type="text/javascript" src="assets/SWFUpload/plugins/swfupload.queue.js"></script>
<script type="text/javascript" src="assets/SWFUpload/fileprogress.js"></script>
<script type="text/javascript" src="assets/SWFUpload/handlers.js"></script>
<script>
	// 文件上传对象
	var swfu;
	window.onload = function () { // Do something... 	
		<?php if (''!=$_smarty_tpl->tpl_vars['cateid']->value){?>
		getNewsCate(<?php echo $_smarty_tpl->tpl_vars['cateid']->value;?>
);
		<?php }?>
		// 文件上传对象初始化
		var settings = {
			upload_url : "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=uploadCateLogo",
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
	
	// 获取新闻分类
	function getNewsCate(cateid){
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=getNewsCate";
		$.ajax({
			type: "post",
			url: url,
			data: 'cateid='+cateid,
			success: function(data) {
				var cateObj = JSON.parse(data);
				$('input[name="cate_name"]').val(cateObj.cate_name);
				$('input[name="sortno"]').val(cateObj.sortno);
				$('#cateLogo').attr('src', cateObj.img_path);
			}
		}); // ajax
	}// func
	
	// 添加分类
	function storeCate(){
		var catename = $('input[name="cate_name"]').val();
		if ("" == catename) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_CATE_TIP1']->value)===null||$tmp==='' ? "请输入分类名称." : $tmp);?>
');
			return;
		}
		
		var sortno = $('input[name="sortno"]').val();
		if ("" == sortno) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_CATE_TIP2']->value)===null||$tmp==='' ? "请输入排序号." : $tmp);?>
');
			return;
		}
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=storeCate";
		$.ajax({
			type: "post",
			url: url,
			data: 'catename='+catename+'&sortno='+sortno,
			success: function(data) {
				if (data > 0){
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_SUCCESS']->value)===null||$tmp==='' ? "添加成功." : $tmp);?>
');
					clearForm();
				}else{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_FAILED']->value)===null||$tmp==='' ? "添加失败." : $tmp);?>
');
				}
			}
		}); // ajax
	}// func
	
	// 清除表单
	function clearForm(){
		$('input[name="cate_name"]').val('');
		$('input[name="sortno"]').val('');
		$('#cateLogo').attr('src', 'assets/images/nopic.png');
	}// func
	
	// 修改分类
	function updateCate(cateid){
		var catename = $('input[name="cate_name"]').val();
		if ("" == catename) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_CATE_TIP1']->value)===null||$tmp==='' ? "请输入分类名称." : $tmp);?>
');
			return;
		}
		
		var sortno = $('input[name="sortno"]').val();
		if ("" == sortno) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_CATE_TIP2']->value)===null||$tmp==='' ? "请输入排序号." : $tmp);?>
');
			return;
		}
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=updateCate";
		$.ajax({
			type: "post",
			url: url,
			data: 'catename='+catename+'&cateid='+cateid+'&sortno='+sortno,
			success: function(data) {
				if (data > 0){
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_SUCCESS']->value)===null||$tmp==='' ? "修改成功." : $tmp);?>
');
				}else{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_FAILED']->value)===null||$tmp==='' ? "修改失败." : $tmp);?>
');
				}
			}
		}); // ajax
	}// func
</script><?php }} ?>