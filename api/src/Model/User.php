<?php

namespace App\Model;

use App\Model\SQL\USER_SQL;
use App\Util\DateUtil;
use App\Util\ValidationUtil;

class User extends Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = parent::returnConnection();
    }

    public function save(array $data): bool
    {

        $stmt = $this->conn->prepare(USER_SQL::VERIFY_USER());

        $stmt->execute([
            $data['email']
        ]);

        $ret = $stmt->rowCount() == 0;

        if ($ret) {

            $stmt = $this->conn->prepare(USER_SQL::SAVE());

            $stmt->execute([
                $data['name'],
                $data['surname'],
                $data['email'],
                ValidationUtil::passwordHash($data['password']),
                DateUtil::currentDateTime()
            ]);

            return $this->conn->lastInsertId() > 0;
        }

        return $ret;
    }
}
