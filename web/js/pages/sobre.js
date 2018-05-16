$(window).resize(function () {
  var heightWindow = $(window).height() - $('header').height() - 80;
  var $el = $('.video iframe');
  $el.height(heightWindow)
}).resize();

$(document).ready(function(){
  $('.slide-parceiros').slick({
    arrows: false,
    dots: false,
    slidesToShow: 6,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    pauseOnHover: true
  });
  $('.slide-parceiros-mobile').slick({
    arrows: false,
    dots: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    pauseOnHover: true
  });
})