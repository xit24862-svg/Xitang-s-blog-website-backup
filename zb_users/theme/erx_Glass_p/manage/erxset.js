/*
For: erx_Glass_p[ZBLOG-PHP主题]
Author: 尔今
Author Email: erx@qq.com
Author URL: http://www.yiwuku.com/
*/

$(function(){
    $("input[type='text']").attr("autocomplete","off");
    $(".erx-set-box input").focus(function(){
        $(".erx-set-box .btnfix").addClass("pulse");
    });
    $(".imgcheck").click(function(){
        $(".erx-set-box .btnfix").addClass("pulse");
    });
    //erx:Select
    $(".xytab-tit label").click(function(){
        var i=$(this).index();
        $(this).parent().next().children("span:eq("+i+")").show().siblings().hide();
    });
    $(".xytab-tit label").each(function(){
        var i=$(this).index();
        if($(this).children().attr("checked")){
            $(this).parent().next().children("span:eq("+i+")").show().siblings().hide();
        }
    });
    //erx:DiyOpen
    $(".xydiybtn").click(function(){
        $(".xydiycon").removeClass("act");
        $(this).next(".xydiycon").toggleClass("act").find("textarea").focus();
    });
    $(document).bind("mousedown",function(e){
        if(!$(e.target).closest(".xydiybtn").length && !$(e.target).closest(".xydiycon").length){
            $(".xydiycon").removeClass("act");
        }
    });
});








/* erx@qq.com https://app.zblogcn.com/?auth=3ec7ee20-80f2-498a-a5dd-fda19b198194 */