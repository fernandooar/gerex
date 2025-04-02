<?php
session_start();
$_SESSION['mensagem'] = ""; //Inicia a variável 'mensagem' vazia


if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    require_once __DIR__ . '/../models/UsuarioModel.php';
    $usuario = new Usuario();
    // Pegando os dados do formulário
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($nome) || empty($email) || empty($senha)) {
        $_SESSION['mensagem'] = "Preencha todos os campos!";
        $_SESSION['tipo_mensagem'] = "erro";
        header('Location: /../../src/views/cadastro.php');
        exit;
    } 

    if($usuario->verificarCadastroPorEmail($email))
    {
        $_SESSION['mensagem'] = "E-Mail já cadastrado!";
        $_SESSION['tipo_mensagem'] = "erro";
    } else {
       if ($usuario->cadastrar($nome, $email, $senha)) {
           $_SESSION['mensagem'] = "Cadastro realizado com sucesso";
           $_SESSION['tipo_mensagem'] = "sucesso";
       } else {
           $_SESSION['mensagem'] = "Erro ao cadastrar. Tente novamente.";
           $_SESSION['tipo_mensagem'] = "erro";
       }
    }
    header('Location: /../../src/views/cadastro.php');
    exit;

}