<?php

namespace App\Service;

use App\Model\Accounts;
use App\Util\MessageUtil;
use App\Util\Validation;
use App\Util\ValidationUtil;
use PDOException;

class AccountsService

{

    private $model;

    public function __construct()
    {
        $this->model = new Accounts;
    }

    public function create(array $data, mixed $auth)
    {
        try {

            $fields = ValidationUtil::validateFields([
                'bank' => $data['bank'],
                'balance' => $data['balance'],
                'account' => $data['account']
            ]);

            $accounts = $this->model->save($fields, $auth['id']);

            if (!$accounts)
                return MessageUtil::error('This bank account is already registered.');

            return $accounts;
        } catch (PDOException $ex) {
            return ValidationUtil::errorBD($ex->errorInfo);
        } catch (\Exception $ex) {
            return MessageUtil::error($ex->getMessage());
        }

    }
}
