<?php

namespace App\Model;

use App\Model\Database;
use App\Model\SQL\ACCOUNTS_SQL;
use App\Util\DateUtil;
use App\Util\MessageUtil;
use App\Util\ValidationUtil;
use PDO;

class Accounts extends Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = parent::returnConnection();
    }

    public function save(array $data, int $id) : bool
    {

        $stmt = $this->conn->prepare(ACCOUNTS_SQL::VERIFY_ACCOUNTS());

        $stmt->execute([
            $data['account'],
            $data['bank']
        ]);
  
        $ret = $stmt->rowCount() == 0;


        if ($ret) {
            $stmt = $this->conn->prepare(ACCOUNTS_SQL::SAVE());

            $stmt->execute([
                $data['bank'],
                $data['balance'],
                $data['account'],
                $id,
                DateUtil::currentDateTime(),
            ]);

            return $this->conn->lastInsertId() > 0 ? true : false;
        }

        return $ret;
    }

    public function find(mixed $auth) : array
    {
        $stmt = $this->conn->prepare(ACCOUNTS_SQL::FIND());

        $stmt->execute(
            [
                $auth['id']
            ]
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAccountById($id, array $auth) : array | bool
    {
        $stmt = $this->conn->prepare(ACCOUNTS_SQL::GET_ACCOUNT_BY_ID());

        $stmt->execute(
            [
                $auth['id'],
                $id
            ]
        );

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
