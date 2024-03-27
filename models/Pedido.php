<?php

namespace api\models;

require_once __DIR__ . '/../config/db_connect.php';

use api\DBConnection;
use PDO;
use PDOException;

class Pedido
{
    protected $pdo;

    public function __construct()
    {
        $db = DBConnection::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function getAll()
    {
        try {
            $query = "SELECT pedidos.cliente_id as CLIENTE_ID,
                             produtos.id as PRODUTO_ID,
                             produtos.vlrunit as VLRUNIT,
                             pedidos.quantidade as QUANTIDADE
                      FROM pedidos
                      INNER JOIN produtos ON pedidos.produto_id = produtos.id
                      INNER JOIN clientes ON pedidos.cliente_id = clientes.id";

            $statement = $this->pdo->query($query);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            $pedidosFormatados = [];
            foreach ($result as $row) {
                $clienteId = $row['CLIENTE_ID'];
                if (!isset($pedidosFormatados[$clienteId])) {
                    $pedidosFormatados[$clienteId] = [
                        'CLIENTE_ID' => $clienteId,
                        'itens' => [],
                    ];
                }
                $pedidosFormatados[$clienteId]['itens'][] = [
                    'PRODUTO_ID' => $row['PRODUTO_ID'],
                    'VLRUNIT' => $row['VLRUNIT'],
                    'QUANTIDADE' => $row['QUANTIDADE'],
                ];
            }

            return array_values($pedidosFormatados);
        } catch (PDOException $e) {
            die('Erro ao recuperar pedidos formatados: ' . $e->getMessage());
        }
    }

    public function getById($id)
    {
        try {
            $query = "SELECT pedidos.cliente_id as CLIENTE_ID,
                             produtos.id as PRODUTO_ID,
                             produtos.vlrunit as VLRUNIT,
                             pedidos.quantidade as QUANTIDADE
                      FROM pedidos
                      INNER JOIN produtos ON pedidos.produto_id = produtos.id
                      INNER JOIN clientes ON pedidos.cliente_id = clientes.id
                      WHERE pedidos.id = :id";

            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);

            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            $pedidosFormatados = [];
            foreach ($result as $row) {
                $clienteId = $row['CLIENTE_ID'];
                if (!isset($pedidosFormatados[$clienteId])) {
                    $pedidosFormatados[$clienteId] = [
                        'CLIENTE_ID' => $clienteId,
                        'itens' => [],
                    ];
                }
                $pedidosFormatados[$clienteId]['itens'][] = [
                    'PRODUTO_ID' => $row['PRODUTO_ID'],
                    'VLRUNIT' => $row['VLRUNIT'],
                    'QUANTIDADE' => $row['QUANTIDADE'],
                ];
            }

            return array_values($pedidosFormatados);
        } catch (PDOException $e) {
            die('Erro ao recuperar pedidos formatados: ' . $e->getMessage());
        }
    }

    public function createOrUpdate($data)
    {
        try {
            $clienteExists = $this->checkIfExists('clientes', $data['cliente_id']);
            $produtoExists = $this->checkIfExists('produtos', $data['produto_id']);

            if ($clienteExists && $produtoExists) {
                if (isset($data['id'])) {
                    $query = 'UPDATE pedidos SET quantidade = :quantidade WHERE cliente_id = :cliente_id AND produto_id = :produto_id';
                } else {
                    $query = 'INSERT INTO pedidos (cliente_id, produto_id, quantidade) VALUES (:cliente_id, :produto_id, :quantidade)';
                }

                $statement = $this->pdo->prepare($query);
                $statement->bindParam(':cliente_id', $data['cliente_id'], PDO::PARAM_INT);
                $statement->bindParam(':produto_id', $data['produto_id'], PDO::PARAM_INT);
                $statement->bindParam(':quantidade', $data['quantidade'], PDO::PARAM_INT);
                $statement->execute();

                return 'Pedido criado ou editado com sucesso';
            }
        } catch (PDOException $e) {
            die('Erro ao salvar ou atualizar pedidos: ' . $e->getMessage());
        }
    }

    private function checkIfExists($table, $id)
    {
        $query = "SELECT COUNT(*) FROM $table WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $count = $statement->fetchColumn();
        return $count > 0;
    }

    public function delete($id)
    {
        try {
            $query = 'DELETE FROM pedidos WHERE id = :id';

            $statement = $this->pdo->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);

            $statement->execute();

            return true;
        } catch (PDOException $e) {
            die('Erro ao excluir pedido do banco de dados: ' . $e->getMessage());
        }
    }
}
