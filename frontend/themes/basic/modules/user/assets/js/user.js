/*! jquery.cookie v1.4.1 | MIT */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?a(require("jquery")):a(jQuery)}(function(a){function b(a){return h.raw?a:encodeURIComponent(a)}function c(a){return h.raw?a:decodeURIComponent(a)}function d(a){return b(h.json?JSON.stringify(a):String(a))}function e(a){0===a.indexOf('"')&&(a=a.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return a=decodeURIComponent(a.replace(g," ")),h.json?JSON.parse(a):a}catch(b){}}function f(b,c){var d=h.raw?b:e(b);return a.isFunction(c)?c(d):d}var g=/\+/g,h=a.cookie=function(e,g,i){if(void 0!==g&&!a.isFunction(g)){if(i=a.extend({},h.defaults,i),"number"==typeof i.expires){var j=i.expires,k=i.expires=new Date;k.setTime(+k+864e5*j)}return document.cookie=[b(e),"=",d(g),i.expires?"; expires="+i.expires.toUTCString():"",i.path?"; path="+i.path:"",i.domain?"; domain="+i.domain:"",i.secure?"; secure":""].join("")}for(var l=e?void 0:{},m=document.cookie?document.cookie.split("; "):[],n=0,o=m.length;o>n;n++){var p=m[n].split("="),q=c(p.shift()),r=p.join("=");if(e&&e===q){l=f(r,g);break}e||void 0===(r=f(r))||(l[q]=r)}return l};h.defaults={},a.removeCookie=function(b,c){return void 0===a.cookie(b)?!1:(a.cookie(b,"",a.extend({},c,{expires:-1})),!a.cookie(b))}});

/*! Copyright (c) 2011 Piotr Rochala (http://rocha.la)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Version: 1.3.3
 *
 */
