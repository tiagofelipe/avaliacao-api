var favoritoManager = new FavoritoManager('leilao');

$(document).ready(function () {

  // Stats Pixel click
  stats.leilaoClick(__STATSLEILAO_URL__);

  // Favorito features
  if (favoritoManager.favoritoExists(__FAVORITO_ID__)) {
    // Favorito existe no storage
    $('.item-favorite-btn').addClass('active');
  }
  $('.item-favorite-btn').click(function (e) {
    e.preventDefault();
    favoritoManager.addFavorito(__FAVORITO_ITEM__, appHistoryBar._mount);
    $('.item-favorite-btn').addClass('active');
  });

  $('.btn-filtros, .btn-fechar-filtros').click(function (e) {
    e.preventDefault();
    $('.leilao-filtros, .leilao-filtros2, .btn-fechar-filtros').toggle();
  })

  /*$('.filterCondicao').change(function ($e) {
    setData('.filterCondicao', '#filtroCondicao')
  })
  $('.filterTipo').change(function ($e) {
    setData('.filterTipo', '#filtroTipo')
  })
  $('.filterAno').change(function ($e) {
    setData('.filterAno', '#filtroAno', false)
  })
  $('.filterMarca').change(function ($e) {
    setData('.filterMarca', '#filtroMarca')
  })
  $('.filterModelo').change(function ($e) {
    setData('.filterModelo', '#filtroModelo')
  })*/
  $('.filterCondicao, .filterTipo, .filterAno, .filterMarca, .filterModelo').change(function ($e) {
    defineFiltersInit()
  })

  $('.pagination2 a.page-link').click(function ($e) {
    $e.preventDefault()
    var form = $('#filterForm');
    form.attr('action', $(this).attr('href'));
    filterTimeoutFcn();
  })

});

var setData = function (origin, dest, checkbox) {
  var data = []
  var checkbox = typeof checkbox !== 'undefined' ? checkbox : true
  var extra = checkbox ? ':checked' : ''
  $(origin + extra).each(function () {
    data.push(this.value)
  })
  data = jQuery.grep(data, function (a) {
    return a !== '';
  });
  $(dest).val(data.join(','))
  defineFiltersInit()
}

var defineFiltersInit = function () {
  console.log('Timeout countdown')
  window.clearTimeout(filterTimeout)
  filterTimeout = window.setTimeout(filterTimeoutFcn, 2000)
}

var filterTimeout
var filterTimeoutFcn = function () {
  $('#filterOverlay').removeClass('hide').fadeIn('fast')
  $('#filterForm').submit()
}