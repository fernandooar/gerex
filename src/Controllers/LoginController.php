<?php
require_once __DIR__ . '/../Models/UsuarioModel.php'; 
require_once __DIR__ . '/../../helpers/Sessao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        header('Location: /src/Views/LoginView.php?erro=campos_vazios');
        exit;
    }

    $usuarioModel = new Usuario();
    $dadosUsuario = $usuarioModel->autenticar($email, $senha);

    if ($dadosUsuario) {
        Sessao::iniciarSessao($dadosUsuario['id_usuario'], $dadosUsuario['nome'], $dadosUsuario['email']);
        header('Location: /src/Views/HomeView.php');
        exit;
    } else {
        header('Location: /src/Views/LoginView.php?erro=credenciais_invalidas');
        exit;
    }
}
