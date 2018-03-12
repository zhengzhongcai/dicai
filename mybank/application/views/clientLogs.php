<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<base href="<?php echo base_url(); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title;?></title>
<link type="text/css" rel="stylesheet" media="all" href="images/admin.css" />
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/comon.js" type="text/javascript"></script>
<script src="js/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="js/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
/*body {
	margin-left: 3px;
	margin-top: 0px;
	margin-right: 3px;
	margin-bottom: 0px;
}
table tr td:hover {
  color:#C0F3F3
}
.STYLE1 {
	color: #e1e2e3;
	font-size: 12px;
}
.STYLE6 {color: #000000; font-size: 12; }
.STYLE10 {color: #000000; font-size: 12px; }
.STYLE19 {
	color: #344b50;
	font-size: 12px;
}
.STYLE21 {
	font-size: 12px;
	color: #3b6375;
}
.STYLE22 {
	font-size: 12px;
	color: #295568;
}
table { border-collapse:collapse;}
table tr td{border:1px solid #C0F3F3}*/
-->
table { border-collapse:collapse;}
table tr td{border:1px solid #C0F3F3}
 table td .left {width:10%;}
</style>
<script language="javascript">
function deleteAllLogs(){
	if(confirm("你确定要删除所有的日志信息")){
		$.ajax({
				 type:"POST",
				 data:"clientID=<?php echo $clientID?>&actions=deleteAll",
				 url:"index.php?control=client&action=deleteLogs",
				 success: function(result)
				 {
							//alert(result);
							getClientLogs();
				 },
											  
				 error: function()
				 {
						   // $("#loading_message").hide();
							alert("ajax error");
				 }  
				   
			});
	}	
}
function deleteByTime(){
	var dNow=new Date();
	yy=dNow.getFullYear();
	mm=((parseInt(dNow.getMonth())+1).toString().length==2)?dNow.getMonth()+1:"0"+(dNow.getMonth()+1);
	dd=dNow.getDate();
	curDate=yy+"-"+mm+"-"+dd;
	
	var time=prompt("请输入开始时间和结束时间",curDate+","+curDate);
	var timeArr=time.split(",");
	startTime=timeArr[0];
	endTime=timeArr[1];
	$.ajax({
				 type:"POST",
				 data: "clientID=<?php echo $clientID?>&actions=deleteByTime&startTime="+startTime+"&endTime="+endTime,
				 url:"index.php?control=client&action=deleteLogs",
				 success: function(result)
				 {
							//alert(result);
							getClientLogs();
				 },
											  
				 error: function()
				 {
						   // $("#loading_message").hide();
							alert("ajax error");
				 }  
				   
			});
}
function getClientLogs(){
	$.ajax({
				 type:"POST",
				 data: "clientID=<?php echo $clientID?>",	
				 url:"index.php?control=client&action=getClientLogsAjax",
				 success: function(result)
				 {
						$("#clientLogs").html(result);
						//alert(result);
				 },
											  
				 error: function()
				 {
						   // $("#loading_message").hide();
						alert("ajax error");
				 }  
				   
			});	
}
</script>

</head>

<body>
<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0"><label style="font-size:14px">日志信息</label></li>
    <li class="TabbedPanelsTab" tabindex="0"><label style="font-size:14px">终端版本</label></li>
    <!--li class="TabbedPanelsTab" tabindex="0"><label style="font-size:14px">文件信息</label></li>
    <li class="TabbedPanelsTab" tabindex="0"><label style="font-size:14px">终端版本</label></li-->
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent"><div id="clientLogs" style="overflow:auto;height:485px;width:100%;float:left">
<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
      <tr>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE10"><div align="center">
       <!--input type="checkbox" name="checkbox" id="checkbox" onchange="checkAll(this.name,'clientID')"/--> 消息类型</div></td>        
        <td width="40%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">日志信息</span></div></td>
        <td width="20%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">时间</span></div></td>
        
      </tr>
       <?php foreach ($clientLogs as $log):?>
       <tr>
         <td height="20" bgcolor="#FFFFFF"><div align="center">
           <?php echo $log['infoType']?>
           </div></td>
         <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="left"><span class="STYLE19">
		 <?php 
		 
		 echo $log['text'];
		 
		 ?></span></div></td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19"><?php echo  $log['time']?></span></div></td>
       </tr>      
       <?php endforeach;?>
      </table>
</div>
      <div align="center" >
      <span class="STYLE22">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pagination?></span>
     <input type="button" name="deleteAll" id="deleteAll" value="删除全部" onclick="deleteAllLogs();"/> &nbsp; <input type="button" name="delete" id="delete" value="删除" onclick="deleteByTime();"/ > &nbsp; <input type="button" name="refresh" id="refresh" value="刷新" onclick="getClientLogs();"/ >
     </div></div>
    
    <div class="TabbedPanelsContent" id="version">版本信息：&nbsp;&nbsp;&nbsp;<?php echo $version;?></div>
  </div>
</div>

<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
      </script>
</body>
</html>
