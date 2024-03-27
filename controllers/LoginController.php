<?php

namespace api\controllers;
use api\models\User;

class LoginController
{
    private $users;

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);


        if (isset($data['email']) && isset($data['senha'])) {
            $usersModel = new User();
            $user = $usersModel->getUser($data['email'], $data['senha']);
        
            $login = false;
        
            if ($user && $user['email'] === $data['email'] && $user['senha'] == $data['senha']) {
                $token = bin2hex(random_bytes(16));
                $login = true;
                $userModel = new User();
                $userModel->setToken($user['id'], $token, date('Y-m-d H:i:s'));
                echo json_encode($token);
            }
        
            if (!$login) {
                echo json_encode(['error' => 'Credenciais inválidas']);
            }
        } else {
            echo json_encode(['error' => 'Por favor, forneça um email e uma senha']);
            exit();
        }
    }
}
?>
