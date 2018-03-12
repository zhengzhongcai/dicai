<!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2>数据管理</h2>
      
      <div class="left_menu_a_list">
        <ul>
			<li auth="96" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=serialParam&fcode=data-b" >业务管理</a></li>
			<li auth="100" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=serverParam&fcode=data-t" >柜员管理</a></li>
			<li auth="104" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=counterParam&fcode=data-c" >柜台管理</a></li>
			<li auth="108" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=vipParam&fcode=data-v" >VIP客户资料管理</a></li>
			<li auth="112" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=commonParam&fcode=data-p" >公共参数管理</a></li>
          <!--  <li auth="data-p" class="statItem"><a href="<{$baseUrl}>/index.php?control=lookimage&action=index" <{if $action eq "commonParam"}>class="on"<{/if}>><{$DATA_LEFTER_MANAGE_PARAM1|default:"查看图片"}></a></li>-->
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