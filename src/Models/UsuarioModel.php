<?php 
require_once __DIR__ . '/../../config/Database.php'; // Carrega a classe 

class Usuario {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }


    /**
     * Cadastra um novo usuário no banco de dados.
     *
     * @param string $nome Nome do usuário.
     * @param string $email Endereço de e-mail do usuário.
     * @param string $senha Senha do usuário que será criptografada antes de ser armazenada.
     * @return bool Retorna true em caso de sucesso ou false em caso de falha ao executar a consulta.
     */
    
    public function cadastrar($nome, $email, $senha) {
        $senha_hash = password_hash($senha, PASSWORD_BCRYPT); // Criptografa a senha
        $sql = "INSERT INTO usuarios (nome, email, senha_hash) VALUES (:nome, :email, :senha)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_hash);
        
        return $stmt->execute();
    }

    /**
     * Verifica se um cadastro já existe no banco de dados com o email fornecido.
     *
     * @param string $email O email a ser verificado.
     * @return bool Retorna true se o email já estiver cadastrado, caso contrário, retorna false.
     */
    public function verificarCadastroPorEmail($email)
    {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Autentica um usuário com base no email e senha fornecidos.
     *
     * @param string $email O email do usuário.
     * @param string $senha A senha do usuário.
     * @return array|false Retorna um array com os dados do usuário (id, nome, senha) se a autenticação for bem-sucedida,
     *                     ou false se o usuário não for encontrado ou a senha estiver incorreta.
     */
    public function autenticar($email, $senha)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            return $usuario;
        }
        return false;
    }
    /**
     * Atualiza o perfil do usuário com base no ID fornecido.
     *
     * @param int $id O ID do usuário.
     * @param string $nome O novo nome do usuário.
     * @param string $email O novo email do usuário.
     * @param string|null $senha A nova senha do usuário (opcional).
     * @return bool Retorna true em caso de sucesso ou false em caso de falha ao executar a consulta.
     */
    public function atualizarPerfil($id, $nome, $email, $senha = null) {
        if ($senha) {
            $senha_hash = password_hash($senha, PASSWORD_BCRYPT); // Criptografa a senha
            $sql = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
        } else {
            $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);

        if ($senha) {
            $stmt->bindParam(':senha', $senha_hash);
        }

        return $stmt->execute();
    }

    /**
     * Deleta um usuário com base no ID fornecido.
     *
     * @param int $id O ID do usuário.
     * @return bool Retorna true em caso de sucesso ou false em caso de falha ao executar a consulta.
     */
    public function deletar($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Busca um usuário com base no ID fornecido.
     *
     * @param int $id O ID do usuário.
     * @return array|false Retorna um array com os dados do usuário se encontrado, ou false se não encontrado.
     */
    public function autenticarUsuario($email, $senha)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute(['email' => $email]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            return $usuario; //Retorna os dados do usuário se autenticado
        } else {
            return false; // Retorna falso se a autenticação falhar
        }
    }


    /**
     * Busca a data da última atualização de credenciais de um usuário específico.
     *
     * @param int $id_usuario ID do usuário cujas credenciais serão buscadas.
     * @return string A data da última atualização formatada ou uma mensagem padrão se não houver atualizações.
     */
    public function dataDaUltimaAtualizacao($id_usuario) {
        $sql = "SELECT MAX(data_alteracao) as ultima FROM servicos WHERE id_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchColumn();
    
        if ($data) {
            $dataFormatada = date('d/m/Y \à\s H:i', strtotime($data));
            return $dataFormatada;
        }
    
        return 'Nenhuma atualização registrada';
    }
    
} // Fechamento da classe Usuario



