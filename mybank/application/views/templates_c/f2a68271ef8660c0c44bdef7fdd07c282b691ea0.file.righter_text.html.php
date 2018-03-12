<?php /* Smarty version Smarty-3.1.8, created on 2014-01-23 10:12:14
         compiled from "G:\WWW\cdyh\application/views\resource\righter_text.html" */ ?>
<?php /*%%SmartyHeaderCode:452452dcd9ff951a22-92389085%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f2a68271ef8660c0c44bdef7fdd07c282b691ea0' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\resource\\righter_text.html',
      1 => 1390443129,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '452452dcd9ff951a22-92389085',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52dcd9ffae6ca6_75306447',
  'variables' => 
  array (
    'RES_RIGHTER_TEXT_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'optArr' => 0,
    'row' => 0,
    'RES_RIGHTER_TABLE_ID' => 0,
    'RES_RIGHTER_STATUS' => 0,
    'RES_RIGHTER_TABLE_FILEPATH' => 0,
    'RES_RIGHTER_TABLE_ADDTIME' => 0,
    'RES_RIGHTER_TABLE_ADDUSER' => 0,
    'baseUrl' => 0,
    'COMMON_TIP_CHOOSE_ONE_TO_EDIT' => 0,
    'RES_RIGHTER_CHECKED' => 0,
    'RES_RIGHTER_NOCHECK' => 0,
    'COMMON_CLICK_TO_PREVIEW' => 0,
    'COMMON_CANCEL_UPLOAD_FINISHED' => 0,
    'COMMON_TIP_CHOOSE_DEL_ITEM' => 0,
    'COMMON_TIP_IS_DEL' => 0,
    'COMMON_TIP_DEL_SUCCESS' => 0,
    'COMMON_TIP_DEL_FAILED' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52dcd9ffae6ca6_75306447')) {function content_52dcd9ffae6ca6_75306447($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="javascript:addText()" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TEXT_ADD']->value)===null||$tmp==='' ? "添加文本" : $tmp);?>
</a>
			<a auth="u" href="javascript:editText()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
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
						<th width="10%">文本名称</th>
						<th width="15%">文本大小</th>
						<!-- <th width="20%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TABLE_FILEPATH']->value)===null||$tmp==='' ? "文件路径" : $tmp);?>
</th> -->
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
<script>
	// 文件上传对象
	window.onload = function () { // Do something... 	
		getResList();
	}
	
	// 添加文本
	function addText(){
		var title = '添加文本';
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=addText";
		popWin.showWin("820","600",title,url);
	}
	
	// 编辑文本
	function editText(){
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
		
		var title = '编辑文本';
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=editText&resid="+resid;
		popWin.showWin("820","600",title,url);
	}
	
	// 获取资源列表
	function getResList(){
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=getResList";
		$.ajax({
			type: "post",
			url: url,
			data: 'res_type=3',
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
"><span style="cursor:pointer" onclick="showRes(\''+res.name+'\', \'<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=checkRes&resid='+res.id+'\')">'+res.name+'</span></td>'+
						  '<td>'+res.size+'</td>'+
						  //'<td>'+res.path+'</td>'+
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
</script><?php }} ?>