<?php /* Smarty version Smarty-3.1.8, created on 2017-03-08 11:18:40
         compiled from "D:\WWW\cdbank\application/views\jqview\index.html" */ ?>
<?php /*%%SmartyHeaderCode:187558bf74d9bde765-75170602%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ab67ef057822fc50a18c6bef319b6e0fcfd33bfa' => 
    array (
      0 => 'D:\\WWW\\cdbank\\application/views\\jqview\\index.html',
      1 => 1488943037,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '187558bf74d9bde765-75170602',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58bf74d9ccd925_31638423',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58bf74d9ccd925_31638423')) {function content_58bf74d9ccd925_31638423($_smarty_tpl) {?>
<h2>Demo4</h2>
<span class="btn" onclick="$.lightTreeview.open('#demo4 ol,#demo4 ul')">展开全部</span> |
<span class="btn" onclick="$.lightTreeview.close('#demo4 ol,#demo4 ul')">收缩全部</span> |
<span class="btn" onclick="$.lightTreeview.toggle('#demo4 ol,#demo4 ul')">切换全部</span> | 
<span class="btn" onclick="$.lightTreeview.toggle('#demo4 ul:last')">切换广东节点</span>

<ul id="demo4">
	
	<li>
		<div>广东</div>
		<ul style="display:none">
			<li><div><table><tr>
            <td><input type="checkbox">查看</td>
            <td><input type="checkbox">删除</td>
            </tr></table></div></li>
			<li><div>湛江</div></li>
			<li><div>佛山</div></li>
		</ul>
	</li>
    <li>
		<div>广东</div>
		<ul style="display:none">
			<li><div>广州</div></li>
			<li><div>湛江</div></li>
			<li><div>佛山</div></li>
		</ul>
	</li>
	</ul>
	


<?php }} ?>