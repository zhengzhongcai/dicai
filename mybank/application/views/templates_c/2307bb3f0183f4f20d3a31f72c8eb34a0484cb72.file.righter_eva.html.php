<?php /* Smarty version Smarty-3.1.8, created on 2017-04-06 14:34:34
         compiled from "D:\bankSct2\BANK\application/views\basedata\righter_eva.html" */ ?>
<?php /*%%SmartyHeaderCode:3135658e5e17a70c0f7-18624961%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2307bb3f0183f4f20d3a31f72c8eb34a0484cb72' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\basedata\\righter_eva.html',
      1 => 1376623584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3135658e5e17a70c0f7-18624961',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'baseUrl' => 0,
    'DATA_RIGHTER_COMMON_TAB1' => 0,
    'DATA_RIGHTER_COMMON_TAB2' => 0,
    'COMMON_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'optArr' => 0,
    'row' => 0,
    'DATA_RIGHTER_EVA_KEY' => 0,
    'DATA_RIGHTER_EVA_NAME' => 0,
    'DATA_RIGHTER_EVA_SCORE' => 0,
    'DATA_RIGHTER_EVA_WARNNING' => 0,
    'DATA_RIGHTER_EVA_SATI' => 0,
    'DATA_RIGHTER_EVA_POPBOX_TITLE' => 0,
    'COMMON_TEXT_YES' => 0,
    'COMMON_TEXT_NO' => 0,
    'COMMON_BOX_SAVA' => 0,
    'COMMON_BOX_CANCEL' => 0,
    'COMMON_TIP_SAVE_SUCCESS' => 0,
    'COMMON_TIP_SAVE_FAILED' => 0,
    'COMMON_TIP_CHOOSE_ONE_TO_EDIT' => 0,
    'COMMON_TIP_EDIT_SUCCESS' => 0,
    'COMMON_TIP_EDIT_FAILED' => 0,
    'COMMON_TIP_CHOOSE_DEL_ITEM' => 0,
    'COMMON_TIP_IS_DEL' => 0,
    'COMMON_TIP_DEL_SUCCESS' => 0,
    'COMMON_TIP_DEL_FAILED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58e5e17a8a5c94_49744974',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58e5e17a8a5c94_49744974')) {function content_58e5e17a8a5c94_49744974($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">  
		<!----title 标题栏 标签---->
		<div class="mod_title mod_title_nonebor">
			<ul class="title_tab">
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=commonParam&fcode=data-p"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_COMMON_TAB1']->value)===null||$tmp==='' ? "公共参数管理" : $tmp);?>
</a></li>
				<li><a href="javascript:void(0)" class="on"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_COMMON_TAB2']->value)===null||$tmp==='' ? "评价项目管理" : $tmp);?>
</a></li>
			</ul>
		</div>
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
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
			<table id="tbEvaPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="5%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_EVA_KEY']->value)===null||$tmp==='' ? "评价项目键值" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_EVA_NAME']->value)===null||$tmp==='' ? "评价项目名称" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_EVA_SCORE']->value)===null||$tmp==='' ? "分数" : $tmp);?>
</th>
						<th width="5%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_EVA_WARNNING']->value)===null||$tmp==='' ? "是否报警" : $tmp);?>
</th>
						<th width="5%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_EVA_SATI']->value)===null||$tmp==='' ? "是否满意" : $tmp);?>
</th>
						<!--
						<th width="40%">备注</th>
						<th width="10%">记录录入时间</th>
						<th width="10%">最后修改时间</th>
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
<div class="pop_box" style="display:none">
	<div class="pop_title">
		<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_EVA_POPBOX_TITLE']->value)===null||$tmp==='' ? "添加评价项目" : $tmp);?>
</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body tbAddParamInfo">
		<table>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_EVA_KEY']->value)===null||$tmp==='' ? "评价项目键值" : $tmp);?>
:</th>
				<td><input name="PJ_ID" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_EVA_NAME']->value)===null||$tmp==='' ? "评价项目名称" : $tmp);?>
:</th>
				<td><input name="PJ_NAME" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_EVA_SCORE']->value)===null||$tmp==='' ? "分数" : $tmp);?>
:</th>
				<td><input name="PJ_SCORE" type="number" style="width:60px" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_EVA_WARNNING']->value)===null||$tmp==='' ? "是否报警" : $tmp);?>
:</th>
				<td>
					<select name="PJ_WARNNING">
						<option value="1"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_YES']->value)===null||$tmp==='' ? "是" : $tmp);?>
</option>
						<option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_NO']->value)===null||$tmp==='' ? "否" : $tmp);?>
</option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_EVA_SATI']->value)===null||$tmp==='' ? "是否满意" : $tmp);?>
:</th>
				<td>
					<select name="PJ_isCaluMyl">
						<option value="1"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_YES']->value)===null||$tmp==='' ? "是" : $tmp);?>
</option>
						<option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_NO']->value)===null||$tmp==='' ? "否" : $tmp);?>
</option>
					</select>
				</td>
			</tr>
			<!--
			<tr>
				<th scope="row">备注:</th>
				<td><textarea name="PJ_bz" rows="4" cols="30"></textarea></td>
			</tr>
			-->
		</table>
		<div class="pop_foot">
			<input onclick="addParamInfo()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hidePopbox()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
    </div>
</div>
<script>
	var paramInfo = {
		PJ_ID:"",
		PJ_NAME:"",
		PJ_SCORE:"",
		PJ_WARNNING:"",
		PJ_isCaluMyl:"",
		PJ_bz:""
	};// 修改前保存参数原始信息
	window.onload=function(){
		getEvaParam();
	}
	// 获取公共参数数据
	function getEvaParam(){
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=getEvaParam";
		$.ajax({
			type: "post",
			url: url,
			data: '',
			success: function(data) {
				$('#tbEvaPram > tbody').html('');
				var paramObjs = eval('(' + data + ')');
				var paramStr = "";
				for (var idx in paramObjs){
					paramStr = generateParam(paramObjs[idx]);
					//alert(paramStr);
					$('#tbEvaPram > tbody').append(paramStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateParam(paramInfo){
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+paramInfo.PJ_ID+'" type="checkbox"/></td>'+
						  '<td>'+paramInfo.PJ_ID+'</td>'+
						  '<td>'+paramInfo.PJ_NAME+'</td>'+
						  '<td>'+paramInfo.PJ_SCORE+'</td>'+
						  '<td>'+paramInfo.PJ_WARNNING+'</td>'+
						  '<td>'+paramInfo.PJ_isCaluMyl+'</td>'+
						  //'<td>'+paramInfo.PJ_bz+'</td>'+
						  //'<td>'+paramInfo.PJ_lrtime.substr(0, paramInfo.PJ_lrtime.indexOf('.'))+'</td>'+
						  //'<td>'+paramInfo.PJ_lasttime.substr(0, paramInfo.PJ_lasttime.indexOf('.'))+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	
	// 弹出添加输入框
	function showPopbox(){
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
/index.php?control=basedata&action=addEvaInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData,
			success: function(data) {
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_SUCCESS']->value)===null||$tmp==='' ? "添加成功." : $tmp);?>
');
					getEvaParam();
					hidePopbox();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_FAILED']->value)===null||$tmp==='' ? "添加失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
	
	// 修改公共参数
	function editParamInfo(){
		var checkedCnt = 0;
		var paramId;
		$('#tbEvaPram').find('input[type="checkbox"]').each(function(){
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
		
		var isEdit = $('#isEdit').val();
		if (isEdit-0) return;
		else $('#isEdit').val(1);
		
		var i = 1;
		$('#'+paramId).parent().nextAll().each(function(){
			var content = $(this).html();
			switch (i){
				case 1:
					paramInfo.PJ_ID = content;
					$(this).html('<input type="text" name="PJ_ID" value="'+content+'"/>');
					break;
				case 2:
					paramInfo.PJ_NAME = content;
					$(this).html('<input type="text" name="PJ_NAME" value="'+content+'"/>');
					break;
				case 3:
					paramInfo.PJ_SCORE = content;
					$(this).html('<input type="number" name="PJ_SCORE" value="'+content+'"/>');
					break;
				case 4:
					paramInfo.PJ_WARNNING = content;
					if (content > 0)
						$(this).html('<select name="PJ_WARNNING"><option value="1" selected><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_YES']->value)===null||$tmp==='' ? "是" : $tmp);?>
</option><option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_NO']->value)===null||$tmp==='' ? "不是" : $tmp);?>
</option></select>');
					else 
						$(this).html('<select name="PJ_WARNNING"><option value="1"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_YES']->value)===null||$tmp==='' ? "是" : $tmp);?>
</option><option value="0" selected><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_NO']->value)===null||$tmp==='' ? "不是" : $tmp);?>
</option></select>');
					break;
				case 5:
					paramInfo.PJ_isCaluMyl = content;
					if (content > 0) 
						$(this).html('<select name="PJ_isCaluMyl"><option value="1" selected><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_YES']->value)===null||$tmp==='' ? "是" : $tmp);?>
</option><option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_NO']->value)===null||$tmp==='' ? "不是" : $tmp);?>
</option></select>');
					else
						$(this).html('<select name="PJ_isCaluMyl"><option value="1"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_YES']->value)===null||$tmp==='' ? "是" : $tmp);?>
</option><option value="0" selected><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_NO']->value)===null||$tmp==='' ? "不是" : $tmp);?>
</option></select>');
						$(this).append('&nbsp;<input class="btn_orange" type="button" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
" onclick="saveParamInfo()"><input class="btn_gray" type="button" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
" onclick="resetParamInfo()">');
					break;
			}// switch
			i++;
		});
	}// func
	
	// 选择全部
	function toggleChooseAll(){
		var chooseAll = $('#checkControl').attr('checked');
		if ('checked' == chooseAll)
		{
			$('#tbEvaPram').find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#tbEvaPram').find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func
	
	// 保存参数的修改
	function saveParamInfo(){
		var postData = getPostData($('#tbEvaPram'));
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=saveEvaInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "paramId=" + paramInfo.PJ_ID,
			success: function(data) {
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_SUCCESS']->value)===null||$tmp==='' ? "修改成功." : $tmp);?>
');
					getEvaParam();
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
		getEvaParam();
		$('#isEdit').val(0);
	}// func
	
	// 删除公共参数
	function deleteParamInfo(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbEvaPram').find('input[type="checkbox"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = "'"+$(this).attr('id')+"'";
				i++;
			}
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
/index.php?control=basedata&action=deleteEvaInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "删除成功." : $tmp);?>
');
					getEvaParam();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "删除失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
</script><?php }} ?>