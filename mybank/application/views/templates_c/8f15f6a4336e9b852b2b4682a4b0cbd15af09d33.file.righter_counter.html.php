<?php /* Smarty version Smarty-3.1.8, created on 2014-01-21 14:53:16
         compiled from "G:\WWW\cdyh\application/views\evalu\righter_counter.html" */ ?>
<?php /*%%SmartyHeaderCode:903352dcce4c53e361-79867096%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f15f6a4336e9b852b2b4682a4b0cbd15af09d33' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\evalu\\righter_counter.html',
      1 => 1390287192,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '903352dcce4c53e361-79867096',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52dcce4c69ab78_22349153',
  'variables' => 
  array (
    'EVALU_RIGHTER_FUZZY_NO_SEARCH' => 0,
    'EVALU_RIGHTER_FUZZY_SERIES_SEARCH' => 0,
    'EVALU_RIGHTER_CHOOSE' => 0,
    'itsOrgArr' => 0,
    'row' => 0,
    'EVALU_RIGHTER_ISUSE' => 0,
    'EVALU_RIGHTER_ISUSE_ON' => 0,
    'EVALU_RIGHTER_ISUSE_OFF' => 0,
    'EVALU_RIGHTER_STATUS' => 0,
    'EVALU_RIGHTER_STATUS_ON' => 0,
    'EVALU_RIGHTER_STATUS_OFF' => 0,
    'baseUrl' => 0,
    'COMMON_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'optArr' => 0,
    'EVALU_RIGHTER_DEVICE_NO' => 0,
    'EVALU_RIGHTER_DEVICE_SERIES' => 0,
    'EVALU_RIGHTER_JG' => 0,
    'EVALU_RIGHTER_COUNTER_NO' => 0,
    'EVALU_RIGHTER_IS_USE_ZIP' => 0,
    'EVALU_RIGHTER_ONLINE_VERSION' => 0,
    'COMMON_TIP_CHOOSE_ONE_TO_EDIT' => 0,
    'COMMON_TIP_CHOOSE_DEL_ITEM' => 0,
    'COMMON_TIP_IS_DEL' => 0,
    'COMMON_TIP_DEL_SUCCESS' => 0,
    'COMMON_TIP_DEL_FAILED' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52dcce4c69ab78_22349153')) {function content_52dcce4c69ab78_22349153($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">  
		<!----tool 工具条---->
		<div class="mob_tool">
			<input type="text" id="no" name="no" placeholder="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_FUZZY_NO_SEARCH']->value)===null||$tmp==='' ? "模糊查询编号" : $tmp);?>
" onchange="getCounterParam()">
			<input type="text" id="series" name="series" placeholder="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_FUZZY_SERIES_SEARCH']->value)===null||$tmp==='' ? "模糊查询序列号" : $tmp);?>
" onchange="getCounterParam()">
			<select name="itsOrgId" id="itsOrgId" onchange="getCounterParam()">
				<option value=""><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_CHOOSE']->value)===null||$tmp==='' ? "选择机构" : $tmp);?>
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
			<select name="isuse" id="isuse" onchange="getCounterParam()">
				<option value=""><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_ISUSE']->value)===null||$tmp==='' ? "是否启用" : $tmp);?>
</option>
				<option value="1"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_ISUSE_ON']->value)===null||$tmp==='' ? "启用" : $tmp);?>
</option>
				<option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_ISUSE_OFF']->value)===null||$tmp==='' ? "禁用" : $tmp);?>
</option>
			</select>
			<select name="status" id="status" onchange="getCounterParam()">
				<option value=""><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_STATUS']->value)===null||$tmp==='' ? "状态" : $tmp);?>
</option>
				<option value="1"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_STATUS_ON']->value)===null||$tmp==='' ? "在线" : $tmp);?>
</option>
				<option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_STATUS_OFF']->value)===null||$tmp==='' ? "掉线" : $tmp);?>
</option>
			</select>
			<!-- <a auth="c" href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=addEvalu" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_ADD']->value)===null||$tmp==='' ? "添加" : $tmp);?>
</a> -->
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
			<table id="tbCounterPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_DEVICE_NO']->value)===null||$tmp==='' ? "设备编号" : $tmp);?>
</th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_DEVICE_SERIES']->value)===null||$tmp==='' ? "设备序列号" : $tmp);?>
</th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_JG']->value)===null||$tmp==='' ? "所属网点" : $tmp);?>
</th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_COUNTER_NO']->value)===null||$tmp==='' ? "柜台编号" : $tmp);?>
</th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_IS_USE_ZIP']->value)===null||$tmp==='' ? "使用压缩包" : $tmp);?>
</th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_ONLINE_VERSION']->value)===null||$tmp==='' ? "在线版本" : $tmp);?>
</th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_ISUSE']->value)===null||$tmp==='' ? "是否启用" : $tmp);?>
</th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_STATUS']->value)===null||$tmp==='' ? "在线状态" : $tmp);?>
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
	window.onload=function(){
		//getCounterParam();
		timedCount();
	}
	
	function timedCount()
	{
		getCounterParam();
		t=setTimeout("timedCount()", 5000)
	}
	
	// 修改公共参数
	function editParamInfo(){
		var checkedCnt = 0;
		var paramId;
		$('#tbCounterPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
				if ('checked' == $(this).attr('checked')) 
				{
					console.dir($(this));
					paramId = $(this).attr('id');
					checkedCnt++;
				}// if
		});
		
		if (checkedCnt > 1 || checkedCnt < 1) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_ONE_TO_EDIT']->value)===null||$tmp==='' ? "请选择其中一个进行编辑." : $tmp);?>
');
			return;
		}// if
		
		// 进入编辑界面
		location.href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=editEvalu&eId="+paramId;
	}// func
	
	// 获取公共参数数据
	function getCounterParam(){
		var no = $('#no').val();
		var series = $('#series').val();
		var orgId = $('#itsOrgId').val();
		var status = $('#status').val();
		var isuse = $('#isuse').val();
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=getCounterParam";
		$.ajax({
			type: "post",
			url: url,
			data: 'orgId='+orgId+'&no='+no+'&status='+status+'&isuse='+isuse+'&series='+series,
			dataType:'json',
			success: function(data) {
			//console.log(data);
				$('#tbCounterPram > tbody').html('');
				var paramObjs = data;
				var paramStr = "";
				for (var idx in paramObjs){
					paramStr = generateParam(paramObjs[idx]);
					$('#tbCounterPram > tbody').append(paramStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateParam(paramInfo){
		var isuse;
		var status;
		if (1 == paramInfo.E_isuse) isuse = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_ISUSE_ON']->value)===null||$tmp==='' ? "启用" : $tmp);?>
';
		else isuse = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_ISUSE_OFF']->value)===null||$tmp==='' ? "禁用" : $tmp);?>
';
		
		if (1 == paramInfo.E_status) status = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_STATUS_ON']->value)===null||$tmp==='' ? "在线" : $tmp);?>
';
		else status = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_STATUS_OFF']->value)===null||$tmp==='' ? "掉线" : $tmp);?>
';
		
		
		var version;
		if (paramInfo.E_version == null) version = '';
		else version = paramInfo.E_version;
		
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+paramInfo.E_id+'" class="optCheck" type="checkbox"/></td>'+
						  '<td>'+paramInfo.E_no+'</td>'+
						  '<td>'+paramInfo.E_series+'</td>'+
						  '<td>'+paramInfo.JG_name+'</td>'+
						  '<td>'+paramInfo.C_no+'</td>'+
						  '<td>'+paramInfo.tpl_name+'</td>'+
						  '<td>'+version+'</td>'+
						  '<td>'+isuse+'</td>'+
						  '<td>'+status+'</td>'+
						  //'<td>'+paramInfo.C_lrtime.substr(0, paramInfo.C_lrtime.indexOf('.'))+'</td>'+
						  //'<td>'+paramInfo.C_lasttime.substr(0, paramInfo.C_lasttime.indexOf('.'))+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	
	// 选择全部
	function toggleChooseAll(){
		var chooseAll = $('#checkControl').attr('checked');
		if ('checked' == chooseAll)
		{
			$('#tbCounterPram').find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#tbCounterPram').find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func
	
	// 删除公共参数
	function deleteParamInfo(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbCounterPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = "'"+$(this).attr('id')+"'";
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
		
		var C_sysno = $('select[name="itsOrgId"]').val();
		//alert(C_sysno);return;
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=deleteCounterInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "删除成功." : $tmp);?>
');
					getCounterParam();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "删除失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
</script><?php }} ?>