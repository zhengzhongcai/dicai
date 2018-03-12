<?php /* Smarty version Smarty-3.1.8, created on 2016-10-12 16:23:06
         compiled from "D:\WWW\cdbank\application/views\evalu\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:376257fdf2ea757547-55398718%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b1818dea062fa14f22264710485bcd844e0d776' => 
    array (
      0 => 'D:\\WWW\\cdbank\\application/views\\evalu\\lefter.html',
      1 => 1384408942,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '376257fdf2ea757547-55398718',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'EVALU_LEFT_MAN' => 0,
    'baseUrl' => 0,
    'action' => 0,
    'EVALU_LEFT_LIST' => 0,
    'EVALU_LEFT_TASK' => 0,
    'fcodeArr' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57fdf2ea7c6dc8_32268501',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57fdf2ea7c6dc8_32268501')) {function content_57fdf2ea7c6dc8_32268501($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_LEFT_MAN']->value)===null||$tmp==='' ? "终端管理" : $tmp);?>
</h2>
      
      <div class="left_menu_a_list">
        <ul>
			<li auth="evalu-l" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=counterParam&fcode=evalu-l" <?php if ($_smarty_tpl->tpl_vars['action']->value=="counterParam"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_LEFT_LIST']->value)===null||$tmp==='' ? "评价器清单" : $tmp);?>
</a></li>
			<li auth="evalu-t" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=task&fcode=evalu-l" <?php if ($_smarty_tpl->tpl_vars['action']->value=="task"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_LEFT_TASK']->value)===null||$tmp==='' ? "任务管理" : $tmp);?>
</a></li>
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