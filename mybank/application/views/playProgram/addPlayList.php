<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta HTTP-EQUIV="pragma" CONTENT="no-cache">
<base href="<?php echo base_url(); ?>" />
<title>添加播放计划</title>

<script src="JavascriptClass/bx.core.js" type="text/javascript"></script>
<script src="JavascriptClass/jquery-1.7.2.min.js" type="text/javascript"></script>
<script language="JavaScript1.5" src="JavascriptClass/artDialog/artDialog.js?skin=blue" type="text/javascript"></script>
<script src="JavascriptClass/bx.comment.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="JavascriptClass/jqueryui/themes/smoothness/jquery-ui.css" />
<link type="text/css" rel="stylesheet" href="JavascriptClass/jqueryui/timepicker/jquery-ui-timepicker-addon.css" />
<script src="JavascriptClass/jqueryui/jquery-ui.min.js" type="text/javascript"></script>
<script src="JavascriptClass/jqueryui/timepicker/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
<script src="JavascriptClass/jqueryui/timepicker/jquery-ui-sliderAccess.js" type="text/javascript"></script>
<script src="JavascriptClass/jqueryui/timepicker/localization/jquery.ui.datepicker-zh-CN.js" type="text/javascript"></script>
<script src="JavascriptClass/jqueryui/timepicker/localization/jquery-ui-timepicker-zh-CN.js" type="text/javascript"></script>

<script language="JavaScript1.5" src="application/views/javaScript/createPlayList.js" type="text/javascript"></script>

<link type="text/css" rel="stylesheet" href="skin/web/index.css" />
<style type="text/css">
/* css for timepicker */

.ui-timepicker-div .ui-widget-header {
	margin-bottom: 8px;
}
.ui-timepicker-div dl {
	text-align: left;
}
.ui-timepicker-div dl dt {
	height: 25px;
	margin-bottom: -25px;
}
.ui-timepicker-div dl dd {
	margin: 0 10px 10px 65px;
}
.ui-timepicker-div td {
	font-size: 90%;
}
.ui-tpicker-grid-label {
	background: none;
	border: none;
	margin: 0;
	padding: 0;
}
.table_class {
	border-collapse: collapse;
}
.table_class tr td {
	border: 1px solid #C0F3F3;
	padding:2px;
}
.table_class .left {
	width: 300px;
}
.err {
	font-size: 12px;
	color: #F33;
}
* {
	list-style-type: none;
	font-size: 12px;
	text-decoration: none;
	margin: 0;
	padding: 0;
}
input,select {
	border: 1px solid #ccc;
	padding: 2px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}
input ,label { font-family:Tahoma,Verdana, Geneva, sans-serif; vertical-align:middle; font-size:12px; }
.tab_b {
	overflow: hidden;
	margin-left: 5px;
	margin-right: 5px;
	margin-top: 5px;
}

