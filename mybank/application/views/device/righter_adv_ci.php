<?php
//定义分辨率
$ScreenResolution=array('1024x768','1024x600','1280x1024','1600x1200','1280x800','1280x720','1440x900','1680x1050','1920x1200','1366x768','1360x768','1920x1080',"800x600");
$clientType=array('X86','LED','em8621');
?>
<script src="js/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="Skin/default/default.css" rel="stylesheet" type="text/css" />
<link href="js/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<script language="JavaScript1.5" src="JavascriptClass/bx.core.js" type="text/javascript"></script>
<script language="JavaScript1.5" src="JavascriptClass/bx.ajax.js" type="text/javascript"></script>
<script language="JavaScript1.5" src="assets/device/clientInfo.js" type="text/javascript"></script>
<script language="JavaScript1.5" src="assets/device/clientInfo_manage.js" type="text/javascript"></script>
<script language="JavaScript1.5" src="JavascriptClass/artDialog/artDialog.js?skin=blue" type="text/javascript"></script>
<script language="JavaScript1.5" src="JavascriptClass/artDialog/plugins/iframeTools.js" type="text/javascript"></script>
<script type="text/javascript">
	var userClientSouce= {"clientInfo":<?=json_encode($clientInfo)?>,"userGroup":<?=json_encode($clientGroup)?>};
	var treeGridData={total:'',rows:[]};
	var userGroupData=[];
</script>
<style type="text/css">
	<!--
	img {
		border:0px;
	}
	* {
		font-size:12px;
	}

	.select {
		width:80px;
	}
	.client_list {
		/*background-color:#eee;*/
		display:block;
		width:100%;
	}
	.client_list:hover {
		background-color:#FAFBC8;
	}
	.client_list_j {
		background-color:#fff;
		display:block;
		width:100%;
	}
	.client_list_j:hover {
		background-color:#FAFBC8;
	}
	.group_list {
		background-color:#eee;
		display:block;
		width:100%;
	}
	.group_list:hover {
		background-color:#FAFBC8;
	}
	.group_list_j {
		background-color:#fff;
		display:block;
		width:100%;
	}
	.group_list_j:hover {
		background-color:#FAFBC8;
	}
	.c_bhao, .c_fzu, .c_mshu, .c_bbiao, .c_zfbl, .c_zlxin, .c_zmac, .c_zip, .c_ztai, .c_zjbcz, .c_zspeed, .c_checkBox {
		height:24px;
		line-height:24px;
		display:inline-block;
		margin:0px;
		padding:0px;
		margin-left:1px;
		color: #344b50;
		font-size: 12px;
		text-align:center;
		min-width:30px;
	}
	.tree_grid_title{
		background:url(js/SpryAssets/tb_bg.png);
		background-repeat:repeat-x;
	}

	.c_bhao {
		width:7%;
	}
	.c_fzu {
		width:10%
	}
	.c_mshu {
		width:12%
	}
	.c_bbiao {
		width:12%
	}
	.c_zfbl {
		width:100px;
		display:none;
	}
	.c_zlxin {
		width:8%
	}
	.c_zmac {
		width:12%
	}
	.c_zip {
		width:12%
	}
	.c_ztai {
		width:5%
	}
	.c_zjbcz {
		width:15%
	}
	.c_zspeed {
		width:50px;
		display:none;
	}
	.c_checkBox {
		width:20px;
		padding:0px;
	}
	.t_ccontent {
	}
	.t_bhao, .t_fzu, .t_mshu, .t_bbiao, .t_zfbl, .t_zlxin, .t_zmac, .t_zip, .t_ztai, .t_zjbcz, .t_zspeed, .t_checkBox {
		display:block;
		height:26px;
		line-height:26px;
		vertical-align:middle;
		float:left;
		margin:0px;
		padding:0px;
		/*color:#FFF;*/
		text-align:center;
		border-left:1px #CCC solid;
		font-size: 12px;
		min-width:30px;/*background-color:#a8c7ce;*/
	}
	.t_bhao {
		width:7%
	}
	.t_fzu {
		width:10%
	}
	.t_mshu {
		width:12%
	}
	.t_bbiao {
		width:12%
	}
	.t_zfbl {
		width:100px;
		display:none;
	}
	.t_zlxin {
		width:8%
	}
	.t_zmac {
		width:12%
	}
	.t_zip {
		/*width:12%*/
		width:110px
	}
	.t_ztai {
		width:5%
	}
	.t_zjbcz {
		width:15%
	}
	.t_zspeed {
		width:50px;
		display:none;
	}
	.t_checkBox {
		width:20px;
	}
	.listContent_Over {
		background-color:#0C6;
	}
	.clickdown {
		width:58px;
		height:14px;
		bottom:10px;
		z-index:999;
		position:relative;
		margin:0 auto;
	}
	/**************************终端分组树横向路径****************************/
	.treePath_sty {
		text-decoration:none;
		color:#eee;
	}
	.treePath_sty:hover {
		background-color:#999;
	}
	.treePath_sty:active {
		color:#00F;
	}
	.treePath_nodeAame {
		padding:2px;
	}
	.treePath_sty:hover .treePath_jt .treePath_nodeAame {
		border:#CCC solid 1px;
		font-weight:bold;
		cursor:pointer;
	}
	/*****************终端组下拉菜单******************/
	.groupName {
		width:50px
	}
	#checkAll {
		top:10px;
		width:30px;
		padding:4px;
		vertical-align:middle
	}
	.clientInfo {
		display:block;
		overflow-y:auto;
	}
	.clientInfo a {
		text-decoration:none;
	}
	.c_zhoZu {
		color:#A4A4A4;
	}
	.tollbarHeight {
		height:140px;
	}
	.screenshotList {
		display:block;
		width:100%;
		height:21px;
		background-image:url(Skin/default/listbg.png);
		text-align:left;
		text-decoration:none;
	}
	.screenshotList .screenshot_table {
		width:100%;
		text-align:left;
	}
	.screenshotList .screenshot_checkbox {
		width:30px;
		padding:0px;
	}
	.screenshotList .screenshot_name {
		width:250px;
	}
	.screenshotList .screenshot_size {
		width:100px;
	}
	.screenshotList .screenshot_time {
		width:150px;
	}
	.screenshotList .screenshot_clientname {
		width:150px;
	}
	.screenshotList .screenshot_toolbar {
		width:100px;
	}
	-->
	#showspan {
		top:5px;
	}

