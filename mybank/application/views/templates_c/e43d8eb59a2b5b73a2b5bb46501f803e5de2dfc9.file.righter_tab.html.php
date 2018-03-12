<?php /* Smarty version Smarty-3.1.8, created on 2017-03-15 10:01:50
         compiled from "D:\bankSct2\BANK\application/views\monitor\righter_tab.html" */ ?>
<?php /*%%SmartyHeaderCode:2398158c8a08e643572-56243555%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e43d8eb59a2b5b73a2b5bb46501f803e5de2dfc9' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\monitor\\righter_tab.html',
      1 => 1368241756,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2398158c8a08e643572-56243555',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58c8a08e645183_67669964',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c8a08e645183_67669964')) {function content_58c8a08e645183_67669964($_smarty_tpl) {?>  <!----right---->
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