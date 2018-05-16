$(document).ready(function () {
  $('.menu-mobile-btn').click(function () {
    $('.menu').toggle();
  });

  //Phone Mask
  $(".phone, .mask-phone").mask("(00) 0000-00009")

  // Tip
  if (typeof $(".tip").tipTip == 'function') {
    $(".tip").tipTip({maxWidth: "auto", delay: 0, defaultPosition: 'top'});
  }
  ;
});

var cookieManager = {
  setCookie: function (cname, cvalue, exdays) {
    var d = new Date()
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000))
    var expires = 'expires=' + d.toUTCString()
    document.cookie = cname + '=' + cvalue + ';' + expires + ';path=/'
  },

  deleteCookie: function (cname) {
    var expires = 'expires=Thu, 01 Jan 1970 00:00:01 GMT'
    document.cookie = cname + '=;' + expires + ';path=/'
  },

  getCookie: function (cname) {
    var name = cname + '='
    var decodedCookie = decodeURIComponent(document.cookie)
    var ca = decodedCookie.split(';')
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i]
      while (c.charAt(0) === ' ') {
        c = c.substring(1)
      }
      if (c.indexOf(name) === 0) {
        return c.substring(name.length, c.length)
      }
    }
    return ''
  }

};

var FavoritoManager = function (name) {
  this.name = "favoritos-" + name;
  this.shortName = name;
};
// Require jQuery

// Atende os requisitos de Lote e Leilao
FavoritoManager.prototype.addFavorito = function (item, cb) {
  if (typeof cb === 'undefined') {
    var cb = function () {
    };
  }
  if (this.favoritoExists(item.id)) {
    return;
  }

  var storage = JSON.parse(localStorage.getItem(this.name));

  var favoritos = storage === null ? [] : storage;

  // jQuery.extend(true, favoritos, [item]);
  console.log('Merge: ', item, favoritos);
  favoritos = this.mergeItems([item], favoritos);
  console.log('Depois do merge: ', favoritos);

  localStorage.setItem(this.name, JSON.stringify(favoritos));
  if (typeof services.FavoritosUrl[this.shortName] !== 'undefined') {
    $.get(services.FavoritosUrl[this.shortName].replace('__ID__', __FAVORITO_ID__), function () {
      cb(); //wrapper. Ver observação abaixo.
    });
  } else {
    cb(); //wrapper. Verificar compatibilidade futura caso nome mude. Recomendo isto vir como parâmetro do construtor
  }
};

FavoritoManager.prototype.favoritoExists = function (id) {
  var favoritos = JSON.parse(localStorage.getItem(this.name));
  return favoritos === null ? false : (function () {
    for (item in favoritos) {
      if (favoritos[item].id === id) {
        return true;
      }
    }
    return false;
  })();
};

FavoritoManager.prototype.sync = function () {

  var _this = this; // wrapper
  var _Promise = $.Deferred();

  var storage = JSON.parse(localStorage.getItem(this.name));

  var favoritos = storage === null ? [] : storage;

  var toSyncronize = [];

  for (var f in favoritos) {
    if (typeof favoritos[f].sync === 'undefined') {
      // Ainda não foi sincronizado
      toSyncronize.push(favoritos[f].id)
    }
  }

  var verifySync = function () {
    var _Promise2 = $.Deferred();

    if (__USERID__ === null) {
      return _Promise2.resolve();
    }

    if (toSyncronize.length > 0) {
      console.log('Itens para sincronizar: ', toSyncronize);
      console.log('O processo retornará somente após a resposta da promise (full-sync)');
      var Syncronized = 0;
      var hasSyncronized = function (v) {
        if (v >= Syncronized) {
          _Promise2.resolve();
        }
      }
      for (var item in toSyncronize) {
        console.log(toSyncronize[item], 'Não sincronizado')
        console.log('Sincronizando ' + toSyncronize[item].id + '...')
        $.get(services.FavoritosUrl[_this.shortName].replace('__ID__', toSyncronize[item]), function () {
          console.log(toSyncronize[item] + ' sincronizado.');
          Syncronized += 1;
          hasSyncronized(Syncronized);
        }).fail(function (data) {
          console.log(toSyncronize[item], data.responseJSON);
          Syncronized += 1;
          hasSyncronized(Syncronized);
        });
      }
    } else {
      return _Promise2.resolve();
    }
  }

  $.when(verifySync()).done(function () {
    if (__USERID__ === null) {
      return _Promise.resolve(_this.mountArray(favoritos));
    }
    console.log('Finalizou a sincronia. (promise)', favoritos);
    console.log('Carregando favoritos da API...')
    $.get(services.FavoritosListar[_this.shortName], function (data) {
      // jQuery.extend(true, favoritos, data);
      favoritos = _this.mergeItems(data, favoritos);
      localStorage.setItem(_this.name, JSON.stringify(favoritos));
      _Promise.resolve(_this.mountArray(favoritos));
    })
      .fail(function (error) {
        _Promise.resolve(_this.mountArray(favoritos));
      });
  });

  return _Promise;

};

FavoritoManager.prototype.mountArray = function (arr) {
  var _array = [];
  for (var item in arr) {
    _array.push(arr[item]);
  }
  return _array;
};

FavoritoManager.prototype.mergeItems = function (newItems, storage) {
  /*var newArray = [];*/
  if (storage.length === 0) {
    return newItems;
  }
  /*var itemExists = false;
  for (var obj in storage) {
    if (storage[obj].id === item.id) {
      itemExists = true;
      newArray.push(jQuery.extend(true, {}, storage[obj], item));
    } else {
      newArray.push(storage[obj]);
    }
  }
  if(!itemExists){
    newArray.push(item);
  }*/

  for (var keyItem in newItems) {

    //Verifico se o item já existe no storage
    var itemExists = false;
    for (var keyStorage in storage) {
      if (storage[keyStorage].id === newItems[keyItem].id) {
        itemExists = true;
        // Faço o merge do item
        jQuery.extend(true, storage[keyStorage], newItems[keyItem]);
      }
    }

    if (!itemExists) {
      // Significa que o item não existe no storage, então devo adicioná-lo
      storage.push(newItems[keyItem]);
    }

  }

  return storage;
}