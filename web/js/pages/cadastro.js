$(document).ready(function () {

  $('.mask-cnpj').mask('99.999.999/9999-99', {placeholder: "__.___.___/___-__"})
  $('.mask-cpf').mask('999.999.999-99', {placeholder: "___.___.___-__"})
  $('.mask-date').mask('00/00/0000', {placeholder: "__/__/____"});
  $('.mask-cep').mask('00000-000', {placeholder: "_____-___"});

  var etapa1 = $('.etapa1');
  var etapa2 = $('.etapa2');
  var etapa3 = $('.etapa3');
  var documento = $('#documento');
  var documentoTitle = $('.documento-title');
  var nome = $('#nome');
  var nomeTitle = $('.nome-title');
  var email = $('#email');
  var termos, tipo;
  var apelido = $('#apelido');
  var btnSugestaoApelido = $('.apelido-sugestao');
  var btnSelecaoPessoa = $('.btn-selecao-pessoa');

  btnSelecaoPessoa.click(function () {

    tipo = $(this).data('pessoa');
    $('#pessoa_tipo').val(tipo === 'fisica' ? 1 : 2);
    termos = $('#termos').is(':checked');

    //Verificação do aceite dos termos
    if (!termos) {
      var termosWarning = $('.termos-warning');
      termosWarning.addClass('termos-warning-active');
      window.setTimeout(function () {
        termosWarning.removeClass('termos-warning-active')
      }, 3000)
      return false;
    }

    etapa1.addClass('fadeOutRight');
    etapa1.one('webkitAnimationEnd oanimationend msAnimationEnd animationend',
      function (e) {
        etapa1.removeClass('fadeOutRight').addClass('hide');
        etapa2.removeClass('hide').addClass('fadeInLeft');
      });

    if (tipo === 'fisica') {
      documentoTitle.html('CPF');
      documento.attr('placeholder', 'Digite seu CPF');
      documento.mask("999.999.999-99");
      nomeTitle.html('Nome');
      nome.attr('placeholder', 'Digite seu nome completo');
      $('.form-pessoa-juridica').removeClass('isActive');
      $('.form-pessoa-fisica').addClass('isActive');
    } else {
      documentoTitle.html('CNPJ');
      documento.attr('placeholder', 'Digite seu CNPJ');
      documento.mask('99.999.999/9999-99');
      nomeTitle.html('Razão Social');
      nome.attr('placeholder', 'Digite a razão social da empresa');
      $('.form-pessoa-juridica').addClass('isActive');
      $('.form-pessoa-fisica').removeClass('isActive');
    }

    window.setTimeout(function () {
      documento.focus()
    }, 2000);

    return false;

  })

  //Etapa 2
  var etapa2Valid = false;
  var etapa2Errors = {};

  documento.blur(function () {
    documento.removeClass('input-error')
    if (tipo == 'fisica') {
      if (!ValidaCPF(documento.val())) {
        documento.addClass('input-error')
      }
      return true
    } else {
      if (!ValidaCNPJ(documento.val())) {
        documento.addClass('input-error')
      }
    }
    return true
  });

  //Somente dígitos e números para o apelido
  apelido.on("keyup", function (event) {
    $(this).removeClass('aprovado');
    var value = $(this).val();
    $(this).val(value.replace(/[^a-zA-Z0-9]+/g, "").toUpperCase());
  });

  btnSugestaoApelido.click(function () {
    //Chama a API para verificar disponibilidade ou sugerir
    verificaApelido('', apelido, nome, true);

  });

  apelido.blur(function () {
    verificaApelido($(this).val(), apelido, nome, false);
  });

  $('form[name="verificar"]').submit(function () {
    console.log('Submited')
    var load = $('#etapa2-verificar');
    var submitButton = $(this).find('[type="submit"]');

    var preLoad = function () {
      $('[class*="form-error-"]').each(function () {
        $(this).addClass('hide');
      });
      load.removeClass('hide');
      submitButton.prop('disabled', true);
    };

    var posLoad = function () {
      load.addClass('hide');
      submitButton.prop('disabled', false);
    };

    preLoad();

    dados = {};
    dados.documento = documento.val();
    dados.email = email.val();
    dados.apelido = apelido.val();
    dados.pessoa = tipo;

    $.post(urlVerificaDadosIniciais, dados, function (data) {
      posLoad();

      $('#pessoa_nome').val(nome.val());
      $('.cadastro_email').val(email.val());
      $('#pessoa_arrematante_apelido').val(apelido.val());
      if (tipo === 'fisica') {
        $('#pessoa_cpf').val(documento.val());
      } else {
        $('#pessoa_cnpj').val(documento.val());
      }

      etapa2.removeClass('fadeInLeft').addClass('fadeOutRight');
      etapa2.one('webkitAnimationEnd oanimationend msAnimationEnd animationend',
        function (e) {
          etapa2.removeClass('fadeOutRight').addClass('hide');
          etapa3.removeClass('hide').addClass('fadeInLeft');
          if (tipo === 'fisica') {
            $('#pessoa_rg').focus();
          } else {
            $('#pessoa_inscricaoEstadual').focus()
          }

        });
    }, 'json')
      .fail(function (error) {
        posLoad();
        errors = error.responseJSON.errors;
        if (errors.length > 0) {
          for (i = 0; i < errors.length; i++) {
            $('.form-error-' + errors[i]).removeClass('hide')
          }
        }
        console.log(error)
      });
    return false;
  })

  //Form Filters
  $('#pessoa_estadoCivil').change(function () {
    if (parseInt($(this).val()) === 2) {
      $('.estado-civil-casado').removeClass('hide')
    } else {
      $('.estado-civil-casado').removeClass('hide').addClass('hide')
    }
  })

  $('.endereco_cep').blur(function () {
    var cep = $(this).val().replace(/\D/g, '');

    var limpa_formulário_cep = function () {
      $(".endereco_logradouro").val("");
      $(".endereco_bairro").val("");
      $(".endereco_cidade").val("");
      $(".endereco_uf").val("");
    };

    if (cep !== "") {

      var validacep = /^[0-9]{8}$/;
      if (validacep.test(cep)) {

        //Preenche os campos com "..." enquanto consulta webservice.
        $(".endereco_logradouro").val("...");
        $(".endereco_bairro").val("...");
        $(".endereco_cidade").val("...");
        $(".endereco_uf").val("...");

        //Consulta o webservice viacep.com.br/
        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

          if (!("erro" in dados)) {
            //Atualiza os campos com os valores da consulta.
            $(".endereco_logradouro").val(dados.logradouro);
            $(".endereco_bairro").val(dados.bairro);
            $(".endereco_cidade").val(dados.localidade);
            $(".endereco_uf").val(dados.uf);
          } //end if.
          else {
            //CEP pesquisado não foi encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
          }
        });
      } //end if.
      else {
        //cep é inválido.
        limpa_formulário_cep();
        alert("Formato de CEP inválido.");
      }
    } //end if.
    else {
      //cep sem valor, limpa formulário.
      limpa_formulário_cep();
    }

  })

  $('.mostrar-senha').click(function () {
    var input = $(this).parent().find('input');
    if (input.attr('type') === 'password') {
      input.prop('type', 'text');
      $(this).addClass('showed');
    } else {
      input.prop('type', 'password')
      $(this).removeClass('showed');
    }
  })

  $('form[name="pessoa"]').submit(function () {
    var submitButton = $(this).find('[type="submit"]');
    $('#cadastro-verificar').removeClass('hide');
    submitButton.prop('disabled', true);
    submitButton.val('Por favor aguarde');
  });

});

