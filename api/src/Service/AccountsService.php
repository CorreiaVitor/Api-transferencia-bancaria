<?php

namespace App\Service;

use App\Util\MessageUtil;
use App\Util\ValidationUtil;
use App\Model\Accounts;

use PDOException;


class AccountsService

{

    private $model;

    public function __construct()
    {
        $this->model = new Accounts;
    }

    public function create(array $data, mixed $auth) : mixed
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

    public function index(array $auth) : mixed
    {
        try {

            if (!$auth)
                return MessageUtil::unauthorized('Please, login to access this resource.');

            return $this->model->find($auth);
        } catch (PDOException $ex) {
            return ValidationUtil::errorBD($ex->errorInfo);
        } catch (\Exception $ex) {
            return MessageUtil::error($ex->getMessage());
        }
    }

    public function show(int $id, array $auth) : mixed
    {
        try {

            if (!$auth)
                return MessageUtil::unauthorized('Please, login to access this resource.');

            $account = $this->model->getAccountById($id, $auth);

            if (!$account)
                return MessageUtil::error('We couldn’t find your bank account.');

            return $account;
        } catch (PDOException $ex) {
            return ValidationUtil::errorBD($ex->errorInfo);
        } catch (\Exception $ex) {
            return MessageUtil::error($ex->getMessage());
        }
    }

    public function remove(array $auth, int $id)
    {
        try {

            if(!$auth)
                return MessageUtil::error('Please, login to access this resource.');

            $accounts = $this->model->remove($auth, $id);

            if (!$accounts) 
                return MessageUtil::error('Sorry, we could not delete your account.');

            return $accounts;
        } catch (PDOException $ex) {
            return ValidationUtil::errorBD($ex->errorInfo);
        } catch (\Exception $ex) {
            return MessageUtil::error($ex->getMessage());
        }
    }
}
