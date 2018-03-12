<?php /* Smarty version Smarty-3.1.8, created on 2017-04-05 17:29:30
         compiled from "D:\bankSct2\BANK\application/views\statistic\righter_table.html" */ ?>
<?php /*%%SmartyHeaderCode:2609358c909f46e9082-48669822%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd77a3d9963907459c1d45cef7017fa090d12968d' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\statistic\\righter_table.html',
      1 => 1491384563,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2609358c909f46e9082-48669822',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58c909f48329d8_95350912',
  'variables' => 
  array (
    'STAT_RIGHTER_CHART_BAR' => 0,
    'STAT_RIGHTER_CHART_PIE' => 0,
    'STAT_RIGHTER_EXPORT_EXCEL' => 0,
    'STAT_RIGHTER_TIP1' => 0,
    'STAT_RIGHTER_TABLE_TO' => 0,
    'STAT_RIGHTER_TABLE_YEAR' => 0,
    'STAT_RIGHTER_TABLE_SEASON' => 0,
    'baseUrl' => 0,
    'STAT_RIGHTER_TABLE_HOUR' => 0,
    'STAT_RIGHTER_TABLE_MINUTE' => 0,
    'STAT_RIGHTER_TABLE_SECOND' => 0,
    'STAT_RIGHTER_TABLE_DISPLAY' => 0,
    'STAT_RIGHTER_TABLE_ITEM' => 0,
    'STAT_RIGHTER_TABLE_ZERORECO' => 0,
    'STAT_RIGHTER_TABLE_EMPTY' => 0,
    'STAT_RIGHTER_TABLE_CURR_DISPLAY' => 0,
    'STAT_RIGHTER_TABLE_INFO' => 0,
    'STAT_RIGHTER_TABLE_INFO_FILTER' => 0,
    'STAT_RIGHTER_TABLE_SEARCH' => 0,
    'STAT_RIGHTER_TABLE_PROCESS' => 0,
    'STAT_RIGHTER_TABLE_FIRST' => 0,
    'STAT_RIGHTER_TABLE_PREVIOU' => 0,
    'STAT_RIGHTER_TABLE_NEXT' => 0,
    'STAT_RIGHTER_TABLE_LAST' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c909f48329d8_95350912')) {function content_58c909f48329d8_95350912($_smarty_tpl) {?>	<input type="hidden" id="orgId"/>
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
					<<?php ?>?php echo $session['timeControl'];?<?php ?>>
				</span>
				&nbsp;&nbsp;至&nbsp;&nbsp;
				<span id="endtime" style="display:inline-block">
					<<?php ?>?php echo $session['timeControl'];?<?php ?>>
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
				<li><a onclick="showChart(this, 'bar')" title="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_CHART_BAR']->value)===null||$tmp==='' ? "查看柱状图" : $tmp);?>
"><i class="view_histogram"></i></a></li>
				<!--
				<li><a onclick="showChart(this, 'line')" title="查看折线图"><i class="view_line_chart"></i></a></li>
				-->
				<li><a onclick="showChart(this, 'pie')" title="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_CHART_PIE']->value)===null||$tmp==='' ? "查看饼图" : $tmp);?>
"><i class="view_pie_chart"></i></a></li>
			 </ul>
		 </div>
		<div class="tr">
			<a href="javascript:exportExcel()" class="tool_exl"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_EXPORT_EXCEL']->value)===null||$tmp==='' ? "导出Excel" : $tmp);?>
</a>
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
				alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TIP1']->value)===null||$tmp==='' ? "请先选择分行和统计类型." : $tmp);?>
');
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
					$('.table_title>p').html('(<span>'+starttime+'</span> <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_TO']->value)===null||$tmp==='' ? "至" : $tmp);?>
 <span>'+endtime+'</span>)');
					break;
				case 'month':
					starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="month"]').val();
					endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="month"]').val();
					$('.table_title>p').html('(<span>'+starttime+'</span> <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_TO']->value)===null||$tmp==='' ? "至" : $tmp);?>
 <span>'+endtime+'</span>)');
					break;
				case 'season':
					starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="season"]').val();
					endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="season"]').val();
					$('.table_title>p').html('(<span>'+$('#starttime>[name="year"]').val()+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_YEAR']->value)===null||$tmp==='' ? "年份" : $tmp);?>
'+$('#starttime>[name="season"]').val()+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_SEASON']->value)===null||$tmp==='' ? "季度" : $tmp);?>
</span> <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_TO']->value)===null||$tmp==='' ? "至" : $tmp);?>
 <span>'+$('#endtime>[name="year"]').val()+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_YEAR']->value)===null||$tmp==='' ? "年份" : $tmp);?>
'+$('#endtime>[name="season"]').val()+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_SEASON']->value)===null||$tmp==='' ? "季度" : $tmp);?>
</span>)');
					break;
				case 'year':
					starttime = $('#starttime>[name="year"]').val();
					endtime = $('#endtime>[name="year"]').val();
					$('.table_title>p').html('(<span>'+starttime+'</span> <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_TO']->value)===null||$tmp==='' ? "至" : $tmp);?>
 <span>'+endtime+'</span>)');
					break;
			}// switch

			// 异步获取数据
			var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=statistic&action="+tableType;
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
					$('.table_title>p').html('(<span>'+starttime+'</span> <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_TO']->value)===null||$tmp==='' ? "至" : $tmp);?>
 <span>'+endtime+'</span>)');
					break;
				case 'month':
					starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="month"]').val();
					endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="month"]').val();
					$('.table_title>p').html('(<span>'+starttime+'</span> <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_TO']->value)===null||$tmp==='' ? "至" : $tmp);?>
 <span>'+endtime+'</span>)');
					break;
				case 'season':
					starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="season"]').val();
					endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="season"]').val();
					$('.table_title>p').html('(<span>'+$('#starttime>[name="year"]').val()+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_YEAR']->value)===null||$tmp==='' ? "年份" : $tmp);?>
'+$('#starttime>[name="season"]').val()+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_SEASON']->value)===null||$tmp==='' ? "季度" : $tmp);?>
</span> <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_TO']->value)===null||$tmp==='' ? "至" : $tmp);?>
 <span>'+$('#endtime>[name="year"]').val()+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_YEAR']->value)===null||$tmp==='' ? "年份" : $tmp);?>
'+$('#endtime>[name="season"]').val()+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_SEASON']->value)===null||$tmp==='' ? "季度" : $tmp);?>
</span>)');
					break;
				case 'year':
					starttime = $('#starttime>[name="year"]').val();
					endtime = $('#endtime>[name="year"]').val();
					$('.table_title>p').html('(<span>'+starttime+'</span> <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_TO']->value)===null||$tmp==='' ? "至" : $tmp);?>
 <span>'+endtime+'</span>)');
					break;
			}// switch
			
			$('#fromExportExcel').attr('action', "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=statistic&action="+tableType);
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
				<li class="li1"><a onclick="showChart(this, 'bar')" title="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_CHART_BAR']->value)===null||$tmp==='' ? "查看柱状图" : $tmp);?>
" class="on"><i class="view_histogram"></i></a></li>
				<!--
				<li><a onclick="showChart(this, 'line')" title="查看折线图"><i class="view_line_chart"></i></a></li>
				-->
				<li><a onclick="showChart(this, 'pie')" title="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_CHART_PIE']->value)===null||$tmp==='' ? "查看饼图" : $tmp);?>
"><i class="view_pie_chart"></i></a></li>
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
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TIP1']->value)===null||$tmp==='' ? "请先选择分行和统计类型." : $tmp);?>
');
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
				$('.table_title>p').html('(<span>'+starttime+'</span> <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_TO']->value)===null||$tmp==='' ? "至" : $tmp);?>
 <span>'+endtime+'</span>)');
				break;
			case 'month':
				starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="month"]').val();
				endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="month"]').val();
				$('.table_title>p').html('(<span>'+starttime+'</span> <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_TO']->value)===null||$tmp==='' ? "至" : $tmp);?>
 <span>'+endtime+'</span>)');
				break;
			case 'season':
				starttime = $('#starttime>[name="year"]').val()+'-'+$('#starttime>[name="season"]').val();
				endtime = $('#endtime>[name="year"]').val()+'-'+$('#endtime>[name="season"]').val();
				$('.table_title>p').html('(<span>'+$('#starttime>[name="year"]').val()+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_YEAR']->value)===null||$tmp==='' ? "年份" : $tmp);?>
'+$('#starttime>[name="season"]').val()+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_SEASON']->value)===null||$tmp==='' ? "季度" : $tmp);?>
</span> <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_TO']->value)===null||$tmp==='' ? "至" : $tmp);?>
 <span>'+$('#endtime>[name="year"]').val()+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_YEAR']->value)===null||$tmp==='' ? "年份" : $tmp);?>
'+$('#endtime>[name="season"]').val()+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_SEASON']->value)===null||$tmp==='' ? "季度" : $tmp);?>
</span>)');
				break;
			case 'year':
				starttime = $('#starttime>[name="year"]').val();
				endtime = $('#endtime>[name="year"]').val();
				$('.table_title>p').html('(<span>'+starttime+'</span> <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_TO']->value)===null||$tmp==='' ? "至" : $tmp);?>
 <span>'+endtime+'</span>)');
				break;
		}// switch
		// 异步获取数据
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=statistic&action="+tableType;
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
												v = h+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_HOUR']->value)===null||$tmp==='' ? "小时" : $tmp);?>
';
											}
											if(m){
												v += m+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_MINUTE']->value)===null||$tmp==='' ? "分" : $tmp);?>
';
											}
											if(s){
												v += s+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_SECOND']->value)===null||$tmp==='' ? "秒" : $tmp);?>
';
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
												v = h+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_HOUR']->value)===null||$tmp==='' ? "小时" : $tmp);?>
';
											}
											if(m){
												v += m+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_MINUTE']->value)===null||$tmp==='' ? "分" : $tmp);?>
';
											}
											if(s){
												v += s+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_SECOND']->value)===null||$tmp==='' ? "秒" : $tmp);?>
';
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
								"sLengthMenu": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_DISPLAY']->value)===null||$tmp==='' ? "显示" : $tmp);?>
_MENU_<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_ITEM']->value)===null||$tmp==='' ? "条" : $tmp);?>
 ",
								"sZeroRecords": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_ZERORECO']->value)===null||$tmp==='' ? "对不起，查询不到相关数据！" : $tmp);?>
",
								"sEmptyTable": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_EMPTY']->value)===null||$tmp==='' ? "表中无数据存在！" : $tmp);?>
",
								"sInfo": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_CURR_DISPLAY']->value)===null||$tmp==='' ? "当前显示" : $tmp);?>
 _START_ <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_TO']->value)===null||$tmp==='' ? "到" : $tmp);?>
 _END_ <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_ITEM']->value)===null||$tmp==='' ? "条" : $tmp);?>
，<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_INFO']->value)===null||$tmp==='' ? "共" : $tmp);?>
 _TOTAL_ <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_ITEM']->value)===null||$tmp==='' ? "条记录" : $tmp);?>
",
								"sInfoFiltered": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_INFO_FILTER']->value)===null||$tmp==='' ? "数据表中共为" : $tmp);?>
 _MAX_ <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_ITEM']->value)===null||$tmp==='' ? "条记录" : $tmp);?>
",
								"sSearch": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_SEARCH']->value)===null||$tmp==='' ? "搜索" : $tmp);?>
",
								"sProcessing": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_PROCESS']->value)===null||$tmp==='' ? "正在加载中......" : $tmp);?>
",
								"oPaginate": {
									"sFirst": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_FIRST']->value)===null||$tmp==='' ? "首页" : $tmp);?>
",
									"sPrevious": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_PREVIOU']->value)===null||$tmp==='' ? "上一页" : $tmp);?>
",
									"sNext": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_NEXT']->value)===null||$tmp==='' ? "下一页" : $tmp);?>
",
									"sLast": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_LAST']->value)===null||$tmp==='' ? "末页" : $tmp);?>
"
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
												v = h+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_HOUR']->value)===null||$tmp==='' ? "小时" : $tmp);?>
';
											}
											if(m){
												v += m+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_MINUTE']->value)===null||$tmp==='' ? "分" : $tmp);?>
';
											}
											if(s){
												v += s+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_SECOND']->value)===null||$tmp==='' ? "秒" : $tmp);?>
';
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
												v = h+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_HOUR']->value)===null||$tmp==='' ? "小时" : $tmp);?>
';
											}
											if(m){
												v += m+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_MINUTE']->value)===null||$tmp==='' ? "分" : $tmp);?>
';
											}
											if(s){
												v += s+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_SECOND']->value)===null||$tmp==='' ? "秒" : $tmp);?>
';
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
								"sLengthMenu": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_DISPLAY']->value)===null||$tmp==='' ? "显示" : $tmp);?>
_MENU_<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_ITEM']->value)===null||$tmp==='' ? "条" : $tmp);?>
 ",
								"sZeroRecords": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_ZERORECO']->value)===null||$tmp==='' ? "对不起，查询不到相关数据！" : $tmp);?>
",
								"sEmptyTable": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_EMPTY']->value)===null||$tmp==='' ? "表中无数据存在！" : $tmp);?>
",
								"sInfo": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_CURR_DISPLAY']->value)===null||$tmp==='' ? "当前显示" : $tmp);?>
 _START_ <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_TO']->value)===null||$tmp==='' ? "到" : $tmp);?>
 _END_ <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_ITEM']->value)===null||$tmp==='' ? "条" : $tmp);?>
，<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_INFO']->value)===null||$tmp==='' ? "共" : $tmp);?>
 _TOTAL_ <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_ITEM']->value)===null||$tmp==='' ? "条记录" : $tmp);?>
",
								"sInfoFiltered": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_INFO_FILTER']->value)===null||$tmp==='' ? "数据表中共为" : $tmp);?>
 _MAX_ <?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_ITEM']->value)===null||$tmp==='' ? "条记录" : $tmp);?>
",
								"sSearch": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_SEARCH']->value)===null||$tmp==='' ? "搜索" : $tmp);?>
",
								"sProcessing": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_PROCESS']->value)===null||$tmp==='' ? "正在加载中......" : $tmp);?>
",
								"oPaginate": {
									"sFirst": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_FIRST']->value)===null||$tmp==='' ? "首页" : $tmp);?>
",
									"sPrevious": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_PREVIOU']->value)===null||$tmp==='' ? "上一页" : $tmp);?>
",
									"sNext": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_NEXT']->value)===null||$tmp==='' ? "下一页" : $tmp);?>
",
									"sLast": "<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_TABLE_LAST']->value)===null||$tmp==='' ? "末页" : $tmp);?>
"
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
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=statistic&action=getTimeControl";
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
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=statistic&action=getOrgInfo";
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
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=statistic&action=busFlow";
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
	</div><?php }} ?>