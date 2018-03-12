<!----right---->
<div class="right_box"> 
<!-- 
	<div class="mod_tab">
		<ul></ul>
    </div>
-->
<style>
.left_menu_b_list h2{width:100%; height:45px; overflow:hidden; border-bottom:1px solid #dedddd;font-size:18px; color:#c6011b; text-align:center; line-height:50px;}
</style>
	<div style="width:100%;float:left;">
		<div class="left_menu_b_list fl">
			<h2>报表</h2>
			<ul>
				<li style="cursor:default;" auth="52" class="statItem"><a onclick="setTableType('busFlow', this)">网点业务量统计</a></li>
				<li style="cursor:default;" auth="55" class="statItem"><a onclick="setTableType('busEff', this)">网点业务效率统计</a></li>
				<li style="cursor:default;" auth="60" class="statItem"><a onclick="setTableType('evaStat', this)">网点服务评价统计</a></li>
				<li style="cursor:default;" auth="64" class="statItem"><a onclick="setTableType('busWait', this)">网点平均等待时间统计</a></li>
				<li style="cursor:default;" auth="68" class="statItem"><a onclick="setTableType('staffBusFlow', this)">柜员业务量统计</a></li>
				<li style="cursor:default;" auth="300" class="statItem"><a onclick="setTableType('staffBusEff', this)">柜员业务效率统计</a></li>
				<li style="cursor:default;" auth="72" class="statItem"><a onclick="setTableType('staffEvaStat', this)">柜员服务评价统计</a></li>
				<li style="cursor:default;" auth="76" class="statItem"><a onclick="setTableType('staffBusWait', this)">柜员平均等待时间统计</a></li>
			</ul>
			<h2>图表</h2>
			<ul>
				<li style="cursor:default;" auth="80" class="statItem"><a onclick="setTableType('busFlowDistr', this, 'g')">业务分布分析</a></li>
				<li style="cursor:default;" auth="84" class="statItem"><a onclick="setTableType('busFlowTrend', this)">业务趋势分析</a></li>
				<li style="cursor:default;" auth="88" class="statItem"><a onclick="setTableType('evaLevelDistr', this, 'g')">评价分布分析</a></li>
				<li style="cursor:default;" auth="92" class="statItem"><a onclick="setTableType('evaLevelTrend', this)">评价趋势分析</a></li>
			</ul>
		</div>
		<!----左边二级菜单 end---->
		<script>
			<?php foreach($www as $val): ?>
			$('li[auth="<?php echo $val['menurole_id'];?>"]').css('display', 'block');
			<?php endforeach;?>
			// 设置查询的图标类型
			function setTableType(tableType, elem, gType){
				var orgId = $('#orgId').val();
				if (orgId == "")
				{
					alert("请先选择机构.");
					return;
				}// func
				if(gType==='g'){
					if($('#pType').val()!='bar'){
						switch(tableType){
							case 'busFlowDistr':
								tableType = 'busPieDistr';
								break;
							case 'evaLevelDistr':
								tableType = 'evaPieDistr';
								break;
						}
					}
					$('#gType').val(tableType);
				}
				if(gType!=='g'){
					$('#tableType').val(tableType);
				}else{
					$('#tableType').val('');
				}
				$('.table_title>h3').html($('#orgTitle').html()+'-'+$(elem).html());
				$(elem).closest('.left_menu_b_list').find('a').each(function(){
					$(this).removeClass('on');
				});
				$(elem).addClass('on');
				// 清空报表位置
				$('#tab1').html('');
				$('#tab2').html('');
				
				if (tableType=='busFlowDistr' || tableType=='busPieDistr' || tableType=='evaLevelDistr' || tableType=='evaPieDistr') $('#displayChoose').css('display', 'block');
				else $('#displayChoose').css('display', 'none');
				
				$('#displayChoose').closest('.left_menu_b_list').find('a').each(function(){
					$(this).removeClass('on');
				});
				selectData();
			}// func
			
			function getStatData(action){
				var url="<{$baseUrl}>/index.php?control=statistic&action="+action;
				var orgId = $('#orgId').val();
				if (orgId == "")
				{
					alert('<{$STAT_RIGHTER_CHOOSE_AGENCY_TIP|default:"请先选择机构."}>');
					return;
				}// func
				$.ajax({
					type: "post",
					url: url,
					data: "orgId=" + orgId,
					success: function(data) {
						var statObj = eval('(' + data + ')');
						$('.table_title>h3').html(statObj.title);
						$('.mob_tool').css("display", "block");
						$('#tab1').html('');
						$('#tab1').append(statObj.tableStr);
						// 设置表排序特效
						$('#tab1>table').dataTable({
							"bPaginate": false,
							"bFilter": false
						});
						$('#tab2').html('');
						$('#tab2').append(statObj.chartStr);
					}
				}); // ajax
			}// func
		</script>