<?php
require_once __DIR__ . '/../Models/CredencialModel.php'; // Carregar o model de credenciais
require_once __DIR__ . '/../../helpers/CryptoHelper.php'; 

// Verificar se o ID do serviço foi enviado na requisição
if (isset($_GET['id_servico'])) {
    $id_servico = $_GET['id_servico'];

    // Instanciar o model de credenciais e buscar a senha criptografada
    $credencial = new Credencial();
    $senha_criptografada = $credencial->buscarSenhaPorId($id_servico); // Método para buscar a senha criptografada

    // Verificar se a senha foi encontrada
    if ($senha_criptografada) {
        // Descriptografar a senha
        $senha = descriptografarSenha($senha_criptografada);

        // Retornar a senha como resposta JSON
        echo json_encode(['senha' => $senha]);
    } else {
        echo json_encode(['erro' => 'Credencial não encontrada']);
    }
} else {
    echo json_encode(['erro' => 'ID do serviço não informado']);
}


