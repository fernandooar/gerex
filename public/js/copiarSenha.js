$(document).ready(function(){
    $('.btnCopiarSenha').click(function(){
        const idServico = $(this).data('id_servico');
        console.log('O id do serviço é:', idServico);

        $.ajax({
            url: '/gerex/src/Controllers/DescriptografarSenhaController.php',
            type: 'GET',
            data: { id_servico: idServico },
            dataType: 'json'
        })
        .done(function(data){
            const senha = String(data.senha);
            console.log('Senha descriptografada:', senha);

            // Tenta usar execCommand para copiar a senha
            const ta = document.createElement('textarea');
            ta.value = senha;
            ta.style.position = 'fixed';  // Faz o textarea ficar invisível
            ta.style.left = '-9999px';    // Coloca o textarea fora da tela
            document.body.appendChild(ta);
            ta.select(); // Seleciona o texto no textarea

            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    console.log('Senha copiada para a área de transferência');
                    mostrarToast();
                } else {
                    console.error('Falha ao copiar a senha');
                }
            } catch (err) {
                console.error('Erro ao tentar copiar a senha:', err);
            }

            // Remove o textarea da tela
            document.body.removeChild(ta);
        })
        .fail(function(jqXHR, textStatus, errorThrown){
            console.error('Erro na requisição:', textStatus, errorThrown);
        });
    });

    function mostrarToast() {
        const toast = $('#toast');
        toast.css('visibility', 'visible');
        setTimeout(() => toast.css('visibility', 'hidden'), 2000);
    }
});
