<?php
require_once __DIR__ . 'Sessao.php';

if (!Sessao::verificarAutenticacao()) {
    // Se não estiver logado, redireciona para login.php com uma mensagem de erro
    header('Location: /../src/views/login.php?erro=acesso_negado');
    exit;
}