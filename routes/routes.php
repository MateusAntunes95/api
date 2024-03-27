<?php

use api\controllers\AuthController;
use api\controllers\ClienteController;
use api\controllers\ProdutoController;
use api\controllers\UserController;
use api\controllers\PedidoController;
use api\controllers\LoginController;

require __DIR__ . '/../controllers/ProdutoController.php';
require __DIR__ . '/../controllers/ClienteController.php';
require __DIR__ . '/../controllers/UserController.php';
require __DIR__ . '/../controllers/PedidoController.php';
require __DIR__ . '/../controllers/LoginController.php';
require __DIR__ . '/../controllers/AuthController.php';

$loginController = new LoginController();

if ($_SERVER['REQUEST_URI'] === '/api/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginController->login();
}

$auth = new AuthController();

if ($auth->auth()) {
    $produtoController = new ProdutoController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($_SERVER['REQUEST_URI'] === '/api/produtos') {
            try {
                $produtoController->index();
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        } elseif (preg_match('#^/api/produtos/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
            try {
                $produtoController->show($matches[1]);
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/produtos') {
        $produtoController->store();
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'PUT' &&  preg_match('#^/api/produtos/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
        $produtoController->update($matches[1]);
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('#^/api/produtos/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
        $produtoController->destroy($matches[1]);
    }
    
    $clienteController = new ClienteController();
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($_SERVER['REQUEST_URI'] === '/api/clientes') {
            try {
                $clienteController->index();
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        } elseif (preg_match('#^/api/clientes/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
            try {
                $clienteController->show($matches[1]);
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/clientes') {
        $clienteController->store();
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'PUT' &&  preg_match('#^/api/clientes/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
        $clienteController->update($matches[1]);
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('#^/api/clientes/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
        $clienteController->destroy($matches[1]);
    }
    
    $userController = new UserController();
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($_SERVER['REQUEST_URI'] === '/api/users') {
            try {
                $userController->index();
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        } elseif (preg_match('#^/api/users/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
            try {
                $userController->show($matches[1]);
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/users') {
        $userController->store();
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'PUT' &&  preg_match('#^/api/users/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
        $userController->update($matches[1]);
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('#^/api/users/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
        $userController->destroy($matches[1]);
    }
    
    $pedidoController = new PedidoController();
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($_SERVER['REQUEST_URI'] === '/api/pedidos/') {
            try {
                $pedidoController->index();
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        } elseif (preg_match('#^/api/pedidos/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
            try {
                $pedidoController->show($matches[1]);
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/pedidos') {
        $pedidoController->store();
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'PUT' &&  preg_match('#^/api/pedidos/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
        $pedidoController->update($matches[1]);
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('#^/api/pedidos/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
        $pedidoController->destroy($matches[1]);
    }
    
} elseif (!$_SERVER['REQUEST_URI'] === '/api/login') {
    echo json_encode('Não autorizado');
}

?>
