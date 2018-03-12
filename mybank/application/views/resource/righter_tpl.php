	<style type="text/css">
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
			<a auth="c" href="<?php echo $session['baseurl']; ?>/index.php?control=resource&action=editTpl" class="tool_add statItem">添加模板</a>
			<a auth="u" href="javascript:updateTpl()" class="tool_edit statItem">编辑</a>
			<a auth="d" href="javascript:deleteTpl()" class="tool_del statItem">删除</a>
			<a href="javascript:exportTpl()" style="text-decoration:underline">下载压缩包</a>
		</div>
		<script>
			<{foreach item=row from=$optArr}>
				$('a[auth="<{$row.Operation}>"]').css('display', 'inline-block');
			<{/foreach}>
		</script>
		<!----tool 工具条 end---->
		<!----table 表格---->
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<table id="tbCommonPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="5%">编号</th>
						<th width="20%">模板名称</th>
						<th width="10%">版本号</th>
						<th width="10%">分辨率</th>
						<th width="10%">生成状态</th>
						<th width="20%">录入时间</th>
						<th width="20%">录入用户代码</th>
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
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=getTplList";
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
			status = '<a href="javascript:genPackages('+tpl.id+')" style="color:red" title="点击生成">未生成包</a>';
		}else{
			status = '已生成包';
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
			alert('请选择其中一个进行编辑.');
			return;
		}// if
		location.href = '<?php echo $session['baseurl']; ?>/index.php?control=resource&action=editTpl&tplid='+tplid;
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
			alert('请选择需要删除的项.');
			return;
		}// if
		
		if (!confirm('确认删除!')) return;
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=deleteTpl";
		$.ajax({
			type: "post",
			url: url,
			data: "tplids=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data == '')
				{
					alert('删除成功.');
					getTplList();
				}
				else
					alert('删除失败.');
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
			alert('请选择其中一个进行编辑.');
			return;
		}// if
		location.href = '<?php echo $session['baseurl']; ?>/index.php?control=resource&action=exportTpl&tplid='+tplid;
	}// func
	
	// 生成更新包
	function genPackages(tplId){
		$('.container').show();
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=genPackage";
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
	
</script>