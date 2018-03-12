<?php /* Smarty version Smarty-3.1.8, created on 2017-02-28 09:49:25
         compiled from "D:\WWW\cdbank\application/views\authority\righter_log.html" */ ?>
<?php /*%%SmartyHeaderCode:2896358b4d7256403f5-28498027%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e05cb140a84d3bff7c6bd21653fc9d88f875e723' => 
    array (
      0 => 'D:\\WWW\\cdbank\\application/views\\authority\\righter_log.html',
      1 => 1390450186,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2896358b4d7256403f5-28498027',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'COMMON_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'optArr' => 0,
    'row' => 0,
    'total_page' => 0,
    'baseUrl' => 0,
    'COMMON_TIP_CHOOSE_DEL_ITEM' => 0,
    'COMMON_TIP_DEL_SUCCESS' => 0,
    'COMMON_TIP_DEL_FAILED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58b4d7256f2174_41595832',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58b4d7256f2174_41595832')) {function content_58b4d7256f2174_41595832($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">  
		<!----title 标题栏 标签---->
		<div class="mod_title mod_title_nonebor">
			
		</div>
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<!--<a auth="c" href="javascript:showPopbox()" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_ADD']->value)===null||$tmp==='' ? "添加" : $tmp);?>
</a>
			<a auth="u" href="javascript:editParamInfo()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>-->
			<a auth="d" href="javascript:deleteParamInfo()" class="tool_del statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEL']->value)===null||$tmp==='' ? "删除" : $tmp);?>
</a>
			<select id="fastDate" name="fastdate" onchange="fastdeletebtn()">
				<option value="0">选择快捷删除日志的时间</option>
				<option value="1">一周之前</option>
				<option value="2">一个月之前</option>
				<option value="3">三个月之前</option>
				<option value="4">半年之前</option>
				<option value="5">一年之前</option>
			</select>
			<button id="fastdeletebtn" auth="d" onclick="fastDelete()" disabled>清除日志</button>
		</div>
		<!----tool 工具条 end---->
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
		<link href="assets/pager/Pager.css" rel="stylesheet" type="text/css" />
		<script src="assets/pager/jquery.pager.js" type="text/javascript"></script>
		<!----table 表格---->
		<!--
		<input type="hidden" id="isEdit" value="0"/>
		-->
		<div class="mod_table">
			<table id="tbCommonPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="10%">操作者</th>
						<th width="10%">操作时间</th>
						<th width="10%">操作记录</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<div id="pager" style="float:right"></div>
		</div>
		<!----table 表格 end----> 
	</div>
	<!----right end----> 
</div>
<!--content end-->



<script>
	window.onload=function(){
        $("#pager").pager({ pagenumber: 1, pagecount: <?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
, buttonClickCallback: PageClick });
		getLogs(1);
	}
	
	PageClick = function(pageclickednumber) {
		$("#pager").pager({ pagenumber: pageclickednumber, pagecount: <?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
, buttonClickCallback: PageClick });
		getLogs(pageclickednumber);
	}
	
	// 快捷删除按钮状态修改
	function fastdeletebtn(){
		var check = $('#fastDate').val();
		if (check != 0) $('#fastdeletebtn').removeAttr('disabled');
		else $('#fastdeletebtn').attr('disabled', true);
	}
	
	// 获取操作日志
	function getLogs(page){
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=getLogs";
		$.ajax({
			dataType: "Json",
			type: "post",
			url: url,
			data: 'page='+page,
			success: function(paramObjs) {
				//console.log(paramObjs.length);
				$('#tbCommonPram > tbody').html('');
				var paramStr = "";
				for (var idx in paramObjs){
					paramStr = generateParam(paramObjs[idx]);
					$('#tbCommonPram > tbody').append(paramStr);
				}// for
			}
		}); // ajax
	}
	
	// 生成一行记录
	function generateParam(paramInfo){
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+paramInfo.id+'" class="optCheck" type="checkbox"/></td>'+
						  '<td>'+paramInfo.username+'</td>'+
						  '<td>'+paramInfo.createtime+'</td>'+
						  '<td>'+paramInfo.content+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	
	
	
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
	
	
	
	// 删除公共参数
	function deleteParamInfo(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbCommonPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
			if ('checked' == $(this).attr('checked')) 
			{
				deleteItemArr[i] = $(this).attr('id');
				i++;
			}// if
		});
		
		if (deleteItemArr.length == 0) 
		{
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_DEL_ITEM']->value)===null||$tmp==='' ? "请选择需要删除的项." : $tmp);?>
');
			return;
		}// if
		
		if (!confirm('确认删除!')) return;
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=deleteLog";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "删除成功." : $tmp);?>
');
					getLogs(1);
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "删除失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
	
	// 快捷删除日志
	function fastDelete(){
		var fastdate = $('#fastdate').val();
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=fastDeleteLog";
		$.ajax({
			dataType:'Json',
			type: "post",
			url: url,
			data: "fastdate="+fastdate,
			success: function(data) {
				if (data.status > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "删除成功." : $tmp);?>
');
					getLogs(1);
				}
				else
					alert(data.error_msg);
			}
		}); // ajax
	}
</script><?php }} ?>