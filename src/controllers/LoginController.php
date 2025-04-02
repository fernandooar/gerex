<?php
require_once __DIR__ . '/../models/UsuarioModel.php';
require_once __DIR__ . '/../../helpers/Sessao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (!empty($email) && !empty($senha)) {
        //Criando um objeto Usuario e chamando o método autenticar usuário da forma correta
        $usuario = new Usuario();
        $dadosUsuario = $usuario->autenticarUsuario($email, $senha);
        
        if ($dadosUsuario && password_verify($senha, $dadosUsuario['senha_hash'])){
            // Se Login bem-sucedido: inicia a sessão do usuário
            Sessao::iniciarSessao($dadosUsuario['id_usuario'], $dadosUsuario['nome'], $dadosUsuario['email']);
            header('Location: /../src/views/home.php');
            exit;
        } else {
            // Login falhou: volta para a tela de login com erro
            header('Location: /../src/views/login.php?erro=1');
            exit;
        }      
    }
}
