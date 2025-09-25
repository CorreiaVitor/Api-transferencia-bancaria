<?php

namespace App\Model;

use App\Model\Database;
use App\Model\SQL\ACCOUNTS_SQL;
use App\Util\DateUtil;

class Accounts extends Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = parent::returnConnection();
    }

    public function save(array $data, int $id)
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
}
