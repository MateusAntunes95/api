<?php

namespace api\controllers;

use api\models\User;

require_once 'models/User.php';

class UserController
{
    public function index() {
        try {
            $users = new User();
            $users = $users->getAll();

            echo json_encode($users);

        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function show($id) {
        try {
            $user = new User();
            $user = $user->getById($id);

            echo json_encode($user);
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function store() {
        try {
            $request = json_decode(file_get_contents('php://input'), true);

            $user = new User();
            $user = $user->createOrUpdate($request);

            echo json_encode($user);
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function update() {
        $request = json_decode(file_get_contents('php://input'), true);

        $user = new User();
        $user = $user->createOrUpdate($request);

        echo json_encode($user);
    }

    public function destroy($id) {
        try {
            $user = new User();
            $user = $user->delete($id);

            echo 'usuário deletado com sucesso';
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}

?>
