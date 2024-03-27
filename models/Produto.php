<?php

namespace api\models;

require_once __DIR__ . '/../config/db_connect.php';

use api\DBConnection;
use PDO;
use PDOException;

class Produto
{
    protected $pdo;

    public function __construct() {
        $db = DBConnection::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function getAll() {
        try {
            $query = "SELECT * FROM produtos";
        
            // Prepara e executa a consulta
            $statement = $this->pdo->query($query);
            
            // Recupera os resultados da consulta como um array associativo
            $produtos = $statement->fetchAll(PDO::FETCH_ASSOC);

            
            return $produtos;
        
        // Recupera os resultados da consulta como um array associativo
        $produtos = $statement->fetchAll(PDO::FETCH_ASSOC);
        
            
        } catch (PDOException $e) {
            // Captura e exibe qualquer exceção ocorrida durante a consulta
            die("Erro ao recuperar usuários do banco de dados: " . $e->getMessage());
        }
    }

    public function getById($id) {
        try {
            $query = "SELECT * FROM produtos WHERE id = :id";
        
            // Prepara a consulta
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            
            // Executa a consulta
            $statement->execute();
            
            // Recupera o cliente como um array associativo
            $produto = $statement->fetch(PDO::FETCH_ASSOC);
            
            return $produto;
            
        } catch (PDOException $e) {
            // Captura e exibe qualquer exceção ocorrida durante a consulta
            die("Erro ao recuperar cliente do banco de dados: " . $e->getMessage());
        }
    }

    public function createOrUpdate($data = null) {
        try {
            if (isset($data['id'])) {
                $query = "UPDATE produtos SET nome = :nome, vlrunit = :vlrunit WHERE id = :id";
            } else {
                $query = "INSERT INTO produtos (nome, vlrunit) VALUES (:nome, :vlrunit)";
            }
    
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':nome', $data['nome'], PDO::PARAM_STR);
            $statement->bindParam(':vlrunit', $data['vlrunit'], PDO::PARAM_STR);
            
            if (isset($data['id'])) {
                $statement->bindParam(':id', $data['id'], PDO::PARAM_INT);
            }
    
            $statement->execute();
            $id = isset($data['id']) ? $data['id'] : $this->pdo->lastInsertId();
            $nome = $data['nome'];
            
            return ['id' => $id, 'nome' => $nome];
            
        } catch (PDOException $e) {
            die("Erro ao criar ou atualizar usuário no banco de dados: " . $e->getMessage());
        }
    }


    public function delete($id) {
        try {
            // Query SQL para excluir o usuário com o ID fornecido
            $query = "DELETE FROM produtos WHERE id = :id";
    
            // Prepara a consulta
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            
            // Executa a consulta
            $statement->execute();
            
            // Retorna true se o usuário foi excluído com sucesso
            return true;
            
        } catch (PDOException $e) {
            // Captura e exibe qualquer exceção ocorrida durante a consulta
            die("Erro ao excluir usuário do banco de dados: " . $e->getMessage());
        }
    }
    

}