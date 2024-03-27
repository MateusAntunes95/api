<?php

namespace api\controllers;

use api\models\Cliente;

require_once 'models/Cliente.php';

class ClienteController
{
    public function index() {
        try {
            $clientes = new Cliente();
            $clientes = $clientes->getAll();

            echo json_encode($clientes);

        } catch (\Throwable $th) {
            echo $th;
        }
    }
    
    public function show($id) {
        try {
            $cliente = new Cliente();
            $cliente = $cliente->getById($id);
            
            echo json_encode($cliente);
        } catch (\Throwable $th) {
            echo $th;
        }
    }
    
    public function store() {
        try {
            $request = json_decode(file_get_contents('php://input'), true);

            $cliente = new Cliente();
            $cliente = $cliente->createOrUpdate($request);

            echo json_encode($cliente);
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function update() {
        $request = json_decode(file_get_contents('php://input'), true);

        $cliente = new Cliente();
        $cliente = $cliente->createOrUpdate($request);

        echo json_encode($cliente);
    }

    public function destroy($id) {
        try {
            $cliente = new Cliente();
            $cliente = $cliente->delete($id);

            echo 'Cliente deletado com sucesso';
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}

?>
