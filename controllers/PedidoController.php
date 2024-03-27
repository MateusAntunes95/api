<?php

namespace api\controllers;

use api\models\Pedido;

require_once 'models/Pedido.php';

class PedidoController
{
    public function index() {
        try {
            $pedidos = new Pedido();
            $pedidos = $pedidos->getAll();

            echo json_encode($pedidos);

        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function show($id) {
        try {
            $pedido = new Pedido();
            $pedido = $pedido->getById($id);

            echo json_encode($pedido);
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function store() {
        try {
            $request = json_decode(file_get_contents('php://input'), true);

            $pedido = new Pedido();
            $pedido = $pedido->createOrUpdate($request);

            echo json_encode($pedido);
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function update() {
        $request = json_decode(file_get_contents('php://input'), true);

        $pedido = new Pedido();
        $pedido = $pedido->createOrUpdate($request);

        echo json_encode($pedido);
    }

    public function destroy($id) {
        try {
            $pedido = new Pedido();
            $pedido = $pedido->delete($id);

            echo 'Pedido deletado com sucesso';
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}
?>
