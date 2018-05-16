$(document).ready(function(){
  var menu = $('.lista-funcionalidades');
  var container = $('.functionalidades-container');
  menu.find('li').click(function(){
    var target = $(this).find('a');
    target.parent().parent().find('.selected').removeClass('selected')
    target.parent().addClass('selected')
    container.find('.selected').removeClass('selected')
    container.find(target.attr('href')).addClass('selected')
    return false
  })
});