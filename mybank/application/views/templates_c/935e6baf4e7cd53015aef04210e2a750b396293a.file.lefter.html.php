<?php /* Smarty version Smarty-3.1.8, created on 2015-07-25 15:31:49
         compiled from "E:\WWW\cdbank\application/views\authority\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:1090655b33b65cf7721-21670214%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '935e6baf4e7cd53015aef04210e2a750b396293a' => 
    array (
      0 => 'E:\\WWW\\cdbank\\application/views\\authority\\lefter.html',
      1 => 1390292394,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1090655b33b65cf7721-21670214',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'AUTH_LEFTER_MENU_TITLE' => 0,
    'baseUrl' => 0,
    'action' => 0,
    'AUTH_LEFTER_MENU_MANAGER_USER' => 0,
    'AUTH_LEFTER_MENU_MANAGER_ROLE' => 0,
    'fcodeArr' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_55b33b65d70701_34796773',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55b33b65d70701_34796773')) {function content_55b33b65d70701_34796773($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_LEFTER_MENU_TITLE']->value)===null||$tmp==='' ? "权限管理" : $tmp);?>
</h2>
      
      <div class="left_menu_a_list">
        <ul>
          <li auth="authority-u" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&fcode=authority-u" <?php if ($_smarty_tpl->tpl_vars['action']->value=="user"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_LEFTER_MENU_MANAGER_USER']->value)===null||$tmp==='' ? "用户管理" : $tmp);?>
</a></li>
		  <li auth="authority-r" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=role&fcode=authority-r" <?php if ($_smarty_tpl->tpl_vars['action']->value=="role"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_LEFTER_MENU_MANAGER_ROLE']->value)===null||$tmp==='' ? "角色管理" : $tmp);?>
</a></li>
		  <li auth="authority-l" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=log&fcode=authority-l" <?php if ($_smarty_tpl->tpl_vars['action']->value=="log"){?>class="on"<?php }?>>日志管理</a></li>
        </ul>
      </div>
    </div>
    
</div>
<a onclick="hiddenLeft()" class="hidden_left" style="background-color:#EEECED"></a>
  <!----left end----> 
  <script>
	<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['fcodeArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
		$('li[auth="<?php echo $_smarty_tpl->tpl_vars['row']->value['F_code'];?>
"]').css('display', 'block');
	<?php } ?>
  </script><?php }} ?>