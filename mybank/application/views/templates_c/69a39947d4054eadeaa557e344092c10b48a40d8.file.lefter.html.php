<?php /* Smarty version Smarty-3.1.8, created on 2017-04-07 11:41:10
         compiled from "D:\bankSct2\BANK\application/views\authority\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:1702158c89ff9b5d4b7-68682221%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '69a39947d4054eadeaa557e344092c10b48a40d8' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\authority\\lefter.html',
      1 => 1491536461,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1702158c89ff9b5d4b7-68682221',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58c89ff9bb2452_04005741',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c89ff9bb2452_04005741')) {function content_58c89ff9bb2452_04005741($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2>权限管理</h2>
      
      <div class="left_menu_a_list">
        <ul>
          <li auth="208" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=authority&fcode=authority-u" >用户管理</a></li>
		  <li auth="204" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=authority&action=role&fcode=authority-r" >角色管理</a></li>
		  <li auth="212" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=authority&action=log&fcode=authority-l" >日志管理</a></li>
        </ul>
      </div>
    </div>
    
</div>
<a onclick="hiddenLeft()" class="hidden_left" style="background-color:#EEECED"></a>
  <!----left end----> 
  <script>
    <<?php ?>?php foreach($www as $val): ?<?php ?>>
    $('li[auth="<<?php ?>?php echo $val['menurole_id'];?<?php ?>>"]').css('display', 'block');
    <<?php ?>?php endforeach;?<?php ?>>
  </script><?php }} ?>