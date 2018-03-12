	<input id="orgId" type="hidden"/>
	<!----right---->
	<div class="right_box">  
		<!----tab 标签页---->
		<div class="mod_tab">
			<ul></ul>
		</div>
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<span>设备类型:</span>
			<select id="deviceType" name="deviceType">
				<option value="All">全部</option>
				<option value="Dmpdj" >排队机</option>
				<option value="Pad" >呼叫器</option>
				<option value="Cled" >窗口LED</option>
				<option value="Mled" >主LED</option>
				<option value="Mled" >广告机</option>
			</select>
			<a auth="c" href="javascript:showPopbox()" class="tool_add statItem">添加</a>
			<a auth="u" href="javascript:editOrgInfo()" class="tool_edit statItem">编辑</a>
			<a auth="d" href="javascript:deleteOrgInfo()" class="tool_del statItem">删除</a>
			上线:<b id="onlineListTotal">0</b>台&nbsp;&nbsp;
			未上线:<b id="unlineListTotal">0</b>台&nbsp;&nbsp;
			总计:<b id="listTotal">0</b>台&nbsp;&nbsp;
		</div>
		<script>
			function showPopbox(){
				alert("请选择网点.");
			}// func
			
			function editOrgInfo(){
				alert("请选择网点.");
			}// func
			
			function deleteOrgInfo(){
				alert("请选择网点.");
			}// func
		
		</script>
		<!----tool 工具条 end---->
		<script>
			//<{foreach item=row from=$optArr}>
			//	$('a[auth="<{$row.Operation}>"]').css('display', 'inline-block');
			//<{/foreach}>
		</script>
		<!----table 表格---->
		<div class="mod_table">
		</div>
		<!----table 表格 end----> 
	</div>
	<!----right end----> 
</div>
<!--content end-->
<script>
	// 获取网点设备基本信息
	function getDeviceInfo(orgId){
		var device = $('#deviceType').val();
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=device&action=get"+device+'List&fcode=device&orgId='+orgId+'&tabs='+orgId;
		location.href=url;
	}// func
</script>