var favoritoManager = new FavoritoManager('lote');

$(document).ready(function () {

  stats.loteClick(__STATSLOTE_URL__);

  $('.prevent-vue-load').removeClass('hide')

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

  //Function to hover in Lotes
  $('.lote-thumbs li').hover(function (e) {
    $(this).parent().find('li.selected').removeClass('selected');
    $(this).addClass('selected')
    var img = $(this).find('img.lote-img');
    src = img.attr('src')
    $('#lote-image').attr('src', src)
    $('#lote-image').data('index', $(this).index())
    return false
  })

  var $pswp = $('.pswp')[0];
  var items = [];

  $('.lote-thumbs a').each(function () {
    var $pic = $(this);
    var $href = $(this).attr('href'),
      $size = $(this).data('size').split('x'),
      $width = $size[0],
      $height = $size[1];

    var item = {
      src: $href,
      w: $width,
      h: $height
    }

    items.push(item);
  });

  $('.lote-thumbs a').click(function (e) {
    e.preventDefault();
    if ($(this).data('index') == '5') {
      $('#lote-image').click();
    }
    return false;
  });
  $('#lote-image').click(function (e) {
    e.preventDefault();

    var $index = $(this).data('index');
    var options = {
      index: $index,
      bgOpacity: 0.7,
      showHideOpacity: true
    }

    var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
    lightBox.init();
  });

  // Slide Lotes
  (function () {

    var content = $('.carousel-content');
    var limit = content.find('.carousel-limit').width();
    console.log('limit', limit);
    var widthContent = content.width();
    console.log('widthContent', widthContent);
    var items = $('.destaques .lista-destaques a .p-item');
    var totalItens = items.length;
    console.log('totalItens', totalItens);
    var itemSize = items.closest('a').width();
    console.log('itemSize', itemSize);
    var itensPerPage = Math.round(widthContent / itemSize);
    console.log('itensPerPage', itensPerPage);
    var salt = itensPerPage * itemSize;
    console.log('salt', salt);
    var totalPages = Math.ceil(limit / salt);
    console.log('totalPages', totalPages);

    var actualPage = 1;

    var changePosition = function (type) {
      $('.carousel-prev, .carousel-next').addClass('disabled');

      /*if (Math.abs(positionSlide) === 0 && type === 'prev') {
        $('.carousel-prev').addClass('disabled');
        return;
      }
      if (type === 'next') {
        $('.carousel-next').addClass('disabled');
        positionSlide -= salt;
      } else {
        $('.carousel-prev').addClass('disabled');
        positionSlide += salt;
      }

      console.log('positionSlideChange', positionSlide);*/

      var newPage = actualPage;
      var cloneActualPage = actualPage;

      if (type === 'next') {
        newPage++;
      } else {
        newPage--;
      }

      console.log(newPage)

      if (newPage <= totalPages && newPage > 0) {
        $('.lista-destaques .carousel-content .carousel-limit').css('transform', 'translateX(' + (newPage > 1 ? '-' : '') + ((newPage - 1) * salt) + 'px)');
        actualPage = newPage;
        console.log('Página atual agora é: ', actualPage);
      }

      //Set buttons actives
      if (actualPage > 1) {
        $('.carousel-prev').removeClass('disabled');
      }
      if (actualPage < totalPages) {
        $('.carousel-next').removeClass('disabled');
      }

    };

    // Start
    $('.destaques .carousel-next, .destaques .carousel-prev').click(function (e) {
      e.preventDefault();
      changePosition($(this).data('type'));
    });

  })();

})


