<?php /* Smarty version Smarty-3.1.8, created on 2013-11-15 18:28:25
         compiled from "G:\WWW\webmark\application/views\resource\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:85555211c71b5c08b6-54440447%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f7e3079af2f17bf87a6e471ef3a23d0f7721234' => 
    array (
      0 => 'G:\\WWW\\webmark\\application/views\\resource\\lefter.html',
      1 => 1384511283,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '85555211c71b5c08b6-54440447',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5211c71b675dc0_06792833',
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
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5211c71b675dc0_06792833')) {function content_5211c71b675dc0_06792833($_smarty_tpl) {?><!--content-->
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