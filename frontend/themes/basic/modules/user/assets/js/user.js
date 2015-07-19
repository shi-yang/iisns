
$(function() {
	'use strict';
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
	$('.openable > a').click(function()	{	
		if(!$('#wrapper').hasClass('sidebar-mini'))	{
			if( $(this).parent().children('.submenu').is(':hidden') ) {
				$(this).parent().siblings().removeClass('open').children('.submenu').slideUp();
				$(this).parent().addClass('open').children('.submenu').slideDown();
			}
			else	{
				$(this).parent().removeClass('open').children('.submenu').slideUp();
			}
		}
		
		return false;
	});
		
	//Toggle Menu
	$('#sidebarToggle').click(function()	{
		$('#wrapper').toggleClass('sidebar-display');
		$('.main-menu').find('.openable').removeClass('open');
		$('.main-menu').find('.submenu').removeAttr('style');
	});

	$('#sizeToggle').click(function()	{
	
		$('#wrapper').off("resize");
	
		$('#wrapper').toggleClass('sidebar-mini');
		$('.main-menu').find('.openable').removeClass('open');
		$('.main-menu').find('.submenu').removeAttr('style');
		$.cookie('sizeToggle', $('#wrapper').attr('class'), {expires:365,path:'/'});
	});

	if(jQuery.type($.cookie('sizeToggle')) != 'undefined')	{
		$('#wrapper').removeClass('sizeToggle');
		$('#wrapper').addClass($.cookie('sizeToggle'));
	}

	if(!$('#wrapper').hasClass('sidebar-mini'))	{ 
		if (Modernizr.mq('(min-width: 768px)') && Modernizr.mq('(max-width: 868px)')) {
			$('#wrapper').addClass('sidebar-mini');
		}
		else if (Modernizr.mq('(min-width: 869px)'))	{
			if(!$('#wrapper').hasClass('sidebar-mini'))	{
			}
		}
	}

	//show/hide menu
	$('#menuToggle').click(function()	{
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
		else if (Modernizr.mq('(min-width: 869px)'))	{
			if($('#wrapper').hasClass('window-resize'))	{
				$('#wrapper').removeClass('sidebar-mini window-resize');
				$('.main-menu').find('.openable').removeClass('open');
				$('.main-menu').find('.submenu').removeAttr('style');
			}
		}
		else	{
			$('#wrapper').removeClass('sidebar-mini window-resize');
			$('.main-menu').find('.openable').removeClass('open');
			$('.main-menu').find('.submenu').removeAttr('style');
		}
	});
	
	//fixed Sidebar
	$('#fixedSidebar').click(function()	{
		if($(this).prop('checked'))	{
			$('aside').addClass('fixed');
		}	
		else	{
			$('aside').removeClass('fixed');
		}
	});
	
	//Inbox sidebar (inbox.html)
	$('#inboxMenuToggle').click(function()	{
		$('#inboxMenu').toggleClass('menu-display');
	});
	
	//Collapse panel
	$('.collapse-toggle').click(function()	{
	
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
	 if(position >= 200)	{
		$('#scroll-to-top').attr('style','bottom:16%;');	
	 }
	 else	{
		$('#scroll-to-top').removeAttr('style');
	 }
});
