<?php

namespace App\Model;

use App\Model\SQL\AUTHENTICATION_SQL;
use PDO;

class Auth extends Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = parent::returnConnection();
    }

    public function authetication(array $data): mixed
    {
        $stmt = $this->conn->prepare(AUTHENTICATION_SQL::AUTH());

        $stmt->execute(
            [
                $data['email']
            ]
        );

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}