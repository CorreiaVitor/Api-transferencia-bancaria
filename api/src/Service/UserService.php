<?php

namespace App\Service;

use App\Model\User;
use App\Util\MessageUtil;
use App\Util\ValidationUtil;
use PDOException;

class UserService
{

    private $model;

    public function __construct()
    {
        $this->model = new User;
    }

    public function create(array $data): mixed
    {
        try {

            $fields = ValidationUtil::validateFields([
                'name' => $data['first_name'],
                'surname' => $data['last_name'],
                'email' => $data['email'],
                'password' => $data['password']
            ]);

            $user = $this->model->save($fields);

            if (!$user)
                return MessageUtil::error('Email is already in use.');

            return $user;
        } catch (PDOException $ex) {
            return ValidationUtil::errorBD($ex->errorInfo);
        } catch (\Exception $ex) {
            return MessageUtil::error($ex->getMessage());
        }
    }
}
