	<!----right---->
	<div class="right_box">  
		<!----title 标题栏 标签---->
		<div class="mod_title mod_title_nonebor">
			
		</div>
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<!--<a auth="c" href="javascript:showPopbox()" class="tool_add statItem"><{$COMMON_ADD|default:"添加"}></a>
			<a auth="u" href="javascript:editParamInfo()" class="tool_edit statItem"><{$COMMON_EDIT|default:"编辑"}></a>-->
			<a auth="d" href="javascript:deleteParamInfo()" class="tool_del statItem"><?=lang('AUTH_LEFTER_DEL')?lang('AUTH_LEFTER_DEL'):'删除' ?></a>
			<select id="fastDate" name="fastdate" onchange="fastdeletebtn()">
				<option value="0"><?=lang('AUTH_SERVER_TIP10')?lang('AUTH_SERVER_TIP10'):'选择快捷删除日志的时间' ?></option>
				<option value="1"><?=lang('AUTH_SERVER_WEEK_AGO')?lang('AUTH_SERVER_WEEK_AGO'):'一周之前' ?></option>
				<option value="2"><?=lang('AUTH_SERVER_MONTH_AGO')?lang('AUTH_SERVER_MONTH_AGO'):'一个月之前' ?></option>
				<option value="3"><?=lang('AUTH_SERVER_THREE_MONTH_AGO')?lang('AUTH_SERVER_THREE_MONTH_AGO'):'三个月之前' ?></option>
				<option value="4"><?=lang('AUTH_SERVER_HALF_YEAR_AGO')?lang('AUTH_SERVER_HALF_YEAR_AGO'):'半年之前' ?></option>
				<option value="5"><?=lang('AUTH_SERVER_YEAR_AGO')?lang('AUTH_SERVER_YEAR_AGO'):'一年之前' ?></option>
			</select>
			<button id="fastdeletebtn" auth="d" onclick="fastDelete()" disabled><?=lang('AUTH_SERVER_TIP11')?lang('AUTH_SERVER_TIP11'):'清除日志' ?></button>
		</div>
		<!----tool 工具条 end---->
		<script>
			//<{foreach item=row from=$optArr}>
			//	$('a[auth="<{$row.Operation}>"]').css('display', 'inline-block');
			//<{/foreach}>
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
						<th width="10%"><?=lang('AUTH_OPERATOR')?lang('AUTH_OPERATOR'):'操作者' ?></th>
						<th width="10%"><?=lang('AUTH_OPERAT_TIME')?lang('AUTH_OPERAT_TIME'):'操作时间' ?></th>
						<th width="10%"><?=lang('AUTH_OPERAT_RECORD')?lang('AUTH_OPERAT_RECORD'):'操作纪录' ?></th>
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
        $("#pager").pager({ pagenumber: 1, pagecount: <?php echo $total_page; ?>, buttonClickCallback: PageClick });
		getLogs(1);
	}
	
	PageClick = function(pageclickednumber) {
		$("#pager").pager({ pagenumber: pageclickednumber, pagecount: <?php echo $total_page; ?>, buttonClickCallback: PageClick });
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
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=getLogs";
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
		alert(chooseAll);
		//var chooseAll = 'checked';

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
			alert('<?=lang('AUTH_SERVER_TIP8')?lang('AUTH_SERVER_TIP8'):'请选择需要删除的项' ?>');
			return;
		}// if
		
		if (!confirm('<?=lang('AUTH_LEFTER_CONFIRM_DEL')?lang('AUTH_LEFTER_CONFIRM_DEL'):'确认删除' ?>')) return;
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=deleteLog";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data > 0)
				{
					alert('<?=lang('AUTH_LEFTER_DEL_SUCCESS')?lang('AUTH_LEFTER_DEL_SUCCESS'):'删除成功' ?>');
					getLogs(1);
				}
				else
					alert('<?=lang('AUTH_LEFTER_DEL_FAIL')?lang('AUTH_LEFTER_DEL_FAIL'):'删除失败' ?>.');
			}
		}); // ajax
	}// func
	
	// 快捷删除日志
	function fastDelete(){
		var fastdate = $('#fastdate').val();
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=fastDeleteLog";
		$.ajax({
			dataType:'Json',
			type: "post",
			url: url,
			data: "fastdate="+fastdate,
			success: function(data) {
				if (data.status > 0)
				{
					alert('<?=lang('AUTH_LEFTER_DEL_SUCCESS')?lang('AUTH_LEFTER_DEL_SUCCESS'):'删除成功' ?>');
					getLogs(1);
				}
				else
					alert(data.error_msg);
			}
		}); // ajax
	}
</script>