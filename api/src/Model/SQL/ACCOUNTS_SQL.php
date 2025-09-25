<?php

namespace App\Model\SQL;

class ACCOUNTS_SQL
{
    public static function SAVE() : string
    {
        $sql = 'INSERT INTO tb_bank_account
                    (bank_name, balance, account_number, tb_user_person_id, create_at) 
                VALUES 
                    (?, ?, ?, ?, ?)';   
        
        return $sql;
    }

     public static function VERIFY_ACCOUNTS() 
    {
        $sql = "SELECT bank_name, account_number FROM tb_bank_account WHERE account_number = ? and bank_name = ?";

        return $sql;
    }
}