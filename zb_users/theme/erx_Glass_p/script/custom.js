/*-------------------
*Description:      By www.yiwuku.com
*Website:          https://app.zblogcn.com/?auth=3ec7ee20-80f2-498a-a5dd-fda19b198194
*Author:           尔今 erx@qq.com
*update:           2025-09-08(Last:2025-09-08)
-------------------*/
$(function() {
	//erx:Navbar
	var erxUrl = location.href;
	$(".erx-menu > ul > li > a").each(function() {
		if (this.href == erxUrl.toString().split("#")[0]) {
			$(this).parent().addClass("cu");
			return false;
		}
	});
	$(".erx-menu > ul > li:has('ul')").each(function() {
		$(this).children("a").append("<i></i>");
	}).mouseenter(function(){
		$(this).addClass("erxact").children("ul").stop(true, true).delay(50).fadeIn(erxIsmobile()?0:200);
	}).mouseleave(function(){
		$(this).removeClass("erxact").children("ul").stop(true, true).delay(50).hide(0);
	});
    $(document).bind("click",function(e){
        if(erxIsmobile() && !$(e.target).closest(".erx-top-nav .navi").length && !$(e.target).closest(".erx-menu").length){
			$(".erx-top-nav .navi").removeClass("erxact");
			$(".erx-menu").removeClass("erxshow");
        }
    });
	$(".erx-top-nav .navi").click(function(){
		$(this).toggleClass("erxact");
		$(".erx-menu").toggleClass("erxshow");
	});
	//erx:Mobile
	$(window).resize(function(){
		erxGlassMobileNav();
	});
	function erxGlassMobileNav(){
		if(erxIsmobile()){
			$(".erx-menu > ul > li:has(ul)").each(function(){
				$(this).attr("data-minav", 0);
			});
		}else{
			$(".erx-menu > ul > li:has(ul)").removeAttr("data-minav");
		}
		$(".erx-search-form .sint").focus(function(){
			$(".erx-head-wrap").addClass("blur");
		}).blur(function(){
			$(".erx-head-wrap").removeClass("blur");
		});
	}
	erxGlassMobileNav();
	$(".erx-menu > ul > li:has('ul') > a").click(function(){
		var minav = $(this).parent().attr("data-minav")*1;
		if(!minav && erxIsmobile()){
			$(this).parent().attr("data-minav", 1).siblings().attr("data-minav", 0);
			return false;
		}
	});
	//erx:Article
	if($(".erx-article .spread").length){
		$(".erx-article .con").height() == 900 ? $('.erx-article .spread').addClass('erxshow') : $(".erx-article .con").removeClass('fold');
		$('.erx-article .spread > span').click(function(){
			let $s = $(this), $c = $s.parent().prev();
			$c.removeClass('fold');
			$s.remove();
		});
	}
    //erx:Catalog
	if($("#divCatalog").length){
		$("#divCatalog .function_c > ul > li:has('ul')").each(function(){
			$(this).append('<i></i>');
		});
		$('#divCatalog .function_c > ul > li').hoverDelay({
			hoverEvent:function(){
				$(this).children("ul").stop(true, false).slideDown();
			},
			outEvent: function(){
				$(this).children("ul").slideUp();
			}
		});
	}
    //erx:Gotop
	$(".erx-gotop").click(function(){
		$("html, body").animate({ scrollTop: 0 },300);
		return false;
	});
	var erxSctop = $(window).scrollTop(), erxSnum = 500;
	if(erxSctop > erxSnum){
		$(".erx-gotop").addClass("active");
	}
	$(window).scroll(function(){
		erxSctop = $(window).scrollTop();
		if(erxSctop > erxSnum){
			$(".erx-gotop").addClass("active");
		}else{
			$(".erx-gotop").removeClass("active");
		}		
	});
	//erx:Sidebar
	if($('.erx-sidebar').length && $(window).width() > 1080){
		$('.erx-sidebar').theiaStickySidebar({
			additionalMarginTop: 20
		});
	}
	function erxIsmobile(){
		var pwt = $(window).width();
		if (pwt < 1080 || /Android|Windows Phone|iPhone|iPod/i.test(navigator.userAgent)) {
			return true;
		}else{
			return false;
		}
	}
});
$.fn.hoverDelay = function(options){
    var defaults = {
        hoverDuring: 300,
        outDuring: 1,
        hoverEvent: function(){
            $.noop();
        },
        outEvent: function(){
            $.noop();
        }
    };
    var sets = $.extend(defaults,options || {});
    var hoverTimer, outTimer;
    return $(this).each(function(){
        var that = this;
        $(this).mouseenter(function(){
            clearTimeout(outTimer);
            hoverTimer = setTimeout(function () { if (typeof sets.hoverEvent == 'function') sets.hoverEvent.call(that) }, sets.hoverDuring);
        }).mouseleave(function(){
            clearTimeout(hoverTimer);
            outTimer = setTimeout(function () { if (typeof sets.outEvent == 'function') sets.outEvent.call(that) }, sets.outDuring);
        });    
    });
}
if(window.console && window.console.log){
    console.log('\n %c Z-Blog erx_Glass_p %c \u5c14\u4eca\u4f5c\u54c1 \n', 'color:#fff;background:#f80;padding:5px 0;', 'color:#fff;background:#333;padding:5px 0;');
    console.log("%c \x68\x74\x74\x70\x73\x3a\x2f\x2f\x61\x70\x70\x2e\x7a\x62\x6c\x6f\x67\x63\x6e\x2e\x63\x6f\x6d\x2f\x3f\x69\x64\x3d\x35\x31\x32\x37\x37", "");
}
//erx:Comments
zbp.plugin.unbind("comment.reply.start", "system");
zbp.plugin.on("comment.reply.start", "erx_Glass_p", function(id) {
	var i = id;
	$("#inpRevID").val(i);
	var frm = $('#divCommentPost'), cancel = $("#cancel-reply");
	if (!frm.hasClass("reply-frm")){
		frm.before($("<div id='temp-frm' style='display:none'>")).addClass("reply-frm");
	}
	if(!$('#AjaxComment' + i).length){
		$("#cmt"+i).find(".con").after('<label id="AjaxComment'+i+'"></label>');
	}else{
		$('#AjaxComment' + i).remove();
		$("#cmt"+i).find(".con").after('<label id="AjaxComment'+i+'"></label>');
	}
	$('#AjaxComment' + i).before(frm);
	cancel.show().click(function() {
		var temp = $('#temp-frm');
		$("#inpRevID").val(0);
		if (!temp.length || !frm.length) return;
		temp.before(frm);
		temp.remove();
		$(this).hide();
		frm.removeClass("reply-frm");
		return false;
	});
	try {
		$('#txaArticle').focus();
	} catch (e) {}
	return false;
})
zbp.plugin.on("comment.get", "erx_Glass_p", function (logid, page) {
	$('span.commentspage').html("Waiting...");
});
zbp.plugin.on("comment.got", "erx_Glass_p", function () {
	$("#cancel-reply").click();
});
zbp.plugin.on("comment.post.success", "erx_Glass_p", function () {
	$("#cancel-reply").click();
});
























//以上代码已做高效和精简处理，默认无任何错误，若无十足把握切勿擅自修改，以免出错！（尔今 erx@qq.com）
//https://app.zblogcn.com/?auth=3ec7ee20-80f2-498a-a5dd-fda19b198194
