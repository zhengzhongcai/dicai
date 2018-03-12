<?php /* Smarty version Smarty-3.1.8, created on 2017-04-05 10:19:25
         compiled from "D:\bankSct2\BANK\application/views\monitor\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:2649858c8a08e59e540-30541266%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'baf76a54d6c9a22e23652b6c6a393d896298560e' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\monitor\\lefter.html',
      1 => 1491358761,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2649858c8a08e59e540-30541266',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58c8a08e6350b2_60154225',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c8a08e6350b2_60154225')) {function content_58c8a08e6350b2_60154225($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box" style="min-height:800px;">
    <div class="left_menu">
      <h2>实时监控</h2>
      <div class="left_menu_tab">
        <ul>
          <li class="li1" style="width:100%"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=monitor&fcode=monitor">组织架构</a></li>
	  <li class="li1" style="width:100%"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=monitor&fcode=monitor&action=map">地图</a></li>
        </ul>
      </div>

      <div class="tree_menu" style="margin-top:50px;margin-right:8px;overflow-y: scroll;max-height: 600px;">
		<ul id="browser" class="filetree">

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