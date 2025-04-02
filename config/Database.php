<?php

class Database {
    private static $instance = null; //$instance: Armazena a única instância da classe (padrão Singleton).
    private $conn;

    private $host = "localhost";
    private $dbname = "gerex";
    private $username = "root";
    private $password = "";

    /**
     * O construtor é privado para impedir que a classe seja instanciada diretamente com new Database(). Isso garante que sempre teremos uma única conexão ativa.
     * Construtor privado para evitar múltiplas instâncias
     */
    private function __construct()
    {
        try {
            /**
             * Aqui estamos criando a conexão com PDO (PHP Data Objects), que é uma maneira segura e flexível de interagir com o MySQL.
             * new PDO(...) → Cria a conexão.
             * setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) → Configura o PDO para lançar exceções caso ocorra erro, facilitando a depuração.
             * Se a conexão falhar, o catch abaixo captura o erro e encerra o script:
             */
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }
    
    /**
     * Método para obter instÂncia única
     * Esse método garante que sempre que chamarmos Database::getInstance(), teremos apenas UMA instância da classe.
     * Se ainda não existir (null), ele cria uma nova conexão. Caso contrário, retorna a já existente.
     * Se a instância ainda não existir (null), criamos uma nova conexão. Se já existir, usamos a mesma.
     *  Resumo: self é como dizer "eu mesmo", mas dentro da classe.
     */
    public static function getInstance()
    {
        /**
         * O self é usado para acessar membros estáticos dentro da própria classe.
         * Aqui, self::$instance refere-se à variável estática $instance dentro da própria classe Database.
         * 
         */
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    /**
     * Método para obter a conexão PDO
     * se método retorna a conexão PDO, que será usada para fazer consultas no banco de dados.
     */
    public function getConnection()
    {
        return $this->conn;
    }

}

// $db = Database::getInstance()->getConnection();
// var_dump($db);