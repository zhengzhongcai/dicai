<?php /* Smarty version Smarty-3.1.8, created on 2013-11-04 11:54:42
         compiled from "G:\WWW\webmark\application/views\evalu\righter_addevalu.html" */ ?>
<?php /*%%SmartyHeaderCode:29559526dd935bbf8c4-43242841%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '445defbd9daf69d1e372f21198a0cd0afc6b8d05' => 
    array (
      0 => 'G:\\WWW\\webmark\\application/views\\evalu\\righter_addevalu.html',
      1 => 1383537217,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29559526dd935bbf8c4-43242841',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_526dd935c74155_84655909',
  'variables' => 
  array (
    'orgInfos' => 0,
    'row' => 0,
    'tplInfos' => 0,
    'baseUrl' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_526dd935c74155_84655909')) {function content_526dd935c74155_84655909($_smarty_tpl) {?>	<!----right---->
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
				<td>编号：</td>
				<td><input type="text" id="no" name="no" placeholder="请输入设备编号"></td>
			</tr>
			<tr>
				<td>序列号：</td>
				<td><input type="text" id="series" name="series" placeholder="请输入设备序列号"></td>
			</tr>
			<tr>
				<td>所属网点：</td>
				<td>
					<select name="JG_ID" id="JG_ID" onchange="getCounter()">
						<option value="0">请选择</option>
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['orgInfos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['JG_ID'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['JG_name'];?>
</option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>所属柜台：</td>
				<td>
					<select name="C_no" id="C_no">
						<option value="0">请选择</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>使用模板：</td>
				<td>
					<select name="T_id" id="T_id">
						<option value="0">请选择</option>
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tplInfos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['tpl_name'];?>
</option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>更新时间：</td>
				<td>
					<input type="time" name="update" id="update">
				</td>
			</tr>
			<tr>
				<td>是否启用：</td>
				<td>
					<input type="radio" name="isuse" value="1" checked>启用
					<input type="radio" name="isuse" value="0">禁用
				</td>
			</tr>
		</table>
		<input onclick="addEvaluInfo()" type="button" value="添加" style="margin:12px" />
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
				var optionStr = '<option value="0">请选择</option>'
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

	function addEvaluInfo(){
		var no = $('#no').val();
		var series = $('#series').val();
		
		if (no === ''){
			alert('请输入设备编号.');
			return;
		}// func
		
		if (series === ''){
			alert('请输入设备序列号');
			return;
		}// func
		
		var jg = $('#JG_ID').val();
		var tpl = $('#T_id').val();
		var update = $('#update').val();
		var isuse = $('input[name="isuse"]').val();
		var cno = $('#C_no').val();
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=saveEvalu";
		$.ajax({
			type: "post",
			url: url,
			data: "no="+no+'&series='+series+'&JG_ID='+jg+'&T_id='+tpl+'&update='+update+'&isuse='+isuse+'&cno='+cno,
			dataType:'json',
			success: function(data) {
				if (data > 0) alert('添加成功.');
				else alert('添加失败.');
			}
		}); // ajax
	}// func
</script><?php }} ?>