(function(e){e.fn.extend({slimScroll:function(g){var a=e.extend({width:"auto",height:"250px",size:"7px",color:"#000",position:"right",distance:"1px",start:"top",opacity:.4,alwaysVisible:!1,disableFadeOut:!1,railVisible:!1,railColor:"#333",railOpacity:.2,railDraggable:!0,railClass:"slimScrollRail",barClass:"slimScrollBar",wrapperClass:"slimScrollDiv",allowPageScroll:!1,wheelStep:20,touchScrollStep:200,borderRadius:"7px",railBorderRadius:"7px"},g);this.each(function(){function u(d){if(r){d=d||window.event;
var c=0;d.wheelDelta&&(c=-d.wheelDelta/120);d.detail&&(c=d.detail/3);e(d.target||d.srcTarget||d.srcElement).closest("."+a.wrapperClass).is(b.parent())&&m(c,!0);d.preventDefault&&!k&&d.preventDefault();k||(d.returnValue=!1)}}function m(d,e,g){k=!1;var f=d,h=b.outerHeight()-c.outerHeight();e&&(f=parseInt(c.css("top"))+d*parseInt(a.wheelStep)/100*c.outerHeight(),f=Math.min(Math.max(f,0),h),f=0<d?Math.ceil(f):Math.floor(f),c.css({top:f+"px"}));l=parseInt(c.css("top"))/(b.outerHeight()-c.outerHeight());
f=l*(b[0].scrollHeight-b.outerHeight());g&&(f=d,d=f/b[0].scrollHeight*b.outerHeight(),d=Math.min(Math.max(d,0),h),c.css({top:d+"px"}));b.scrollTop(f);b.trigger("slimscrolling",~~f);v();p()}function C(){window.addEventListener?(this.addEventListener("DOMMouseScroll",u,!1),this.addEventListener("mousewheel",u,!1)):document.attachEvent("onmousewheel",u)}function w(){s=Math.max(b.outerHeight()/b[0].scrollHeight*b.outerHeight(),30);c.css({height:s+"px"});var a=s==b.outerHeight()?"none":"block";c.css({display:a})}
function v(){w();clearTimeout(A);l==~~l?(k=a.allowPageScroll,B!=l&&b.trigger("slimscroll",0==~~l?"top":"bottom")):k=!1;B=l;s>=b.outerHeight()?k=!0:(c.stop(!0,!0).fadeIn("fast"),a.railVisible&&h.stop(!0,!0).fadeIn("fast"))}function p(){a.alwaysVisible||(A=setTimeout(function(){a.disableFadeOut&&r||x||y||(c.fadeOut("slow"),h.fadeOut("slow"))},1E3))}var r,x,y,A,z,s,l,B,k=!1,b=e(this);if(b.parent().hasClass(a.wrapperClass)){var n=b.scrollTop(),c=b.parent().find("."+a.barClass),h=b.parent().find("."+a.railClass);
w();if(e.isPlainObject(g)){if("height"in g&&"auto"==g.height){b.parent().css("height","auto");b.css("height","auto");var q=b.parent().parent().height();b.parent().css("height",q);b.css("height",q)}if("scrollTo"in g)n=parseInt(a.scrollTo);else if("scrollBy"in g)n+=parseInt(a.scrollBy);else if("destroy"in g){c.remove();h.remove();b.unwrap();return}m(n,!1,!0)}}else if(!(e.isPlainObject(g)&&"destroy"in g)){a.height="auto"==a.height?b.parent().height():a.height;n=e("<div></div>").addClass(a.wrapperClass).css({position:"relative",
overflow:"hidden",width:a.width,height:a.height});b.css({overflow:"hidden",width:a.width,height:a.height});var h=e("<div></div>").addClass(a.railClass).css({width:a.size,height:"100%",position:"absolute",top:0,display:a.alwaysVisible&&a.railVisible?"block":"none","border-radius":a.railBorderRadius,background:a.railColor,opacity:a.railOpacity,zIndex:90}),c=e("<div></div>").addClass(a.barClass).css({background:a.color,width:a.size,position:"absolute",top:0,opacity:a.opacity,display:a.alwaysVisible?
"block":"none","border-radius":a.borderRadius,BorderRadius:a.borderRadius,MozBorderRadius:a.borderRadius,WebkitBorderRadius:a.borderRadius,zIndex:99}),q="right"==a.position?{right:a.distance}:{left:a.distance};h.css(q);c.css(q);b.wrap(n);b.parent().append(c);b.parent().append(h);a.railDraggable&&c.bind("mousedown",function(a){var b=e(document);y=!0;t=parseFloat(c.css("top"));pageY=a.pageY;b.bind("mousemove.slimscroll",function(a){currTop=t+a.pageY-pageY;c.css("top",currTop);m(0,c.position().top,!1)});
b.bind("mouseup.slimscroll",function(a){y=!1;p();b.unbind(".slimscroll")});return!1}).bind("selectstart.slimscroll",function(a){a.stopPropagation();a.preventDefault();return!1});h.hover(function(){v()},function(){p()});c.hover(function(){x=!0},function(){x=!1});b.hover(function(){r=!0;v();p()},function(){r=!1;p()});b.bind("touchstart",function(a,b){a.originalEvent.touches.length&&(z=a.originalEvent.touches[0].pageY)});b.bind("touchmove",function(b){k||b.originalEvent.preventDefault();b.originalEvent.touches.length&&
(m((z-b.originalEvent.touches[0].pageY)/a.touchScrollStep,!0),z=b.originalEvent.touches[0].pageY)});w();"bottom"===a.start?(c.css({top:b.outerHeight()-c.outerHeight()}),m(0,!0)):"top"!==a.start&&(m(e(a.start).position().top,null,!0),a.alwaysVisible||c.hide());C()}});return this}});e.fn.extend({slimscroll:e.fn.slimScroll})})(jQuery);

/*!
 * Copyright 2015, iiSNS
 * Released under the MIT License
 * http://www.iisns.com
 */