input,select {
	border: 1px solid #ccc;
	padding: 2px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}
input ,label { font-family:Tahoma,Verdana, Geneva, sans-serif; vertical-align:middle; font-size:12px; }


	.select {	width:80px;
	}
</style>
<input id="orgId" type="hidden"/>
	<!----right---->
	<div id="gridt" class="right_box" >
		<!----tab 标签页---->

<div id="_alert_id" style="display: none;left:45%;top:185px;background-color:#F5F5B5;border:1px solid #DECA7E;color:#303030;font-weight:bold;font-family:sans-serif;font-size:18px;line-height:18px;padding:13px 15px;position:absolute;text-align:center;z-index:1111;" onclick="this.style.display='none';"></div>
<div id="ifarmetop" style="width:99%; min-width:980px; margin:0 auto; border:1px  #195186 solid; border-top:0px; height:300px; overflow:hidden; visibility:inherit" >
  <div id="divHeader" class="divHeader">
    <table width="100%" border="0" cellspacing="0" class="h_title" bgcolor="" cellpadding="0">
      <tr>
        <td width="18"><img src="Skin/web/skin/tb.gif" width="14" height="14" /></td>
        <td id="h_content"><div id="treePath_con" class="treePath_con"> </div></td>
        <td width="400"><a href="javascript:void(0);" style="color:#FFFFFF; text-decoration:none;" onclick="onloadInfo()">返回顶级</a>

          &nbsp;&nbsp;<img src="Skin/web/skin/on.gif" alt=""width="12" height="12"/>&nbsp;上线:<b id="onlineClientTotal">0</b>台&nbsp;&nbsp;<img src="Skin/web/skin/down.gif" alt=""width="12" height="12"/>&nbsp;未上线:<b id="unlineClientTotal">0</b>台&nbsp;&nbsp;总计:<b id="clientTotal">0</b>台&nbsp;&nbsp; </td>
      </tr>
    </table>
  </div>
  <a href="#" id="btn_refresh" class="easyui-linkbutton" iconCls="icon-reload">重载数据</a>
  <a href="#" id="btn_check" class="easyui-linkbutton" iconCls="icon-reload">检索终端</a>
  <a href="#" id="btn_show_all_client" class="easyui-linkbutton" iconCls="icon-reload">显示全部终端</a>
  <a href="#" id="btn_show_online_client" class="easyui-linkbutton" iconCls="icon-reload">显示在线终端</a>
  <div style="width:1000px;height:300px">
  <table  id="goods_type_grid" ></table >
  </div>
  <div id="group_right_click_memu" class="easyui-menu" style="width:120px;"></div>
  <div id="right_click_memu" class="easyui-menu"  style="width:120px;">
  </div>
  <div id="clientTitle" class="clientTitle">
    <div style=" width:100%;border:0 cellpadding:0 cellspacing:1px; " class="tree_grid_title">
      <div style="min-width:600px;">
        <span class="t_checkBox">
        <!--<input type="checkbox" id="checkAll" onclick="checkAll(this,'clientID')" checked="checked"/> -->
          <button  type="button"  id="checkAll" onclick=buttonCheck(this,"clientID") title="全">全</button >
          </span>
        <span class="t_bhao">编号</span>
        <span class="t_fzu"> 分组
       <select id='groupName' class="groupName" onchange="changeCurrentNodePath(this);">
         <?php  foreach($clientGroup as $k=>$c):?>
           <option title="<?=$c['TreeNodeCode']?>" value="<?=$c['TreeName']?>">
             <?=$c['TreeName']?>
           </option>
         <?php endforeach;?>
       </select>
        </span>
        <span class=" t_mshu">终端名称</span>
        <span class="t_bbiao">播放计划</span>
        <span class="t_zfbl">终端分辨率</span>
        <span class=" t_zlxin">终端类型
        <select id='clientType' style="display:none"  onchange="getClientInfoBySelect();">
          <option title="" value="">所有</option>
          <?php foreach($clientType as $c):?>
          <option title="<?php echo $c?>" value="<?php echo $c?>">
          <?=$c?>
          </option>
          <?php endforeach;?>
        </select>
        </span>
        <span class="t_zmac">终端地址</span>
        <span class="t_zip">终端IP</span>
        <span class="t_ztai">状态</span>
        <span class=" t_zjbcz">基本操作</span>
        <span class="t_zspeed">下载速度</span>
      </div>
    </div>
  </div>
  <div id="clientInfo" class="clientInfo" ></div>
  <input type="hidden" value="" id="HValue" />
  <input type="hidden" value="" id="clientTotalhidden">
