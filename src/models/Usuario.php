<?php

require_once __DIR__ . '/../../config/Database.php';

class Usuario
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    //Cadastro de Usuário
    public function cadastrar($nome, $email, $senha)
    {
        $sql = "INSERT INTO usuarios (nome, email, senha_hash) VALUES (:nome, :email, :senha)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['nome' => $nome,
                        'email' => $email,
                        'senha' => password_hash($senha, PASSWORD_DEFAULT)
        ]);
        /*
        * O que significa ['nome' => $nome, 'email' => $email, 'senha' => $senhaHash]?
        * Esse trecho cria um array associativo.
        * Veja este exemplo de código:
        * $sql = "INSERT INTO usuarios (nome, email, senha_hash) VALUES (:nome, :email, :senha)";
        * $stmt = $this->db->prepare($sql);
        * return $stmt->execute(['nome' => $nome, 'email' => $email, 'senha' => $senhaHash]);
        * Aqui, estamos preparando um statement SQL com placeholders (:nome, :email, :senha).
        * Depois, usamos um array associativo para associar valores a esses placeholders:
        * ['nome' => $nome, 'email' => $email, 'senha' => $senhaHash]
        * Isso significa:
            :nome será substituído por $nome.
            :email será substituído por $email.
            :senha será substituído por $senhaHash.
        * Essa técnica previne SQL Injection, tornando o código mais seguro.
        * Resumo: Esse array serve para substituir valores dentro do SQL de maneira segura.
        */
    }

    public function verificarCadastroPorEmail($email)
    {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    
    /**
     * Login do usuário
     * Usar fetchColumn() em vez de fetch(PDO::FETCH_ASSOC)
     * Como queremos apenas saber se o e-mail existe, não precisamos trazer todas as colunas do banco.
     * fetchColumn() é mais rápido e eficiente porque retorna apenas um valor (o e-mail, por exemplo).
     */
    public function autenticar($email, $senha)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senhaHash'])) {
            return $usuario;
        }
        return false;
    }

    // Buscar usuário por id
    public function buscarUsuarioPorId($id)
    {
        $sql = "SELECT id_usario, nome, email FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Deletar conta do usuário
    public function deletarContaUsuario($id)
    {
        $sql = "DELETE FROM usuarios WHERE id_usario = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
