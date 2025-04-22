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
    public function cadastrarCredencial($dados, $id_usuario) {
        try {
            // Prepara o SQL para inserir os dados no banco
            $sql = "INSERT INTO servicos (nome_servico, email_servico, login_servico, telefone_servico, senha_criptografada, id_usuario) 
                    VALUES (:nome_servico, :email_servico, :login_servico, :telefone_servico, :senha_criptografada, :id_usuario)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nome_servico', $dados['nome_servico']);
            $stmt->bindValue(':email_servico', $dados['email_servico']);
            $stmt->bindValue(':login_servico', $dados['login_servico']);
            $stmt->bindValue(':telefone_servico', $dados['telefone_servico']);
            $stmt->bindValue(':senha_criptografada', $dados['senha_criptografada']);
            $stmt->bindValue(':id_usuario', $id_usuario);
    
            // Executa a query e retorna true ou false
            return $stmt->execute(); // Retorna true se a query for executada com sucesso, ou false caso contrário.
        } catch (Exception $e) {
            // Caso aconteça algum erro, loga e retorna false
            error_log("Erro ao cadastrar: " . $e->getMessage());
            return false;
        }
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
