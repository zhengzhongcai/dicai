	<input type="hidden" id="orgId"/>
	<input type="hidden" id="tableType"/>
	<input type="hidden" id="gType"/>
	<input type="hidden" id="pType" value="bar"/>
	<div style="overflow:hidden;overflow-x:auto"><!----mob_search ---->
		<div class="mob_search" style="width:auto;">
			<form method="post">
				<select id="selectType" onchange="changeType()">
					<option value="day">日期</option>
					<option value="month">月份</option>
					<option value="season">季度</option>
					<option value="year">年份</option>
				</select>
				<span id="starttime" style="display:inline-block">
					<?php echo $session['timeControl'];?>
				</span>
				&nbsp;&nbsp;至&nbsp;&nbsp;
				<span id="endtime" style="display:inline-block">
					<?php echo $session['timeControl'];?>
				</span>
				<a href="javascript:void(0)" class="btn_orange" onclick="selectData()"/>查询</a>
			</form>
		</div>
      <!----mob_search end----> 
      <!----table title---->
      <div class="table_title">
		<h3></h3>
        <p></p>
		<span id="orgTitle" style="display:none"></span>
      </div>
      <!----table title end----> 
       <!----tool 工具条---->
    <div class="mob_tool" style="display:none">
		<div class="table_view" style="display:none">
			 <ul>
				<!--
				<li class="li1"><a onclick="showTableData(this)" title="查看表格" class="on"><i class="view_table"></i></a></li>
				-->
				<li><a onclick="showChart(this, 'bar')" title="查看柱状图"><i class="view_histogram"></i></a></li>
				<!--
				<li><a onclick="showChart(this, 'line')" title="查看折线图"><i class="view_line_chart"></i></a></li>
				-->
				<li><a onclick="showChart(this, 'pie')" title="查看饼图"><i class="view_pie_chart"></i></a></li>
			 </ul>
		 </div>
		<div class="tr">
			<a href="javascript:exportExcel()" class="tool_exl">导出Excel</a>
			<!-- <a href="javascript:printTable()" class="tool_print">打印</a> -->
		</div>
		<form id="fromExportExcel" method="post">
			<input type="hidden" name="orgId">
			<input type="hidden" name="timeType">
			<input type="hidden" name="starttime">
			<input type="hidden" name="endtime">
			<input type="hidden" name="exportFlag" value="1">
		</form>
    </div>
	<div id="printContent" style="display:none"></div>
		<div>
	<script src="assets/js/jquery.printarea.js"></script>
	<script>
		// 打印报表数据
		function printTable(){ 
			// 获取机构
			var orgId = $('#orgId').val();
			// 获取业务类型
			var tableType = $('#tableType').val();
			var gType = $('#gType').val();
			if("" === tableType){
				tableType = gType;
			}
			if ("" == orgId || "" == tableType)
			{
				alert('请先选择分行和统计类型.');
				return;
			}// if

			// 获取查询时间类型
			var timeType = $('#selectType').val();
			// 获取查询开始时间
			var starttime;
			// 获取查询结束时间
			var endtime;
			switch(timeType){
				case 'day':
					starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="month"]').val()+'-'+$('#starttime>[name="day"]').val();
					endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="month"]').val()+'-'+$('#endtime>[name="day"]').val();
					$('.table_title>p').html('(<span>'+starttime+'</span> 至 <span>'+endtime+'</span>)');
					break;
				case 'month':
					starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="month"]').val();
					endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="month"]').val();
					$('.table_title>p').html('(<span>'+starttime+'</span> 至 <span>'+endtime+'</span>)');
					break;
				case 'season':
					starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="season"]').val();
					endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="season"]').val();
					$('.table_title>p').html('(<span>'+$('#starttime>[name="year"]').val()+'年份'+$('#starttime>[name="season"]').val()+'季度</span> 至 <span>'+$('#endtime>[name="year"]').val()+'年份'+$('#endtime>[name="season"]').val()+'季度</span>)');
					break;
				case 'year':
					starttime = $('#starttime>[name="year"]').val();
					endtime = $('#endtime>[name="year"]').val();
					$('.table_title>p').html('(<span>'+starttime+'</span> 至 <span>'+endtime+'</span>)');
					break;
			}// switch

			// 异步获取数据
			var url = "<{$baseUrl}>/index.php?control=statistic&action="+tableType;
			$.ajax({
				type: "post",
				url: url,
				data: "orgId="+orgId+'&timeType='+timeType+'&starttime='+starttime+'&endtime='+endtime+'&printFlag=1',
				success: function(data) {
					$('#printContent').html1(data);
					$('#printContent').printArea();
				}
			});
		}// func
	</script>
	<script>
		// 导出excel表格
		function exportExcel(){
			// 获取机构
			var orgId = $('#orgId').val();
			// 业务类型
			var tableType = $('#tableType').val();
			// 获取查询时间类型
			var timeType = $('#selectType').val();
			// 获取查询开始时间
			var starttime;
			// 获取查询结束时间
			var endtime;
			switch(timeType){
				case 'day':
					starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="month"]').val()+'-'+$('#starttime>[name="day"]').val();
					endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="month"]').val()+'-'+$('#endtime>[name="day"]').val();
					$('.table_title>p').html('(<span>'+starttime+'</span> 至 <span>'+endtime+'</span>)');
					break;
				case 'month':
					starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="month"]').val();
					endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="month"]').val();
					$('.table_title>p').html('(<span>'+starttime+'</span> 至 <span>'+endtime+'</span>)');
					break;
				case 'season':
					starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="season"]').val();
					endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="season"]').val();
					$('.table_title>p').html('(<span>'+$('#starttime>[name="year"]').val()+'年份'+$('#starttime>[name="season"]').val()+'季度</span> 至 <span>'+$('#endtime>[name="year"]').val()+'年份'+$('#endtime>[name="season"]').val()+'季度</span>)');
					break;
				case 'year':
					starttime = $('#starttime>[name="year"]').val();
					endtime = $('#endtime>[name="year"]').val();
					$('.table_title>p').html('(<span>'+starttime+'</span> 至 <span>'+endtime+'</span>)');
					break;
			}// switch
			
			$('#fromExportExcel').attr('action', "<{$baseUrl}>/index.php?control=statistic&action="+tableType);
			$('#fromExportExcel > input[name="orgId"]').val(orgId);
			$('#fromExportExcel > input[name="timeType"]').val(timeType);
			$('#fromExportExcel > input[name="starttime"]').val(starttime);
			$('#fromExportExcel > input[name="endtime"]').val(endtime);
			$('#fromExportExcel').submit();
		}// func
	
	</script>
     
         <!----tool 工具条 end---->
          <!----table 表格---->
	<script LANGUAGE="Javascript" SRC="assets/FusionCharts/FusionCharts.js"></script>	
    <div class="mod_table">
		<div id="tab1">
		</div>
		<div id="displayChoose" class="table_view" style="display:none">
			 <ul>
				<!--
				<li class="li1"><a onclick="showTableData(this)" title="查看表格" class="on"><i class="view_table"></i></a></li>
				-->
				<li class="li1"><a onclick="showChart(this, 'bar')" title="查看柱状图" class="on"><i class="view_histogram"></i></a></li>
				<!--
				<li><a onclick="showChart(this, 'line')" title="查看折线图"><i class="view_line_chart"></i></a></li>
				-->
				<li><a onclick="showChart(this, 'pie')" title="查看饼图"><i class="view_pie_chart"></i></a></li>
			 </ul>
		 </div>
		<div id="tab2" style="padding:40px;display:none;width:1000px;margin:0 auto">
		</div>
    </div>
    <!----table 表格 end----> 
         
    </div>
  </div>
  </div>
  <!----right end----> 
  
