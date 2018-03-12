// JavaScript Document
var reg=/[\~\!\@\#\$\%\^\&\*\(\)\_\+\`\-\=\～\！\＠\＃\＄\％\＾\＆\＊\\（\）\＿\＋\＝\－\｀\[\]\\'\;\/\.\,\<\>\?\:\"\{\}\|\，\．\／\；\＇\［\］\＼\＜\＞\？\：\＂\｛\｝\｜'\。\r+\n+\t+\s]/g;

//tab标签
function tabs(n)
{

	for (var i = 1; i <= 2; i++)
	{
		_('tab_a' + i).style.display = (i == n) ? 'block' : 'none';
		_('tab_' + i).className = (i == n) ? 'tab_selected' : 'none';
	}
}

function Week_getProgramlist(weekdayid)
{
		var gdtime=playList.getWeekCycleDateTime(),
		weekms = gdtime.s.d.m-1,
		weekme = gdtime.e.d.m-1,
		weekdatastart = new Date(gdtime.s.d.y,weekms,gdtime.s.d.d),
		weekdataend = new Date(gdtime.e.d.y,weekme,gdtime.e.d.d),
		dayss=weekdataend.getTime()-weekdatastart.getTime(), //时间差的毫秒数
     //计算出相差天数
		days=Math.floor(dayss/(24*3600*1000));
	if(days<7)
	{
	    alert("时间差必须大于一周!"); 
		return false;
	}

	$.ajax({
				 type:"POST",
				 data: "weekday="+weekdayid,
				 url:"index.php?control=playlist&action=getProfileInfo&type="+playList.info.golbal.playListType,
				 success: function(result)
				 {
					art.dialog({
						padding:0,
						title:'选择播放单元',
						id:'viewNodeInfoUi',
						width: '500px',
						lock:true,
						content: result
					});
					$('#weekStartTime').val("00:00:00").timepicker({timeFormat: 'hh:mm:ss',showSecond: true}).attr({readOnly:true});
					$('#weekEndTime').val("23:59:59").timepicker({timeFormat: 'hh:mm:ss',showSecond: true}).attr({readOnly:true});
				 },
				 error: function()
				 {
					alert("ajax error");

				 }
		   });
}


function chosepro(rowid){
        //获取 radio 所在容器名，根据容器名称搜索 radio 的标签 input
        var checks = document.getElementById('tab_prolist').getElementsByTagName("input");

		if(checks.length<=0)
		{
			alert("您还没选择节目!");
			return false;
		}

		var stime=_stime=$('#weekStartTime').val(),etime=_etime=$('#weekEndTime').val();
		if(_stime.replace(":","")*1>=etime.replace(":","")*1)
		{
		   alert('开始时间必须小于结束时间!');
		   return false;
		}
		var pid = "p__"+rowid+playList.info.programs.weekCycle.length;
		//alert(pid);
        //初始化对象
        var grade = "";
        //是否选中 radio,默认不选中，radio 可指定 checked="checked" 不受 flag 影响
        var flag = false;
        //根据容器中搜索到的 input 标签的个数（长度）进行遍历
        for(var i=0;i<checks.length;i++){
            //如果当前有选中
            	if(checks[i].checked == true){
                    //赋值
                    grade = checks[i].value;
               		var strs = grade.split('|');
					var renderInfo={weekDay:rowid,programViewHtmlId:pid,startTime:stime,endTime:etime,programName:strs[1]};
					weekProgramRender(renderInfo);
					var programInfo={
						weekDay:rowid,
						programId: strs[0],
						programName:strs[1],
						startTime:stime,
						endTime:etime,
						key:pid};
					cacheWeekCycleProgramInfo(programInfo);
                }
        }
		art.dialog.list['viewNodeInfoUi'].close();
       return grade;
    }
function weekProgramRender(renderInfo)
{
	var job = _('week_info').rows;
	job[1].cells[renderInfo["weekDay"]].innerHTML = job[1].cells[renderInfo["weekDay"]].innerHTML+"<p id=\""+renderInfo["programViewHtmlId"]+"\" class='week_day_program_con'>"+renderInfo["programName"]+"<a href=\"javascript:void(0)\" onclick=\"Week_DeletePlaylist("+renderInfo["weekDay"]+",'"+renderInfo["programViewHtmlId"]+"',this)\" >&nbsp;&nbsp;删</a>"+"<BR/>"+"("+renderInfo["startTime"]+"~"+renderInfo["endTime"]+")</p>";
}
function Week_DeletePlaylist(weekDay,pid,o)
{
	parentNode(parentNode(o)).removeChild(parentNode(o));

	var programArrayInfo=playList.info.programs.weekCycle,
		n=programArrayInfo.length;
		for(var i =0; i<n; i)
		{
			if(programArrayInfo[i]["key"]==pid&&programArrayInfo[i]["weekDay"]==weekDay)
			{
				playList.info.programs.weekCycle.splice(i,1);
				programArrayInfo=playList.info.programs.weekCycle;
				i=0,n=programArrayInfo.length;
			}
			else
			{i++;}
		}
}
function cacheWeekCycleProgramInfo(info){
	var gdtime=playList.getWeekCycleDateTime(),
		weekms = gdtime.s.d.m-1,
		weekme = gdtime.e.d.m-1,
		weekdatastart = new Date(gdtime.s.d.y,weekms,gdtime.s.d.d),
		weekdataend = new Date(gdtime.e.d.y,weekme,gdtime.e.d.d),
		dayss=weekdataend.getTime()-weekdatastart.getTime(), //时间差的毫秒数
     //计算出相差天数
		days=Math.floor(dayss/(24*3600*1000));
	if(days<7)
	{
	    alert("时间差必须大于一周!");
		return false;
	}
	for(var i=0;i<=days;i++)
	{
	    var tem = weekdatastart,
	    tem = new Date(tem.getTime()+i*24*3600*1000),
		willWeekday =  tem.getDay();
		var m = tem.getMonth()+1;
		var d = tem.getDate();
		if(m<10){m="0"+m;}
		if(d<10){d="0"+d;}
		var timeday = tem.getFullYear()+"-"+m+"-"+d;
		if(willWeekday == info["weekDay"])
		{
			var programInfo={
				weekDay:info["weekDay"],
				programId:info["programId"],
				programName:info["programName"],
				startDate:timeday,
				endDate:timeday,
				startTime:info["startTime"],
				endTime:info["endTime"],
				programType:"",
				key:info["key"],
				playType:"weekCycle",
				prior:1,
				playTypeName:"周周期",
				extend:'"playType":"weekCycle"||"weekDay":"'+willWeekday+'"||"key":"'+info["key"]+'"'
				};
			playList.info.programs.weekCycle.push(programInfo);
		}
	}
}


function checkIsExist(){
	$.ajax({
						 type:"post",
						 data: "playlistName="+$("#playlistName").val().replace(reg,""),
						 url:"index.php?control=playlist&action=checkIsExists",
						 success: function(result)

						 {///bank/index.php?control=playlist&action=addPlayList'

									if(result=="0"){
									}else{
										$("#playlistNameInfo").html("播放计划名已用");
									}

						 },

						 error: function()
						 {
									alert("ajax error");

						 }
		   });
}
function checkPlaylistName(){
	var playlistName=$("#playlistName").val();
	$("#playlistNameInfo").html("");
	if(playlistName==''){
		$("#playlistNameInfo").html("播放计划名称不能为空");
	}else{
		checkIsExist();
	}
}
function deltr(index)
{
	$table=$("#tab tr[id='"+index+"']").remove();
}


$(document).ready(function(){

	playList.init();
	playList.edit.init();
});
//{startDate:"",endDate:"",startTime:"",endTime:"",program:"",playType:""}
var playList={
	cacheInfo:{
		//时间线
		timeLine:[]},
	info:{golbal:{startDateTime:"",endDateTime:"",playListName:"",playListType:"x86",playlistModel:0},programs:{dayCycle:[],weekCycle:[]}},
	init:function(){
		$('#input_weekEndDatetime').datepicker({
			onClose: function(dateText, inst) {
				var startDateTextBox = $('#input_weekStartDatetime');
				if (startDateTextBox.val() != '') {
					//alert(startDateTextBox.val());
					var testStartDate = new Date(startDateTextBox.val());
					var testEndDate = new Date(dateText);
					//alert(testStartDate.getTime()+"::"+testEndDate.getTime());
					if (testStartDate.getTime() > testEndDate.getTime())
						startDateTextBox.val(dateText);
				}
				else {
					startDateTextBox.val(dateText);
				}
				playList.setWeekEndDateTime(this.value);
				//alert(this.value);
				$("#edate").val(this.value);
			},
			onSelect: function (selectedDateTime){
				//var end = $(this).datetimepicker('getDate');
//				$('#input_weekStartDatetime').datetimepicker('option', 'maxDate', new Date(end.getTime()) );
				playList.setWeekEndDateTime(this.value);
				$("#edate").val(this.value.split(" ")[0]);
			}
		}).attr({readOnly:true});
		$('#input_weekStartDatetime').datepicker({
			minDate:0,
			onClose: function(dateText, inst) {
				var endDateTextBox = $('#input_weekEndDatetime');
				if (endDateTextBox.val() != '') {
					var testStartDate = new Date(dateText);
					var testEndDate = new Date(endDateTextBox.val());
					if (testStartDate.getTime() > testEndDate.getTime())
						endDateTextBox.val(dateText);
				}
				else {
					endDateTextBox.val(dateText);
				}
				playList.setWeekStartDateTime(this.value);
				//$("#sdate").val(this.value.split(" ")[0]);
			},
			onSelect: function (selectedDateTime){
				var start = $(this).datetimepicker('getDate');
				$('#input_weekEndDatetime').datepicker('option', 'minDate', new Date(start.getTime()));
				playList.setWeekStartDateTime(this.value);
				//$("#sdate").val(this.value.split(" ")[0]);
			}
		}).attr({readOnly:true});
		$('#input_weekEndDatetime').datepicker('option', 'minDate', new Date());
		$("#playlistName").change(playList.setPlaylistName);
		$('#playListType').change(playList.setPlaylistType);
		$("#stime").timepicker({
									timeFormat: 'hh:mm:ss',showSecond: true,
									onClose:function(timeText, inst) {
											var endTimeTextBox = $('#etime');
											if (endTimeTextBox.val() != '') {
												var testStartTime = new Date(timeText);
												var testEndTime = new Date(endTimeTextBox.val());
												if (testStartTime.getTime() > testEndTime.getTime())
													endTimeTextBox.val(timeText);
											}
											else {
												endTimeTextBox.val(timeText);
											}
										}
									,
									onSelect:function(selectedTime){}
								}).attr({readOnly:true});
		$("#etime").timepicker({
									timeFormat: 'hh:mm:ss',showSecond: true,
									onClose:function(selectedTime){
										var _selectedTime=parseInt(selectedTime.replace(/:/g,""));
										var stime=$("#stime").val();
										var _stime=parseInt(stime.replace(/:/g,""));
										if(_stime>=_selectedTime){
											$("#etime").val(stime);
										}
										
									},
									onSelect:function(selectedTime){
										var _selectedTime=parseInt(selectedTime.replace(/:/g,""));
										var stime=$("#stime").val();
										var _stime=parseInt(stime.replace(/:/g,""));
										if(_stime>=_selectedTime){
											$("#etime").val(stime);
										}
										
									}
								}).attr({readOnly:true});
		$('#sdate').datepicker({minDate:0,
								onClose: function(dateText, inst) {
									var endDateTextBox = $('#edate');
									if (endDateTextBox.val() != '') {
										var testStartDate = new Date(dateText);
										var testEndDate = new Date(endDateTextBox.val());
										if (testStartDate.getTime() > testEndDate.getTime())
											endDateTextBox.val(dateText);
									}
									else {
										endDateTextBox.val(dateText);
									}
								},
								onSelect:function(selectedDate){
									$('#edate').datetimepicker('option', 'minDate', new Date(this.value));
								}});
		$('#edate').datepicker({minDate:0});
		$("#cycleAdd_btn").click(playList.addCycleProgram);
		$("#uncycleAdd_btn").click(playList.addUnCycleProgram);
		
		var date = new Date(),
			year = date.getFullYear(),
			month = (date.getMonth()+1),
			day = date.getDate(),
			hours = date.getHours(),
			minutes = date.getMinutes(),
			seconds = date.getSeconds();
		if(month < 10){month = "0"+month;}
		if(day < 10){day = "0"+day;}
		if(hours<10){hours="0"+hours;}
		if(minutes<10){minutes="0"+minutes;}
		if(seconds<10){seconds="0"+seconds;}
		var showDate = year +"-"+ month+"-"+ day,
			showTime = hours +":"+ minutes +":"+ seconds;
		$('#input_weekStartDatetime').val(showDate);
		$('#input_weekEndDatetime').val(showDate);
		playList.info.golbal.startDateTime=showDate+" 00:00:00";
		playList.info.golbal.endDateTime=showDate+" 23:59:59";
		$('#sdate').val(showDate);
		$('#edate').val(showDate);
		$('#stime').val("00:00:00");
		$('#etime').val("23:59:59");

		$('#sdate-time').val(showDate+" 00:00:00");
		$('#edate-time').val(showDate+" 23:59:59");

		$("#save_playList_Btn").click(playList.save);
		
		//设置播放计划周期类型
		$("#tab_1").click(function(){playList.setPlaylistModel(0);});
		$("#tab_2").click(function(){playList.setPlaylistModel(1);});
	},
	setPlaylistModel:function(model){
	    //0 天周期播放列 1 周周期播放列表
	    playList.info.golbal.playlistModel=model;
	},
	setPlaylistName:function(){
		playList.info.golbal.playListName=$("#playlistName").val();
	},
	setWeekStartDateTime:function(t){
		playList.info.golbal.startDateTime=t;
		$("#input_weekStartDatetime").val(t);
	},
	setWeekEndDateTime:function(t){
		playList.info.golbal.endDateTime=t;
		
		$("#input_weekEndDatetime").val(t);
	},
	setPlaylistType:function(){
		playList.info.golbal.playListType=this.value;
		//清理已经添加的节目
		playList.info.golbal.programs={dayCycle:[],weekCycle:[]};
		//清理界面数据 天周期
		$("#tab").find("tr").each(function(index,element){
			if(index!=0){
				$(element).remove();
			}
		});
		//清理界面数据 周周期
		$("#weekCycleContainer").find("td").each(function(index,el){
			$(el).find("p").each(function(i) {
			  	$(this).remove();
			});
		});
		var _this=$("#programList");
		$.ajax({
			type:"get",
			url:"index.php?control=c_playListManage&action=getProgramInfoToPlayListAdd&proType="+playList.info.golbal.playListType,
			success:function(result){
				
				result=$.parseJSON(result);
				if(typeof(result)=="object"&&result.state)
				{
					_this.html("");
					var pro=result.data;
					
					for(var i =0,n=pro.length; i<n; i++){
						$('<option value="'+pro[i]["profileID"]+'" title="'+pro[i]["profileType"]+'">'+pro[i]['profileName']+'</option>').appendTo(_this);	
					}
						
				}
				
			},
			error:function(){}
		});
	},
	cyclePragromReady:function(){
		var programName="",
			programId="";
			$("#programList").children("option").each(function(index, element) {
				if(element.selected)
				{
					programName = element.innerHTML;
					programId = element.value;
				}
       		});
			var info={startDate:$('#sdate').val(),
					  endDate:$('#edate').val(),
					  startTime:$('#stime').val(),
					  endTime:$('#etime').val(),
					  programId:programId,
					  programName:programName
					  };
			return playList.setDayCycleProgram(info);
	},
	setDayCycleProgram:function(info){
		var sdate=info["startDate"].split("-"), edate= info["endDate"].split("-");
		weekms = sdate[1]*1-1,
		weekme = edate[1]*1-1,
		weekdatastart = new Date(sdate[0],weekms,sdate[2]),
		weekdataend = new Date(edate[0],weekme,edate[2]),
		dayss=weekdataend.getTime()-weekdatastart.getTime(), //时间差的毫秒数
     //计算出相差天数
		days=Math.floor(dayss/(24*3600*1000));

		var key=playList.info.programs.dayCycle.length,data=[];
		for(var i =0, n=days; i<=n; i++)
		{
			var tem = weekdatastart,
				tem = new Date(tem.getTime()+i*24*3600*1000),
				willWeekday =  tem.getDay();
			var m = tem.getMonth()+1,
				d = tem.getDate();
				if(m<10){m="0"+m;}
				if(d<10){d="0"+d;}
			var timeday = tem.getFullYear()+"-"+m+"-"+d;

			var dayCycleInfo={
					key:key+"_div",
					startDate:timeday,
					endDate:timeday,
					startTime:info["startTime"],
					endTime:info["endTime"],
					programId:info["programId"],
					programName:info["programName"],
					playType:"dayCycle",
					prior:1,
					playTypeName:"日周期",
					extend:'"startDate":"'+info["startDate"]+'"||"endDate":"'+info["endDate"]+'"||"playType":"dayCycle"||"key":"'+key+'_div"'
				};
			playList.info.programs.dayCycle.push(dayCycleInfo);
		}
		//playList.info.programs.dayCycle.push({key:key+"_div",startDate:$('#sdate').val(),endDate:$('#edate').val(),playType:"dataCycle",data:data})
		var dayCycleInfo={
					key:key+"_div",
					startDate:info["startDate"],
					endDate:info["endDate"],
					startTime:info["startTime"],
					endTime:info["endTime"],
					programId:info["programId"],
					programName:info["programName"],
					playType:"dayCycle",
					prior:1,
					playTypeName:"日周期"
				};
		//playList.cacheInfo.timeLine.push([]); 时间线
		return dayCycleInfo;
	},
	addCycleProgram:function(){
		var dayCycleInfo=playList.cyclePragromReady();
		playList.rendering(dayCycleInfo);
	},
	rendering:function(dayCycleInfo){
		$("#tab").append("<tr id="+dayCycleInfo.key+"  align='center' height='20' bgcolor='#FFFFFF' class='STYLE19'><td><input type='checkbox' name='abort' value='"+dayCycleInfo.pragromId+"' ></td><td >"+dayCycleInfo.programName+"</td><td>"+dayCycleInfo.startDate+"/"+dayCycleInfo.endDate+"</td><td>"+dayCycleInfo.startTime+"/"+dayCycleInfo.endTime+"</td><td>"+dayCycleInfo.playTypeName+"</td><td ><a href='javaScript:void(0);' onclick=\"playList.deleteDayCycle('"+dayCycleInfo.key+"')\"><span style=\"font-size:12px;\">删除</span></a></td></tr>");
	},
	deleteDayCycle:function(key){
		var programArrayInfo=playList.info.programs.dayCycle,
		n=programArrayInfo.length;
		for(var i =0; i<n; i)
		{
			if(programArrayInfo[i]["key"]==key)
			{
				playList.info.programs.dayCycle.splice(i,1);
				programArrayInfo=playList.info.programs.dayCycle;
				i=0,n=programArrayInfo.length;
			}
			else
			{i++;}
		}
		deltr(key);
	},
	addUnCycleProgram:function(){
		
	},
	getWeekCycleDateTime:function(){
		var s=playList.info.golbal.startDateTime,
			e=playList.info.golbal.endDateTime;

			s=s.split(" "),
			sd=s[0].split("-"),
			s={d:{y:sd[0],m:sd[1],d:sd[2]}},
			e=e.split(" "),
			ed=e[0].split("-"),
			e={d:{y:ed[0],m:ed[1],d:ed[2]}};

		return {s:s,e:e};
	},
	dayCycleDateTime:function(){
		var sdate=$("#sdate").val(),stime=$("#stime").val(),
			edate=$("#edate").val(),etime=$("#etime").val();

			sdate=sdate.split("-"),edate=edate.split("-"),
			stime=stime.split(":"),etime=etime.split(":");

			playDate={
				sdate:{y:sdate[0],m:sdate[1],d:sdate[2]},
				edate:{y:edate[0],m:edate[1],d:edate[2]},
				cycleStime:{h:stime[0],m:stime[1],s:stime[2]},
				cycleEtime:{h:etime[0],m:etime[1],s:etime[2]},
				};
			return playDate;
	},
	save:function(){
		if(playList.edit.editKey!="")
		{
			playList.edit.save();
		}
		else
		{
			playList.create.save();
		}
	}
};
playList.create={
	programReady:function(){
		if(playList.info.golbal.playListName=="")
		{
			alert("请填写播放列表名称。请填写播放列表名称后保存!");
			return false;
		}
		if(playList.info.programs.dayCycle.length==0&&playList.info.programs.weekCycle.length==0)
		{
			alert("您为添加任何的节目,在节目列表中。请添加节目后保存!");
			return false;
		}
		return true;
	},
	save:function(){
		if(!playList.create.programReady())
		{
			return false;
		}
		//alert(JSON.stringify(playList.info));///bank/index.php?control=playlist&action=addPlayList'
		tip.tip({message:"数据提交中请稍等",stateClose:false});
		$.ajax({
			type:"POST",
			data: {data:playList.info},
			url:"index.php?control=c_playListManage&action=savePlayList",
			success: function(result)
			{
				//alert(result.fg);
				result=$.parseJSON(result);
				if(result.state)
				{
					alert(result.info);
					if(window.parent!=self)
					{
						updateClientControlPlayList();
						var  parentobj=window.parent.document.getElementById("playListTable");
						if(parentobj)
						{
							if(parentobj.contentWindow){

								parentobj.contentWindow.location.reload();


							}else{
								parentobj.contentDocument.location.reload();
								//alert("3");
							}

						}
						window.location.href=window.location.href;
					}
				}
				else
				{
				    tip.change(result.info);
				    tip.tipTime(2);
				    }
			},
			error: function()
			{
				tip.change("网络访问失败或者界面被刷新,取消保存!");
			}
		});
	}
};
playList.edit={
	editKey:"",
	init:function(){
		//playList.edit.editKey=6;
	//playList.edit.loadPlayListInfo();
//		return ;
		if(window.top!=self&&window.top._BS_.playList.edit)
		{
			playList.edit.editKey=window.top._BS_.playList.id;
			playList.edit.loadPlayListInfo();
			window.top._BS_.playList.edit=false;
		}
	},
	loadPlayListInfo:function(){
		tip.tip({message:"正在努力加载播放列表信息.....",stateClose:false,id:"loadPlayList"});
		$.ajax({
			type:"POST",
			data: {data:{playListId:playList.edit.editKey}},
			url:"index.php?control=c_playListManage&action=loadEditPlayListInfo",
			success: function(result)
			{

				result=$.parseJSON(result);
				if(result.state)
				{
					art.dialog.list["loadPlayList"].content("数据加载成功,处理中......");
					playList.edit.resetPlayListInfo(result.data);
				}
				else
				{art.dialog.list["loadPlayList"].content(result.data);}
			},
			error: function()
			{
				art.dialog.list["loadPlayList"].content("数据加载失败");
			}
		});
	},
	resetPlayListInfo:function(info){
		var programs=info["programs"],
		dayCycle=programs["dayCycle"],
		weekCycle=programs["weekCycle"];
		with(playList.info.golbal)
		{
			playListName=info["name"];
			playListType=info["type"];
			startDateTime=info["startDate"];//+" "+weekCycle["startTime"];
			endDateTime=info["endDate"];//+" "+weekCycle["endTime"];
			playlistModel=info["playlistModel"];
		}

        //选择显示周期界面
        tabs(playList.info.golbal.playlistModel*1+1);
        
		$("#input_weekStartDatetime").val(playList.info.golbal.startDateTime);
		$("#input_weekEndDatetime").val(playList.info.golbal.endDateTime);
		$("#playlistName").val(playList.info.golbal.playListName);
		$('#playListType').children("option").each(function(index, element) {
            if(element.value==playList.info.golbal.playListType)
				{
					element.selected=true;
				}
        });

		if(dayCycle.length>0)
		{

			for(var i=0,n=dayCycle.length; i<n; i++)
			{
				var info={startDate:dayCycle[i]["extend"]["startDate"],
					  endDate:dayCycle[i]["extend"]["endDate"],
					  startTime:dayCycle[i]["startTime"],
					  endTime:dayCycle[i]["endTime"],
					  programId:dayCycle[i]["programId"],
					  programName:dayCycle[i]["programName"]
					  };
				playList.rendering(playList.setDayCycleProgram(info));

			}

		}


		for(var i in weekCycle)
		{
			var weekDay="";
			switch(i)
			{
				case "Mon": weekDay=1; break;
				case "Tues": weekDay=2; break;
				case "Wed": weekDay=3; break;
				case "Thur": weekDay=4; break;
				case "Fri": weekDay=5; break;
				case "Sat": weekDay=6; break;
				case "Sun": weekDay=0; break;
			}
			var pid = "p__"+weekDay+playList.info.programs.weekCycle.length;
			for(var a=0,b=weekCycle[i].length; a<b; a++)
			{
				if(typeof(weekCycle[i])!="object"){continue;}
				var renderInfo={
						weekDay:weekDay,
						programViewHtmlId:pid,
						startTime:weekCycle[i][a]["startTime"],
						endTime:weekCycle[i][a]["endTime"],
						programName:weekCycle[i][a]["programName"]};
				weekProgramRender(renderInfo);
				var programInfo={
						weekDay:weekDay,
						programId: weekCycle[i][a]["programId"],
						startTime:weekCycle[i][a]["startTime"],
						endTime:weekCycle[i][a]["endTime"],
						programName:weekCycle[i][a]["programName"],
						key:pid};
				cacheWeekCycleProgramInfo(programInfo);
			}


		}
		tip.tipInfo.defaultState=true;
		tip.tipClose("loadPlayList");
	},
	save:function(){
		if(!playList.create.programReady())
		{
			return false;
		}
		tip.tip({message:"数据提交中请稍等",stateClose:false});
		$.ajax({
			type:"POST",
			data: {data:playList.info,playListkey:playList.edit.editKey},
			url:"index.php?control=c_playListManage&action=saveEditPlayList",
			success: function(result)
			{
				result=$.parseJSON(result);
				if(result.state)
				{
					alert(result.info);
					if(window.top!=self&&window.top._BS_.playList.edit)
					{
						window.top._BS_.playList.id="";
						window.top._BS_.playList.edit=false;
					}
					if(window.parent!=self)
					{
						updateClientControlPlayList();
						var  parentobj=window.parent.document.getElementById("playListTable");
						if(parentobj)
						{
							if(parentobj.contentWindow){

								parentobj.contentWindow.location.reload();

							}else{
								parentobj.contentDocument.location.reload();
							}

						}
						window.location.href=window.location.href;
					}
				}
				else
				{
				tip.change(result.info);
                    tip.tipTime(2);
                    }
            },
            error: function()
            {
                tip.change("网络访问失败或者界面被刷新,取消保存!");
            }
		});
	}
};

function updateClientControlPlayList(){
	//alert("updateClientControlPlayList");
	var client_control=window.parent.document.getElementById("getClientInfo");
	if(client_control){
		if(client_control.contentWindow){
			client_control.contentWindow.refreshPlayList();
		}else{
			client_control.contentDocument.refreshPlayList();
		}
	}
}