<?php /* Smarty version Smarty-3.1.8, created on 2017-04-06 16:53:56
         compiled from "D:\bankSct2\BANK\application/views\resource\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:253158c909fcf2bc32-96395627%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c662646f373e766018d648e40be73aaff8f8adf0' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\resource\\lefter.html',
      1 => 1491468833,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '253158c909fcf2bc32-96395627',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58c909fd073fa0_85681431',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c909fd073fa0_85681431')) {function content_58c909fd073fa0_85681431($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2>数据管理</h2>
      
      <div class="left_menu_a_list">
        <ul>
          <li auth="288" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=resource&action=resMananger&fcode=resource-tpl">资源文件管理</a></li>
			<li auth="232" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=resource&action=tplList&fcode=resource-tpl" >模板</a></li>
			<li auth="236" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=resource&action=videoList&fcode=resource-v">视频</a></li>
			<li auth="240" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=resource&action=audioList&fcode=resource-a" >音频</a></li>
			<li auth="244" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=resource&action=picList&fcode=resource-p" >图片</a></li>
			<li auth="248" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=resource&action=textList&fcode=resource-t" >文字</a></li>
			<li auth="252" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=resource&action=newscate&fcode=resource-c" >新闻分类</a></li>
			<li auth="256" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=resource&action=newsitem&fcode=resource-i" >新闻条目</a></li>
			<li auth="260" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=resource&action=rescheck&fcode=resource-ch" >资源审核</a></li>
			<li auth="264" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=resource&action=commoncfg&fcode=resource-cfg" >总体配置</a></li>
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