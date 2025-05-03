<?php

require_once __DIR__ . '/../Models/CredencialModel.php';
require_once __DIR__ . '/../../helpers/Sessao.php';
require_once __DIR__ . '/../../helpers/CryptoHelper.php';

//Verifica se o usuário está logado
Sessao::verificarAutenticacao();
//session_start();
$usuario = $_SESSION['usuario']; // acessa os dados do usuário
$id_usuario = $usuario['id_usuario'] ?? null;

if (!$id_usuario) {
    die("Erro: Usuário não autenticado.");
}


if (!empty($_POST['id_servico'])) {
    // Aqui o código do editar
    $senha_criptografada = criptografarSenha($_POST['senha_servico']);

    if ($_POST['login_servico'] == "") {
        $_POST['login_servico'] = $_POST['email_servico'];
    }

    $dados_editados = [
        'id_servico' => $_POST['id_servico'],
        'nome_servico' => trim($_POST['nome_servico']),
        'email_servico' => trim($_POST['email_servico']),
        'login_servico' => trim($_POST['login_servico']),
        'telefone_servico' => trim($_POST['telefone_servico']),
        'senha_criptografada' => $senha_criptografada,
        'id_usuario' => $id_usuario
    ];

    // Validação
    if (empty($dados_editados['nome_servico']) || empty($dados_editados['email_servico']) || empty($_POST['senha_servico'])) {
        $_SESSION['mensagem'] = "Preencha os campos obrigatórios.";
        $_SESSION['tipo_mensagem'] = "erro";
        header('Location: /home');
        exit;
    }

    $credencial = new Credencial();
    $sucesso = $credencial->editarCredencial($dados_editados);

    if ($sucesso) {
        $_SESSION['mensagem'] = "Credencial editada com sucesso!";
        $_SESSION['tipo_mensagem'] = "sucesso";
    } else {
        $_SESSION['mensagem'] = "Erro ao editar a credencial.";
        $_SESSION['tipo_mensagem'] = "erro";
    }

    header('Location: /home');
    exit;
} else {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // var_dump($_POST['senha_servico']);
        // exit;

        $senha_criptografada = criptografarSenha($_POST['senha_servico']);

        if ($_POST['login_servico'] == "") {
            $_POST['login_servico'] = $_POST['email_servico'];
        }
        $dados_credencial = [
            'nome_servico' => trim($_POST['nome_servico']),
            'email_servico' => trim($_POST['email_servico']),
            'login_servico' => trim($_POST['login_servico']),
            'telefone_servico' => trim($_POST['telefone_servico']),
            'senha_criptografada' => $senha_criptografada,
            'id_usuario' => $id_usuario
        ];

        // Validação básica
        if (empty($dados_credencial['nome_servico']) || empty($dados_credencial['email_servico']) || empty($_POST['senha_servico'])) {
            $_SESSION['mensagem'] = "Preencha os campos obrigatórios.";
            $_SESSION['tipo_mensagem'] = "erro";
            header('Location: /home?erro=1');
            exit;
        }

        $novaCredencial = new Credencial();
        $sucesso = $novaCredencial->cadastrarCredencial($dados_credencial, $id_usuario);

        if ($sucesso) {
            $_SESSION['mensagem'] = "Credencial cadastrada com sucesso!";
            $_SESSION['tipo_mensagem'] = "sucesso";
        } else {
            $_SESSION['mensagem'] = "Erro ao cadastrar credencial.";
            $_SESSION['tipo_mensagem'] = "erro";
        }

        header('Location: /home.php');
        exit;
    }
}
