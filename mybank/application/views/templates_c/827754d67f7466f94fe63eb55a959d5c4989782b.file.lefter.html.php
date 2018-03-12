<?php /* Smarty version Smarty-3.1.8, created on 2013-08-19 16:27:19
         compiled from "G:\WWW\webmark\application/views\institution\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:40475211d6e7ea52f3-81690334%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '827754d67f7466f94fe63eb55a959d5c4989782b' => 
    array (
      0 => 'G:\\WWW\\webmark\\application/views\\institution\\lefter.html',
      1 => 1376637320,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '40475211d6e7ea52f3-81690334',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ORG_LEFTER_MENU_TITLE' => 0,
    'ORG_LEFTER_MENU_ORG' => 0,
    'orgTreeStr' => 0,
    'fcodeArr' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5211d6e8017fa5_67755164',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5211d6e8017fa5_67755164')) {function content_5211d6e8017fa5_67755164($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_LEFTER_MENU_TITLE']->value)===null||$tmp==='' ? "机构管理" : $tmp);?>
</h2>
      <div class="left_menu_tab">
        <ul>
          <li class="li1" style="width:100%"><a href="#" class="on"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_LEFTER_MENU_ORG']->value)===null||$tmp==='' ? "组织架构" : $tmp);?>
</a></li>
        </ul>
      </div>
      <div class="tree_menu" style="margin-top:50px;margin-right:8px;overflow-y: scroll;max-height: 600px;">
		<ul id="browser" class="filetree">
			<?php echo $_smarty_tpl->tpl_vars['orgTreeStr']->value;?>

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