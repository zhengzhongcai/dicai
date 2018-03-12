<?php /* Smarty version Smarty-3.1.8, created on 2016-10-12 16:23:01
         compiled from "D:\WWW\cdbank\application/views\resource\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:1026057fdf2e5590d22-07058546%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4e197d83983e96f4d6f5aa8c3fc42ff0c5a962ab' => 
    array (
      0 => 'D:\\WWW\\cdbank\\application/views\\resource\\lefter.html',
      1 => 1390378592,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1026057fdf2e5590d22-07058546',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RES_LEFTER_MENU_TITLE' => 0,
    'baseUrl' => 0,
    'action' => 0,
    'RES_LEFTER_MENU_LIST_TPL' => 0,
    'RES_LEFTER_MENU_LIST_VIDEO' => 0,
    'RES_LEFTER_MENU_LIST_AUDIO' => 0,
    'RES_LEFTER_MENU_LIST_PIC' => 0,
    'RES_LEFTER_MENU_LIST_TEXT' => 0,
    'RES_LEFTER_MENU_LIST_NEWSCATE' => 0,
    'RES_LEFTER_MENU_LIST_NEWSITEM' => 0,
    'RES_LEFTER_MENU_LIST_RESCHECK' => 0,
    'fcodeArr' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57fdf2e56e2d81_76984670',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57fdf2e56e2d81_76984670')) {function content_57fdf2e56e2d81_76984670($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_LEFTER_MENU_TITLE']->value)===null||$tmp==='' ? "数据管理" : $tmp);?>
</h2>
      
      <div class="left_menu_a_list">
        <ul>
			<li auth="resource-tpl" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=tplList&fcode=resource-tpl" <?php if ($_smarty_tpl->tpl_vars['action']->value=="tplList"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_LEFTER_MENU_LIST_TPL']->value)===null||$tmp==='' ? "模板" : $tmp);?>
</a></li>
			<li auth="resource-v" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=videoList&fcode=resource-v" <?php if ($_smarty_tpl->tpl_vars['action']->value=="videoList"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_LEFTER_MENU_LIST_VIDEO']->value)===null||$tmp==='' ? "视频" : $tmp);?>
</a></li>
			<li auth="resource-a" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=audioList&fcode=resource-a" <?php if ($_smarty_tpl->tpl_vars['action']->value=="audioList"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_LEFTER_MENU_LIST_AUDIO']->value)===null||$tmp==='' ? "音频" : $tmp);?>
</a></li>
			<li auth="resource-p" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=picList&fcode=resource-p" <?php if ($_smarty_tpl->tpl_vars['action']->value=="picList"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_LEFTER_MENU_LIST_PIC']->value)===null||$tmp==='' ? "图片" : $tmp);?>
</a></li>
			<li auth="resource-t" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=textList&fcode=resource-t" <?php if ($_smarty_tpl->tpl_vars['action']->value=="textList"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_LEFTER_MENU_LIST_TEXT']->value)===null||$tmp==='' ? "文字" : $tmp);?>
</a></li>
			<li auth="resource-c" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=newscate&fcode=resource-c" <?php if ($_smarty_tpl->tpl_vars['action']->value=="newscate"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_LEFTER_MENU_LIST_NEWSCATE']->value)===null||$tmp==='' ? "新闻分类" : $tmp);?>
</a></li>
			<li auth="resource-i" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=newsitem&fcode=resource-i" <?php if ($_smarty_tpl->tpl_vars['action']->value=="newsitem"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_LEFTER_MENU_LIST_NEWSITEM']->value)===null||$tmp==='' ? "新闻条目" : $tmp);?>
</a></li>
			<li auth="resource-ch" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=rescheck&fcode=resource-ch" <?php if ($_smarty_tpl->tpl_vars['action']->value=="rescheck"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_LEFTER_MENU_LIST_RESCHECK']->value)===null||$tmp==='' ? "资源审核" : $tmp);?>
</a></li>
			<li auth="resource-ch" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=commoncfg&fcode=resource-cfg" <?php if ($_smarty_tpl->tpl_vars['action']->value=="commoncfg"){?>class="on"<?php }?>>总体配置</a></li>
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