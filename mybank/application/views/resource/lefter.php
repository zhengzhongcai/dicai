<!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2>数据管理</h2>
      
      <div class="left_menu_a_list">
        <ul>
          <li auth="288" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=resource&action=resMananger&fcode=resource-tpl">资源文件管理</a></li>
			<li auth="232" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=resource&action=tplList&fcode=resource-tpl" >模板</a></li>
			<li auth="236" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=resource&action=videoList&fcode=resource-v">视频</a></li>
			<li auth="240" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=resource&action=audioList&fcode=resource-a" >音频</a></li>
			<li auth="244" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=resource&action=picList&fcode=resource-p" >图片</a></li>
			<li auth="248" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=resource&action=textList&fcode=resource-t" >文字</a></li>
			<li auth="252" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=resource&action=newscate&fcode=resource-c" >新闻分类</a></li>
			<li auth="256" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=resource&action=newsitem&fcode=resource-i" >新闻条目</a></li>
			<li auth="260" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=resource&action=rescheck&fcode=resource-ch" >资源审核</a></li>
			<li auth="264" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=resource&action=commoncfg&fcode=resource-cfg" >总体配置</a></li>
        </ul>
      </div>
    </div>
    </div>
<a onclick="hiddenLeft()" class="hidden_left" style="background-color:#EEECED"></a>
  <!----left end----> 
  <script>
    <?php foreach($www as $val): ?>
    $('li[auth="<?php echo $val['menurole_id'];?>"]').css('display', 'block');
    <?php endforeach;?>
  </script>