.week_day_program_con { border-bottom:#09C 1px dotted;}
.week_day_program_con:hover {background-color:#F8FAA3;}
</style>
<link  type="text/css" rel="stylesheet" href="JavascriptClass/bxTabView/themes/blue/kongz.css"  />

</head>
<body>
<table align="center" width="100%" id="playList_gobal" class="table_class">
  <tr>
    <td class="left">播放计划名称</td>
    <td><input type="text" name="playlistName" id="playlistName"  size="28" onblur="checkPlaylistName();"/>
      &nbsp;
      <label id="playlistNameInfo" class="err"></label></td>
  </tr>
  
  <tr>
    <td class="left">终端类型</td>
    <td><select id="playListType" name="playListType" >
        <option value="X86" selected >X86</option>
		<option value="Android"  >Android</option>
      </select></td>
  </tr>

</table>
<div class="tabView">
  <div class="tabHead" >
    <ul class="tabHead_con" id="menutitle">
      <!--<li id="tab_0" class="tab_selected"><a href="javascript:void(0)" onclick="tabs(0)" >无周期</a></li>-->
      <li id="tab_1" class="tab_selected"><a href="javascript:void(0)" onclick="tabs(1)" >天/周期</a></li>
      <li id="tab_2" ><a href="javascript:void(0)" onclick="tabs(2)">周/周期</a></li>
      
    </ul>
  </div>
  <div class="tabContent" >
  	<!--<div class="tab_b" id="tab_a0" style="display:block;">
      <table align="center" width="100%" class="table_class">
        <tbody>
			            <tr>
            <td class="left">节目选择列表</td>
            <td ><select id="programList" name="programList"  >
                <?php foreach ($profile as $play):?>
                <option value="<?php echo $play['profileID']?>" title="<?php echo $play['profileType']?>"><?php echo iconv("gb2312","utf-8",urldecode(preg_replace("/\_/","%",$play['profileName'])));?></option>
                <?php endforeach;?>
              </select></td>
          </tr>
          <tr>
            <td class="left">开始日期时间</td>
            <td><input type="text" id="sdate-time" name="sdate-time" maxlength="19" size="21" /> </td>
          </tr>
          <tr>
            <td class="left">结束日期时间</td>
            <td><input type="text" id="edate-time" name="edate-time" maxlength="19" size="21" /> </td>
          </tr>
          <tr>
            <th colspan="5" ><div id="spancheck" style=" margin-left:auto; margin-right:auto; width:50PX;" ><a href="javascript:void(0)" id="uncycleAdd_btn" class="blue_left"><span class="blue_right">添加</span></a></div>
            </th>
          </tr>
        </tbody>
      </table>
      <div id="UnCyclePlaylistInfo">
        <table id='tab' class="table_class" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" align="center">
          <tr>
            <td width="10%" height="20" bgcolor="d3eaef" class="STYLE10"><div align="center">
                <input type="checkbox" name="checkbox" id="checkbox" />
                是否优先 </div></td>
            <td width="8%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">播放单元</span></div></td>
            <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">播放日期</span>段</div></td>
            <td width="8%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="left">播放时间段</span></div></td>
            <td width="8%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">周期性</span></div></td>
            <td width="8%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">操作</span></div></td>
            </tr>
        </table>
        
      </div>
    </div>-->
    <div class="tab_b" id="tab_a1" style="display:block;">
      <table align="center" width="100%" class="table_class">
        <tbody>
			            <tr>
            <td class="left">节目选择列表</td>
            <td ><select id="programList" name="programList"  >
                <?php foreach ($profile as $play):?>
                <option value="<?php echo $play['profileID']?>" title="<?php echo $play['profileType']?>"><?php echo iconv("gb2312","utf-8",urldecode(preg_replace("/\_/","%",$play['profileName'])));?></option>
                <?php endforeach;?>
              </select></td>
          </tr>
          <tr>
            <td class="left">节目播放日期段</td>
            <td><input type="text" id="sdate" name="sdate" maxlength="10" size="12" /> 到 <input type="text" id="edate" name="edate" maxlength="8" size="12" /></td>
          </tr>
          <tr>
            <td class="left">每日播放时间</td>
            <td><input type="text" id="stime" name="stime" maxlength="10" size="12" /> 到 <input type="text" id="etime" name="etime" maxlength="10" size="12" /></td>
          </tr>
          <tr>
            <td colspan="5" ><div id="spancheck" style=" margin-left:auto; margin-right:auto; width:50PX;" ><a href="javascript:void(0)" id="cycleAdd_btn" class="blue_left"><span class="blue_right">添加</span></a></div>
            </td>
          </tr>
        </tbody>
      </table>
      <div id="playlistInfo">
        <table id='tab' class="table_class" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" align="center">
          <tr>
            <td width="10%" height="20" bgcolor="d3eaef" class="STYLE10"><div align="center">
                <input type="checkbox" name="checkbox" id="checkbox" />
                是否优先 </div></td>
            <td width="8%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">播放单元</span></div></td>
            <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">播放日期段</span></div></td>
            <td width="8%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="left">播放时间段</span></div></td>
            <td width="8%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">周期性</span></div></td>
            <td width="8%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">操作</span></div></td>
            </tr>
        </table>
        
      </div>
    </div>
    <div class="tab_b" id="tab_a2" style="display:none;">
      <div id="Week_playlistInfo">
        <center>
          <div style="width:100%">
            <table width="100%" id="week_info" border="1" class="table_class">
				<tr>
    <td class="left">开始日期</td>
    <td><input type="text" id="input_weekStartDatetime" name="input_weekStartDatetime"  /></td>
    <td class="left">结束日期</td>
    <td><input type="text" id="input_weekEndDatetime" name="input_weekEndDatetime"  /></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  </tr>
              <!--DWLayoutTable-->
              <tr align="center" id="weekCycleContainer">
                <td width="14%">星期日</td>
                <td width="14%">星期一</td>
                <td width="14%">星期二</td>
                <td width="14%">星期三</td>
                <td width="14%">星期四</td>
                <td width="14%">星期五</td>
                <td width="14%">星期六</td>
              </tr>
              <tr  style="font-size:10px">
                <td align="center" valign="top" width="14%" ><div style="width:80px; margin:0 auto 0 auto">
                    <p><a href="javascript:void(0)" onclick="Week_getProgramlist(0)" class="s_blue_left"> <span class="s_blue_right">添加节目</span></a></p>
                  </div></td>
                <td align="center" valign="top"  width="14%"><div style="width:80px; margin:0 auto 0 auto">
                    <p><a href="javascript:void(0)" onclick="Week_getProgramlist(1)" class="s_blue_left"> <span class="s_blue_right">添加节目</span></a></p>
                  </div></td>
                <td align="center" valign="top"  width="14%"><div style="width:80px; margin:0 auto 0 auto">
                    <p><a href="javascript:void(0)" onclick="Week_getProgramlist(2)" class="s_blue_left"> <span class="s_blue_right">添加节目</span></a></p>
                  </div></td>
                <td align="center" valign="top"  width="14%"><div style="width:80px; margin:0 auto 0 auto">
                    <p><a href="javascript:void(0)" onclick="Week_getProgramlist(3)" class="s_blue_left"> <span class="s_blue_right">添加节目</span></a></p>
                  </div></td>
                <td align="center" valign="top"  width="14%"><div style="width:80px; margin:0 auto 0 auto">
                    <p><a href="javascript:void(0)" onclick="Week_getProgramlist(4)" class="s_blue_left"> <span class="s_blue_right">添加节目</span></a></p>
                  </div></td>
                <td align="center" valign="top"  width="14%"><div style="width:80px; margin:0 auto 0 auto">
                    <p><a href="javascript:void(0)" onclick="Week_getProgramlist(5)" class="s_blue_left"> <span class="s_blue_right">添加节目</span></a></p>
                  </div></td>
                <td align="center" valign="top"  width="14%"><div style="width:80px; margin:0 auto 0 auto">
                    <p><a href="javascript:void(0)" onclick="Week_getProgramlist(6)" class="s_blue_left"> <span class="s_blue_right">添加节目</span></a></p>
                  </div></td>
              </tr>
            </table>
          </div>
        </center>
      </div>
    </div>
  </div>
  <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" align="center">
          <tr>
            <th colspan="5" > <div id="save" align="center" style=" margin-left:auto; margin-right:auto; width:50PX; display:block" ><a href="javascript:void(0)" class="blue_left" id="save_playList_Btn"><span class="blue_right">保存</span></a></div>
            </th>
           </tr>
        </table>
</div>
</body>
</html>
