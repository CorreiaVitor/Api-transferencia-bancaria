<?php

namespace App\Service;

use App\Http\JWT;
use App\Model\Auth;
use App\Util\MessageUtil;
use App\Util\ValidationUtil;
use PDOException;

class AuthService
{

    private $model;

    public function __construct()
    {
        $this->model = new Auth;
    }

    public function auth(array $data): string | array | bool
    {
        try {

            $fields = ValidationUtil::validateFields(
                [
                    'email' => $data['email'],
                    'password' => $data['password']
                ]
            );

            $user_data = $this->model->authetication($fields);

            if (!$user_data) return false;

            $password = ValidationUtil::passwordVerify($fields['password'], $user_data['password']);

            if (!$password) return false;

            $token = JWT::token(
                [
                    'id' => $user_data['person_id'],
                    'name' => $user_data['first_name'],
                    'email' => $user_data['email']
                    #'iat' => time()
                ]
            );

            return $token;
        } catch (PDOException $ex) {
            return ValidationUtil::errorBD($ex->errorInfo);
        } catch (\Exception $ex) {
            return MessageUtil::error($ex->getMessage());
        }
    }
}
