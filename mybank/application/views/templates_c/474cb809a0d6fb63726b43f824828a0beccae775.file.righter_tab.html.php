<?php /* Smarty version Smarty-3.1.8, created on 2015-07-25 14:59:41
         compiled from "E:\WWW\cdbank\application/views\monitor\righter_tab.html" */ ?>
<?php /*%%SmartyHeaderCode:2928455b333dd82ea00-68706709%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '474cb809a0d6fb63726b43f824828a0beccae775' => 
    array (
      0 => 'E:\\WWW\\cdbank\\application/views\\monitor\\righter_tab.html',
      1 => 1368241756,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2928455b333dd82ea00-68706709',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_55b333dd8325d4_67702809',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55b333dd8325d4_67702809')) {function content_55b333dd8325d4_67702809($_smarty_tpl) {?>  <!----right---->
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