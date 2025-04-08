<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/CredencialModel.php';
require_once __DIR__ . '/../../helpers/Sessao.php';



Sessao::verificarAutenticacao();

$credencial = new Credencial();

$id_usuario = $_SESSION['usuario']['id_usuario'] ;
$credenciais = $credencial->buscarCredenciaisPorUsuario($id_usuario);

require_once __DIR__ . '/../views/home.php';