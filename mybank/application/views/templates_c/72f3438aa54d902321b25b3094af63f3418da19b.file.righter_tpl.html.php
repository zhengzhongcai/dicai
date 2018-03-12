<?php /* Smarty version Smarty-3.1.8, created on 2014-01-22 10:49:02
         compiled from "G:\WWW\cdyh\application/views\resource\righter_tpl.html" */ ?>
<?php /*%%SmartyHeaderCode:2977452dcce66a6c929-07733564%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '72f3438aa54d902321b25b3094af63f3418da19b' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\resource\\righter_tpl.html',
      1 => 1390358939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2977452dcce66a6c929-07733564',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52dcce66b9e6f2_34956876',
  'variables' => 
  array (
    'baseUrl' => 0,
    'RES_RIGHTER_TPL_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'RES_RIGHTER_TPL_EXPORT' => 0,
    'optArr' => 0,
    'row' => 0,
    'RES_RIGHTER_TABLE_ID' => 0,
    'RES_RIGHTER_TPL_NAME' => 0,
    'RES_RIGHTER_VERSION' => 0,
    'RES_RIGHTER_TPL_RESOLU' => 0,
    'RES_RIGHTER_GENSTATUS' => 0,
    'RES_RIGHTER_TABLE_ADDTIME' => 0,
    'RES_RIGHTER_TABLE_ADDUSER' => 0,
    'RES_RIGHTER_CLICK_TO_GEN' => 0,
    'RES_RIGHTER_GEN_WAITED' => 0,
    'RES_RIGHTER_GEN_FINISHED' => 0,
    'COMMON_TIP_CHOOSE_ONE_TO_EDIT' => 0,
    'COMMON_TIP_CHOOSE_DEL_ITEM' => 0,
    'COMMON_TIP_IS_DEL' => 0,
    'COMMON_TIP_DEL_SUCCESS' => 0,
    'COMMON_TIP_DEL_FAILED' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52dcce66b9e6f2_34956876')) {function content_52dcce66b9e6f2_34956876($_smarty_tpl) {?>	<style type="text/css">
	h1 {
		font: 4em normal Arial, Helvetica, sans-serif;
		padding: 20px;	margin: 0;
		text-align:center;
		color:#bbb;
	}

	h1 small{
		font: 0.2em normal  Arial, Helvetica, sans-serif;
		text-transform:uppercase; letter-spacing: 0.2em; line-height: 5em;
		display: block;
		color:red;
	}

	.container {position:absolute;top:0;bottom:0;width:100%;background: rgba(255, 255, 255, 0.8);}
	.content_loading {width:800px; margin:0 auto; padding-top:50px;}
	.contentBar {width:90px; margin:0 auto; padding-top:50px; padding-bottom:50px;}
	/* Second Loadin Circle */

	.circle {
		background-color: rgba(0,0,0,0);
		border:5px solid rgba(0,183,229,0.9);
		opacity:.9;
		border-right:5px solid rgba(0,0,0,0);
		border-left:5px solid rgba(0,0,0,0);
		border-radius:50px;
		box-shadow: 0 0 35px #2187e7;
		width:50px;
		height:50px;
		margin:0 auto;
		-moz-animation:spinPulse 1s infinite ease-in-out;
		-webkit-animation:spinPulse 1s infinite linear;
	}
	.circle1 {
		background-color: rgba(0,0,0,0);
		border:5px solid rgba(0,183,229,0.9);
		opacity:.9;
		border-left:5px solid rgba(0,0,0,0);
		border-right:5px solid rgba(0,0,0,0);
		border-radius:50px;
		box-shadow: 0 0 15px #2187e7; 
		width:30px;
		height:30px;
		margin:0 auto;
		position:relative;
		top:-50px;
		-moz-animation:spinoffPulse 1s infinite linear;
		-webkit-animation:spinoffPulse 1s infinite linear;
	}

	@-moz-keyframes spinPulse {
		0% { -moz-transform:rotate(160deg); opacity:0; box-shadow:0 0 1px #2187e7;}
		50% { -moz-transform:rotate(145deg); opacity:1; }
		100% { -moz-transform:rotate(-320deg); opacity:0; }
	}
	@-moz-keyframes spinoffPulse {
		0% { -moz-transform:rotate(0deg); }
		100% { -moz-transform:rotate(360deg);  }
	}
	@-webkit-keyframes spinPulse {
		0% { -webkit-transform:rotate(160deg); opacity:0; box-shadow:0 0 1px #2187e7; }
		50% { -webkit-transform:rotate(145deg); opacity:1;}
		100% { -webkit-transform:rotate(-320deg); opacity:0; }
	}
	@-webkit-keyframes spinoffPulse {
		0% { -webkit-transform:rotate(0deg); }
		100% { -webkit-transform:rotate(360deg); }
	}
	</style>
	<div class="container" style="display:none">
		<h1>正在生成压缩包...</h1>
		<div class="content_loading">
			<div class="circle"></div>
			<div class="circle1"></div>
		</div>
	</div>
	<!----right---->
	<div class="right_box">
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=editTpl" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TPL_ADD']->value)===null||$tmp==='' ? "添加模板" : $tmp);?>
</a>
			<a auth="u" href="javascript:updateTpl()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>
			<a auth="d" href="javascript:deleteTpl()" class="tool_del statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEL']->value)===null||$tmp==='' ? "删除" : $tmp);?>
</a>
			<a href="javascript:exportTpl()" style="text-decoration:underline"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TPL_EXPORT']->value)===null||$tmp==='' ? "下载压缩包" : $tmp);?>
</a>
		</div>
		<script>
			<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['optArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
				$('a[auth="<?php echo $_smarty_tpl->tpl_vars['row']->value['Operation'];?>
"]').css('display', 'inline-block');
			<?php } ?>
		</script>
		<!----tool 工具条 end---->
		<!----table 表格---->
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<table id="tbCommonPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="5%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TABLE_ID']->value)===null||$tmp==='' ? "编号" : $tmp);?>
</th>
						<th width="20%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TPL_NAME']->value)===null||$tmp==='' ? "模板名称" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_VERSION']->value)===null||$tmp==='' ? "版本号" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TPL_RESOLU']->value)===null||$tmp==='' ? "分辨率" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_GENSTATUS']->value)===null||$tmp==='' ? "生成状态" : $tmp);?>
</th>
						<th width="20%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TABLE_ADDTIME']->value)===null||$tmp==='' ? "录入时间" : $tmp);?>
</th>
						<th width="20%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TABLE_ADDUSER']->value)===null||$tmp==='' ? "录入用户代码" : $tmp);?>
</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<!----table 表格 end----> 
	</div>
	<!----right end----> 
</div>
<!--content end-->
<script>
	window.onload = function(){
		getTplList();
	}
	// 获取模板列表
	function getTplList(){
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=getTplList";
		$.ajax({
			type: "post",
			url: url,
			data: 'res_type=0',
			success: function(data) {
				$('#tbCommonPram > tbody').html('');
				var tplObjs = JSON.parse(data);
				var tplStr = "";
				for (var idx in tplObjs){
					tplStr = generateTpl(tplObjs[idx]);
					$('#tbCommonPram > tbody').append(tplStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateTpl(tpl){
		var parts = tpl.create_time.split('.');
		var status = ''
		if (tpl.status == 0){
			status = '<a href="javascript:genPackages('+tpl.id+')" style="color:red" title="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_CLICK_TO_GEN']->value)===null||$tmp==='' ? "点击生成" : $tmp);?>
"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_GEN_WAITED']->value)===null||$tmp==='' ? "未生成包" : $tmp);?>
</a>';
		}else{
			status = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_GEN_FINISHED']->value)===null||$tmp==='' ? "已生成包" : $tmp);?>
';
		}
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+tpl.id+'" type="checkbox" class="item"/></td>'+
						  '<td>'+tpl.id+'</td>'+
						  '<td>'+tpl.tpl_name+'</td>'+
						  '<td>'+tpl.version+'</td>'+
						  '<td>'+tpl.resolution+'</td>'+
						  '<td>'+status+'</td>'+
						  '<td>'+parts[0]+'</td>'+
						  '<td>'+tpl.username+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	
	// 跳转到修改模板
	function updateTpl(){
		var checkedCnt = 0;
		var tplid;
		$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
			if ('checked' == $(this).attr('checked')) 
			{
				tplid = $(this).attr('id');
				checkedCnt++;
			}
		});
		
		if (checkedCnt > 1 || checkedCnt < 1) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_ONE_TO_EDIT']->value)===null||$tmp==='' ? "请选择其中一个进行编辑." : $tmp);?>
');
			return;
		}// if
		location.href = '<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=editTpl&tplid='+tplid;
	}

	// 选择全部
	function toggleChooseAll(){
		var chooseAll = $('#checkControl').attr('checked');
		if ('checked' == chooseAll)
		{
			$('#tbCommonPram').find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#tbCommonPram').find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func
	
	// 删除模板
	function deleteTpl(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = $(this).attr('id');
				i++;
			}
		});
		
		if (deleteItemArr.length == 0) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_DEL_ITEM']->value)===null||$tmp==='' ? "请选择需要删除的项." : $tmp);?>
');
			return;
		}// if
		
		if (!confirm('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_IS_DEL']->value)===null||$tmp==='' ? "确认删除!" : $tmp);?>
')) return;
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=deleteTpl";
		$.ajax({
			type: "post",
			url: url,
			data: "tplids=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data == '')
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "删除成功." : $tmp);?>
');
					getTplList();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "删除失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
	
	// 导出模板
	function exportTpl(){
		var checkedCnt = 0;
		var tplid;
		$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
			if ('checked' == $(this).attr('checked')) 
			{
				tplid = $(this).attr('id');
				checkedCnt++;
			}
		});
		
		if (checkedCnt > 1 || checkedCnt < 1) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_ONE_TO_EDIT']->value)===null||$tmp==='' ? "请选择其中一个进行编辑." : $tmp);?>
');
			return;
		}// if
		location.href = '<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=exportTpl&tplid='+tplid;
	}// func
	
	// 生成更新包
	function genPackages(tplId){
		$('.container').show();
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=genPackage";
		$.ajax({
			type: "post",
			url: url,
			data: 'tplid='+tplId,
			success: function(data) {
				$('.container').hide();
				//console.log(data);
				if (data != 0) {
					alert('成功生成压缩包.');
					getTplList();
				}else alert('生成压缩包失败.');
			}
		}); // ajax
	}
	
</script><?php }} ?>