<?php

namespace App\Model\SQL;

class ACCOUNTS_SQL
{
    public static function SAVE(): string
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

    public static function FIND()
    {
        $sql = "SELECT 
                    bank_id, bank_name, balance, account_number, first_name
                FROM
                    tb_bank_account
                LEFT JOIN
                    tb_user ON tb_bank_account.tb_user_person_id = tb_user.person_id
                WHERE
                    tb_user_person_id = ?";

        return $sql;
    }

    public static function GET_ACCOUNT_BY_ID()
    {
        $sql = "SELECT 
                    bank_id, bank_name, balance, account_number, first_name
                FROM
                    tb_bank_account
                LEFT JOIN
                    tb_user ON tb_bank_account.tb_user_person_id = tb_user.person_id
                WHERE
                    tb_user_person_id = ? and bank_id = ?";

        return $sql;
    }

    public static function DELETE()
    {
        $sql = "DELETE FROM tb_bank_account WHERE bank_id = ?";

        return $sql;
    }
}
