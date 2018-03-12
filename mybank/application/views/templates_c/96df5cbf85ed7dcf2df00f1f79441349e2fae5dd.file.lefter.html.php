<?php /* Smarty version Smarty-3.1.8, created on 2017-04-06 15:19:54
         compiled from "D:\bankSct2\BANK\application/views\device\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:529258c909fb391fb5-77350720%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '96df5cbf85ed7dcf2df00f1f79441349e2fae5dd' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\device\\lefter.html',
      1 => 1491462830,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '529258c909fb391fb5-77350720',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58c909fb3fa639_19550916',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c909fb3fa639_19550916')) {function content_58c909fb3fa639_19550916($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2>设备管理</h2>
      <div class="left_menu_tab">
        <ul>
          <li class="li1" style="width:100%"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=device" class="on">组织架构</a></li>
        </ul>
      </div>
      <div class="tree_menu" style="margin-top:50px;margin-right:8px;overflow-y: scroll;max-height: 600px;">
		<ul id="browser" class="filetree">
          <<?php ?>?php echo $session['orgtree']; ?<?php ?>>
		</ul>
	  </div>
      <div class="left_menu_tab">
        <ul>
          <li class="li1" style="width:100%"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=device&action=adMachine" class="on">广告机器</a></li>
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
  </script>
<?php }} ?>