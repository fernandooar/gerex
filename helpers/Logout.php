<?php
// logout.php
require_once __DIR__ . '/Sessao.php';

// Chama o método para fazer o logout
Sessao::logout();
header('Location: /gerex/index.php');

exit;
