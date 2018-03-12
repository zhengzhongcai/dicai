<?php /* Smarty version Smarty-3.1.8, created on 2013-08-19 16:27:17
         compiled from "G:\WWW\webmark\application/views\monitor\righter_tab.html" */ ?>
<?php /*%%SmartyHeaderCode:237675211d6e503fe29-83190106%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f5ebafc27898d8020f49377069211be87a4c00d8' => 
    array (
      0 => 'G:\\WWW\\webmark\\application/views\\monitor\\righter_tab.html',
      1 => 1368241754,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '237675211d6e503fe29-83190106',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5211d6e50422e8_29156646',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5211d6e50422e8_29156646')) {function content_5211d6e50422e8_29156646($_smarty_tpl) {?>  <!----right---->
  <div class="right_box">  
    <!----tab 标签页---->
    <div class="mod_tab">
      <ul>
      </ul>
    </div>
	
	<script>
		// 找出网点数据
		function tabChange(elem){
			$(elem).parent().children("li").each(function(){
				$(this).removeClass('on');
			});
			$(elem).addClass('on');
		}// func
		
		// 删除网点tab
		function deleteTab(elem){
			$(elem).parent().remove();
		}// func
	
	</script>
    <!----tab 标签页 end----> <?php }} ?>