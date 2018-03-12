<?php /* Smarty version Smarty-3.1.8, created on 2015-07-25 15:25:37
         compiled from "E:\WWW\cdbank\application/views\device\righter_list.html" */ ?>
<?php /*%%SmartyHeaderCode:2895255b339f1865199-81310583%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '524ddb21807315c53b7f73eaabbbcc23929af071' => 
    array (
      0 => 'E:\\WWW\\cdbank\\application/views\\device\\righter_list.html',
      1 => 1376646354,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2895255b339f1865199-81310583',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'DEVICE_RIGHTER_TOOL_CATE' => 0,
    'type' => 0,
    'DEVICE_RIGHTER_TOOL_DMPJD' => 0,
    'DEVICE_RIGHTER_TOOL_PAD' => 0,
    'DEVICE_RIGHTER_TOOL_CLED' => 0,
    'DEVICE_RIGHTER_TOOL_MLED' => 0,
    'COMMON_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'DEVICE_RIGHTER_TIP1' => 0,
    'optArr' => 0,
    'row' => 0,
    'baseUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_55b339f190ab45_82957786',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55b339f190ab45_82957786')) {function content_55b339f190ab45_82957786($_smarty_tpl) {?>	<input id="orgId" type="hidden"/>
	<!----right---->
	<div class="right_box">  
		<!----tab 标签页---->
		<div class="mod_tab">
			<ul></ul>
		</div>
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_TOOL_CATE']->value)===null||$tmp==='' ? "设备类型" : $tmp);?>
:</span>
			<select id="deviceType" name="deviceType">
				<option value="Dmpdj" <?php if ($_smarty_tpl->tpl_vars['type']->value=="Dmpdj"){?>selected<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_TOOL_DMPJD']->value)===null||$tmp==='' ? "排队机" : $tmp);?>
</option>
				<option value="Pad" <?php if ($_smarty_tpl->tpl_vars['type']->value=="Pad"){?>selected<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_TOOL_PAD']->value)===null||$tmp==='' ? "呼叫器" : $tmp);?>
</option>
				<option value="Cled" <?php if ($_smarty_tpl->tpl_vars['type']->value=="Cled"){?>selected<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_TOOL_CLED']->value)===null||$tmp==='' ? "窗口LED" : $tmp);?>
</option>
				<option value="Mled" <?php if ($_smarty_tpl->tpl_vars['type']->value=="Mled"){?>selected<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_TOOL_MLED']->value)===null||$tmp==='' ? "主LED" : $tmp);?>
</option>
			</select>
			<a auth="c" href="javascript:showPopbox()" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_ADD']->value)===null||$tmp==='' ? "添加" : $tmp);?>
</a>
			<a auth="u" href="javascript:editOrgInfo()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>
			<a auth="d" href="javascript:deleteOrgInfo()" class="tool_del statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEL']->value)===null||$tmp==='' ? "删除" : $tmp);?>
</a>
		</div>
		<script>
			function showPopbox(){
				alert("<?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_TIP1']->value)===null||$tmp==='' ? "请选择网点." : $tmp);?>
");
			}// func
			
			function editOrgInfo(){
				alert("<?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_TIP1']->value)===null||$tmp==='' ? "请选择网点." : $tmp);?>
");
			}// func
			
			function deleteOrgInfo(){
				alert("<?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_TIP1']->value)===null||$tmp==='' ? "请选择网点." : $tmp);?>
");
			}// func
		
		</script>
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
		<div class="mod_table">
		</div>
		<!----table 表格 end----> 
	</div>
	<!----right end----> 
</div>
<!--content end-->
<script>
	// 获取网点设备基本信息
	function getDeviceInfo(orgId){
		var device = $('#deviceType').val();
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=device&action=get"+device+'List&fcode=device&orgId='+orgId+'&tabs='+orgId;
		location.href=url;
	}// func
</script><?php }} ?>