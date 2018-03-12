<?php /* Smarty version Smarty-3.1.8, created on 2014-01-23 14:57:51
         compiled from "G:\WWW\cdyh\application/views\evalu\righter_editevalu.html" */ ?>
<?php /*%%SmartyHeaderCode:2961452dfaa839be537-71449803%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fca1a542c4cb8a1abefb723fd45c05fabf22d7ea' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\evalu\\righter_editevalu.html',
      1 => 1390460251,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2961452dfaa839be537-71449803',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52dfaa83c2c557_11943596',
  'variables' => 
  array (
    'EVALU_RIGHTER_BACK' => 0,
    'EVALU_RIGHTER_DEVICE_NO' => 0,
    'EVALU_RIGHTER_INPUT_NO_TIP' => 0,
    'evalu' => 0,
    'EVALU_RIGHTER_DEVICE_SERIES' => 0,
    'EVALU_RIGHTER_INPUT_SERIES_TIP' => 0,
    'EVALU_RIGHTER_JG' => 0,
    'EVALU_RIGHTER_CHOOSE_TIP' => 0,
    'itsOrgArr' => 0,
    'row' => 0,
    'EVALU_RIGHTER_COUNTER_NO' => 0,
    'cnos' => 0,
    'EVALU_RIGHTER_IS_USE_ZIP' => 0,
    'tplInfos' => 0,
    'EVALU_RIGHTER_UPDATE_TIME' => 0,
    'EVALU_RIGHTER_ISUSE' => 0,
    'EVALU_RIGHTER_ISUSE_ON' => 0,
    'EVALU_RIGHTER_ISUSE_OFF' => 0,
    'COMMON_BOX_CHANGE' => 0,
    'baseUrl' => 0,
    'eId' => 0,
    'COMMON_TIP_EDIT_SUCCESS' => 0,
    'COMMON_TIP_EDIT_FAILED' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52dfaa83c2c557_11943596')) {function content_52dfaa83c2c557_11943596($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">  
		<div class="mob_tool" style="padding:12px;margin:0px;border-bottom:solid #DCDCDC 1px">
			<a href="javascript:history.go(-1)"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_BACK']->value)===null||$tmp==='' ? "返回" : $tmp);?>
</a>
		</div>
		<style>
			table{margin:12px;}
			table tr{height:30px;line-height:30px;}
		</style>
		<table>
			<tr>
				<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_DEVICE_NO']->value)===null||$tmp==='' ? "设备编号" : $tmp);?>
：</td>
				<td><input type="text" id="no" name="no" placeholder="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_INPUT_NO_TIP']->value)===null||$tmp==='' ? "请输入设备编号" : $tmp);?>
" value="<?php echo $_smarty_tpl->tpl_vars['evalu']->value['E_no'];?>
"></td>
			</tr>
			<tr>
				<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_DEVICE_SERIES']->value)===null||$tmp==='' ? "设备序列号" : $tmp);?>
：</td>
				<td><input type="text" disabled size="50" id="series" name="series" placeholder="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_INPUT_SERIES_TIP']->value)===null||$tmp==='' ? "请输入设备序列号" : $tmp);?>
" value="<?php echo $_smarty_tpl->tpl_vars['evalu']->value['E_series'];?>
"></td>
			</tr>
			<tr>
				<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_JG']->value)===null||$tmp==='' ? "所属网点" : $tmp);?>
：</td>
				<td>
					<select name="JG_ID" id="JG_ID" onchange="getCounter(<?php echo $_smarty_tpl->tpl_vars['evalu']->value['C_no'];?>
)">
						<option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_CHOOSE_TIP']->value)===null||$tmp==='' ? "请选择" : $tmp);?>
</option>
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['itsOrgArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['row']->value['sysno']==$_smarty_tpl->tpl_vars['evalu']->value['JG_ID']){?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['sysno'];?>
" selected><?php echo $_smarty_tpl->tpl_vars['row']->value['sysname'];?>
</option>
						<?php }else{ ?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['sysno'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['sysname'];?>
</option>
						<?php }?>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_COUNTER_NO']->value)===null||$tmp==='' ? "所属柜台" : $tmp);?>
：</td>
				<td>
					<select name="C_no" id="C_no">
						<option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_CHOOSE_TIP']->value)===null||$tmp==='' ? "请选择" : $tmp);?>
</option>
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cnos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['row']->value['C_no']==$_smarty_tpl->tpl_vars['evalu']->value['C_no']){?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['C_no'];?>
" selected><?php echo $_smarty_tpl->tpl_vars['row']->value['C_no'];?>
</option>
						<?php }else{ ?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['C_no'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['C_no'];?>
</option>
						<?php }?>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_IS_USE_ZIP']->value)===null||$tmp==='' ? "使用模板" : $tmp);?>
：</td>
				<td>
					<select name="T_id" id="T_id">
						<option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_CHOOSE_TIP']->value)===null||$tmp==='' ? "请选择" : $tmp);?>
</option>
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tplInfos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['row']->value['id']==$_smarty_tpl->tpl_vars['evalu']->value['T_id']){?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" selected><?php echo $_smarty_tpl->tpl_vars['row']->value['tpl_name'];?>
</option>
						<?php }else{ ?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['tpl_name'];?>
</option>
						<?php }?>
						<?php } ?>
					</select>
				</td>
			</tr>
			<!--
			<tr>
				<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_UPDATE_TIME']->value)===null||$tmp==='' ? "更新时间" : $tmp);?>
：</td>
				<td>
					<input type="time" name="update" id="update" value="<?php echo $_smarty_tpl->tpl_vars['evalu']->value['E_update'];?>
">
				</td>
			</tr>
			-->
			<tr>
				<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_ISUSE']->value)===null||$tmp==='' ? "是否启用" : $tmp);?>
：</td>
				<td>
					<select id="isuse" name="isuse">
						<option value="1" <?php if ($_smarty_tpl->tpl_vars['evalu']->value['E_isuse']==1){?>selected<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_ISUSE_ON']->value)===null||$tmp==='' ? "启用" : $tmp);?>
</option>
						<option value="0" <?php if ($_smarty_tpl->tpl_vars['evalu']->value['E_isuse']==0){?>selected<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_ISUSE_OFF']->value)===null||$tmp==='' ? "禁用" : $tmp);?>
</option>
					</select>
				</td>
			</tr>
		</table>
		<input onclick="editEvaluInfo()" type="button" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CHANGE']->value)===null||$tmp==='' ? "修改" : $tmp);?>
" style="margin:12px"/>
	</div>
</div>
<!--content end-->
<script>
	// 异步获取网点对应的窗口数据
	function getCounter(cno){
		// 获取网点id
		var orgId = $('#JG_ID').val();
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=getCounterParam";
		$.ajax({
			type: "post",
			url: url,
			data: 'orgId='+orgId,
			dataType:'json',
			success: function(data) {
				var optionStr = '<option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_CHOOSE_TIP']->value)===null||$tmp==='' ? "请选择" : $tmp);?>
</option>';
				for (var idx in data){
					var item = data[idx];
					if (cno == item.C_no){
						optionStr = optionStr+'<option value="'+item.C_no+'" selected>'+item.C_no+'</option>';
					}else{
						optionStr = optionStr+'<option value="'+item.C_no+'">'+item.C_no+'</option>';
					}
				}// for
				
				$('#C_no').html(optionStr);
			}
		}); // ajax
	}

	function editEvaluInfo(){
		var no = $('#no').val();
		var series = $('#series').val();
		var eId = '<?php echo $_smarty_tpl->tpl_vars['eId']->value;?>
';
		
		if (no === ''){
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_INPUT_NO_TIP']->value)===null||$tmp==='' ? "请输入设备编号" : $tmp);?>
.');
			return;
		}// func
		
		if (series === ''){
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_INPUT_SERIES_TIP']->value)===null||$tmp==='' ? "请输入设备序列号" : $tmp);?>
.');
			return;
		}// func
		
		var jg = $('#JG_ID').val();
		var tpl = $('#T_id').val();
		var update = $('#update').val();
		if (update == 'undefined') update = '';
		var isuse = $('#isuse').val();
		var cno = $('#C_no').val();
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=saveEvalu";
		$.ajax({
			type: "post",
			url: url,
			//data: "no="+no+'&series='+series+'&JG_ID='+jg+'&T_id='+tpl+'&update='+update+'&isuse='+isuse+'&eId='+eId+'&cno='+cno,
			data: "no="+no+'&series='+series+'&JG_ID='+jg+'&T_id='+tpl+'&isuse='+isuse+'&eId='+eId+'&cno='+cno,
			dataType:'json',
			success: function(data) {
				if (data > 0) alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_SUCCESS']->value)===null||$tmp==='' ? "修改成功." : $tmp);?>
');
				else alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_FAILED']->value)===null||$tmp==='' ? "修改失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
</script><?php }} ?>