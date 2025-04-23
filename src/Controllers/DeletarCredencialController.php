<?php
require_once __DIR__ . '/../Models/CredencialModel.php';
require_once __DIR__ . '/../../helpers/Sessao.php';

Sessao::verificarAutenticacao();
$usuario = $_SESSION['usuario'];
$id_usuario = $usuario['id_usuario'] ?? null;

if (!$id_usuario) {
    die ("Erro: Usuário não autenticado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_servico'])) {

    
    $id = $_POST['id_servico'];
    
    $credencial = new Credencial();
    $resultado = $credencial->deletarCredencial($id, $id_usuario);

    if ($resultado) {
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => 'Erro ao deletar no banco de dados']);
    }
    
} else {
    echo json_encode(['sucesso' => false, 'erro' => 'Requisição inválida.']);
}