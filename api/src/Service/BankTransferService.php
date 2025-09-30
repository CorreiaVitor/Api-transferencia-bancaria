<?php

namespace App\Service;

use App\Model\BankTransfer;
use App\Util\MessageUtil;
use App\Util\ValidationUtil;
use PDOException;

class BankTransferService
{
    private $model;

    public function __construct()
    {
        $this->model = new BankTransfer;
    }

    public function moneyTransfer(int $user_id, array $data): mixed
    {
        try {

            $fields = ValidationUtil::validateFields([
                'bank' => $data['bank'],
                'account' => $data['account'],
                'amount' => $data['amount'],
            ]);

            $transfer = $this->model->moneyTransfer($user_id, $fields);

            return $transfer;
        } catch (PDOException $ex) {
            return ValidationUtil::errorBD($ex->errorInfo);
        } catch (\Exception $ex) {
            return MessageUtil::error($ex->getMessage());
        }
    }

    public function index(array $auth)
    {
        try {

            if (!$auth)
                return MessageUtil::unauthorized('Please, login to access this resource.');

            return $this->model->listUserTransfers($auth);
        } catch (PDOException $ex) {
            return ValidationUtil::errorBD($ex->errorInfo);
        } catch (\Exception $ex) {
            return MessageUtil::error($ex->getMessage());
        }
    }
}
