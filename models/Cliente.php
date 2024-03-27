<?php

namespace api\models;


require_once __DIR__ . '/../config/db_connect.php';

use api\DBConnection;
use PDO;
use PDOException;



class Cliente
{
    protected $pdo;

    public function __construct() {
        $db = DBConnection::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function getAll() {
        try {
            $query = "SELECT * FROM clientes";
        
            // Prepara e executa a consulta
            $statement = $this->pdo->query($query);
            
            // Recupera os resultados da consulta como um array associativo
            $clientes = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $clientes;
        
        // Recupera os resultados da consulta como um array associativo
        $clientes = $statement->fetchAll(PDO::FETCH_ASSOC);
        
            
        } catch (PDOException $e) {
            // Captura e exibe qualquer exceção ocorrida durante a consulta
            die("Erro ao recuperar usuários do banco de dados: " . $e->getMessage());
        }
    }

    public function getById($id) {
        try {
            $query = "SELECT * FROM clientes WHERE id = :id";
        
            // Prepara a consulta
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            
            // Executa a consulta
            $statement->execute();
            
            // Recupera o cliente como um array associativo
            $cliente = $statement->fetch(PDO::FETCH_ASSOC);
            
            return $cliente;
            
        } catch (PDOException $e) {
            // Captura e exibe qualquer exceção ocorrida durante a consulta
            die("Erro ao recuperar cliente do banco de dados: " . $e->getMessage());
        }
    }

    public function createOrUpdate($data) {
        try {
            // Verifica se o usuário já existe com base no ID fornecido
            if (isset($data['id'])) {
                // Se o ID do usuário estiver definido, atualiza o usuário
                $query = "UPDATE clientes SET nome = :nome, cidade_nome = :cidade_nome WHERE id = :id";
            } else {
                // Se o ID do usuário não estiver definido, cria um novo usuário
                $query = "INSERT INTO clientes (nome, cidade_nome) VALUES (:nome, :cidade_nome)";
            }
    
            // Prepara a consulta
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':nome', $data['nome'], PDO::PARAM_STR);
            $statement->bindParam(':cidade_nome', $data['cidade_nome'], PDO::PARAM_STR);
            
            // Se for uma atualização, vincula também o ID
            if (isset($data['id'])) {
                $statement->bindParam(':id', $data['id'], PDO::PARAM_INT);
            }
    
            // Executa a consulta
            $statement->execute();
    
            // Retorna o ID e o nome do usuário criado ou atualizado
            $id = isset($data['id']) ? $data['id'] : $this->pdo->lastInsertId();
            $nome = $data['nome'];
            
            return ['id' => $id, 'nome' => $nome];
            
        } catch (PDOException $e) {
            // Captura e exibe qualquer exceção ocorrida durante a consulta
            die("Erro ao criar ou atualizar usuário no banco de dados: " . $e->getMessage());
        }
    }


    public function delete($id) {
        try {
            // Query SQL para excluir o usuário com o ID fornecido
            $query = "DELETE FROM clientes WHERE id = :id";
    
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