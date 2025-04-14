<?php
require_once __DIR__ . '/config.php'; // Usa a chave correta definida no config.php
require_once __DIR__ . '/../src/Controllers/DescriptografarSenhaController.php'; 
function criptografarSenha($senha)
{
    $chave = CHAVE_CRIPTO;
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
    $senha_criptografada = openssl_encrypt($senha, 'AES-256-CBC', $chave, 0, $iv);

    return base64_encode($senha_criptografada . '::' . $iv); // 💥 Isso aqui resolve tudo
}

function descriptografarSenha($senhaCriptografada)
{
    $chave = CHAVE_CRIPTO;
    $dados = base64_decode($senhaCriptografada);

    if (!str_contains($dados, '::')) {
        return 'Formato inválido';
    }

    list($senha, $iv) = explode('::', $dados);

    return openssl_decrypt($senha, 'AES-256-CBC', $chave, 0, $iv);
}
