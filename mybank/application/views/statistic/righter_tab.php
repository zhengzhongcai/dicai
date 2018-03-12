  <!----right---->
  <div class="right_box">  
    <!----tab 标签页---->
    <div class="mod_tab">
      <ul>
      </ul>
    </div>
	<script>
		// 找出网点数据
		function tabChange(elem){
			$(elem).parent().children("li").each(function(){
				$(this).removeClass('on');
			});
			$(elem).addClass('on');
		}// func
		
		// 删除网点tab
		function deleteTab(elem){
			$(elem).parent().remove();
		}// func
	
	</script>
    <!----tab 标签页 end----> 