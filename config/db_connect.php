<?php
// db_connection.php

namespace api;

use PDO;
use PDOException;

class DBConnection {
    private static $instance;
    private $pdo;

    private function __construct() {
        $hostname = 'localhost'; // Hostname do servidor MySQL
        $username = 'root';      // Nome de usuário do MySQL
        $password = '123';       // Senha do MySQL
        $database = 'api';       // Nome do banco de dados

        try {
            // Cria uma nova conexão PDO
            $this->pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
            
            // Configura o modo de erro do PDO para exceções
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Captura e exibe qualquer exceção ocorrida durante a conexão
            die("Erro ao conectar-se ao banco de dados: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>
