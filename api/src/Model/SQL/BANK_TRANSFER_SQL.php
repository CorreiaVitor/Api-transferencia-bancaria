<?php

namespace App\Model\SQL;

class BANK_TRANSFER_SQL
{
    public static function FETCH_SENDER_ACCOUNT_DETAILS(): string
    {
        $sql = 'SELECT 
                    bank_id, balance, tb_user_person_id 
                FROM 
                    tb_bank_account 
                WHERE 
                   tb_user_person_id = ?';

        return $sql;
    }

    public static function FETCH_RECEIVER_ACCOUNT_DETAILS(): string
    {
        $sql = 'SELECT 
                    bank_id, balance, tb_user_person_id 
                FROM 
                    tb_bank_account 
                WHERE 
                    account_number = ? 
                        AND bank_name = ?';
        return $sql;
    }

    public static function UPDATE_SENDER_BALANCE(): string
    {
        $sql = "UPDATE tb_bank_account 
                SET 
                    balance = balance - ?
                WHERE
                    bank_id = ?
                    and tb_user_person_id = ?";

        return $sql;
    }

    public static function UPDATE_RECEIVER_BALANCE(): string
    {
        $sql = "UPDATE tb_bank_account 
                SET 
                    balance = balance + ?
                WHERE
                    bank_id = ? 
                    and tb_user_person_id = ?";

        return $sql;
    }

    public static function MAKE_TRANSFER() : string
    {
        $sql = 'INSERT 
                INTO 
                    tb_transactions (amount, from_account_id, to_account_id, transfer_date_time) 
                VALUES 
                    (?, ?, ?, ?)';
        
        return $sql;
    }
}