</div>
<div style=" height:4px; width:100%; text-align:center"><span  id="cclick" class="clickdown">
<a href="javascript:void(0)" id="hidespan" onclick="sclickdown(this)" style="display:block">
    <img id="clickdown" src="skin/web/skin/clickdown.png"  />
</a>

<a href="javascript:void(0)"  id="showspan"  onclick="sclickdown(this)" style="display:none">
    <img id="clickdown" src="skin/web/skin/clickup.png" />
</a>
</span></div>
<div id="TabbedPanels1" style="height:170px; min-width:980px; border:0px solid #F00" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0">
      <label style="font-size:14px">播放计划</label>
    </li>
    <li class="TabbedPanelsTab" tabindex="0">
      <label style="font-size:14px">插播</label>
    </li>
    <li class="TabbedPanelsTab" tabindex="0">
      <label style="font-size:14px">终端控制</label>
    </li>
    <li class="TabbedPanelsTab" tabindex="0">
      <label style="font-size:14px">终端升级</label>
    </li>
    <li class="TabbedPanelsTab" tabindex="0">
      <label style="font-size:14px">终端搜索</label>
    </li>
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent tollbarHeight" >
      <form>

       <!-- <input type="button" value="发送给终端" onclick="controlAjax('playlist');">-->
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="260"> 播放计划
              <select name="playList" class="select" style="width: 160px;" id="playList">
                <?php foreach ($playList as $play):?>
                <option title="<?php echo $play['lastTime']?>" type="<?php echo $play['playListType']?>" value="<?php echo $play['playListID']?>" <?php if($playListID==$play['playListID']){
			echo 'selected';
		}?>><?php echo $play['playListName']?>----(<?php echo $play['playListType']?>)</option>
                <?php endforeach;?>
            </select></td>
            <td width="63"><a href="javascript:void(0)" onclick="controlAjax('shengpi')" class="zduan_left"><span class="zduan_right">发送</span></a></td>
            <td width="164"><!--a href="javascript:void(0)" onclick="deleteplaylist()" class="zduan_left"><span class="zduan_right">清除播放计划</span></a--></td>
          </tr>
        </table>
      </form>
      <div id="playInfo" ></div>
    </div>
    <div class="TabbedPanelsContent tollbarHeight" >
      <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:0px;">
        <tr>
          <td width="100px">插播播放单元</td>
          <td width="100px"><select name="insertProfile" class="select" id="insertProfile">
              <?php foreach ($profile as $p):?>
              <option value="<?php echo $p['profileID'];
	 ?>" ><?php echo iconv("gb2312","utf-8",urldecode(preg_replace("/\_/","%",$p['profileName'])))?></option>
              <?php endforeach;?>
          </select></td>
          <td width="100px"><a href="javascript:void(0)" onclick="controlAjax('profile')" class="zduan_left"><span class="zduan_right">发送</span></a> <a href="javascript:void(0)" onclick="controlAjax('stopInsert')" class="zduan_left"><span class="zduan_right">停止插播</span></a></td>
          <td>&nbsp;</td>
        </tr>

      </table>


    </div>

   <!--控制------控制----------控制------>
