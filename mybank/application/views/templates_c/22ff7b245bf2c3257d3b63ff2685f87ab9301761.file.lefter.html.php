<?php /* Smarty version Smarty-3.1.8, created on 2017-04-05 15:28:46
         compiled from "D:\bankSct2\BANK\application/views\institution\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:2740258c9ee46878427-34144848%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22ff7b245bf2c3257d3b63ff2685f87ab9301761' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\institution\\lefter.html',
      1 => 1491377321,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2740258c9ee46878427-34144848',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58c9ee4691c178_70296762',
  'variables' => 
  array (
    'orgTreeStr' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c9ee4691c178_70296762')) {function content_58c9ee4691c178_70296762($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2>机构管理</h2>
      <div class="left_menu_tab">
        <ul>
          <li class="li1" style="width:100%"><a href="#" class="on">组织架构</a></li>
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
    <<?php ?>?php foreach($www as $val): ?<?php ?>>
    $('li[auth="<<?php ?>?php echo $val['menurole_id'];?<?php ?>>"]').css('display', 'block');
    <<?php ?>?php endforeach;?<?php ?>>
  </script><?php }} ?>