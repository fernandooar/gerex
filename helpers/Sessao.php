<?php

class Sessao {


    public static function iniciarSessao($id, $nome, $email) {
        
        // Se a sessão não foi iniciada, chamamos session_start().
        if (session_start() === PHP_SESSION_NONE) {
           
            session_start(); 
        }
        // Se a sessão já estiver ativa, não tentamos reiniciá-la.
        $_SESSION['usuario_id'] = $id;
        $_SESSION['usuario_nome'] = $nome;
        $_SESSION['usuario_email'] = $email;
        
        // Define o tempo de expiração para 30 minutos (1800 segundos)
        $_SESSION['ultimo_acesso'] = time(); 
        $_SESSION['tempo_expiracao'] = 1800; // 30 minutos
    }

    public static function verificarAutenticacao() {
        // Retorna verdadeiro se o usuário estiver logado
        return isset($_SESSION['id_usuario']);
    }
}