<?php

function criptografarSenha($senha)
{
    $chave = 'sua_chave_super_secreta'; // Defina uma chave secreta
    $iv = openssl_random_pseudo_bytes(16); // Gera um vetor de inicialização aleatório
    $senha_criptografada =  openssl_encrypt($senha, 'AES-256-CBC', $chave, 0, $iv);
    return base64_encode($senha_criptografada . '::' . $iv); // Retorna a senha criptografada e o vetor de inicialização separadas por :: para posterior descriptografia
}