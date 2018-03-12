<?php /* Smarty version Smarty-3.1.8, created on 2017-04-07 10:54:27
         compiled from "D:\bankSct2\BANK\application/views\play\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:1335158ca5f5605ba82-57876498%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac7ffa658df7c54b20ac7ef988fc00d91f4947c4' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\play\\lefter.html',
      1 => 1491533665,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1335158ca5f5605ba82-57876498',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58ca5f560ccb63_41925597',
  'variables' => 
  array (
    'baseUrl' => 0,
    'action' => 0,
    'DATA_LEFTER_MANAGE_PARAM1' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58ca5f560ccb63_41925597')) {function content_58ca5f560ccb63_41925597($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2>节目播放管理</h2>
      
      <div class="left_menu_a_list">
        <ul>
		
			<li auth="269" class="statItem"  ><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=play&action=fast&fcode=monitor" >快速创建节目</a></li>
      <li auth="277" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=play&action=temp&fcode=monitor" >创建模板</a></li>
      <li auth="281" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=play&action=profile&fcode=monitor" >创建节目</a></li>
      <li auth="284" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=play&action=play_list&fcode=monitor" >创建播放列表</a></li>
      <li auth="269" class="statItem"  ><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=play_second&action=fast_second&fcode=monitor" >快速创建节目</a></li>
      <li auth="277" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=play_second&action=temp_second&fcode=monitor">创建模板</a></li>
      <li auth="281" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=play_second&action=profile_second&fcode=monitor">创建节目</a></li>
      <li auth="284" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=play_second&action=play_list_second&fcode=monitor" >创建播放列表</a></li>
          <!--  <li auth="data-p" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=lookimage&action=index" <?php if ($_smarty_tpl->tpl_vars['action']->value=="commonParam"){?>class="on"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_LEFTER_MANAGE_PARAM1']->value)===null||$tmp==='' ? "查看图片" : $tmp);?>
</a></li>-->
        </ul>
      </div>
    </div>
    </div>

  <!----left end----> 
 
  <!----left end---->
  <script type="text/javascript" src="/CI/system/application/views/javaScript/fastProgramManage.js"></script> 
  <script>
    <<?php ?>?php foreach($www as $val): ?<?php ?>>
    $('li[auth="<<?php ?>?php echo $val['menurole_id'];?<?php ?>>"]').css('display', 'block');
    <<?php ?>?php endforeach;?<?php ?>>
  </script><?php }} ?>