if (permitidoLances) {
  var webSocket = WS.connect(__WSSERVER__);
  var _WS = null
  Vue.use(VMoney, {precision: 2})

  var app = new Vue({
      // components: {'leilao': historyItem},
      el: '#lote-lance ',
      delimiters: ['${', '}'],
      data: function () {
        return {
          leilao: leilao,
          lote: lote,
          lances: lances,
          pregao: pregao,
          audioNotification: true,
          hasNovoLance: false,
          hasConfirm: false,
          confirmLanceIncremento: false,
          confirmLanceManual: false,
          confirmLanceManualCheck: false,
          modalLanceManual: false,
          valorLance: 0.00,
          valorLanceFormatado: '0,00',
          money: {
            decimal: ',',
            thousands: '.',
            prefix: 'R$ ',
            suffix: '',
            precision: 2,
            masked: false
          }
        }
      },
      methods: {
        conected: function () {
          if (this.ws == null) {
            return false
          }
          if (typeof this.ws._websocket_connected == 'undefined') {
            return false
          }
          return this.ws._websocket_connected
        },
        lanceManual: function () {
          this.confirmLanceManual = true;
          this.hasConfirm = true;
          var that = this;
          this.$nextTick(function () {
            that.$refs.valorLanceFormatado.focus()
          })
        },
        cancelConfirm: function () {
          this.hasConfirm = false;
          this.confirmLanceIncremento = false;
          this.confirmLanceManual = false;
          this.confirmLanceManualCheck = false;
          this.valorLanceFormatado = '0,00';
          this.modalLanceManual = false;
        },
        lanceIncrementoConfirm: function () {
          this.confirmLanceIncremento = true;
          this.hasConfirm = true;
          var that = this;
          this.$nextTick(function () {
            that.$refs.lanceIncrementoBtn.focus();
            console.log(that.$refs.lanceIncrementoBtn)
          });
          var valor;
          // Pega último lance
          if (typeof this.lances[0] === 'undefined') {
            // Não existe lance atual, pega o mínimo inicial
            valor = this.lote.valorInicial
          } else {
            valor = Number(this.lances[0].valor) + Number(this.lote.valorIncremento) // TODO: If valorIncremento is null?
          }
          this.valorLance = valor;
        },
        lanceManualConfirmar: function () {
          this.valorLance = Number((this.valorLanceFormatado.replace(/[^0-9,]/g, '')).replace(',', '.'));
          this.lanceIncremento();
          this.cancelConfirm();
        },
        lanceIncremento: function () {
          var that = this;
          var valor = this.valorLance;
          this.cancelConfirm();
          $.ajax({
            url: leilaoService.lance,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({valor: valor}),
            dataType: 'json'
          })
            .done(function (response) {
              console.log(response)
              that.novoLance(response.lance)
            })
            .fail(function (response) {
              console.log(response)
              if (that.audioNotification) {
                AudioNotification.err.play()
              }
              window.alert('Erro ao efetuar a operação: \n\n' + response.responseJSON.errors)
              // Carrega últimos lances novamente para prevenir painel não sincronizado
              $.get(leilaoService.ultimosLances, {callback: Date.now()})
                .done(function (data) {
                  that.lances = data
                });
            })
          ;
          /*$.post(leilaoService.lance, {valor: valor},
            function (response) {
              console.log(response.responseJSON)
              that.novoLance(response.responseJSON.lance)
            })
            .fail(function (response) {
              console.log(response)
              window.alert('Erro ao efetuar a operação: \n\n' + response.responseJSON.errors)
            });*/
        },
        configurarLanceAutomatico: function () {
          window.alert('Esta funcionalidade está temporariamente indisponível e será habilitada a partir do dia 01/03')
        },
        processRemoteMessage: function (uri, payload) {

          console.log("Received message", payload)

          if (typeof payload.code === 'undefined') {
            return
          }

          var message = payload
          var code = message.code;
          var token = message.token;

          var queue = window._socketQueue.indexOf(token);
          if (queue > -1) {
            window._socketQueue.splice(queue, 1);
            console.log('message from me. nothing to do')
            return; // nothing to do
          }

          if (code === SocketStatus.LANCE.code) {
            // Recebeu um lance novo
            this.remoteNovoLance(message.lote, message.lance)
          } else if (code === SocketStatus.LEILAO_ABERTO.code) {
            // Leilão foi aberto
            this.leilao.status = 6
          }
        },
        remoteNovoLance: function (lote, lance) {
          if (this.lote.id !== lote) {
            return; // Lance não é deste lote
          }

          if (this.audioNotification) {
            AudioNotification.lance.play()
          }

          var that = this;
          this.hasNovoLance = true
          this.$nextTick(function () {
            window.setTimeout(function () {
              that.hasNovoLance = false
            }, 100)
          })

          this.lances.unshift(lance)
          if (this.lances.length > 5) {
            this.lances.splice((this.lances.length - 1), 1)
          }
        },
        novoLance: function (lance) {
          // Verifica se o lote que recebeu o lance é o mesmo ativo na view
          /*if (lote.id !== this.lote.id) {
            return
          }*/
          if (this.audioNotification) {
            AudioNotification.meuLance.play()
          }
          console.log('Adicionando novo lance', this.lances, lance)
          this.lances.unshift(lance)
          if (this.lances.length > 5) {
            this.lances.splice((this.lances.length - 1), 1)
          }
          this.transmitirMensagem(this.wsChannel, {
            code: SocketStatus.LANCE.code,
            message: SocketStatus.LANCE.message,
            bind: {lote: lote.id, lance: lance.id}
          });

        },
        transmitirMensagem: function (canal, mensagem) {
          /* TODO: Implementar uma classe única de comunicação, para ser reaproveitada pelo Controlador e clientes */
          var token = Math.random().toString(36).substr(2);
          window._socketQueue.push(token)
          mensagem.token = token
          this.ws.publish(canal, mensagem)
        }
      },
      computed: {
        maiorLance: function () {
          if (this.lances.length > 0) {
            return 'R$ ' + number_format(this.lances[0].valor, 2, ',', '.')
          }
          return '-'
        },
        hasPregao: function () {
          return Number(this.leilao.status) === 6
        }
      }
      ,
      mounted: function () {
        var that = this;
        this.ws = null;
        this.wsChannel = "pregao/" + __LEILAO__;
        webSocket.on("socket/connect", function (session) {
          //session is an Autobahn JS WAMP session.
          _WS = session
          that.ws = _WS
          console.log(_WS)
          //the callback function in "subscribe" is called everytime an event is published in that channel.
          session.subscribe("pregao/" + __LEILAO__, function (uri, payload) {
            that.processRemoteMessage(uri, payload)
          });

          console.log("Conectado com sucesso no WS!");
        })

        webSocket.on("socket/disconnect", function (error) {
          //error provides us with some insight into the disconnection: error.reason and error.code

          console.log("Disconnected for " + error.reason + " with code " + error.code);
        })

        this.$nextTick(function () {

        })

      }
    })
  ;

}

$(function () {
  $('#fullLoader').remove();
  $('#app-container').removeClass('isFullLoading');
});
/*
document.addEventListener("DOMContentLoaded", function(event) {
  loader = document.querySelector('#fullLoader')
  loader.parentNode.removeChild(loader)
});*/
