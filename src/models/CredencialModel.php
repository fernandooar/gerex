<?php
require_once __DIR__ . '/../../config/Database.php';

class Credencial 
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();

    }

    public function cadastrarCredencial($dadosCredencial, $id_usuario)
    {
        $sql = "INSERT INTO servicos (nome_servico, email_servico, telefone_servico, senha_criptografada, id_usuario)
        VALUES (:nome_servico, :email_servico, :telefone_servico, :senha_criptografada, :id_usuario)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome_servico', $dadosCredencial['nome_servico']);
        $stmt->bindValue(':email_servico', $dadosCredencial['email_servico']);
        $stmt->bindValue(':telefone_servico', $dadosCredencial['telefone_servico']);
        $stmt->bindValue(':senha_criptografada', $dadosCredencial['senha_criptografada']);
        $stmt->bindValue(':id_usuario', $id_usuario);

        return $stmt->execute();
    }

    public function buscarCredenciaisPorUsuario($id_usuario) {
        $sql = "SELECT *FROM servicos WHERE id_usuario = :id_usuario ORDER BY data_cadastro DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}