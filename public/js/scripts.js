$(document).ready(function () {
    // Evento para carregar detalhes da credencial
    $('.btn-ver').click(function () {
        // Preenche os detalhes da credencial no modal
        $('#detalhe-nome').text($(this).data('nome'));
        $('#detalhe-email').text($(this).data('email'));
        $('#detalhe-login').text($(this).data('login'));
        $('#detalhe-senha').text("********"); // Esconde a senha inicialmente
        $('#detalhe-senha').data('senha', $(this).data('senha')); // Armazena a senha criptografada para quando necessário
        $('#btnMostrarSenha').data('id-servico', $(this).data('id-servico')); // Armazena o id_serviço no botão
    });

    // Evento para mostrar ou ocultar a senha
    $(document).on('click', '#btnMostrarSenha', function () {
        const btn = $(this);
        const id_servico = btn.data('id-servico'); // Obtém o id_serviço do botão

        console.log("O id do serviço é: " + id_servico);

        const spanSenha = $('#detalhe-senha');  // O campo onde a senha será exibida

        // Verifica se a senha está oculta
        if (spanSenha.text() === "********") {
            // Exibe o loading (opcional)
            btn.text('Carregando...');

            // Faz a requisição AJAX para o controller de descriptografar
            $.ajax({
                url: '/gerex/src/Controllers/DescriptografarSenhaController.php', // Caminho do controller
                method: 'GET',
                data: { id_servico: id_servico }, // Passa o id_servico da credencial
                success: function (response) {
                    console.log(response); // Verifique o que está sendo retornado
                    try {
                        const data = JSON.parse(response);
                        if (data.senha) {
                            // A variável 'data.senha' contém a senha descriptografada
                            spanSenha.text(data.senha);  // Exibe a senha descriptografada no campo do modal
                            btn.text("Ocultar Senha");  // Altera o texto do botão para 'Ocultar Senha'
                        } else {
                            spanSenha.text('Erro ao carregar a senha');
                            btn.text('Mostrar Senha');
                        }
                    } catch (e) {
                        console.error('Erro ao fazer o parse do JSON:', e);
                        spanSenha.text('Erro ao carregar a senha');
                        btn.text('Mostrar Senha');
                    }
                },
                error: function () {
                    spanSenha.text('Erro ao carregar a senha');
                    btn.text('Mostrar Senha');
                }
            });
        } else {
            // Caso a senha já esteja visível, ocultamos novamente
            spanSenha.text("********");
            btn.text('Mostrar Senha'); // Altera o texto do botão para 'Mostrar Senha'
        }
    });
});
