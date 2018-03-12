<?php /* Smarty version Smarty-3.1.8, created on 2017-03-09 09:10:45
         compiled from "D:\WWW\cdbank\application/views\monitor\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:2775057fdf16f4a9c89-31306101%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b63df38be00ce08365e98518a081f7db703af9f1' => 
    array (
      0 => 'D:\\WWW\\cdbank\\application/views\\monitor\\lefter.html',
      1 => 1489021842,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2775057fdf16f4a9c89-31306101',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57fdf16f512072_34927234',
  'variables' => 
  array (
    'MONITOR_LEFTER_TITLE' => 0,
    'baseUrl' => 0,
    'action' => 0,
    'MONITOR_LEFRER_ORG' => 0,
    'orgTreeStr' => 0,
    'fcodeArr' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57fdf16f512072_34927234')) {function content_57fdf16f512072_34927234($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box" style="min-height:800px;">
    <div class="left_menu">
      <h2><?php echo (($tmp = @$_smarty_tpl->tpl_vars['MONITOR_LEFTER_TITLE']->value)===null||$tmp==='' ? "实时监控" : $tmp);?>
</h2>
      <div class="left_menu_tab">
        <ul>
          <li class="li1" style="width:100%"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=monitor&fcode=monitor"<?php if ($_smarty_tpl->tpl_vars['action']->value=="report"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['MONITOR_LEFRER_ORG']->value)===null||$tmp==='' ? "组织架构" : $tmp);?>
</a></li>
	  <li class="li1" style="width:100%"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=monitor&fcode=monitor&action=map"<?php if ($_smarty_tpl->tpl_vars['action']->value=="map"){?>class="on"<?php }?>>地图</a></li>
        </ul>
      </div>
	  <?php if ($_smarty_tpl->tpl_vars['action']->value=="report"){?>
      <div class="tree_menu" style="margin-top:50px;margin-right:8px;overflow-y: scroll;max-height: 600px;">
		<ul id="browser" class="filetree">
			<?php echo $_smarty_tpl->tpl_vars['orgTreeStr']->value;?>

		</ul>
	  </div>
	  <?php }?>
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
  </script>
<?php }} ?>