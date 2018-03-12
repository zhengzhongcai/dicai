<?php /* Smarty version Smarty-3.1.8, created on 2014-01-22 19:55:05
         compiled from "G:\WWW\cdyh\application/views\evalu\righter_addtask.html" */ ?>
<?php /*%%SmartyHeaderCode:3057752dfb1998ea6a4-42416065%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c02aa516c949a935a2b8b1483809a104820d289e' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\evalu\\righter_addtask.html',
      1 => 1384418946,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3057752dfb1998ea6a4-42416065',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'itsOrgArr' => 0,
    'row' => 0,
    'baseUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52dfb1999bbea6_40205770',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52dfb1999bbea6_40205770')) {function content_52dfb1999bbea6_40205770($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">  
		<div class="mob_tool" style="padding:12px;margin:0px;border-bottom:solid #DCDCDC 1px">
			<a href="javascript:history.go(-1)">返回</a>
		</div>
		<style>
			table{margin:12px;}
			table tr{height:30px;line-height:30px;}
		</style>
		<table>
			<tr>
				<td>所属网点：</td>
				<td>
					<select name="JG_ID" id="JG_ID">
						<option value="0">请选择</option>
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
				<td>更新时间：</td>
				<td>
					<input type="time" name="updatetime" id="updatetime">
				</td>
			</tr>
		</table>
		<input onclick="addTaskInfo()" type="button" value="添加" style="margin:12px" />
	</div>
</div>
<!--content end-->
<script>
	function addTaskInfo(){
		var jgId = $('#JG_ID').val();
		var updatetime = $('#updatetime').val();
		
		if (jgId == 0){
			alert('请选择机构.');
			return;
		}// func
		
		if (updatetime == ''){
			alert('请输入信息包更新时间');
			return;
		}// func
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=saveTask";
		$.ajax({
			type: "post",
			url: url,
			data: 'jgId='+jgId+'&updatetime='+updatetime,
			success: function(data) {
				if (data > 0) alert('添加成功.');
				else alert('添加失败.');
			}
		}); // ajax
	}// func
</script><?php }} ?>