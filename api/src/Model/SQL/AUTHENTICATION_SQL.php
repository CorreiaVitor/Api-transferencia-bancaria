<?php

namespace App\Model\SQL;

class AUTHENTICATION_SQL
{
    public static function AUTH()
    {
        $sql = "SELECT person_id, first_name, email, password FROM tb_user WHERE email = ?";

        return $sql;
    }
}