document.addEventListener('DOMContentLoaded', () => {
    let idParaExcluir = null;
    let rowParaExcluir = null;
  
    // 1) Quando clica no botão excluir, guardamos o ID e a linha
    document.querySelectorAll('.btn-excluir').forEach(btn => {
      btn.addEventListener('click', () => {
        // Aqui depende de qual data-atributo você usa:
        // const id = btn.dataset.id;           // se for data-id="..."
        const id = btn.dataset.idServico;    // se for data-id-servico="..."
        idParaExcluir = id;
        rowParaExcluir = btn.closest('tr');
  
        // Abre o modal
        new bootstrap.Modal(
          document.getElementById('modalConfirmarExclusao')
        ).show();
      });
    });
  
    // 2) Quando clica em "Excluir" no modal
    document.getElementById('btnConfirmarExclusao')
      .addEventListener('click', () => {
        if (!idParaExcluir || !rowParaExcluir) return;
  
        fetch('/gerex/src/Controllers/DeletarCredencialController.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `id_servico=${encodeURIComponent(idParaExcluir)}`
        })
        .then(res => {
          if (!res.ok) throw new Error(`HTTP ${res.status}`);
          return res.json();
        })
        .then(data => {
          console.log('Resposta JSON:', data);
  
          if (data.sucesso) {
            // Remove a linha da tabela
            rowParaExcluir.remove();
  
            // Atualiza o contador só se existir
            const contador = document.getElementById('totalCredenciais');
            if (contador) {
              const novo = Math.max(0, parseInt(contador.textContent, 10) - 1);
              contador.textContent = novo;
  
              // Se zerar, mostra o alerta de "nenhuma credencial"
              const alerta = document.querySelector('.alert-info');
              if (alerta && novo === 0) alerta.style.display = 'block';
            }
  
            // Exibe o toast de sucesso, se existir no HTML
            const toastEl = document.getElementById('toastSucesso');
            if (toastEl) new bootstrap.Toast(toastEl).show();
          } else {
            alert('Erro ao deletar: ' + (data.erro || 'desconhecido'));
          }
        })
        .catch(err => {
          console.error('Erro na requisição:', err);
          alert('Falha na requisição: ' + err.message);
        })
        .finally(() => {
          // Fecha o modal
          const modalEl = document.getElementById('modalConfirmarExclusao');
          const modal = bootstrap.Modal.getInstance(modalEl);
          if (modal) modal.hide();
  
          // Limpa as variáveis
          idParaExcluir = null;
          rowParaExcluir = null;
        });
    });
  });
  