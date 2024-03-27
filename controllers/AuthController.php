<?php

namespace api\controllers;

use api\models\User;

class AuthController
{
    public function auth()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authorizationHeader = $headers['Authorization'];
            list($tokenType, $token) = explode(' ', $authorizationHeader);
            if ($tokenType === 'Bearer') {
               return $this->validateToken($token);
            }
        }

        return false;
    }

    public function validateToken($token)
    {
        $user = new User();

        $user = $user->getUserByToken($token);

        if ($user) {
            $expirationDate = strtotime($user['expiracao_token']);
            
            $currentDate = time();
            
            $differenceInSeconds = $expirationDate - $currentDate;
            
            $differenceInHours = $differenceInSeconds / 3600;
            
            if ($differenceInHours > 3) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
