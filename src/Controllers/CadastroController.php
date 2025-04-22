<?php 
echo "Entrei no Controller cadastro";
ini_set('display_errors', 1);
error_reporting(E_ALL);


if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicia a sessão se ainda não estiver iniciada
}
require_once __DIR__ . '/../Models/UsuarioModel.php'; // Carrega a classe UsuarioModel
require_once __DIR__ . '/../Models/CredencialModel.php'; // Carrega a classe CredencialModel
require_once __DIR__ . '/../../helpers/Sessao.php'; // Carrega a classe Sessao
require_once __DIR__ . '/../../config/Database.php'; // Carrega a classe Database



$_SESSION['mensagem'] = null; // Inicializa a variável de sessão 'mensagem' como nula

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
echo "Entrei no POST";
    $usuario = new Usuario();

    //var_dump($_POST);

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    //$confirma_email = $_POST['confirma_email'];
    $senha = trim($_POST['senha']);
    //$confirmar_senha = $_POST['confirmar_senha'];
    // Validação básica
    if (empty($nome) || empty($email) || empty($senha)) {
        $_SESSION['mensagem'] = "Preencha todos os campos!";
        $_SESSION['tipo_mensagem'] = "erro";
        header('Location: /src/Views/CadastroView.php');
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
            header('Location: /gerex/src/Views/LoginView.php');
            exit();
        } else {
           
            $_SESSION['tipo_mensagem'] = "erro";
        }
    }

    $_SESSION['erro'] = "Erro ao cadastrar usuário. Tente novamente.";

        
  }

// Redireciona para a página de cadastro após o processamento do formulário

    header('Location: ../Views/CadastroView.php');