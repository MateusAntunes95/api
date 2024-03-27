<?php


try {
    require_once __DIR__ . '/routes/routes.php';

} catch (\Throwable $th) {
    echo $th;
}

/*
require_once 'models/Pedido.php';

try {
    $userModel = new Pedido();
    $users = $userModel->getAll();
    print_r($users);
} catch (\Throwable $th) {

    echo $th;
}
use api\models\User;
use Cliente\Cliente;
use Produto\Produto;

require_once 'models/User.php';
require_once 'models/Produto.php';
require_once 'models/Cliente.php';

$data = [
    'id' => 1,
    'nome' => 'bonot',
    'email' => 'bonot@gmail.com',
    'senha' => '123'
];

$data2 = [
    'id' => 3,
    'nome' => 'hehe',
    'vlrunit' => '4.20',
];

$data3 = [
    'id' => 3,
    'nome' => 'Wesley',
    'cidade_nome' => 'Brusque',
];

$data4 = [
    'cliente_id' => 1,
    'produto_id' => 1,
    'quantidade' => 10,
];


*/
?>
