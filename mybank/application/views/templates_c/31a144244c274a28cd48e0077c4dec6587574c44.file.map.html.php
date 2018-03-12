<?php /* Smarty version Smarty-3.1.8, created on 2017-03-28 16:18:22
         compiled from "D:\bankSct2\BANK\application/views\monitor\map.html" */ ?>
<?php /*%%SmartyHeaderCode:2172958da1c4e0f0e02-55358049%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '31a144244c274a28cd48e0077c4dec6587574c44' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\monitor\\map.html',
      1 => 1489549419,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2172958da1c4e0f0e02-55358049',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'baseUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58da1c4e1f3c45_14014004',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58da1c4e1f3c45_14014004')) {function content_58da1c4e1f3c45_14014004($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DIV+CSS布局教程</title>
<style type="text/css">
#Container{
    width:1500px;
	 height:800px;
    margin: right;/*设置整个容器在浏览器中水平居中*/
  border:1px dashed #706f68;

	
}
#Header{
    height:80px;
    background:#093;
}
#logo{
    padding-left:50px;
    padding-top:20px;
    padding-bottom:50px;
}
#Content{
	height:auto;
    /*此处对容器设置了高度，一般不建议对容器设置高度，一般使用overflow:auto;属性设置容器根据内容自适应高度，如果不指定高度或不设置自适应高度，容器将默认为1个字符高度，容器下方的布局元素（footer）设置margin-top:属性将无效*/
    margin-top:20px;/*此处讲解margin的用法，设置content与上面header元素之间的距离*/
    background:#0FF;
     
}
#Content-Left{
    height:700px;
    width:150px;
    margin:20px;/*设置元素跟其他元素的距离为20像素*/
	border:1px dashed #706f68;
    float:left;/*设置浮动，实现多列效果，div+Css布局中很重要的*/
    background:#f3f3f3;
	text-align:center;
}
#Content-Left ul{ padding-top:20px;}
#Content-Left ul li{ height:40px; top:15px}
#Content-Main{
    height:700px;
    width:800px;
    margin:20px;/*设置元素跟其他元素的距离为20像素*/
    float:left;/*设置浮动，实现多列效果，div+Css布局中很重要的*/
    background:whrite;
	border:1px dashed #706f68;
}

/*注：Content-Left和Content-Main元素是Content元素的子元素，两个元素使用了float:left;设置成两列，这个两个元素的宽度和这个两个元素设置的padding、margin的和一定不能大于父层Content元素的宽度，否则设置列将失败*/
#Footer{
    height:40px;
    background:#90C;
    margin-top:20px;
}
.Clear{
    clear:both;
}
.td{height:100px;}
.date{ padding-top:100px;}
</style>
</head>
 
<body>
<foreach from=$ret item='val'>
{$val.username}
</foreach>
<div id="Container">
  <div id="Content">
        <div id="Content-Left">
        <ul>
 <li><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/branch.png" /></a></li> 
 <li><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/branch.png" /></a></li>
  <li><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/branch.png" /></a></li>
   <li><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/branch.png" /></a></li>
    <li><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/branch.png" /></a></li>
     <li><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/branch.png" /></a></li>
      <li><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/branch.png" /></a> </li>
      <li class="date"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/top1.png"/><li>
 </ul>
        </div>
        <div id="Content-Main">
        <ul>
        <li>
        <span><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=monitor&fcode=monitor"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/buton.png" width="200px" /></a></span>
        <span><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/buton.png" width="200px" /></a></span>
        <span><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/buton.png" width="200px" /></a></span>
        <li>
        <li>
        <span><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/buton.png"  width="200px" /></a></span>
        <span><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/buton.png"   width="200px" /></a></span>
        <span><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/buton.png"  width="200px"  /></a></span>
        </li>
        <li style="padding-top:10px"><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/customers.png"  width="600px"  /></a></li>
        </ul>
        </div>
  </div>
</div>
</body>
</html>
<?php }} ?>