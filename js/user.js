$(function() {
  _.templateSettings = {
    interpolate: /\{\{([\s\S]+?)\}\}/g,
    evaluate : /\{%([\s\S]+?)%\}/g,
    escape: /\{\{-([\s\S]+?)\}\}/g,
  }

  // 自定义 单选控件 
  $('.u-radio').on('click', '.radio', function(e){
      var t = $(this),
          v = t.data('v');
        t.addClass('chked').siblings('.radio').removeClass('chked');
        $('#h_gender').val(v);
  });

  var dataset = [
    {fullName : '周华辉', shortName: 'zhh' ,remainder : 15, id:45},
    {fullName : '李威', shortName: 'lw' ,remainder : -48, id:12},
    {fullName : '贺世英', shortName: 'hsy' ,remainder : -15, id:13},
    {fullName : '汪航洋', shortName: 'why' ,remainder : 25, id:14},
    {fullName : '饶瑟', shortName: 'rs' ,remainder : 16, id:15},
    {fullName : '宁晓晴', shortName: 'nxq' ,remainder : 18, id:16},
    {fullName : '胡潇', shortName: 'hx' ,remainder : 0, id:17},
    {fullName : '周华辉', shortName: 'zhh' ,remainder : 15, id:45},
    {fullName : '李威', shortName: 'lw' ,remainder : -48, id:12},
    {fullName : '贺世英', shortName: 'hsy' ,remainder : -15, id:13},
    {fullName : '汪航洋', shortName: 'why' ,remainder : 25, id:14}
  ],
  _temp = _.template($('#tem-userlist').html());

  $('#data_cont1').html(_temp(dataset));
}); 