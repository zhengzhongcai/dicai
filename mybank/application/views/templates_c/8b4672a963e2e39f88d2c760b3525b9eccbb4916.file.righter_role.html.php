<?php /* Smarty version Smarty-3.1.8, created on 2015-07-25 15:31:52
         compiled from "E:\WWW\cdbank\application/views\authority\righter_role.html" */ ?>
<?php /*%%SmartyHeaderCode:1853755b33b685bec88-21867937%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b4672a963e2e39f88d2c760b3525b9eccbb4916' => 
    array (
      0 => 'E:\\WWW\\cdbank\\application/views\\authority\\righter_role.html',
      1 => 1376894942,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1853755b33b685bec88-21867937',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'COMMON_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'optArr' => 0,
    'row' => 0,
    'AUTH_RIGHTER_ROLEID' => 0,
    'AUTH_RIGHTER_NAME' => 0,
    'AUTH_RIGHTER_CHANGE_TIME' => 0,
    'AUTH_RIGHTER_ADDTIME' => 0,
    'AUTH_RIGHTER_ADD_ROLE' => 0,
    'authlist' => 0,
    'COMMON_BOX_SAVA' => 0,
    'COMMON_BOX_CANCEL' => 0,
    'AUTH_RIGHTER_EDIT_ROLE' => 0,
    'baseUrl' => 0,
    'AUTH_RIGHTER_TIP1' => 0,
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
  'unifunc' => 'content_55b33b686857c4_84708353',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55b33b686857c4_84708353')) {function content_55b33b686857c4_84708353($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">  
		<!----title 标题栏 标签---->
		<div class="mod_title mod_title_nonebor">
			
		</div>
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="javascript:showPopbox()" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_ADD']->value)===null||$tmp==='' ? "添加" : $tmp);?>
</a>
			<a auth="u" href="javascript:editParamInfo()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>
			<a auth="d"href="javascript:deleteParamInfo()" class="tool_del statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEL']->value)===null||$tmp==='' ? "删除" : $tmp);?>
</a>
		</div>
		<!----tool 工具条 end---->
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
		<!----table 表格---->
		<!--
		<input type="hidden" id="isEdit" value="0"/>
		-->
		<div class="mod_table">
			<table id="tbCommonPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_ROLEID']->value)===null||$tmp==='' ? "角色ID" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_NAME']->value)===null||$tmp==='' ? "角色名称" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_CHANGE_TIME']->value)===null||$tmp==='' ? "修改时间" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_ADDTIME']->value)===null||$tmp==='' ? "添加时间" : $tmp);?>
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
<div id="popupadd" class="pop_box" style="display:none;height:auto;">
	<div class="pop_title">
		<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_ADD_ROLE']->value)===null||$tmp==='' ? "添加角色" : $tmp);?>
</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body" id="tbAddParamInfo">
		<div id="authChoose" style="height:500px;overflow-y:auto">
			<?php echo $_smarty_tpl->tpl_vars['authlist']->value;?>

		</div>
		<div class="pop_foot">
			<input onclick="addParamInfo()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hidePopbox()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
    </div>
</div>

<!--content end-->
<div id="popupedit" class="pop_box" style="display:none">
	<div class="pop_title">
		<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_EDIT_ROLE']->value)===null||$tmp==='' ? "修改角色" : $tmp);?>
</h3>
		<a href="javascript:hideEditPopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body" id="tbEditParamInfo">
		<div id="authUpdate" style="height:500px;overflow-y:auto">
		</div>
		<div class="pop_foot">
			<input onclick="saveParamInfo()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hideEditPopbox()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
    </div>
</div>

<script>
	var paramInfo = {
		R_ID:""
	};// 修改前保存参数原始信息
	window.onload=function(){
		getCommonParam();
	}
	
	// 获取公共参数数据
	function getCommonParam(){
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=getRoles";
		$.ajax({
			type: "post",
			url: url,
			data: '',
			success: function(data) {
				$('#tbCommonPram > tbody').html('');
				var paramObjs = eval('(' + data + ')');
				var paramStr = "";
				for (var idx in paramObjs){
					paramStr = generateParam(paramObjs[idx]);
					$('#tbCommonPram > tbody').append(paramStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateParam(paramInfo){
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+paramInfo.R_ID+'" class="optCheck" type="checkbox"/></td>'+
						  '<td>'+paramInfo.R_ID+'</td>'+
						  '<td>'+paramInfo.R_name+'</td>'+
						  '<td>'+paramInfo.R_lasttime.substr(0, paramInfo.R_lasttime.indexOf('.'))+'</td>'+
						  '<td>'+paramInfo.R_lrtime.substr(0, paramInfo.R_lrtime.indexOf('.'))+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	
	// 弹出添加输入框
	function showPopbox(){
		$('#popupadd').css('display', 'block');
	}// func
	// 取消添加输入框
	function hidePopbox(){
		$('#popupadd').css('display', 'none');
		$('#tbAddParamInfo').find('input[type="text"],input[type="checkbox"],textarea').each(function(){
			$(this).val('');
			$(this).removeAttr('checked');
		});
	}// func
	
	// 取消添加输入框
	function hideEditPopbox(){
		$('#popupedit').css('display', 'none');
		$('#tbEditParamInfo').find('input[type="text"],textarea').each(function(){
			$(this).val('');
		});
	}// func
	
	
	// 添加参数信息
	function addParamInfo(){
		var postData = getPostData($('#authChoose'));
		if ('' == $('input[name="R_name"]').val()){
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_TIP1']->value)===null||$tmp==='' ? "请添加角色名." : $tmp);?>
');
			return;
		}// if
		//alert(postData);return;
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=addRoleInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData,
			success: function(data) {
				//alert(data);return;
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_SUCCESS']->value)===null||$tmp==='' ? "添加成功." : $tmp);?>
');
					getCommonParam();
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
		$('#tbCommonPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
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
		
		//var isEdit = $('#isEdit').val();
		//if (isEdit-0) return;
		//else $('#isEdit').val(1);
		
		paramInfo.R_ID = paramId;
		
		$('#popupedit').css('display', 'block');
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=getRoleInfo";
		$.ajax({
			type: "post",
			url: url,
			data: 'R_ID='+paramId,
			success: function(data) {
				var roleObj = eval('(' + data + ')');
				$('#authUpdate').html(roleObj.auths);
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
	
	// 保存参数的修改
	function saveParamInfo(){
		var postData = getPostData($('#tbEditParamInfo'));
		//alert(postData);return;
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=saveRoleInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "paramId=" + paramInfo.R_ID,
			success: function(data) {
				//alert(data);return;
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_SUCCESS']->value)===null||$tmp==='' ? "修改成功." : $tmp);?>
');
					getCommonParam();
					//$('#isEdit').val(0);
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_FAILED']->value)===null||$tmp==='' ? "修改失败." : $tmp);?>
');
					
				hideEditPopbox();
			}
		}); // ajax
	}// func
	
	// 取消参数编辑
	function resetParamInfo(){
		getCommonParam();
		//$('#isEdit').val(0);
	}// func
	
	// 删除公共参数
	function deleteParamInfo(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbCommonPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
			if ('checked' == $(this).attr('checked')) 
			{
				deleteItemArr[i] = $(this).attr('id');
				i++;
			}// if
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
/index.php?control=authority&action=deleteRoleInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				//alert(data);return;
				if (data == '' || typeof data == 'undefined')
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "删除成功." : $tmp);?>
');
					getCommonParam();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "删除失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
</script><?php }} ?>