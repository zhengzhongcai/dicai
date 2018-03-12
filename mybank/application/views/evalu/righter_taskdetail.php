	<!----right---->
	<div class="right_box">  
		<!----tool 工具条---->
		<div class="mob_tool">
			<a href="javascript:history.go(-1)"><{$COMMON_BACK|default:"返回"}></a>
			<!--<a auth="c" href="<{$baseUrl}>/index.php?control=evalu&action=addTask" class="tool_add statItem"><{$COMMON_ADD|default:"添加"}></a>
			<a auth="u" href="javascript:editParamInfo()" class="tool_edit statItem"><{$COMMON_EDIT|default:"编辑"}></a>
			<a auth="d" href="javascript:deleteParamInfo()" class="tool_del statItem"><{$COMMON_DEL|default:"删除"}></a>-->
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
			<table id="tbCounterPram">
				<thead>
					<tr>
						<th><{$EVALU_RIGHTER_COUNTER_NO|default:"所属窗口"}></th>
						<th><{$EVALU_RIGHTER_DEVICE_NO|default:"设备编号"}></th>
						<th><{$EVALU_RIGHTER_DEVICE_SERIES|default:"设备序列号"}></th>
						<th><{$EVALU_RIGHTER_UPDATE_STATUS|default:"更新状态"}></th>
					</tr>
				</thead>
				<tbody>
					<{foreach item=row from=$details}>
						<tr>
							<td><{$row.C_no}></td>
							<td><{$row.E_no}></td>
							<td><{$row.E_series}></td>
							<td>
								<{if $row.status eq 0}>
									<{$EVALU_RIGHTER_UPDATING|default:"等待更新..."}>
								<{else}>
									<{$EVALU_RIGHTER_UPDATED|default:"已更新"}>
								<{/if}>
							</td>
						</tr>
					<{/foreach}>
				</tbody>
			</table>
		</div>
		<!----table 表格 end----> 
	</div>
	<!----right end----> 
</div>
<!--content end-->