</div>
<!--content end-->
<script>
	// 查询数据
	var defaultTableMenuItem = null;
	function selectData(){
		// 获取机构
		var orgId = $('#orgId').val();
		// 获取业务类型
		var tableType = $('#tableType').val();
		var gType = $('#gType').val();
		if("" === tableType){
			tableType = gType;
		}
		if ("" == orgId || "" == tableType)
		{
			alert('请先选择分行和统计类型.');
			return;
		}// if

		// 获取查询时间类型
		var timeType = $('#selectType').val();
		// 获取查询开始时间
		var starttime;
		// 获取查询结束时间
		var endtime;
		switch(timeType){
			case 'day':
				starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="month"]').val()+'-'+$('#starttime>[name="day"]').val();
				endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="month"]').val()+'-'+$('#endtime>[name="day"]').val();
				$('.table_title>p').html('(<span>'+starttime+'</span> 至 <span>'+endtime+'</span>)');
				break;
			case 'month':
				starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="month"]').val();
				endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="month"]').val();
				$('.table_title>p').html('(<span>'+starttime+'</span> 至 <span>'+endtime+'</span>)');
				break;
			case 'season':
				starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="season"]').val();
				endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="season"]').val();
				$('.table_title>p').html('(<span>'+$('#starttime>[name="year"]').val()+'年份'+$('#starttime>[name="season"]').val()+'季度</span> 至 <span>'+$('#endtime>[name="year"]').val()+'年份'+$('#endtime>[name="season"]').val()+'季度</span>)');
				break;
			case 'year':
				starttime = $('#starttime>[name="year"]').val();
				endtime = $('#endtime>[name="year"]').val();
				$('.table_title>p').html('(<span>'+starttime+'</span> 至 <span>'+endtime+'</span>)');
				break;
		}// switch
		// 异步获取数据
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=statistic&action="+tableType;
		$.ajax({
			type: "post",
			url: url,
			data: "orgId="+orgId+'&timeType='+timeType+'&starttime='+starttime+'&endtime='+endtime ,
			success: function(data) {
				//alert(data);return;
				var statObj = eval('(' + data + ')');
				switch(tableType){
					case 'busFlow':
					case 'busEff':
					case 'evaStat':
					case 'busWait':
						$('#tab1').html('');
						$('#tab1').append(statObj.tableStr);
						$('#tab1').css('display', 'block');
						$('#tab2').css('display', 'none');
						// 导出和打印
						$('.mob_tool').css('display', 'block');
						// 设置表排序特效
						$('#tab1>table').dataTable({
							"bInfo": true,
							"bPaginate": true,
							"bFilter": true,
							"bStateSave": true,
							"bAutoWidth": false,
							"iDisplayLength":defaultTableMenuItem?defaultTableMenuItem:10,
							"aoColumnDefs": [
								{ "sWidth": "20%", "aTargets": [ -1 ] }
							],
							"fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
							  $('td',nHead).each(function(index, el){
								if($(el).html().length>7){  
									//给td设置title属性,并且设置td的完整值.给title属性.  
									$(el).attr("title",$(el).html());  
									//获取td的值,进行截取。赋值给text变量保存.  
									var text=$(el).html().substring(0,7)+"...";  
									//重新为td赋值;  
									$(el).text(text);  
								} 
							  });
							},
							"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
									defaultTableMenuItem = $('#tab1').find('.dataTables_length select').val();
									if($('#tableType').val()=="busWait" || $('#tableType').val()=="staffBusWait" || $('#tableType').val()=="staffBusEff" || $('#tableType').val()=="busEff"){
                                        var startIndex = 2;
                                        if($('#tableType').val()=="staffBusEff" || $('#tableType').val()=="staffBusWait"){
                                            startIndex = 3;
                                        }
										for(var i=startIndex; i<aData.length; i++){
											if(isNaN(aData[i]))continue;
											var v = parseInt(aData[i]);
											var h = v/(60*60)|0;
											var m = (v%(60*60))/60|0;
											var s = (v%(60*60))%60;
											v = '';
											if(h){
												v = h+'<{$STAT_RIGHTER_TABLE_HOUR|default:"小时"}>';
											}
											if(m){
												v += m+'<{$STAT_RIGHTER_TABLE_MINUTE|default:"分"}>';
											}
											if(s){
												v += s+'<{$STAT_RIGHTER_TABLE_SECOND|default:"秒"}>';
											}
											if(v.length==0){
												v = '0';
											}
											$(nRow).find('td:eq('+i+')').text(v);
										}
									}
							},
							"fnInitComplete": function(oSettings, json) {
								if($('#tab1 table tfoot').length>0 && oSettings.aoData.length>0 && oSettings.aoData[0]._aData.length > 0){
									var isTimeFormat = false;
									if($('#tableType').val()=="busWait" || $('#tableType').val()=="staffBusWait" || $('#tableType').val()=="staffBusEff" || $('#tableType').val()=="busEff"){
										isTimeFormat = true;
									}
									var nColumns = oSettings.aoData[0]._aData.length;
									for(var i=2; i<nColumns; i++){ // column
										var v = 0;
										for(var j=0; j<oSettings.aoData.length; j++){ // row
											if (oSettings.aoData[j]._aData[i].indexOf('-') > -1 ) continue;
											v += parseInt(oSettings.aoData[j]._aData[i]);
										}
										if(isTimeFormat){
											var h = v/(60*60)|0;
											var m = (v%(60*60))/60|0;
											var s = (v%(60*60))%60;
											v = '';
											if(h){
												v = h+'<{$STAT_RIGHTER_TABLE_HOUR|default:"小时"}>';
											}
											if(m){
												v += m+'<{$STAT_RIGHTER_TABLE_MINUTE|default:"分"}>';
											}
											if(s){
												v += s+'<{$STAT_RIGHTER_TABLE_SECOND|default:"秒"}>';
											}
											if(v.length==0){
												v = '0';
											}
										}
										$('#tab1 table tfoot td:eq('+i+')').text(v);
									}
									
								}
							},
							"oLanguage": {
								"sLengthMenu": "显示_MENU_条 ",
								"sZeroRecords": "对不起，查询不到相关数据！",
								"sEmptyTable": "表中无数据存在！",
								"sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录",
								"sInfoFiltered": "数据表中共为 _MAX_ 条记录",
								"sSearch": "搜索",
								"sProcessing": "正在加载中......",
								"oPaginate": {
									"sFirst": "首页",
									"sPrevious": "上一页",
									"sNext": "下一页",
									"sLast": "末页"
								}
							}
						});
						break;
					case 'staffBusFlow':
					case 'staffBusEff':
					case 'staffEvaStat':
					case 'staffBusWait':
						$('#tab1').html('');
						$('#tab1').append(statObj.tableStr);
						$('#tab1').css('display', 'block');
						$('#tab2').css('display', 'none');
						// 导出和打印
						$('.mob_tool').css('display', 'block');
						// 设置表排序特效
						$('#tab1>table').dataTable({
							"bInfo": true,
							"bPaginate": true,
							"bFilter": true,
							"bStateSave": true,
							"bAutoWidth": false,
							"iDisplayLength":defaultTableMenuItem?defaultTableMenuItem:10,
							"aoColumnDefs": [
								{ "sWidth": "20%", "aTargets": [ -1 ] }
							],
							"fnHeaderCallback": function( nHead, aData, iStart, iEnd, aiDisplay ) {
							  $('td',nHead).each(function(index, el){
								if($(el).html().length>7){  
									//给td设置title属性,并且设置td的完整值.给title属性.  
									$(el).attr("title",$(el).html());  
									//获取td的值,进行截取。赋值给text变量保存.  
									var text=$(el).html().substring(0,7)+"...";  
									//重新为td赋值;  
									$(el).text(text);  
								} 
							  });
							},
							"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
									defaultTableMenuItem = $('#tab1').find('.dataTables_length select').val();
										if($('#tableType').val()=="busWait" || $('#tableType').val()=="staffBusWait" || $('#tableType').val()=="staffBusEff" || $('#tableType').val()=="busEff"){
                                        var startIndex = 2;
                                        if($('#tableType').val()=="staffBusEff" || $('#tableType').val()=="staffBusWait"){
                                            startIndex = 3;
                                        }
										for(var i=startIndex; i<aData.length; i++){
											if(isNaN(aData[i]))continue;
											var v = parseInt(aData[i]);
											var h = v/(60*60)|0;
											var m = (v%(60*60))/60|0;
											var s = (v%(60*60))%60;
											v = '';
											if(h){
												v = h+'<{$STAT_RIGHTER_TABLE_HOUR|default:"小时"}>';
											}
											if(m){
												v += m+'<{$STAT_RIGHTER_TABLE_MINUTE|default:"分"}>';
											}
											if(s){
												v += s+'<{$STAT_RIGHTER_TABLE_SECOND|default:"秒"}>';
											}
											if(v.length==0){
												v = '0';
											}
											$(nRow).find('td:eq('+i+')').text(v);
										}
									}
							},
							"fnInitComplete": function(oSettings, json) {
								if($('#tab1 table tfoot').length>0 && oSettings.aoData.length>0 && oSettings.aoData[0]._aData.length > 0){
									var isTimeFormat = false;
									if($('#tableType').val()=="busWait" || $('#tableType').val()=="staffBusWait" || $('#tableType').val()=="staffBusEff" || $('#tableType').val()=="busEff"){
										isTimeFormat = true;
									}
									var nColumns = oSettings.aoData[0]._aData.length;
									for(var i=2; i<nColumns; i++){ // column
										var v = 0;
										for(var j=0; j<oSettings.aoData.length; j++){ // row
											if (oSettings.aoData[j]._aData[i].indexOf('-') > -1 ) continue;
											v += parseInt(oSettings.aoData[j]._aData[i]);
										}
										v = '';
										if(isTimeFormat){
											var h = v/(60*60)|0;
											var m = (v%(60*60))/60|0;
											var s = (v%(60*60))%60;
											if(h){
												v = h+'<{$STAT_RIGHTER_TABLE_HOUR|default:"小时"}>';
											}
											if(m){
												v += m+'<{$STAT_RIGHTER_TABLE_MINUTE|default:"分"}>';
											}
											if(s){
												v += s+'<{$STAT_RIGHTER_TABLE_SECOND|default:"秒"}>';
											}
											if(v.length==0){
												v = '0';
											}
										}
										$('#tab1 table tfoot td:eq('+i+')').text(v);
									}
									
								}
							},
							"oLanguage": {
								"sLengthMenu": "显示_MENU_条 ",
								"sZeroRecords": "对不起，查询不到相关数据！",
								"sEmptyTable": "表中无数据存在！",
								"sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录",
								"sInfoFiltered": "数据表中共为 _MAX_ 条记录",
								"sSearch": "搜索",
								"sProcessing": "正在加载中......",
								"oPaginate": {
									"sFirst": "首页",
									"sPrevious": "上一页",
									"sNext": "下一页",
									"sLast": "末页"
								}
							}
						});
						break;
					case 'busFlowDistr':
					case 'busPieDistr':
					case 'busFlowTrend':
					case 'evaLevelDistr':
					case 'evaPieDistr':
					case 'evaLevelTrend':
						//alert(tableType);
						$('#tab2').html('');
						$('#tab2').append(statObj.chartStr);
						$('#tab1').css('display', 'none');
						$('#tab2').css('display', 'block');
						// 导出和打印
						$('.mob_tool').css('display', 'none');
						break;
				}
				$('.left_box').css('height', $('.right_box').css('height'));
				$('.left_menu_b_list').css('height', $('.right_box').css('height'));
			}
		}); // ajax
	}// func

	// 修改查询时间类型
	function changeType(){
		var type = $('#selectType').val();
		var url = "<{$baseUrl}>/index.php?control=statistic&action=getTimeControl";
		$.ajax({
			type: "post",
			url: url,
			data: "type="+type,
			success: function(data) {
				$('#starttime').html(data);
				$('#endtime').html(data);
			}
		}); // ajax
	}// func
	
	// 显示报表
	function showTableData(elem) {
		$('#tab1').css('display', 'block');
		$('#tab2').css('display', 'none');
		$(elem).parent().parent().find('a').each(function(){
			$(this).removeClass('on');
		});
		$(elem).addClass('on');
	}//
	
	// 显示图表
	function showChart(elem, type){
		$('#tab1').css('display', 'none');
		$('#tab2').css('display', 'block');
		$(elem).parent().parent().find('a').each(function(){
			$(this).removeClass('on');
		});
		$('#pType').val(type);
		$(elem).addClass('on');
		
		switch($('#gType').val()){
			case 'busFlowDistr':
			case 'busPieDistr':
				if ('pie' == type){
					$('#gType').val('busPieDistr');
					//selectData();
				}
				else{
					$('#gType').val('busFlowDistr');
					//selectData();
				}// if
				break;
			case 'evaLevelDistr':
			case 'evaPieDistr':
				if ('pie' == type){
					$('#gType').val('evaPieDistr');
					//selectData();
				}
				else{
					$('#gType').val('evaLevelDistr');
					//selectData();
				}// if
				break;
		}// switch
		selectData();
	}// func
	
	function getOrgStat(orgId, el){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=statistic&action=getOrgInfo";
		$('#orgId').val(orgId);
		$(el).closest('.treeview').find('a.selected').removeClass('selected');
		$(el).addClass('selected');
		$.ajax({
			type: "post",
			url: url,
			data: "orgId=" + orgId,
			success: function(data) {
				var orgInfo = eval('(' + data + ')');
				var tParts = $('.table_title > h3').text().split('-');
				if(tParts.length==2){
					$('.table_title > h3').html(orgInfo.JG_name+'-'+tParts[1]);
				}else{
					$('.table_title > h3').html(orgInfo.JG_name);
				}
				$('#orgTitle').html(orgInfo.JG_name);
				addOrgTab(orgInfo);
				tabChange(orgId);
				var tableType = $('#tableType').val();
				var gType = $('#gType').val();
				if(tableType || gType){
					selectData();
				}
			}
		}); // ajax
	}// func
	
	// 添加网点标签
	function addOrgTab(orgInfo){
		// 找出是否存在该网点标签
		var isExists = false;
		$('.mod_tab > ul').children('li').each(function (){
			if (('tab_'+orgInfo.JG_ID) == $(this).attr('id')) isExists = true;
		});
		// 不存在该网点的标签则添加
		if (false == isExists) $('.mod_tab>ul').append('<li id="tab_'+orgInfo.JG_ID+'" class="on"><span onclick="tabChange(\''+orgInfo.JG_ID+'\')">'+orgInfo.JG_name+'</span><a onclick="tabDelete(\''+orgInfo.JG_ID+'\')" class="tab_close"></a></li>');
	}// func
	
	// 切换激活标签，并找出网点数据
	function tabChange(orgId){
		$('#tab_'+orgId).parent().children("li").each(function(){
			$(this).removeClass('on');
		});
		$('#tab_'+orgId).addClass('on');
		
		// 找出默认的设备类型，并显示其列表
		$('#orgId').val(orgId);
		//getDmpdjInfos();
	}// func
	
	// 删除标签，并将上一标签的内容显示出来
	function tabDelete(orgId){
		var activeId = $('#tab_'+orgId).prev().attr('id');
		if ("on" == $('#tab_'+orgId).attr('class') && typeof activeId != "undefined"){
			var parts = activeId.split('_');
			tabChange(parts[1]);
		}
		else if (typeof activeId == "undefined") {
			activeId = $('#tab_'+orgId).next().attr('id');
			if (typeof activeId != "undefined"){
				var parts = activeId.split('_');
				tabChange(parts[1]);
			}// if
			else $('#tbDevice > tbody').html('');
		}// if
		$('#tab_'+orgId).remove();
		// 找出需要显示的标签和将要显示的标签
	}// func
	/*
	function getOrgStat(orgId){
		var url = "<{$baseUrl}>/index.php?control=statistic&action=busFlow";
		$('#orgId').val(orgId);
		$.ajax({
			type: "post",
			url: url,
			data: "orgId=" + orgId,
			success: function(data) {
				var statObj = eval('(' + data + ')');
				var tabStr = '<li id="'+statObj.pid+'" class="on" onclick="tabChange(this)"><span>'+statObj.pname+'</span><a onclick="deleteTab(this)" class="tab_close"></a></li>'
				$('.mod_tab>ul').append(tabStr);
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
	*/
</script>
	</div>