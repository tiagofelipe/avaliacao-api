$(document).ready(function () {

  //Cria a animação das logos dos comitentes (slide)
  $('[id^="comitente-anim"]').each(function (index) {
    var self = $(this);
    window.setInterval(function () {
      atual = self.find('img.show');
      next = (atual.index() + 2) > self.find('img').length ? 0 : atual.index() + 1;
      next = self.find('img').eq(next);
      atual.removeClass('show');
      next.addClass('show');
    }, 3000)
  })

  $('.slide').slick({
    arrows: false,
    autoplay: true,
    speed: 700,
    touchThreshold: 10,
    autoplaySpeed: 6000,
    dots: true,
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    pauseOnHover: true
  });

});