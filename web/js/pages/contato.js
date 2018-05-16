$(document).ready(function () {
  $('form[name="contato"]').submit(function (e) {
    $(this).find('.submit-contato').val('Por favor, aguarde.')
    $(this).find('.submit-contato').prop('disabled', true)
  })
})