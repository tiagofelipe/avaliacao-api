/*
*
* Vue Directive
*
* TODO: Lote/Leilão removido mas que existe na lista de favoridos fica inválido/quebrado. Deve existir uma verificação
*
* */
function validate (binding) {
  if (typeof binding.value !== 'function') {
    console.warn('Directive Vue-clickout: provided expression', binding.expression, 'is not a function.')
    return false
  }

  return true
}

function isPopup (popupItem, elements) {
  if (!popupItem || !elements) {
    return false
  }

  for (var i = 0, len = elements.length; i < len; i++) {
    try {
      if (popupItem.contains(elements[i])) {
        return true
      }
      if (elements[i].contains(popupItem)) {
        return false
      }
    } catch (e) {
      return false
    }
  }

  return false
}

Vue.directive('clickout',{
  bind: function (el, binding, vNode) {
    if (!validate(binding)) return

    // Define Handler and cache it on the element
    function handler (e) {
      if (!vNode.context) return

      // some components may have related popup item, on which we shall prevent the click outside event handler.
      var elements = e.path || (e.composedPath && e.composedPath())
      elements && elements.length > 0 && elements.unshift(e.target)

      // console.log(el, vNode.context.popupItem, elements)
      if (el.contains(e.target) || isPopup(vNode.context.popupItem, elements)) return

      el.__vueClickOutside__.callback(e)
    }

    // add Event Listeners
    el.__vueClickOutside__ = {
      handler: handler,
      callback: binding.value
    }
    document.addEventListener('click', handler)
  },

  update: function (el, binding) {
    if (validate(binding)) el.__vueClickOutside__.callback = binding.value
  },

  unbind: function (el, binding) {
    // Remove Event Listeners
    document.removeEventListener('click', el.__vueClickOutside__.handler)
    delete el.__vueClickOutside__
  }
});

/*var historyItem = new Vue({
  el: '#history-item',
  name: 'history-item'
});*/

historyItem = {
  template: '#history-item',
  delimiters: ['${', '}'],
  props: {
    itens: {
      type: Array,
      default: []
    }
  },
  data: function () {
    return {
      opened: false
    }
  },
  computed: {
    bindArrow: function () {
      return {
        'fa-chevron-up': !this.opened,
        'fa-chevron-down': this.opened
      }
    }
  },
  methods: {
    popoverItem: function () {
      this.opened = !this.opened;
    },
    close: function () {
      this.opened = false;
    }
  }
};

var appHistoryBar = new Vue({
  components: {'history-item': historyItem},
  el: '#history-bar',
  delimiters: ['${', '}'],
  data: function () {
    return {
      lotesFavoritos: [],
      leiloesFavoritos: []
    }
  },
  methods: {
    sucessLoadFavoritosLotes: function (data) {
      this.lotesFavoritos = data;
    },
    redirect: function (url) {
      window.location = url;
    },
    data: function (stringDate) {
      stringDate = stringDate.replace(/-/g, '/');
      var date = new Date(stringDate);
      return ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date.getMonth() + 1)).slice(-2) + ' ' + ('0' + date.getHours()).slice(-2) + 'h' + ('0' + date.getMinutes()).slice(-2);
    },
    _mount: function () {
      var _this = this;

      // Lote
      var _favoritoManagerLote = new FavoritoManager('lote');
      $.when(_favoritoManagerLote.sync()).done(function (favoritos) {
        console.log('Finalizou o carregamento completo dos Lotes favoritos.', favoritos);
        _this.lotesFavoritos = favoritos;
      });

      // Leilao
      var _favoritoManagerLeilao = new FavoritoManager('leilao');
      $.when(_favoritoManagerLeilao.sync()).done(function (favoritos) {
        console.log('Finalizou o carregamento completo dos Leilões favoritos.', favoritos);
        _this.leiloesFavoritos = favoritos;
      });
    }
  },
  computed: {},
  mounted: function () {

    this._mount();

  }
});