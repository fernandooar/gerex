<?php
require_once __DIR__ . '/../../config/Database.php';

class Credencial
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Cadastra uma nova credencial no banco de dados.
     */
    public function cadastrarCredencial(array $dadosCredencial, int $id_usuario): bool
    {
        if (empty($dadosCredencial['nome_servico']) || empty($dadosCredencial['senha_criptografada'])) {
            return false;
        }

        $sql = "INSERT INTO servicos 
                (nome_servico, email_servico, login_servico, telefone_servico, senha_criptografada, data_cadastro, data_alteracao, id_usuario)
                VALUES 
                (:nome_servico, :email_servico, :login_servico, :telefone_servico, :senha_criptografada, NOW(), NOW(), :id_usuario)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome_servico', $dadosCredencial['nome_servico']);
        $stmt->bindValue(':email_servico', $dadosCredencial['email_servico'] ?? null);
        $stmt->bindValue(':login_servico', $dadosCredencial['login_servico'] ?? null);
        $stmt->bindValue(':telefone_servico', $dadosCredencial['telefone_servico'] ?? null);
        $stmt->bindValue(':senha_criptografada', $dadosCredencial['senha_criptografada']);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Retorna todas as credenciais de um usuário.
     */
    public function buscarCredenciaisPorUsuario(int $id_usuario): array
    {
        $sql = "SELECT * FROM servicos WHERE id_usuario = :id_usuario ORDER BY data_cadastro DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retorna uma credencial específica por ID.
     */
    public function buscarCredencialPorId(int $id_servico): ?array
    {
        $sql = "SELECT * FROM servicos WHERE id_servico = :id_servico";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_servico', $id_servico, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

    /**
     * Atualiza uma credencial específica.
     */
    public function atualizarCredencial(int $id_servico, array $dadosCredencial, int $id_usuario): bool
    {
        $sql = "UPDATE servicos SET 
                    nome_servico = :nome_servico,
                    email_servico = :email_servico,
                    login_servico = :login_servico,
                    telefone_servico = :telefone_servico,
                    senha_criptografada = :senha_criptografada,
                    data_alteracao = NOW()
                WHERE id_servico = :id_servico AND id_usuario = :id_usuario";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome_servico', $dadosCredencial['nome_servico']);
        $stmt->bindValue(':email_servico', $dadosCredencial['email_servico'] ?? null);
        $stmt->bindValue(':login_servico', $dadosCredencial['login_servico'] ?? null);
        $stmt->bindValue(':telefone_servico', $dadosCredencial['telefone_servico'] ?? null);
        $stmt->bindValue(':senha_criptografada', $dadosCredencial['senha_criptografada']);
        $stmt->bindValue(':id_servico', $id_servico, PDO::PARAM_INT);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Deleta uma credencial pelo ID.
     */
    public function deletarCredencial(int $id_servico, int $id_usuario): bool
    {
        $sql = "DELETE FROM servicos WHERE id_servico = :id_servico AND id_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_servico', $id_servico, PDO::PARAM_INT);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function buscarSenhaPorId(int $id_servico): ?string    {
        // SQL para buscar a senha criptografada do serviço
        $sql = "SELECT senha_criptografada FROM servicos WHERE id_servico = :id_servico";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_servico', $id_servico, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Retornar a senha criptografada, ou null se não encontrado
        return $resultado ? $resultado['senha_criptografada'] : null;
    }
    
}
