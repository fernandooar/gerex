<?php


class Database {
    private static $instance = null; //$instance: Armazena a única instância da classe (padrão Singleton).
    private $conn;

    private $host = "localhost";
    private $dbname = "gerex";
    private $username = "root";
    private $password = "";

   
    private function __construct()
    {
        try {
          
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {

            die("Erro na conexão: " . $e->getMessage());

        }
    }
    
   
    public static function getInstance()
    {
       if (!self::$instance) {
            self::$instance = new Database();
       }
         return self::$instance;
    }
    
    public function getConnection()
    {
        return $this->conn;
    }

}