$(function() {
    'use strict';

    //顶部导航宽度
    var topNavWidth = parseInt($('#main-container').css('width')) + parseInt($('aside.skin-1').css('width'));
    $('#top-nav').css('width', topNavWidth + 'px');

    //scroll to top of the page
    $("#scroll-to-top").click(function() {
        $("html, body").animate({ scrollTop: 0 }, 600);
         return false;
    });
    
    //scrollable sidebar
    $('.scrollable-sidebar').slimScroll({
        height: '100%',
        size: '0px'
    });
    
    //Sidebar menu dropdown
    $('aside li').hover(
       function(){ $(this).addClass('open') },
       function(){ $(this).removeClass('open') }
    )
    
    //Collapsible Sidebar Menu
    $('.openable > a').click(function()    {    
        if(!$('#wrapper').hasClass('sidebar-mini'))    {
            if( $(this).parent().children('.submenu').is(':hidden') ) {
                $(this).parent().siblings().removeClass('open').children('.submenu').slideUp();
                $(this).parent().addClass('open').children('.submenu').slideDown();
            }
            else    {
                $(this).parent().removeClass('open').children('.submenu').slideUp();
            }
        }
        
        return false;
    });
        
    //Toggle Menu
    $('#sidebarToggle').click(function()    {
        $('#wrapper').toggleClass('sidebar-display');
        $('.main-menu').find('.openable').removeClass('open');
        $('.main-menu').find('.submenu').removeAttr('style');
    });

    $('#sizeToggle').click(function()    {
    
        $('#wrapper').off("resize");
    
        $('#wrapper').toggleClass('sidebar-mini');
        $('.main-menu').find('.openable').removeClass('open');
        $('.main-menu').find('.submenu').removeAttr('style');
        $.cookie('sizeToggle', $('#wrapper').attr('class'), {expires:365,path:'/'});
    });

    if(jQuery.type($.cookie('sizeToggle')) != 'undefined')    {
        $('#wrapper').removeClass('sizeToggle');
        $('#wrapper').addClass($.cookie('sizeToggle'));
    }

    if(!$('#wrapper').hasClass('sidebar-mini'))    { 
        if (Modernizr.mq('(min-width: 768px)') && Modernizr.mq('(max-width: 868px)')) {
            $('#wrapper').addClass('sidebar-mini');
        }
        else if (Modernizr.mq('(min-width: 869px)'))    {
            if(!$('#wrapper').hasClass('sidebar-mini'))    {
            }
        }
    }

    //show/hide menu
    $('#menuToggle').click(function()    {
        $('#wrapper').toggleClass('sidebar-hide');
        $('.main-menu').find('.openable').removeClass('open');
        $('.main-menu').find('.submenu').removeAttr('style');
    });
    
    $(window).resize(function() {
        if (Modernizr.mq('(min-width: 768px)') && Modernizr.mq('(max-width: 868px)')) {
            $('#wrapper').addClass('sidebar-mini').addClass('window-resize');
            $('.main-menu').find('.openable').removeClass('open');
            $('.main-menu').find('.submenu').removeAttr('style');
        }
        else if (Modernizr.mq('(min-width: 869px)'))    {
            if($('#wrapper').hasClass('window-resize'))    {
                $('#wrapper').removeClass('sidebar-mini window-resize');
                $('.main-menu').find('.openable').removeClass('open');
                $('.main-menu').find('.submenu').removeAttr('style');
            }
        }
        else    {
            $('#wrapper').removeClass('sidebar-mini window-resize');
            $('.main-menu').find('.openable').removeClass('open');
            $('.main-menu').find('.submenu').removeAttr('style');
        }
    });
    
    //fixed Sidebar
    $('#fixedSidebar').click(function()    {
        if($(this).prop('checked'))    {
            $('aside').addClass('fixed');
        }    
        else    {
            $('aside').removeClass('fixed');
        }
    });
    
    //Inbox sidebar (inbox.html)
    $('#inboxMenuToggle').click(function()    {
        $('#inboxMenu').toggleClass('menu-display');
    });
    
    //Collapse panel
    $('.collapse-toggle').click(function()    {
    
        $(this).parent().toggleClass('active');
    
        var parentElm = $(this).parent().parent().parent().parent();
        
        var targetElm = parentElm.find('.panel-body');
        
        targetElm.toggleClass('collapse');
    });
    
    
    //Hover effect on touch device
    $('.image-wrapper').bind('touchstart', function(e) {
        $('.image-wrapper').removeClass('active');
        $(this).addClass('active');
    });
    
    //Dropdown menu with hover
    $('.hover-dropdown').hover(
       function(){ $(this).addClass('open') },
       function(){ $(this).removeClass('open') }
    )

    //选择系统头像
    $('#set-avatar').click(function() {
        $.ajax({
            url: $(this).attr('href'),
            type:'post',
            error: function(){alert('error');},
            success:function(html){
                $('#avatar-container').html(html);
                $('#avatarModal').modal('show');
            }
        });
    });

    //头像提示用户信息
    $('[rel=author]').popover({
        trigger : 'manual',
        container: 'body',
        html : true,
        placement: 'auto right',
        content : '<div class="popover-user"></div>',
    }).on('mouseenter', function(){
        var _this = this;
        $(this).popover('show');
        $.ajax({
            url: $(this).attr('href'),
            success: function(html){
                $('.popover-user').html(html);
                $('.popover .btn-success, .popover .btn-danger').click(function(){
                    $.ajax({
                        url: $(this).attr('href'),
                        success: function(data) {
                            $('.popover .btn-success').text('关注成功').addClass('disabled');
                            $('.popover .btn-danger').text('取消成功').addClass('disabled');
                        },
                        error: function (XMLHttpRequest, textStatus) {
                            $(_this).popover('hide');
                            $('#modal').modal({ remote: '/site/login'});
                        }
                    });
                    return false;
                });
            }
        });
        $('.popover').on('mouseleave', function () {
            $(_this).popover('hide');
        });
    }).on('mouseleave', function () {
        var _this = this;
        setTimeout(function () {
            if(!$('.popover:hover').length) {
                $(_this).popover('hide')
            }
        }, 100);
    });
});

