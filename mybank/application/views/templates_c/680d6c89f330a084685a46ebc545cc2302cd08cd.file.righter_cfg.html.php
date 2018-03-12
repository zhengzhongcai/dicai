<?php /* Smarty version Smarty-3.1.8, created on 2017-03-28 17:05:26
         compiled from "D:\bankSct2\BANK\application/views\resource\righter_cfg.html" */ ?>
<?php /*%%SmartyHeaderCode:2350358da2756bbb881-59215099%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '680d6c89f330a084685a46ebc545cc2302cd08cd' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\resource\\righter_cfg.html',
      1 => 1390390600,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2350358da2756bbb881-59215099',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RES_RIGHTER_VIDEO_ADD' => 0,
    'COMMON_EDIT' => 0,
    'RES_RIGHTER_SETCHECK' => 0,
    'optArr' => 0,
    'row' => 0,
    'baseUrl' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58da2756c6c032_58777657',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58da2756c6c032_58777657')) {function content_58da2756c6c032_58777657($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">
		<!----tool 工具条---->
		<div class="mob_tool">
			<!--<a auth="c" href="javascript:showPopbox('addRes')" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_VIDEO_ADD']->value)===null||$tmp==='' ? "添加视频" : $tmp);?>
</a>-->
			<!--<a auth="u" href="javascript:showPopbox('editRes')" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>
			<a auth="u" href="javascript:setCheck()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_SETCHECK']->value)===null||$tmp==='' ? "通过审核" : $tmp);?>
</a>-->
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
			<form action="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=storeCfg" method="post" enctype="multipart/form-data" onsubmit="return checkConfig()">
				<table>
					<tr>
						<td width="200">切换到信息发布页面的时间：</td>
						<td><input type="text" id="toPublish" name="toPublish" value="<?php echo $_smarty_tpl->tpl_vars['config']->value->toPublish;?>
" style="width:100px">(秒)</td>
					</tr>
					<tr>
						<td width="200">切换到查询系统页面的时间：</td>
						<td><input type="text" id="toSelect" name="toSelect" value="<?php echo $_smarty_tpl->tpl_vars['config']->value->toSelect;?>
" style="width:100px">(秒)</td>
					</tr>
					<tr>
						<td width="200">信息发布页面图片切换时间：</td>
						<td><input type="text" id="pptpic" name="pptpic" value="<?php echo $_smarty_tpl->tpl_vars['config']->value->pptpic;?>
" style="width:100px">(秒)</td>
					</tr>
					<tr>
						<td width="200">上传评价页面语音文件：</td>
						<td><input type="file" id="apprise" name="apprise" accept="audio/mpeg">(文件名必须为:apprise.mp3)</td>
					</tr>
					<tr>
						<td width="200">上传欢迎页面语音文件：</td>
						<td><input type="file" id="welcome" name="welcome" accept="audio/mpeg">(文件名必须为:welcome.mp3)</td>
					</tr>
					<tr>
						<td width="200">上传谢谢您页面语音文件：</td>
						<td><input type="file" id="thanks" name="thanks" accept="audio/mpeg">(文件名必须为:thanks.mp3)</td>
					</tr>
				</table>
				<input type="submit" value="保存">
			</form>
		</div>
		<!----table 表格 end----> 
	</div>
	<!----right end----> 
</div>
<!--content end-->
<script>
	function checkConfig(){
		var toPublish = $('#toPublish').val();
		var toSelect = $('#toSelect').val();
		var pptpic = $('#pptpic').val();
		
		if (toPublish == '' || toPublish < 1){
			alert('请输入正确的切换到信息发布页面的时间.');
			return false;
		}
		
		if (toSelect == '' || toSelect < 1){
			alert('请输入正确的切换到查询系统页面的时间.');
			return false;
		}
		
		if (pptpic == '' || pptpic < 1){
			alert('请输入正确的信息发布页面图片切换时间.');
			return false;
		}
		/*
		var apprise = $('#apprise').val();
		var welcome = $('#welcome').val();
		var thanks = $('#thanks').val();
		
		if (apprise == '') {
			alert("请选择评价页面的语音文件.");
			return false;
		}
		
		if (welcome == '') {
			alert("请选择欢迎页面的语音文件.");
			return false;
		}
		
		if (thanks == '') {
			alert("请选择谢谢您页面的语音文件.");
			return false;
		}
		*/
	}
</script><?php }} ?>