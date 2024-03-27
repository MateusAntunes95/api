<?php

namespace api\controllers;

use api\models\Produto;

require_once 'models/Produto.php';



class ProdutoController
{
    public function index() {
        try {
            $produtos = new Produto();
            $produtos = $produtos->getAll();

            echo json_encode($produtos);

        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function show($id) {
        try {
            $produto = new Produto();
            $produto = $produto->getById($id);

            echo json_encode($produto);
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function store() {
        try {
            $request = json_decode(file_get_contents('php://input'), true);

            $produto = new Produto();
            $produto = $produto->createOrUpdate($request);

            echo json_encode($produto);
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function update() {
        $request = json_decode(file_get_contents('php://input'), true);

        $produto = new Produto();
        $produto = $produto->createOrUpdate($request);

        echo json_encode($produto);
    }

    public function destroy($id) {
        try {
            $produto = new Produto();
            $produto = $produto->delete($id);

            echo 'Produto deletado com sucesso';
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}
?>
