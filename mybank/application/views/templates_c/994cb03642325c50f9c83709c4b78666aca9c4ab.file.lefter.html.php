<?php /* Smarty version Smarty-3.1.8, created on 2017-04-06 17:42:57
         compiled from "D:\bankSct2\BANK\application/views\evalu\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:1457958c90a05917122-09631367%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '994cb03642325c50f9c83709c4b78666aca9c4ab' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\evalu\\lefter.html',
      1 => 1491471772,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1457958c90a05917122-09631367',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58c90a059f4dc1_26914206',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c90a059f4dc1_26914206')) {function content_58c90a059f4dc1_26914206($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2>信息发布</h2>
      
      <div class="left_menu_a_list">
        <ul>
			<li auth="224" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=evalu&action=counterParam&fcode=evalu-l" >评价器清单</a></li>
			<li auth="228" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=evalu&action=task&fcode=evalu-l" >任务管理</a></li>
			<li auth="290" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=evalu&action=templateManage&fcode=evalu-l" >模块管理作</a></li>
			<li auth="292" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=evalu&action=profileManage&fcode=evalu-l" >节目管理</a></li>
			<li auth="294" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=evalu&action=projectManage&fcode=evalu-l" >播放计划管理</a></li>
			<li auth="296" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=evalu&action=fastManage&fcode=evalu-l" >快速创建节目</a></li>
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