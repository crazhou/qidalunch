$(function() {

    var avali = [],
        short = $('#short');

    $('datalist option').each(function(e,i,o){
        var t = $(this),
            value = t.val();
        avali.push(value);
    });
    // 事件绑定
    $('.needInput').on('click', '.btn:not(.btn-dis)', function(){
        var v = $.trim(short.val()),
            role = $(this).data('role');

        if(v === '') {
            alert('请输入姓名简拼')
            short.trigger('focus');
        } else {
            if($.inArray(v, avali) > -1) {
                if(role ==='admin') {
                    location.href = '/entry/choose-menu?id=' + v;
                } else {
                    location.href = '/user/dian?short=' + v;
                }
            } else {
                alert('请输入正确的姓名简拼')
                short.trigger('focus');
            }
        }

    });

    // 菜单选择
    var menu = $('.menu-list').on('click', '.menu-item', function() {
        $(this).toggleClass('active');
        var lis = menu.find('a.active');
        if(lis.size()>2) {
            $(this).removeClass('active');
            return alert('每天最多可以选择两个菜单！');
        }
    });

    $('#entry').on('click', function(e) {
        var lis = menu.find('a.active');
        if(lis.size() > 0 && lis.size() < 3) {
            var q = [];
            lis.each(function(i,e){
                q.push($(e).data('id'));
            });
            location.href = '/user/admin?menuid='+ q.join(',');
        } else {
            alert('请选择今日菜单!');
        }
    });
});