$(function() {
  _.templateSettings = {
    interpolate: /\{\{([\s\S]+?)\}\}/g,
    evaluate : /\{%([\s\S]+?)%\}/g,
    escape: /\{\{-([\s\S]+?)\}\}/g
  }

    // 显示弹出层
  var alertDialog = function (j) {
    this.open = function() {
      j.removeClass('hide')
    }
    this.init(j);  
  }

  _.extend(alertDialog.prototype, {
    init : function(j) {
      j.on('click', '.close', function(e){
        j.addClass('hide');
      });
    }
  })
  // 倒计时代码
  $('.countdown').countdown({
    tmpl : $('#tem-countdown').html(),
    afterEnd : function(q) {
        q.html('<span class="txt">不在点餐时间段</span>')
    }
  })

  // 自定义Checkbox
  $('.table').on('click', '.con-chk', function(e) {
    var t = $(this),
        cls = ['con-chkgray', 'fa fa-check-square color-gre'],
        i = t.find('i'),
        tr = t.parent().parent(),
        pkong = tr.find('.pkong');
    
    if(t.hasClass('chked')) {
      t.removeClass('chked');
      i.attr('class', cls[0]);
      tr.removeClass('active');
      pkong.addClass('hide');
    } else {
      t.addClass('chked');
      i.attr('class', cls[1]);
      tr.addClass('active');
      pkong.removeClass('hide');
    }
    UpdateText();
  });

  // 加减控件
  $('.table').on('click', '.pkong', function(e) {
    var t = $(e.target),
        numcont = $(this).find('span'),
        num = +numcont.html();
      if(t.hasClass('add')) {
        num++;
        if(num>10) {
          return alert('每个菜最多点十份哦！')
        }
      }
      if(t.hasClass('mus')) {
        num--;
        if(num<1) {
          return false;
        }
      }
      numcont.html(num);
      UpdateText();
  })

  var dialog = new alertDialog($('.aler_dialog'));
  // 增加菜单
  $('.app').on('click', '.add-new-menu,.edit-menu', function(e) {
      dialog.open();
  });

  // 更新文字 
  function UpdateText() {
    var cont = $('#data_cont1'),
        selData = [],
        trs = cont.find('tr.active'),
        tips = $('.tips .tip-btn'),
        _temp = _.template($('#tem-summary').html()),
        tiptxt= $('.tip-txt');
      if(trs.size()>0) {
        trs.each(function(i,e){
          var 
          t = $(e),
          tmp = {
            id : t.data('id'),
            name : t.find('.dish-name').html(),
            count : t.find('.nums').html(),
            price : t.find('.price').html()
          };
          selData.push(tmp);
        });
        tiptxt.html(_temp(selData));
        tips.removeClass('hide');
      } else {
        tips.addClass('hide');
      }
  }

    $('.ptabs').on('click', 'a:not(.add-new-menu)', function(e) {
        var t = $(this),
            id = t.data('menuid');
        t.addClass('active').siblings().removeClass('active');

        getDishList(id);
        $('input[name=menuid]').val(id);
    });

  // 模板渲染
    function getDishList(id) {
        var _temp = _.template($('#tem-dishlist').html()),
            data_cont = $('#data_cont1'),
            url = '/dish/list';
        $.ajax(url, {
            type : 'GET',
            dataType : 'json',
            data : {id:id},
            cache : false,
            timeout : 2000,
            success : function(resp) {
                if(!resp.ret) {
                    data_cont.html(_temp(resp.dataset));
                } else {
                    alert(resp.errorMsg);
                }
            }
        })
    }
    var activeEl = $('.ptabs').find('.active');
    if(activeEl.size() > 0) {
        var id = activeEl.data('menuid');
        getDishList(id);
    }

    if(pageVar.isAdmin) {
        var form = $('.add-dish').on('submit', function(e) {
            e.preventDefault();
            var data = form.serializeArray(),
                post_data = {}
            $.each(data, function(i,e) {
                if(e.value !== '') {
                    if(e.name === 'price') {
                        if(/^\d{1,2}$/.test(e.value)) {
                            post_data[e.name] = e.value;
                        } else {
                            alert('价格必需为数字！');
                        }
                    } else {
                        post_data[e.name] = e.value;
                    }
                } else {
                    alert('还有字段没有填写！');
                    return false;
                }
            });

            if(_.size(post_data) === 4) {
                var url = '/dish/adddish';

                $.ajax(url, {
                    type : 'GET',
                    dataType : 'json',
                    data : post_data,
                    cache : false,
                    timeout : 2000,
                    success : function(resp) {

                    }
                });
            } else {
                alert('输入不完整，请检查!');
            }
        });
    }
});