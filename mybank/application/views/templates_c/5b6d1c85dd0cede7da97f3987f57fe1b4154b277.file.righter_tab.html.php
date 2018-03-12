<?php /* Smarty version Smarty-3.1.8, created on 2016-10-12 16:16:47
         compiled from "D:\WWW\cdbank\application/views\monitor\righter_tab.html" */ ?>
<?php /*%%SmartyHeaderCode:2755957fdf16f51f3b1-28267110%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b6d1c85dd0cede7da97f3987f57fe1b4154b277' => 
    array (
      0 => 'D:\\WWW\\cdbank\\application/views\\monitor\\righter_tab.html',
      1 => 1368241756,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2755957fdf16f51f3b1-28267110',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57fdf16f5214a4_37542626',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57fdf16f5214a4_37542626')) {function content_57fdf16f5214a4_37542626($_smarty_tpl) {?>  <!----right---->
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