(function() {
    //删除
    $('body').on('mouseenter', '[data-clicklog=delete]', function(event) {
        $('[data-clicklog=delete]').popover({
            trigger : 'click',
            container: 'body',
            placement: 'top',
            title: this.title,
            content : '<div class="delete"><a class="btn-ok" href="javascript:void(0)"><i class="glyphicon glyphicon-ok"></i> 确定</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="$(\'.popover\').popover(\'hide\')"><i class="glyphicon glyphicon-remove"></i> 取消</a></div>',
            html: true
        }).on('click', function(){
            var _this = this;
            var url = $(this).attr('href');
            var div_id = url.substr(url.indexOf('=') + 1);
            $(this).popover('show');
            $('.popover').on('mouseleave', function () {
                $(_this).popover('hide');
            });
            $('.btn-ok').on('click', function(){
                $.ajax({
                    type: 'POST',
                    url: url,
                    success: function() {
                        $(_this).popover('hide');
                        $('#'+div_id).fadeOut(1000);
                    }
                });
                return false;
            });
        }).on('mouseleave', function () {
            var _this = this;
            setTimeout(function () {
                if(!$('.popover:hover').length) {
                    $(_this).popover('hide')
                }
            }, 500);
        });
        return false;
    });

    //添加评论
    $('body').on('click', '[data-clicklog=comment]', function(event) {
        var _this = this;
        $(this).css('display', 'none');
        $(this).after('<div class="comment-box-wrap"><textarea class="form-control" id="comment-textarea"></textarea><a href="" class="btn btn-default btn-comment">Send</a></div>');
        $('.btn-comment').on('click', function(){
            $.ajax({
                type: 'GET',
                url: $(_this).children().attr('href'),
                data: {content : $('#comment-textarea').val()},
                success: function() {
                }
            });
            return false;
        });
         $(document).click(function (e) {
             var id = $(e.target).attr('class');
            if (id != 'comment-box-wrap' && id != 'form-control' && id != 'btn-comment') {
                $('.comment-box-wrap').remove();
                $(_this).css('display', 'block');
            };
        });
        return false;
    });
}).call(this);

$(window).scroll(function(){
     var position = $(window).scrollTop();
     //Display a scroll to top button
     if(position >= 200)    {
        $('#scroll-to-top').attr('style','bottom:16%;');    
     }
     else    {
        $('#scroll-to-top').removeAttr('style');
     }
});
