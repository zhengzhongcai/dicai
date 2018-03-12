<?php /* Smarty version Smarty-3.1.8, created on 2017-04-06 10:03:44
         compiled from "D:\bankSct2\BANK\application/views\basedata\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:1796658c909f72cc660-57590538%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eaf1d81a536fc08ca708810b5988b71de23132f0' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\basedata\\lefter.html',
      1 => 1491444219,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1796658c909f72cc660-57590538',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58c909f73628e0_24760472',
  'variables' => 
  array (
    'baseUrl' => 0,
    'action' => 0,
    'DATA_LEFTER_MANAGE_PARAM1' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c909f73628e0_24760472')) {function content_58c909f73628e0_24760472($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2>数据管理</h2>
      
      <div class="left_menu_a_list">
        <ul>
			<li auth="96" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=basedata&action=serialParam&fcode=data-b" >业务管理</a></li>
			<li auth="100" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=basedata&action=serverParam&fcode=data-t" >柜员管理</a></li>
			<li auth="104" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=basedata&action=counterParam&fcode=data-c" >柜台管理</a></li>
			<li auth="108" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=basedata&action=vipParam&fcode=data-v" >VIP客户资料管理</a></li>
			<li auth="112" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=basedata&action=commonParam&fcode=data-p" >公共参数管理</a></li>
          <!--  <li auth="data-p" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=lookimage&action=index" <?php if ($_smarty_tpl->tpl_vars['action']->value=="commonParam"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_LEFTER_MANAGE_PARAM1']->value)===null||$tmp==='' ? "查看图片" : $tmp);?>
</a></li>-->
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