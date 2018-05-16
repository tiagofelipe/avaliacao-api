// Require jQuery
var stats = {}

stats.loteClick = function(url, lote){
  $.get(url, {callback: Date.now()});
}

stats.leilaoClick = function(url, leilao){
  console.log(url, 'pixel click')
  $.get(url, {callback: Date.now()});
}