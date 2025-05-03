
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerex - Gerenciador de Credenciais</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container">
    <a class="navbar-brand fs-3" href="#">Gerex</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link btn btn-outline-light px-3 ms-2" href="/src/Views/LoginView.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-primary px-3 ms-2" href="/cadastro">Cadastrar-se</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<header class="py-5 bg-primary text-white text-center">
  <div class="container">
    <h1 class="display-4 fw-bold">Bem-vindo ao Gerex</h1>
    <p class="lead">Sua central de controle de senhas e credenciais com segurança e praticidade.</p>
    <a href="/cadastro" class="btn btn-lg btn-light mt-3">Começar Agora</a>
  </div>
</header>

<section class="py-5">
  <div class="container">
    <div id="featureCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#featureCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#featureCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#featureCarousel" data-bs-slide-to="2"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active text-center py-5">
          <h2 class="fw-bold">CRUD de Credenciais</h2>
          <p class="text-muted">Adicione, edite e exclua seus acessos com poucos cliques.</p>
        </div>
        <div class="carousel-item text-center py-5">
          <h2 class="fw-bold">Dashboard Dinâmico</h2>
          <p class="text-muted">Visualize estatísticas em tempo real: total de credenciais, última modificação e muito mais.</p>
        </div>
        <div class="carousel-item text-center py-5">
          <h2 class="fw-bold">Segurança Avançada</h2>
          <p class="text-muted">Criptografia AES-256 garante que apenas você possa acessar suas senhas.</p>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#featureCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#featureCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </div>
</section>

<footer class="py-4 bg-dark text-white-50">
  <div class="container text-center">
    <small>© 2025 Fernando almeida - Gerex. Todos os direitos reservados.</small>
  </div>
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