<div class="TabbedPanelsContent tollbarHeight">

<table border="0" align="left" cellpadding="0" cellspacing="0" >
  <tr>
    <td width="30" align="left" valign="middle" style="width:60px;">终端控制</td>
    <td colspan="2" align="left" valign="middle"><!--span><a href="javascript:void(0)"  onclick="controlAjax('play')" class="zduan_left"><span class="zduan_right">播放</span></a></span> <span><a href="javascript:void(0)"  onclick="controlAjax('pause')" class="zduan_left"><span class="zduan_right">暂停</span></a></span--> <span><a href="javascript:void(0)"  onclick="controlAjax('reboot')" class="zduan_left"><span class="zduan_right">重启</span></a></span><a href="javascript:void(0)"  onclick="controlAjax('wakeup')" class="zduan_left"><span class="zduan_right">开机</span></a></span> <span><a href="javascript:void(0)"  onclick="controlAjax('shutDown')" class="zduan_left"><span class="zduan_right">关机</span></a></span></td>
    <td width="20" rowspan="3" align="center" valign="middle" ><img src="skin/web/skin/ge.png" /></td>
    <td width="55" align="left" valign="middle" ><!--input type="button" value="停止" onclick="controlAjax('stop');"-->定时开机<br />关机</td>
    <td width="78" align="left" valign="middle"><input name="shutOnTime" type="text" id="shutOnTime" value="00:00:00" size="8" maxlength="8" style="padding:0px; margin:0px; height:20px; width:55px"/>
      <br />
      <input name="shutOffTime" type="text" id="shutOffTime" value="23:59:59" size="8" maxlength="8" style="padding:0px; margin:0px;height:20px; width:55px"/></td>
    <td width="50" align="left" valign="middle" style="width:50px;" ><a href="javascript:void(0)"  onclick="controlAjax('shutTime')" class="zduan_left"><span class="zduan_right">发送</span></a></td>
    <td width="20" rowspan="3" align="center" valign="middle" ><img src="skin/web/skin/ge.png" /></td>
    <!--td width="55" align="left" valign="middle"  >定时截屏</td>
    <td width="55" align="left" valign="middle" ><input name="ScreenshotTime1" type="text" id="ScreenshotTime1" style="padding:0px; margin:0px;height:20px; width:55px" value="07:00:00" size="8" maxlength="8"/>
      <input name="ScreenshotTime2" type="text" id="ScreenshotTime2" value="12:00:00" size="8" maxlength="8" style="padding:0px; margin:0px;height:20px; width:55px" />
      <input name="ScreenshotTime3" type="text" id="ScreenshotTime3" value="20:00:00" size="8" maxlength="8" style="padding:0px; margin:0px;height:20px; width:55px"/></td>
    <td width="60" align="left" valign="middle" style="width:30px;" ><a href="javascript:void(0)"  onclick="controlAjax('screenshot')" class="zduan_left"><span class="zduan_right">发送</span></a></td-->
    <td></td>
    <td></td>
    <td></td>
    <td width="20" rowspan="3" align="center" valign="middle" ><img src="skin/web/skin/ge.png" /></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" width="50">&nbsp;</td>
    </tr>
  <tr>
    <td align="left" valign="middle" style="width:30px;" >分辨率</td>
    <td width="100" align="left" valign="middle" style="width:90px;" ><select name="ScreenResolution" class="select" id="ScreenResolution" style="padding:0px; margin:0px;">
      <?php foreach ($ScreenResolution as $screen):?>
      <option value="<?php echo $screen;?>"
		<?php if($screenResolution==$screen){
			echo 'selected';
		}?>><?php echo $screen?></option>
      <?php endforeach; ?>
    </select>
      <select name="RotateDirection" class="select" id="RotateDirection" style="padding:0px; margin:0px;">
        <option value="normal" <?php if($rotateDirection=='normal'){
			echo 'selected';
		}?>>正常</option>
        <option value="inverted" <?php if($rotateDirection=='inverted'){
			echo 'selected';
		}?>>旋转180度</option>
        <option value="left" <?php if($rotateDirection=='left'){
			echo 'selected';
		}?>>左旋转90度</option>
        <option value="right" <?php if($rotateDirection=='right'){
			echo 'selected';
		}?>>右旋转90度</option>
      </select></td>
    <td width="70" align="left" valign="middle" style="width:50px;" ><a href="javascript:void(0)" onclick="controlAjax('screen')" class="zduan_left"><span class="zduan_right">发送</span></a></td>
    <td align="left" valign="middle">定时下载</td>
    <td align="left" valign="middle"><input name="spesicTime" type="text" id="spesicTime" value="22:00:00" size="8" maxlength="8" style="padding:0px; margin:0px;height:20px; width:55px" /></td>
    <td align="left" valign="middle"><span style="width:50px;"><a href="javascript:void(0)"  onclick="setDownLoadTime()" class="zduan_left"><span class="zduan_right">发送</span></a></span></td>
    <!--td align="left" valign="middle">FTP服务器</td>
    <td align="left" valign="middle"><select name="defaultFtp" id="defaultFtp" style="padding:0px; margin:0px;">
      <?=$ftpInfo?>
    </select>      <br /></td>
    <td width="60" align="left" valign="middle"><a href="javascript:void(0)"  onclick="setFTP()" class="zduan_left"><span class="zduan_right">发送</span></a></td-->
	<td></td>
    <td></td>
    <td></td>
