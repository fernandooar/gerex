document.querySelectorAll('.btn-editar').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.idServico;

        // Busca os dados diretamente do HTML (se quiser algo mais avançado, usa AJAX)
        const row = this.closest('tr');
        const nome = row.querySelector('td:nth-child(2)').textContent.trim();
        const email = row.querySelector('td:nth-child(3)').textContent.trim();
        const login = row.querySelector('td:nth-child(4)').textContent.trim();
        const telefone = row.querySelector('td:nth-child(5)').textContent.trim();

        document.getElementById('modalNovaCredencialLabel').textContent = 'Editar Credencial';
        document.getElementById('id_servico').value = id;
        document.getElementById('nome_servico').value = nome;
        document.getElementById('email_servico').value = email;
        document.getElementById('login_servico').value = login;
        document.getElementById('telefone_servico').value = telefone;

        // Trocar botão "Salvar" por "Atualizar" (opcional)
        document.querySelector('#modalNovaCredencial button[type="submit"]').textContent = 'Atualizar';

        // Abre o modal
        const modal = new bootstrap.Modal(document.getElementById('modalNovaCredencial'));
        modal.show();
    });
});
