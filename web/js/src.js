$(function() {
  _.templateSettings = {
    interpolate: /\{\{([\s\S]+?)\}\}/g,
    evaluate : /\{%([\s\S]+?)%\}/g,
    escape: /\{\{-([\s\S]+?)\}\}/g
  }
    // 显示弹出层
  var alertDialog = function (j, txt) {

    this.open = function() {
      j.removeClass('hide')
    };

    this.hide = function() {
      j.addClass('hide');
    };

    this.setContent = function(m) {
      j.find('.content').html(m);
        return this;
    };
    txt && this.setContent(txt);

    this.tips = function(txt, t) {
      txt && this.setContent('<div class="item">' + txt + '</div>');
      if(t> 1000) {
          var _this = this;
          this.open();
          setTimeout(function(){
              _this.hide();
          }, t);
      }

    };
    this.confirm = function(obj, onok, oncancel) {
        // obj.okText, obj.cancelText, obj.content
        var conf = _.extend({
            'cancelText': '取消',
            'okText' :'确定'
        },obj);
        j.find('.item:first').html(conf.content);
        j.find('.item .btn').html(function(i, e) {
          return [conf.okText, conf.cancelText][i];
        });
        this.onOk = onok;
        this.onCancel = oncancel;
        this.open();
    };
     this.init(j);
  };

  _.extend(alertDialog.prototype, {
      // 事件处理
    init : function(j) {
        var _this = this;
        j.on('click', '.close', function(e){
            _this.hide();
        });
        j.on('click', '.btn', function(e) {
            var t= $(this);
            if(t.hasClass('onOK')) {
                _this.onOk?_this.onOk():_this.hide();
            }
            if(t.hasClass('onCancel')) {
                _this.onCancel&&_this.onCancel();
                _this.hide();
            }
        })
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

  var dialog = new alertDialog($('#d001')),
      tip = new alertDialog($('#d002')),
      dia2 = new alertDialog($('#d003'));
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
        var dataArr = [];
        trs.each(function(i,e) {
          var 
          t = $(e),
          tmp = {
            id : t.data('id'),
            name : t.find('.dish-name').html(),
            count : t.find('.nums').html(),
            price : t.find('.price').html()
          };
            dataArr.push(tmp.id + ':' + tmp.count);
          selData.push(tmp);
        });
          var dataStr = dataArr.join('|');
        $('#od1').val(dataStr);
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
        $('.tip-btn').addClass('hide');
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

    // 如果是要管理员
    if(pageVar.isAdmin) {
        // 刷新今日订单量
        var Count = $('.count');
        if(pageVar.countdown > 5) {
            var T = setInterval(function () {
                $.ajax('/order/todaycount', {
                    type: 'GET',
                    dataType: 'json',
                    cache: false,
                    timeout: 2000,
                    success: function (resp) {
                        if (!resp.ret) {
                            var vo = resp.dataset.Volume;
                            Count.html(vo > 9 ? '9+' : vo).addClass('color-red').attr('title', '总订单数:' + vo);
                        }
                    }
                })
            }, 2000);
            setTimeout(function () {
                clearInterval(T)
            }, pageVar.countdown * 1000);
        }
        // 收起与展开
        $('.dian-header').on('click','.more', function(){
            var t = $(this),
                i = t.find('i'),
                trs = t.parent().siblings('.tb2').find('tr.f-item'),
                hasOpen = t.data('hasOpen')?true:false;
            if(trs.size()<1) return false;
            if(hasOpen) {
                t.data('hasOpen', false);
                i.attr('class', 'fa fa-angle-down');
                trs.addClass('hide');
            } else {
                t.data('hasOpen', true);
                i.attr('class', 'fa fa-angle-up');
                trs.removeClass('hide');
            }
        });

        // 增加菜品
        var form = $('.add-dish').on('submit', function(e) {
            e.preventDefault();
            var data = form.serializeArray(),
                post_data = {};
            if(pageVar.onSubmit) {
                return alert('正在提交...');
            }
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
                    alert('你是不是漏了什么?');
                    return false;
                }
            });
            if(_.size(post_data) >= 5) {
                var url = '/dish/adddish';
                pageVar.onSubmit = true;
                $.ajax(url, {
                    type : 'POST',
                    dataType : 'json',
                    data : post_data,
                    cache : false,
                    timeout : 2000,
                    success : function(resp) {
                        if(!resp.ret) {
                            tip.tips('菜品保存成功！', 1500);
                            form.find('.inp').val('');
                            $('.ptabs .active').trigger('click');
                        }
                    },
                    complete : function() {
                        pageVar.onSubmit = false;
                    }
                });
            }
        });
    } else {
        // 点赞相关代码
        $('.t2').on('click', 'a', function(e) {
            e.preventDefault();
            var url = '/user/addpraise',
                t = $(this),p = t.parent();
            if(p.hasClass('had-star')) return false;
            $.getJSON(url, function(resp) {
                if(!resp.ret) {
                    t.html('已赞<i class="fa fa-thumbs-o-up mgl5 fa-lg"></i>');
                    p.addClass('had-star');
                }
            });
        });

        // 用户列表页
        if(pageVar.UserList) {
            function updateUsers() {
                var url = '/user/get-users',
                    _temp = _.template($('#tem-userlist').html());
                $.ajax(url, {
                    type : 'GET',
                    dataType : 'json',
                    cache : false,
                    timeout : 2000,
                    success : function(resp) {
                        if(!resp.ret) {
                            $('#data_cont1').html(_temp(resp.dataset));
                        }
                    }
                })
            }
            updateUsers();
            // 自定义 单选控件
            $('.u-radio').on('click', '.radio', function(e) {
                var t = $(this),
                    v = t.data('v');
                t.addClass('chked').siblings('.radio').removeClass('chked');
                $('#h_gender').val(v);
            });
            // 充值相关代码
            $('#data_cont1').on('click', '.chargeAct', function(e) {
                var t = $(this),
                    tr = t.parent().parent(),
                    userId = t.data('id'),
                    userName = tr.find('.user-name').html(),
                    volume = tr.find('.tiny').val(),
                    _temp = _.template('确定要为 <span class="color-org">{{userName}}</span> 充值 <span class="color-red">{{volume}}</span> 元吗？');
                if(volume <=0) {
                    return tip.tips('<span class="color-red">充值余额必需大于0</span>', 1500);
                }
                dia2.confirm({
                    content: _temp({userName:userName,volume:volume}),
                    okText:'充值',
                    cancelText: '没钱，不充'
                }, false, function() {
                    var url = '/user/charge',
                        data = {
                            user_id : userId,
                            volume : volume,
                            _csrf : $('input:hidden[name=_csrf]').val()
                        };
                    $.ajax(url, {
                        type : 'POST',
                        dataType : 'json',
                        data : data,
                        cache : false,
                        timeout : 2000,
                        success : function(resp) {
                            if(!resp.ret) {
                                tip.tips(resp.msg,1800);
                                updateUsers();
                            } else {
                                tip.tips(resp.errorMsg, 1500);
                            }
                        }
                    })
                });
            });
            // 增加用户表单
            $('.add-user').on('submit', function(e){
                e.preventDefault();
                var form = $(this),
                    data = form.serializeArray(),
                    post_data = {};
                $.each(data, function(i,e) {
                    if(e.value === '') {
                        alert('你是不是漏了什么?');
                        return false;
                    } else {
                        if(e.name === 'user_spell') {
                            if(/^\w{2,5}$/.test(e.value)) {
                                post_data[e.name] = e.value;
                            } else {
                                alert('简拼只能为字母或数字,长度2-5位')
                            }
                        } else {
                            post_data[e.name] = e.value;
                        }
                    }
                });
                if(_.size(post_data) >= 4) {
                    var url = '/user/add';
                    $.ajax(url, {
                        type : 'POST',
                        dataType : 'json',
                        data : post_data,
                        cache : false,
                        timeout : 2000,
                        success : function(resp) {
                            if(!resp.ret) {
                                form.find('.inp').val('').first().trigger('focus');
                                tip.tips(resp.msg, 1500);
                                updateUsers();
                            } else {
                                tip.tips(resp.errorMsg, 1500);
                            }
                        }
                    })
                }
            });
        }

    }

    // 订单的提交
    $('.add-order').on('submit', function(e) {
        e.preventDefault();
        var form = $(this),
            data = form.serialize(),
            url = '/order/add-order';
        if(pageVar.onSubmit) {
            alert('订单正在提交...');
        }
        pageVar.onSubmit = true;
        $.ajax(url, {
            type : 'POST',
            dataType : 'json',
            data : data,
            cache : false,
            timeout : 2000,
            success : function(resp) {
                if(resp.ret === 1) {
                    tip.tips(resp.errorMsg, 1500);
                }
                if(resp.ret === 2 ){
                    dia2.confirm({
                        content : resp.errorMsg,
                        okText : '有钱，任性',
                        cancelText : '不点了'
                    }, function() {
                        form.append('<input id="od3" type="hidden" name="force" value="1">').trigger('submit');
                        this.hide();
                    })
                }
                if(!resp.ret) {
                    tip.tips(resp.msg, 2000);
                }
            },
            complete : function() {
                form.find('#od3').remove();
                pageVar.onSubmit = false;
            }
        })
    });

    // 菜品的删除
    $('.table-inter').on('click', '.del-dish', function() {
        var t = $(this),
            tr = t.parent().parent(),
            id = tr.data('id'),
            dish_name = tr.find('.dish-name').html();
        dia2.confirm({
            content : '确定要删除  <span class="color-red">' + dish_name + '</span>  这道菜吗？'
        },function(){
            var _this = this;
            $.ajax('/dish/deldish',{
                type : 'GET',
                dataType : 'json',
                data : {id : id},
                cache : false,
                timeout : 2000,
                success : function(resp) {
                    var msg = '';
                    if(!resp.ret) {
                        msg = resp.msg;
                        $('.ptabs .active').trigger('click');
                    } else {
                        msg = '删除菜品失败!';
                    }
                    tip.tips(msg, 1500);
                },
                complete : function() {
                    _this.hide();
                }
            })
        })
    });
});