<?php

class Sessao {

    public static function iniciarSessao(int $id, string $nome, string $email): void {
        self::garantirSessaoAtiva();

        $_SESSION['usuario'] = [
            'id_usuario' => $id,
            'nome' => $nome,
            'email' => $email
        ];
        $_SESSION['ultimo_acesso'] = time(); 
        $_SESSION['tempo_expiracao'] = 1800; // 30 minutos
    }

    public static function verificarAutenticacao(): bool {
        self::garantirSessaoAtiva();

        if (!isset($_SESSION['usuario']['id_usuario'])) {
            return false;
        }

        if (isset($_SESSION['ultimo_acesso']) && (time() - $_SESSION['ultimo_acesso'] > $_SESSION['tempo_expiracao'])) {
            self::logout();
            return false;
        }

        $_SESSION['ultimo_acesso'] = time(); // Renova tempo de sessão
        return true;
    }

    public static function obterUsuario(): array|null {
        self::garantirSessaoAtiva();

        return $_SESSION['usuario'] ?? null;
    }

    public static function logout(): void {
        self::garantirSessaoAtiva();
        session_unset();
        session_destroy();
        header("Location: /"); // vai cair na rota 'welcome'
exit;
    }

    private static function garantirSessaoAtiva(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}
