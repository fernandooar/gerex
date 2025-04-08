<?php
require_once __DIR__ . '/../../helpers/Sessao.php';
require_once __DIR__ . '/../controllers/HomeController.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerex - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body.dark-mode { background-color: #121212; color: white; }
        .dark-mode .card { background-color: #1e1e1e; color: white; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark p-3">
        <span class="navbar-brand">Gerex</span>
        <button id="modoNoturno" class="btn btn-outline-light">Modo Noturno</button>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Bem-vindo, <span id="usuarioNome">Fernando</span></h5>
                    <p><strong>Email:</strong> fernando@email.com</p>
                    <div class="card col-2">
                        <a href="/helpers/Logout.php" class="btn btn-outline-danger"><i class="bi bi-door-open"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row text-center">
                    <div class="col-md-6">
                        <div class="card p-3">
                            <h6>Total de Credenciais</h6>
                            <h3 id="totalCredenciais">12</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3">
                            <h6>Última Modificação</h6>
                            <h3 id="ultimaModificacao">2024-03-30</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNovaCredencial">
  + Nova Credencial
</button>

<?php if (!empty($credenciais)) : ?>
    <div class="container mt-4">
        <h2>Minhas Credenciais</h2>
        <table class="table table-dark table-hover table-bordered mt-3">
            <thead>
                <tr>
                    <th>Serviço</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Data Cadastro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($credenciais as $cred) : ?>
                    <tr>
                        <td><?= htmlspecialchars($cred['nome_servico']) ?></td>
                        <td><?= htmlspecialchars($cred['email_servico']) ?></td>
                        <td><?= htmlspecialchars($cred['telefone_servico']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($cred['data_cadastro'])) ?></td>
                        <td>
                            <a href="ver_credencial.php?id=<?= $cred['id_servico'] ?>" class="btn btn-sm btn-primary">Ver</a>
                            <a href="editar_credencial.php?id=<?= $cred['id_servico'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="excluir_credencial.php?id=<?= $cred['id_servico'] ?>" class="btn btn-sm btn-danger">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    
    <div class="alert alert-info">Nenhuma credencial cadastrada ainda.</div>
<?php endif ?>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#modoNoturno").click(function() {
                $("body").toggleClass("dark-mode");
            });
        });
    </script>
    <div class="modal fade" id="modalNovaCredencial" tabindex="-1" aria-labelledby="modalNovaCredencialLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="/src/controllers/CredenciaisController.php" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="modalNovaCredencialLabel">Adicionar Nova Credencial</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label for="nome_servico" class="form-label">Nome do Serviço</label>
            <input type="text" class="form-control" id="nome_servico" name="nome_servico" required>
          </div>

          <div class="mb-3">
            <label for="email_servico" class="form-label">Email</label>
            <input type="email" class="form-control" id="email_servico" name="email_servico" required>
          </div>

          <div class="mb-3">
            <label for="telefone_servico" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone_servico" name="telefone_servico" require>
          </div>

          <div class="mb-3">
            <label for="senha_servico" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha_servico" name="senha_servico" required>
          </div>

          <div class="mb-3">
            <label for="imagem" class="form-label">Imagem (opcional, máx. 512MB)</label>
            <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
          </div>

        </div>
        <div class="modal-footer">
           <?php
                if (isset($_GET['erro']) && $_GET['erro'] == 1)
           ?>
           <div class="alert alert-danger alert-mismissible fade show" role="alert">
                Preencha todos os campos obrigatórios!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>
          <button type="submit" class="btn btn-primary">Salvar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
        
      </form>
    </div>
  </div>
</div>

</body>
</html>
