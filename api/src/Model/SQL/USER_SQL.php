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

    public static function SHOW()
    {
        $sql = "SELECT 
                    person_id, first_name, last_name, email 
                FROM 
                    tb_user 
                WHERE 
                    person_id = ?";
        
        return $sql;
    }

    public static function UPDATE()
    {
        $sql = "UPDATE 
                    tb_user 
                SET 
                    first_name = ?, last_name = ?, email = ?, password = ?, update_at = ? 
                WHERE 
                    person_id = ?";
        
        return $sql;
    }

    public static function DELETE()
    {
        $sql = "DELETE FROM tb_user WHERE person_id =?";

        return $sql;
    }
}
