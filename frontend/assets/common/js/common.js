$(function() {
    'use strict';
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
            url: $(this).attr('href') + '?card=1',
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
