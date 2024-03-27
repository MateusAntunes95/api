<?php

namespace api\models;

require_once __DIR__ . '/../config/db_connect.php';

use api\DBConnection;
use PDO;
use PDOException;

class User
{
    protected $pdo;

    public function __construct() {
        $db = DBConnection::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function getAll() {
        try {
            $query = "SELECT * FROM users";
        
            $statement = $this->pdo->query($query);
            
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $users;
        
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        
            
        } catch (PDOException $e) {
            die("Erro ao recuperar usuários do banco de dados: " . $e->getMessage());
        }
    }

    public function getById($id) {
        try {
            $query = "SELECT * FROM users WHERE id = :id";
        
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            
            $statement->execute();
            
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            
            return $user;
            
        } catch (PDOException $e) {
            die("Erro ao recuperar cliente do banco de dados: " . $e->getMessage());
        }
    }

    public function createOrUpdate($data) {
        try {

            if (isset($data['senha'])) {
                $data['senha'] = md5($data['senha']);
            }

            if (isset($data['id'])) {
                $query = "UPDATE users SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
            } else {
                $query = "INSERT INTO users (nome, email, senha) VALUES (:nome, :email, :senha)";
            }
    
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':nome', $data['nome'], PDO::PARAM_STR);
            $statement->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $statement->bindParam(':senha', $data['senha'], PDO::PARAM_STR);
            
            if (isset($data['id'])) {
                $statement->bindParam(':id', $data['id'], PDO::PARAM_INT);
            }
    
            $statement->execute();
    
            $userId = isset($data['id']) ? $data['id'] : $this->pdo->lastInsertId();
            $usernome = $data['nome'];
            
            return ['id' => $userId, 'nome' => $usernome];
            
        } catch (PDOException $e) {
            die("Erro ao criar ou atualizar usuário no banco de dados: " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM users WHERE id = :id";
    
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            
            $statement->execute();
            
            return true;
            
        } catch (PDOException $e) {
            die("Erro ao excluir usuário do banco de dados: " . $e->getMessage());
        }
    }
    
    public function getUser($email, $senha) {
        try {
            $query = "SELECT * FROM users WHERE email = :email AND senha = :senha";

            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
            $statement->execute();
    
            $user = $statement->fetch(PDO::FETCH_ASSOC);
    
            return $user ? $user : null;
            
        } catch (PDOException $e) {
            die("Erro ao recuperar emails e senhas: " . $e->getMessage());
        }
    }

    public function setToken($userId, $token, $expiration) {
        try {
            $query = "UPDATE users SET token = :token, expiracao_token = :expiration WHERE id = :id";
        
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':token', $token, PDO::PARAM_STR);
            $statement->bindParam(':expiration', $expiration, PDO::PARAM_STR);
            $statement->bindParam(':id', $userId, PDO::PARAM_INT);
            $statement->execute();
            
            return true;
        } catch (PDOException $e) {
            die("Erro ao definir o token do usuário: " . $e->getMessage());
        }
    }

    public function getUserByToken($token) {
        try {
            $query = "SELECT * FROM users WHERE token = :token";
    
            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':token', $token, PDO::PARAM_STR);
            $statement->execute();
    
            $user = $statement->fetch(PDO::FETCH_ASSOC);
    
            return $user ? $user : null; // Retorna o usuário encontrado ou null se nenhum usuário corresponder ao token
    
        } catch (PDOException $e) {
            die("Erro ao buscar usuário pelo token: " . $e->getMessage());
        }
    }
    
}
?>