<td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td width="50" align="left" valign="middle">&nbsp;</td>
    </tr>
  <tr>
    <td align="left" valign="middle" style="width:30px;" >音量</td>
    <td align="left" valign="middle" ><input name="Volume" type="text" id="Volume" value="50" size="10" maxlength="3" onkeyup="setVolume(this)" style="padding:0px; margin:0px;" /></td>
    <td align="left" valign="middle" style="width:50px;" ><a href="javascript:void(0)" onclick="controlAjax('volume')" class="zduan_left"><span class="zduan_right">发送</span></a></td>
    <!--td align="left" valign="middle"><span style="width:50px;">下载速度</span></td>
    <td align="left" valign="middle"><input name="clientSpeed" type="text" id="clientSpeed" size="8" maxlength="3" style="padding:0px; margin:0px;height:20px; width:55px" />
      <br />
      <label>
        <input type="radio" name="speedDv" value="M" id="speedDv_0" />
        M</label>
      <label>
        <input name="speedDv" type="radio" id="speedDv_1" value="K" checked="checked" />
        K</label></td>
    <td align="left" valign="middle"><span style="width:50px;"><a href="javascript:void(0)"  onclick="controlAjax('setClientDownload')" class="zduan_left"><span class="zduan_right">发送</span></a></span></td-->
    <td></td>
    <td></td>
    <td></td>
    <td align="left" valign="middle"><span style="width:50px;">监控终端</span></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td width="60" align="left" valign="middle"><span style="width:60px;"><a href="javascript:void(0)" onclick="viewClient()" class="zduan_left"><span class="zduan_right">开始监控</span></a></span></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    </tr>
  </table>
</div>
<div class="TabbedPanelsContent tollbarHeight"  >
  <table width="557" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="315"><?=$upgradeFileList?></td>
      <td width="242"></td>
    </tr>
  </table>
</div>
<div class="TabbedPanelsContent tollbarHeight" >
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr style="height:25px">
      <td style="height:20px">终端名称</td>
      <td style="height:20px"><input type="text" id="txt_clientname"/></td>
      <td style="height:20px">终端IP</td>
      <td style="height:20px"><input type="text" id="txt_clientip"/></td>
      <td style="height:20px">终端类型</td>
      <td style="height:20px"><input type="text" id="txt_clienttype"/></td>
      <td style="height:20px">播放计划</td>
      <td style="height:20px"><input type="text" id="txt_clientplaylist"/></td>
    </tr>
    <tr style="height:25px">
      <td style="height:20px">终端地址</td>
      <td style="height:20px"><input type="text" id="txt_clientaddress"/></td>
      <td style="height:20px">维护人</td>
      <td style="height:20px"><input type="text" id="txt_clientUserName"/></td>
      <td style="height:20px">显示屏尺寸</td>
      <td style="height:20px"><input type="text" id="txt_displaysize"  maxlength="8"/></td>
      <td style="height:20px">FTP服务器</td>
      <td style="height:20px"><select name="selectFTP" id="selectFTP">
          <?=$ftpInfoselect?>
        </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><a href="javascript:void(0)" id="but_sel" onclick="delCurrentNodePath(this);selectClient();" class="zduan_left"><span class="zduan_right"> 搜  索 </span></a></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
