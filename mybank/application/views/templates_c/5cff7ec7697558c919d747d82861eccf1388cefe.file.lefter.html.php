<?php /* Smarty version Smarty-3.1.8, created on 2016-10-12 16:20:51
         compiled from "D:\WWW\cdbank\application/views\basedata\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:697957fdf263f03805-96669950%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5cff7ec7697558c919d747d82861eccf1388cefe' => 
    array (
      0 => 'D:\\WWW\\cdbank\\application/views\\basedata\\lefter.html',
      1 => 1376571868,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '697957fdf263f03805-96669950',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'DATA_LEFTER_MANAGE' => 0,
    'baseUrl' => 0,
    'action' => 0,
    'DATA_LEFTER_MANAGE_BUS' => 0,
    'DATA_LEFTER_MANAGE_STAFF' => 0,
    'DATA_LEFTER_MANAGE_COUNTER' => 0,
    'DATA_LEFTER_MANAGE_VIP' => 0,
    'DATA_LEFTER_MANAGE_PARAM' => 0,
    'fcodeArr' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57fdf264241670_93607686',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57fdf264241670_93607686')) {function content_57fdf264241670_93607686($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_LEFTER_MANAGE']->value)===null||$tmp==='' ? "数据管理" : $tmp);?>
</h2>
      
      <div class="left_menu_a_list">
        <ul>
			<li auth="data-b" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=serialParam&fcode=data-b" <?php if ($_smarty_tpl->tpl_vars['action']->value=="serialParam"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_LEFTER_MANAGE_BUS']->value)===null||$tmp==='' ? "业务管理" : $tmp);?>
</a></li>
			<li auth="data-t" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=serverParam&fcode=data-t" <?php if ($_smarty_tpl->tpl_vars['action']->value=="serverParam"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_LEFTER_MANAGE_STAFF']->value)===null||$tmp==='' ? "柜员管理" : $tmp);?>
</a></li>
			<li auth="data-c" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=counterParam&fcode=data-c" <?php if ($_smarty_tpl->tpl_vars['action']->value=="counterParam"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_LEFTER_MANAGE_COUNTER']->value)===null||$tmp==='' ? "柜台管理" : $tmp);?>
</a></li>
			<li auth="data-v" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=vipParam&fcode=data-v" <?php if ($_smarty_tpl->tpl_vars['action']->value=="vipParam"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_LEFTER_MANAGE_VIP']->value)===null||$tmp==='' ? "VIP客户资料管理" : $tmp);?>
</a></li>
			<li auth="data-p" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=commonParam&fcode=data-p" <?php if ($_smarty_tpl->tpl_vars['action']->value=="commonParam"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_LEFTER_MANAGE_PARAM']->value)===null||$tmp==='' ? "公共参数管理" : $tmp);?>
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