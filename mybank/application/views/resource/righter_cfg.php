	<!----right---->
	<div class="right_box">
		<!----tool 工具条---->
		<div class="mob_tool">
			<!--<a auth="c" href="javascript:showPopbox('addRes')" class="tool_add statItem"><{$RES_RIGHTER_VIDEO_ADD|default:"添加视频"}></a>-->
			<!--<a auth="u" href="javascript:showPopbox('editRes')" class="tool_edit statItem"><{$COMMON_EDIT|default:"编辑"}></a>
			<a auth="u" href="javascript:setCheck()" class="tool_edit statItem"><{$RES_RIGHTER_SETCHECK|default:"通过审核"}></a>-->
		</div>
		<script>
			//<{foreach item=row from=$optArr}>
			//	$('a[auth="<{$row.Operation}>"]').css('display', 'inline-block');
			//<{/foreach}>
		</script>
		<!----tool 工具条 end---->
		<!----table 表格---->
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<form action="<{$baseUrl}>/index.php?control=resource&action=storeCfg" method="post" enctype="multipart/form-data" onsubmit="return checkConfig()">
				<table>
					<tr>
						<td width="200">切换到信息发布页面的时间：</td>
						<td><input type="text" id="toPublish" name="toPublish" value="<{$config->toPublish}>" style="width:100px">(秒)</td>
					</tr>
					<tr>
						<td width="200">切换到查询系统页面的时间：</td>
						<td><input type="text" id="toSelect" name="toSelect" value="<{$config->toSelect}>" style="width:100px">(秒)</td>
					</tr>
					<tr>
						<td width="200">信息发布页面图片切换时间：</td>
						<td><input type="text" id="pptpic" name="pptpic" value="<{$config->pptpic}>" style="width:100px">(秒)</td>
					</tr>
					<tr>
						<td width="200">上传评价页面语音文件：</td>
						<td><input type="file" id="apprise" name="apprise" accept="audio/mpeg">(文件名必须为:apprise.mp3)</td>
					</tr>
					<tr>
						<td width="200">上传欢迎页面语音文件：</td>
						<td><input type="file" id="welcome" name="welcome" accept="audio/mpeg">(文件名必须为:welcome.mp3)</td>
					</tr>
					<tr>
						<td width="200">上传谢谢您页面语音文件：</td>
						<td><input type="file" id="thanks" name="thanks" accept="audio/mpeg">(文件名必须为:thanks.mp3)</td>
					</tr>
				</table>
				<input type="submit" value="保存">
			</form>
		</div>
		<!----table 表格 end----> 
	</div>
	<!----right end----> 
</div>
<!--content end-->
<script>
	function checkConfig(){
		var toPublish = $('#toPublish').val();
		var toSelect = $('#toSelect').val();
		var pptpic = $('#pptpic').val();
		
		if (toPublish == '' || toPublish < 1){
			alert('请输入正确的切换到信息发布页面的时间.');
			return false;
		}
		
		if (toSelect == '' || toSelect < 1){
			alert('请输入正确的切换到查询系统页面的时间.');
			return false;
		}
		
		if (pptpic == '' || pptpic < 1){
			alert('请输入正确的信息发布页面图片切换时间.');
			return false;
		}
		/*
		var apprise = $('#apprise').val();
		var welcome = $('#welcome').val();
		var thanks = $('#thanks').val();
		
		if (apprise == '') {
			alert("请选择评价页面的语音文件.");
			return false;
		}
		
		if (welcome == '') {
			alert("请选择欢迎页面的语音文件.");
			return false;
		}
		
		if (thanks == '') {
			alert("请选择谢谢您页面的语音文件.");
			return false;
		}
		*/
	}
</script>