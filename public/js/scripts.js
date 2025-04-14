$(document).ready(function() {
    $('.btn-ver').click(function() {
        $('#detalhe-nome').text($(this).data('nome'));
        $('#detalhe-email').text($(this).data('email'));
        $('#detalhe-login').text($(this).data('login'));
        $('#detalhe-senha').text("********"); // Esconde a senha inicialmente
        $('#detalhe-senha').data('senha', $(this).data('senha'));
    });

});

$(document).on('click', '#btnMostrarSenha', function () {
    const btn = $(this);
    const id_servico = btn.data('id-servico');
    const spanSenha = $('#detalhe-senha');  // Aqui é o campo do modal onde a senha será exibida

    // Verifica se a senha está oculta
    if (spanSenha.text() === "********") {
        // Exibe o loading (opcional)
        btn.text('Carregando...');

        // Faz a requisição AJAX para o controller de descriptografar
        $.ajax({
            url: '/src/controllers/DescriptografarSenhaController.php', // Caminho do controller
            method: 'GET',
            data: { id_servico: id_servico },
            success: function(response) {
                console.log(response);  // Verifique no console o que está sendo retornado
                try {
                    const data = JSON.parse(response);
                    if (data.senha) {
                        // A variável 'data.senha' contém a senha descriptografada
                        spanSenha.text(data.senha);  // Exibe a senha descriptografada no campo do modal
                        
                        btn.text('Ocultar Senha'); // Altera o texto do botão para 'Ocultar Senha'
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
            error: function() {
                spanSenha.text('Erro ao carregar a senha');
                btn.text('Mostrar Senha');
            }
        });
    } else {
        // Caso a senha já esteja visível, ocultamos novamente
        spanSenha.text("********");
        btn.text('Mostrar Senha'); // Altera o texto do botão para 'Mostrar Senha'
    }

    $(document).on('click', '#btnCopiarSenha', function () {
        const senha = $('#detalhe-senha').text();
    
        if (senha === '********') {
            alert('Primeiro mostre a senha!');
            return;
        }
    
        navigator.clipboard.writeText(senha).then(function() {
            $('#btnCopiarSenha').html('<i class="bi bi-clipboard-check"></i>');
    
            setTimeout(() => {
                $('#btnCopiarSenha').html('<i class="bi bi-clipboard"></i>');
            }, 2000);
        }).catch(function(err) {
            console.error('Erro ao copiar: ', err);
            alert('Erro ao copiar a senha');
        });
    });
    
});
