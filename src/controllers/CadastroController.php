<?php
require_once __DIR__ . '/../../helpers/Sessao.php';
require_once __DIR__ . '/../models/UsuarioModel.php';

Sessao::verificarAutenticacao();

$id_usuario = $_SESSION['usuario_id']; // Corrigido o nome da chave da sessão
$_SESSION['mensagem'] = ""; // Zera a mensagem de sessão antes de começar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario = new Usuario();

    // Sanitiza os dados
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Validação básica
    if (empty($nome) || empty($email) || empty($senha)) {
        $_SESSION['mensagem'] = "Preencha todos os campos!";
        $_SESSION['tipo_mensagem'] = "erro";
        header('Location: /src/views/cadastro.php');
        exit;
    }

    // Verifica se o e-mail já existe
    if ($usuario->verificarCadastroPorEmail($email)) {
        $_SESSION['mensagem'] = "E-mail já cadastrado!";
        $_SESSION['tipo_mensagem'] = "erro";
    } else {
        // Cadastra o novo usuário
        if ($usuario->cadastrar($nome, $email, $senha)) {
            $_SESSION['mensagem'] = "Cadastro realizado com sucesso.";
            $_SESSION['tipo_mensagem'] = "sucesso";
        } else {
            $_SESSION['mensagem'] = "Erro ao cadastrar. Tente novamente.";
            $_SESSION['tipo_mensagem'] = "erro";
        }
    }

    // Redireciona pro form de cadastro com a mensagem
    header('Location: /src/views/cadastro.php');
    exit;
}
