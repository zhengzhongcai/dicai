$(document).ready(function(){

    // first example
    $("#browser").treeview();

    // 修改侧边的高度
    resizeLeftHeight();

    // 调整地图区域大小
    $('#allmap').css('min-height', $('.left_box').css('min-height'));
    $('#allmap').css('height', $('.right_box').css('height'));
});

String.prototype.trimcomma=function(){
    // 用正则表达式将前后空格
    // 用空字符串替代。
    return this.replace(/(^,*)|(,*$)/g, "");
}
String.prototype.chop=function(){
    // 用正则表达式将前后空格
    // 用空字符串替代。
    return this.replace(/(^\s*)|(\s*$)/g,"");
}
/*
function checkOrginizationTree(orgid, actionCall, el){
    $(el).closest('.treeview').find('a.selected').removeClass('selected');
    $(el).addClass('selected');
    actionCall(orgid, el);
}
*/
function checkOrginizationTree(orgid, actionCall, el){
    $(el).closest('.treeview').find('a.selected').removeClass('selected');
    $(el).addClass('selected');
    actionCall(orgid, el);
}


// 隐藏左侧
function hiddenLeft(){
    $('.left_box').toggle();
    if ('0px' == $('.hidden_left').css('left')){
        $('.hidden_left').css('left', '193px');
        $('.hidden_left').css('background', 'url(assets/images/hidden_left.png)');
        //$('.hidden_left').css('top', '126px');
    }else{
        $('.hidden_left').css('left', '0px');
        $('.hidden_left').css('background', 'url(assets/images/hidden_right.png)');
        //$('.hidden_left').css('top', '126px');
    }// if
}// fun

// 隐藏头部
function hiddenTop(){
    $('.head_bar').toggle();
    if ('24px' == $('.hidden_top').css('top'))
    {
        $('.hidden_top').css('top', '118px');
        $('.hidden_left').css('top', '126px');

        $('.sel_container').css('top', '137px');
        $('.spot').css('top', '137px');

        $('.hidden_top').css('background', 'url(assets/images/hidden_top.png) no-repeat center 0 #EEECED');
    }else{
        $('.hidden_top').css('top', '24px');
        $('.hidden_left').css('top', '32px');

        $('.sel_container').css('top', '40px');
        $('.spot').css('top', '40px');

        $('.hidden_top').css('background', 'url(assets/images/hidden_down.png) no-repeat center 0 #EEECED');
    }// if
}// func

// resize左边侧边栏高度
function resizeLeftHeight(){
    var hdoc = document.body.clientHeight;
    var sdoc = window.innerHeight-160;
    var h = (hdoc > sdoc) ? hdoc:sdoc;
    // 修改侧边的高度
    $('.right_box').css('min-height', h);
    $('.left_box').css('height', h);
    $('.hidden_left').css('height', h);
    $('.left_menu_b_list').css('height', h);
}// func


// 返回post参数
function getPostData(obj) {
    var postDataStr = '';
    var type;
    $(obj).find("input[type='text'],input[type='hidden'],input[type='number'],input[type='password'],select,textarea").each(function(index, element) {
        postDataStr += $(this).attr("name")+'='+$(this).val().chop()+'&';
    });

    // 复选框
    var checkboxArr = new Object();
    $(obj).find("input[type='checkbox'][name='isspot'],input[type='checkbox'][name='funcs'],input[class='auth'],input[name='org']").each(function(index, element) {
        if ($(this).attr("checked")){
            if (typeof checkboxArr[$(this).attr("name")] == "undefined") checkboxArr[$(this).attr("name")] = "";
            // 合并值,用逗号分隔
            checkboxArr[$(this).attr("name")] += $(this).attr("value")+',';
        }// if
    });
    for (var idx in checkboxArr){
        postDataStr += idx+"="+checkboxArr[idx].trimcomma()+"&";
    }// for
    //alert(postDataStr);
    return postDataStr;
}// func

function chartActive(type){
    // jQuery Data Visualize
    $('table.data').each(function() {
        var chartWidth = Math.floor($(this).parent().width()*0.95); // Set chart width to 90% of its parent
        var chartType = ''; // Set chart type

        if ($(this).attr('data-chart')) { // If exists chart-chart attribute
            chartType = $(this).attr('data-chart'); // Get chart type from data-chart attribute
        } else {
            chartType = 'area'; // If data-chart attribute is not set, use 'area' type as default. Options: 'bar', 'area', 'pie', 'line'
        }

        chartType = type;

        if(chartType == 'line' || chartType == 'pie') {
            $(this).hide().visualize({
                type: chartType,
                width: chartWidth,
                height: '240px',
                colors: ['#be1e2d','#666699','#92d5ea','#ee8310','#8d10ee','#5a3b16','#26a4ed','#f45a90','#e9e744'],
                lineDots: 'double',
                interaction: true,
                multiHover: 5,
                tooltip: true,
                tooltiphtml: function(data) {
                    var html ='';
                    for(var i=0; i<data.point.length; i++){
                        html += '<p class="chart_tooltip"><strong>'+data.point[i].value+'</strong> '+data.point[i].yLabels[0]+'</p>';
                    }
                    return html;
                }
            });
        } else {
            $(this).hide().visualize({
                type: chartType,
                width: chartWidth,
                height: '240px',
                colors: ['#be1e2d','#666699','#92d5ea','#ee8310','#8d10ee','#5a3b16','#26a4ed','#f45a90','#e9e744']
            });
        }
    });
}// func

// 显示资源弹窗
function showRes(title, url){
    popWin.showWin("600","400",title,url);
}

function savemenu(){
    var  str="";
    $("#demo4").find("input[name='fun_name'][type='checkbox']").each(function(){
        if($(this).attr("checked")){
            str+=$(this).attr("id")+",";
        }
    });
    return str;
}
function saverole(){
    var  str="";
    $("#demo5").find("input").each(function(){
        if($(this).attr("checked")){
            str+=$(this).attr("id")+",";
        }
    });
    return str;
}