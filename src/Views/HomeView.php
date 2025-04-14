<?php
require_once __DIR__ . '/../../helpers/Sessao.php'; // Carrega a classe Sessao

if (Sessao::verificarAutenticacao()) {
  // Usuário está logado, pode acessar a página
  $usuario = Sessao::obterUsuario();  // Obtém dados do usuário
  //echo "Bem-vindo, " . $usuario['nome']; // Exibe o nome do usuário
} else {
  // Redireciona para a página de login
  header("Location: LoginView.php");
  exit;
}
require_once __DIR__ . '/../../includes/HeaderInclude.php';
require_once __DIR__ . '/../Models/CredencialModel.php'; // Carrega a classe CredencialModel
require_once __DIR__ . '/../Models/UsuarioModel.php'; // Carrega a classe UsuarioModel

$credenciais = new Credencial();

$credenciais = $credenciais->buscarCredenciaisPorUsuario($usuario['id_usuario']);
/**
 * Verifica e inicializa as credenciais.
 *
 * Se a variável $credenciais for avaliada como false, ela será inicializada
 * como um array vazio. Caso contrário, cada elemento do array $credenciais
 * será convertido em um objeto.
 *
 * @var mixed $credenciais Pode ser false ou um array de credenciais.
 * @return void
 */

if ($credenciais === false) {
  $credenciais = []; // Inicializa como array vazio se não houver credenciais
} else {
  $credenciais = array_map(function ($cred) {
    return (object) $cred; // Converte cada credencial para objeto
  }, $credenciais);
}

$totalCrendenciais = count($credenciais);

$ultimaAtualizacao =  new Usuario();
$ultimaAtualizacao = $ultimaAtualizacao->dataDaUltimaAtualizacao($usuario['id_usuario']);

?>

<nav class="navbar navbar-dark bg-dark p-3">
  <span class="navbar-brand">Gerex</span>
  <button id="modoNoturno" class="btn btn-outline-light">Modo Noturno</button>
</nav>
<div class="container mt-4">
  <div class="row">
    <div class="col-md-4">
      <div class="card p-3">
        <h5>Bem-vindo, <span id="usuarioNome"><?= $usuario['nome'] ?></span></h5>
        <p><strong>Email:</strong> <?= $usuario['email'] ?></p>
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
            <h3 id="totalCredenciais"><?= $totalCrendenciais ?></h3>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card p-3">
            <h6>Última Modificação</h6>
            <h3 id="ultimaModificacao"><?= $ultimaAtualizacao ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="mt-4">
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNovaCredencial">
      <i class="bi bi-file-earmark-plus-fill fs-5"></i> Nova Credencial
    </button>

    <?php

    if (!empty($credenciais)) : ?>

      <div class="container mt-4">
        <h2>Minhas Credenciais</h2>
        <table class="table table-dark table-hover table-bordered mt-3">
          <thead>
            <tr>
              <th>Serviço</th>
              <th>Email</th>
              <th>Login</th>
              <th>Telefone</th>
              <th>Data Cadastro</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($credenciais as $cred) : ?>
              <tr>
                <td><?= htmlspecialchars($cred->nome_servico) ?></td>
                <td><?= htmlspecialchars($cred->email_servico) ?></td>
                <td><?= htmlspecialchars($cred->login_servico) ?></td>
                <td><?= htmlspecialchars($cred->telefone_servico) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($cred->data_cadastro)) ?></td>
                <td>
                  <button
                    class="btn btn-sm btn-primary btn-ver"
                    data-nome="<?= htmlspecialchars($cred->nome_servico) ?>"
                    data-email="<?= htmlspecialchars($cred->email_servico) ?>"
                    data-login="<?= htmlspecialchars($cred->login_servico) ?>"
                    data-senha="<?= htmlspecialchars($cred->senha_criptografada) ?>"
                    data-bs-toggle="modal"
                    data-bs-target="#modalDetalhesCredencial"> <i class="bi bi-eye-fill fs-5"></i></i>
                  </button>

                  <button class="btn btn-sm btn-success btn-editar" 
                    data-id-servico="<?= htmlspecialchars($cred->id_servico) ?>"> <i class="bi bi-clipboard-plus-fill fs-5"></i>
                  </button>

                  <button class="btn btn-sm btn-danger btn-editar" 
                    data-id-servico="<?= htmlspecialchars($cred->id_servico) ?>"> <i class="bi bi-calendar-x-fill fs-5"></i>
                  </button>                 
                  
                </td>
              </tr>
            <?php endforeach; ?>

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
      <form action="/src/Controllers/CredencialController.php" method="POST" enctype="multipart/form-data">
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
            <label for="login_servico" class="form-label">Login do serviço</label>
            <input type="text" class="form-control" id="login_servico" name="login_servico">
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
          <?php if (isset($_GET['erro']) && $_GET['erro'] == 1) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Preencha todos os campos obrigatórios!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>


          <?php endif; ?>

          <button type="submit" class="btn btn-primary">Salvar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>

      </form>
    </div>
  </div>
</div>
<script src="/public/js/scripts.js"></script>

<!-- Modal de Detalhes da Credencial -->
<div class="modal fade" id="modalDetalhesCredencial" tabindex="-1" aria-labelledby="detalhesLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="detalhesLabel">Detalhes da Credencial</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body card-body">
        <p><strong>Serviço:</strong> <span id="detalhe-nome"> </span></p>
        <p><strong>Email:</strong> <span id="detalhe-email"></span></p>
        <p><strong>Login:</strong> <span id="detalhe-login"></span></p>
        <p><strong>Senha:</strong> <span id="detalhe-senha">********</span></p>
        <div class="card-footer">
        
          <button id="btnMostrarSenha" class="btn btn-outline-primary btn-sm me-1" data-id-servico="<?= $cred->id_servico ?>">
            <i id="iconMostrar" class="bi bi-eye-slash"></i>
          </button>
          <button id="btnCopiarSenha" class="btn btn-outline-success btn-sm" title="Copiar senha">
            <i class="bi bi-clipboard"></i>
          </button>
        </div>
      </div>


      </p>
    </div>
  </div>
</div>
</div>

<?php
require_once __DIR__ . '/../../includes/FooterInclude.php'; // Carrega o rodapé
?>