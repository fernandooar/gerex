<?php
// logout.php
require_once __DIR__ . '/Sessao.php';

// Chama o método para fazer o logout
Sessao::logout();

// Redireciona para a página de login
header('Location: /');
exit;