var cacheCheckApelido = '';
var verificaApelido = function (sugestao, apelido, nome, sugerir) {
  sugerir = typeof sugerir !== 'undefined' ? sugerir : false;

  if (cacheCheckApelido === sugestao && sugerir !== true) {
    apelido.removeClass('aprovado').addClass('aprovado');
    return;
  }

  //Sugere um apelido
  if (sugerir === true) {
    var _nome = nome.val();
    if (_nome.length < 3) {
      alert('Não consigo sugerir antes de você digitar seu nome completo :/');
      nome.focus();
      return;
    }
    listNomes = _nome.split(' ', 2);
    if (listNomes.length < 2) {
      alert('Preciso do seu nome completo antes de sugerir um apelido :/');
      nome.focus();
      return;
    }

    var sugestao = listNomes.join('').toLowerCase();
    // remove accents, swap ñ for n, etc
    var from = "àáäâèéëêìíïîòóöôùúüûñçãõê";
    var to = "aaaaeeeeiiiioooouuuuncaoe";
    for (var i = 0, l = from.length; i < l; i++) {
      sugestao = sugestao.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }
    sugestao = sugestao.toUpperCase();
  }

  if (sugestao.length < 3) {
    alert('O apelido deve conter no mínimo três caracteres.')
    return;
  }

  var cloneSugestao = sugestao;

  var load = apelido.parent().find('.sugestao-load');
  var divSugestao = apelido.parent().find('.apelido-sugestao');
  load.removeClass('hide');
  divSugestao.addClass('hide');
  apelido.removeClass('aprovado');
  $.get(urlVerificaApelido.replace('__APELIDO__', sugestao), function (data) {
    if (!data.disponivel) {
      sugestao = data.sugestao.toUpperCase();
    }
    if (sugerir === false && cloneSugestao !== sugestao) {
      alert('O apelido ' + cloneSugestao + ' não está disponível, sugerimos um parecido para você: ' + sugestao);
    }
    apelido.val(sugestao);
    load.addClass('hide');
    divSugestao.removeClass('hide');
    apelido.keyup();
    apelido.addClass('aprovado');
    cacheCheckApelido = sugestao;
  })
    .fail(function (error) {
      alert('Ocorreu algum problema ao acessar a aplicação. Tente novamente, caso o erro persista contate a equipe de suporte.')
      console.log(error)
    });
}
