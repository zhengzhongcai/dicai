	<!----right---->
	<div class="right_box">
		<!----tool 工具条---->
		<div class="mob_tool">
			<select name="restype" id="restype" onchange="getResList()">
				<option value="">全部</option>
				<option value="0">视频</option>
				<option value="1">音频</option>
				<option value="2">图片</option>
				<option value="3">文字</option>
			</select>
			<!--<a auth="c" href="javascript:showPopbox('addRes')" class="tool_add statItem"><{$RES_RIGHTER_VIDEO_ADD|default:"添加视频"}></a>-->
			<!--<a auth="u" href="javascript:showPopbox('editRes')" class="tool_edit statItem"><{$COMMON_EDIT|default:"编辑"}></a>-->
			<a auth="u" href="javascript:setCheck()" class="tool_edit statItem">通过审核</a>
		</div>
		<script>
		//	<{foreach item=row from=$optArr}>
		//		$('a[auth="<{$row.Operation}>"]').css('display', 'inline-block');
		//	<{/foreach}>
		</script>
		<!----tool 工具条 end---->
		<!----table 表格---->
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<table id="tbCommonPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="10%">编号</th>
						<th width="10%">状态</th>
						<th width="15%">文件名称</th>
						<th width="15%">文件大小</th>
						<th width="15%">审核时间</th>
						<th width="15%">审核人</th>
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
	window.onload = function () { // Do something... 	
		getResList();
	}
	
	// 获取资源列表
	function getResList(){
		var res_type = $('#restype').val();
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=checkResList";
		$.ajax({
			type: "post",
			url: url,
			data: 'res_type='+res_type,
			success: function(data) {
				$('#tbCommonPram > tbody').html('');
				var resObjs = eval('(' + data + ')');
				var resStr = "";
				for (var idx in resObjs){
					resStr = generateRes(resObjs[idx]);
					$('#tbCommonPram > tbody').append(resStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateRes(res){
		var status;
		if (res.status == 1){
			status = '已审核';
		}else{
			status = '<span style="color:red">未审核<span>';
		}
		
		if (res.checktime == null) res.checktime = '';
		if (res.username == null) res.username = '';
		
		var time = res.checktime.substring(0, res.checktime.indexOf('.'));
		
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+res.id+'" type="checkbox" class="item"/></td>'+
						  '<td>'+res.id+'</td>'+
						  '<td>'+status+'</td>'+
						  '<td title="点击预览"><span onclick="showRes(\''+res.name+'\',\'<?php echo $session['baseurl']; ?>/index.php?control=resource&action=checkRes&resid='+res.id+'\')">'+res.name+'</span></td>'+
						  '<td>'+res.size+'</td>'+
						  '<td>'+time+'</td>'+
						  '<td>'+res.username+'</td>'+
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
	
	// 资源通过审核
	function setCheck(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = $(this).attr('id');
				i++;
			}
		});
		
		if (deleteItemArr.length == 0) {
			alert('请选择需要审核的项.');
			return;
		}// if
		
		if (!confirm('确认通过审核')) return;
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=setcheck";
		
		$.ajax({
			type: "post",
			url: url,
			data: "resids=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data > 0)
				{
					alert('处理成功.');
					getResList();
				}
				else
					alert('处理失败.');
			}
		}); // ajax
	}// func
</script>