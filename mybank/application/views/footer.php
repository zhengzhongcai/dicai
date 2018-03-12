<div id="popupedit1" class="pop_box1" style="height:auto;display: none;">
	<div class="pop_title">
		<h3>权限查看</h3>
		<a href="javascript:hideEditPopbox1()" class="pop_close"></a>
	</div>

	<!--	<div class="pop_title">
		<h3 id="role_id"><?=lang('AUTH_RIGHTER_EDIT')?lang('AUTH_RIGHTER_EDIT'):'角色编辑' ?></h3>
	<a href="javascript:rolemenuPopbox()" class="pop_close"></a>
</div>
-->
	<div style="height:auto;">
		<div style="text-align: center; font-size: 15px">角色名称：<input type="text" id="" readonly="true" value="<?php echo $session['rolename']; ?>"></div>
	</div>
	<ul id="demo6" style="height:500px;overflow-y:auto" >
		<?php foreach($rolemenu as $val): ?>
			<li>
				<div><?php echo $val['menu_name'] ; ?></div>
				<?php foreach($val['_child'] as $val1): ?>
					<ul style="display: none">
						<li><div><table width="1000px" border="0" id="">
									<tr>
										<hr />
									<tr id=""><?php echo $val1['menu_name']; ?></tr>
									<tr>
										<?php foreach($val1['_child'] as $val2): ?><?php if($val2['visit_roleid']== $session['roleId']){echo "<th style='width: 100px'>";
											$menid=$val2['menu_id'];
											echo "<input type='checkbox'checked id=' $menid'>";
											echo  $val2['menu_name'];
											echo "</th>";}
										else{
											$menid=$val2['menu_id'];
											echo "<th style='width: 100px'>";
											echo "<input type='checkbox' id='$menid'>";
											echo  $val2['menu_name'];
											echo "</th>";
										}
											?><?php endforeach ; ?>
										<td></td>
									</tr>
								</table>
							</div></li>
					</ul>
				<?php endforeach ; ?>
			</li>
		<?php endforeach ; ?>
	</ul>
</div>
</div>
<!----table 表格 end---->
</div>
<div class="foot">

	<p><?= lang('COMMON_COPY_RIGHT')?lang('COMMON_COPY_RIGHT'):'版权'?></p>
</div>
<script src="assets/js/common.js"></script>
<script>
// 格式化时间
function formateTiemStr(second){
	var minute = 0;
	if (second > 60) 
	{
		minute = parseInt(second/60);
		second = second%60;
	}// if
	return minute+'<?= lang('COMMON_MIN')?lang('COMMON_MIN'):'分'?>'+second+'<?= lang('COMMON_SEC')?lang('COMMON_SEC'):'秒'?>';
}// func
</script>
</body>
</html>
