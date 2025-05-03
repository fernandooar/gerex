<?php
// captura a rota ou assume 'welcome'
$rota = $_GET['rota'] ?? 'welcome';

switch ($rota) {
  case 'login':
    require_once __DIR__ . '/src/Views/LoginView.php';
    break;

  case 'cadastro':
    require_once __DIR__ . '/src/Views/CadastroView.php';
    break;

  case 'home':
    require_once __DIR__ . '/src/Views/HomeView.php';
    break;

  case 'welcome':
    require_once __DIR__ . '/src/Views/WelcomeView.php';
    break;

  default:
    http_response_code(404);
    echo "Página não encontrada.";
    break;
}
