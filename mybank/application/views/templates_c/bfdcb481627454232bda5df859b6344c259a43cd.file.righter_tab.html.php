<?php /* Smarty version Smarty-3.1.8, created on 2014-01-20 15:20:38
         compiled from "G:\WWW\cdyh\application/views\monitor\righter_tab.html" */ ?>
<?php /*%%SmartyHeaderCode:878052dcce46b5ae30-70672180%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bfdcb481627454232bda5df859b6344c259a43cd' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\monitor\\righter_tab.html',
      1 => 1368241754,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '878052dcce46b5ae30-70672180',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52dcce46b5d2f3_89428606',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52dcce46b5d2f3_89428606')) {function content_52dcce46b5d2f3_89428606($_smarty_tpl) {?>  <!----right---->
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