</div>
</div>
	</div>

	</div>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1", {defaultTab:2});
//-->
resizeHeight();
function resizeHeight()
{
	_("clientInfo").style.height=(document.documentElement.clientHeight-200)+"px";
}
window.onresize=mainheight;

	function setVolume(dom)
	{
		dom.value=dom.value.replace(/\D/g,'');
		if(dom.value==""){dom.value=0;}
	}
	function mainheight(){
		if(document.getElementById('TabbedPanels1').style.display=="none") {
			//var c=window.document.body.clientHeight;
			var c=$('#gridt').height();
			var b=c-18;
			var cobj=document.getElementById('ifarmetop');
			cobj.style.height=b+"px";
			document.getElementById('TabbedPanels1').style.display="none"
		}
		else {
			//var c=window.document.body.clientHeight;
			var c=$('#gridt').height();
			var b=c-188;
			var cobj=document.getElementById('ifarmetop');
			cobj.style.height=b+"px";}
	}
	function sclickdown(obja){
		//var objo=obja;
		var ids=obja.id;
		switch (ids) {
			case 'showspan':
				document.getElementById('showspan').style.display="none";
				document.getElementById('cclick').style.bottom="10px";
				document.getElementById('hidespan').style.display="block";
					var c=$('#gridt').height();
				var _w_height=c-17-170;
				$("#ifarmetop").animate({height:_w_height},1000);
				$("#TabbedPanels1").css({display:"block"}).animate({height:170,opacity:1},1000);
				break;
			case 'hidespan':
				document.getElementById('hidespan').style.display="none";
				document.getElementById('cclick').style.bottom="5px";

				document.getElementById('showspan').style.display="block";
				var c=$('#gridt').height();
				var _w_height=c-16;
				$("#ifarmetop").animate({height:_w_height},1000);
				$("#TabbedPanels1").animate({height:10,opacity:0},1000,function(){$(this).css({display:"none"});});
				break;
		}
	}

// 修正 创建、编辑完成播放计划后没有更新，终端控制中的播放计划的BUG；
function refreshPlayList()
{
	//alert("update playList now!");
	$.ajax({
		url:"index.php/c_playlistManage/getPlayListToCilent",
		success:function(data, textStatus, jqXHR){
			var result=$.parseJSON(data);
			if(typeof(result)=="object"&&result.state)
			{
				$("#playList").html("");

				//{"playListID":"17","playListName":"dsd","playListType":"X86","startTime":"2012-08-06,00:00:00","lastTime":"2012-08-06,23:59:59"}
				if(!result.data.length){return ;}
				$('<option title="'+result.data[0]["lastTime"]+'" type="'+result.data[0]["playListType"]+'" selected="true" value="'+result.data[0]["playListID"]+'" >'+result.data[0]["playListName"]+'----('+result.data[0]['playListType']+')</option>').appendTo("#playList");
				for(var i =1, n=result.data.length; i<n; i++)
				{
					$('<option title="'+result.data[i]["lastTime"]+'" type="'+result.data[i]["playListType"]+'"  value="'+result.data[i]["playListID"]+'" >'+result.data[i]["playListName"]+'----('+result.data[i]['playListType']+')</option>').appendTo("#playList");
				}

			}
		},
		error:function(){},
		timeout:function(){}
	})
}
function menuHandler(item){
  console.log('Click Item: '+item.name);
  client_tree.removeRow(client_tree.right_click_select);
}
window.onload=function(){
	getClientInfoBySelect();
	mainheight();
	clientManage.clients=<?=json_encode($clientInfo)?>;
	clientManage.clientGroup=<?=json_encode($clientGroup)?>;
  var data=UCStoTreeGridData(userClientSouce);
  client_tree.init(data);

  //dbl_click_memu
  //$("#goods_Type_Grid").css("overflow-y", "scroll");
  /*
  $("input[type='checkbox']").each(
      function(){
        $(this).attr("checked",true);
        });*/
}
</script>