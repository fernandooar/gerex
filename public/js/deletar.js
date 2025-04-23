$(document).on('click', '.btn-excluir', function(){
    e.preventDefault();
    const id_servico = $(this).data('id');


    if (confirm ('Tem certeza que deseja excluir a credêncial?')) {
        $.ajax({
            url: '/gerex/src/Controllers/DeletarCredencialController.php',
            method: 'POST',
            data: { id_servico: id_servico},
            success: function (response){
                const data = JSON.parse(response);
                if (data.success) {
                    alert('Credencial excluida com sucesso!');
                    location.reload();

                } else {
                    alert(" Erro ao deletar: " + data.erro);
                }
            },

            error: function () {
                alert('Erro na comunicação com o servidor.');
            }
        });
    }
});