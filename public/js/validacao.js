$(document).ready(function() {
  // Evento disparado ao tentar enviar o formulário
  $('#formCadastroUsuario').on('submit', function(e) {
    // Pegando os valores dos campos
    let email = $('#email').val();
    let senha = $('#senha').val();
    let confirmarSenha = $('#confirmarSenha').val();
    let erro = false;

    // Limpando mensagens anteriores e removendo classes de erro
    $('.invalid-feedback').text('');
    $('.form-control').removeClass('is-invalid');

    // Validação do e-mail (formato válido)
    if (!validarEmail(email)) {
      $('#erroEmail').text('Informe um e-mail válido');
      $('#email').addClass('is-invalid');
      erro = true;
    }

    // Validação do tamanho da senha
    if (senha.length < 6) {
      $('#erroSenha').text('A senha deve ter no mínimo 6 caracteres.');
      $('#senha').addClass('is-invalid');
      erro = true;
    }

    // Verifica se as senhas coincidem
    if (senha !== confirmarSenha) {
      $('#erroConfirmarSenha').text('As senhas não coincidem');
      $('#confirmarSenha').addClass('is-invalid');
      erro = true;
    }

    // Se houve algum erro, impede o envio do formulário
    if (erro) {
      e.preventDefault();
    }
  });

  // Função para validar formato de e-mail com regex
  function validarEmail(email) {
    var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return regex.test(email);
  }
});
