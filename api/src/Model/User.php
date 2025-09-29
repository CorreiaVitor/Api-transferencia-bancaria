<?php

namespace App\Model;

use App\Model\SQL\USER_SQL;
use App\Util\DateUtil;
use App\Util\ValidationUtil;
use PDO;

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

    public function find(array $data): array | bool
    {
        $stmt = $this->conn->prepare(USER_SQL::SHOW());

        $stmt->execute(
            [
                $data['id']
            ]
        );

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $data, mixed $authentication): bool
    {
        $stmt = $this->conn->prepare(USER_SQL::UPDATE());

        $stmt->execute(
            [
                $data['name'],
                $data['last_name'],
                $data['email'],
                ValidationUtil::passwordHash($data['password']),
                DateUtil::currentDateTime(),
                $authentication['id']
            ]
        );

        return $stmt->rowCount() > 0 ? true : false;
    }

    public function remove(mixed $authentication)
    {
        $stmt = $this->conn->prepare(USER_SQL::DELETE());

        $stmt->execute([
            $authentication['id']
        ]);

        return $stmt->rowCount() > 0 ? true : false;
    }
}
