<?php

namespace App\Model\SQL;

class USER_SQL
{
    public static function SAVE(): string
    {
        $sql = 'INSERT INTO tb_user 
                    (first_name, last_name, email, password, create_at) 
                VALUES 
                    (?, ?, ?, ?, ?)';

        return $sql;
    }

    public static function VERIFY_USER()
    {
        $sql = "SELECT email FROM tb_user WHERE email = ?";

        return $sql;
    }
}
