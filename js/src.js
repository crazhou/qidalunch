$(function() {
  _.templateSettings = {
    interpolate: /\{\{([\s\S]+?)\}\}/g,
    evaluate : /\{%([\s\S]+?)%\}/g,
    escape: /\{\{-([\s\S]+?)\}\}/g,
  }
  // 倒计时代码
  $('.countdown').countdown({
    tmpl : $('#tem-countdown').html()
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
  $('.table').on('click', '.pkong', function(e){
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

  // 更新文字 
  function UpdateText() {
    var cont = $('#data_cont1'),
        selData = [],
        trs = cont.find('tr.active'),
        tips = $('.tips'),
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

  // 模板渲染
  var dataset = [
    {name:'农家一桶香饭',price:15.00,id:10},
    {name:'凉瓜肉片饭',price:10.00,id:11},
    {name:'农家小炒肉饭',price:13.50,id:12},
    {name:'酸辣鸡杂饭',price:12.00,id:14},
    {name:'农家一桶香饭',price:15.00,id:21},
    {name:'凉瓜肉片饭',price:10.00,id:22},
    {name:'农家小炒肉饭',price:13.00,id:23},
    {name:'酸辣鸡杂饭',price:12.00,id:24},
    {name:'农家一桶香饭',price:15.00,id:21},
    {name:'凉瓜肉片饭',price:10.00,id:22},
    {name:'农家小炒肉饭',price:13.00,id:23},
    {name:'酸辣鸡杂饭',price:12.00,id:24}
  ],
  _temp = _.template($('#tem-dishlist2').html());

  $('#data_cont1').html(_temp(dataset))
});