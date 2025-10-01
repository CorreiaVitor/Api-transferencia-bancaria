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

    public static function LIST_USER_TRANSFERS() : string 
    {
        $sql = "SELECT 
                    transfer_id,
                    from_user.first_name as sender_name,
                    from_account.bank_name as from_bank_name,
                    amount,
                    to_user.first_name as receiver_name,
                    to_account.bank_name as to_bank_name
                FROM
                    tb_transactions
                        INNER JOIN
                    tb_bank_account as from_account ON tb_transactions.from_account_id = from_account.bank_id
                        INNER JOIN 
                    tb_bank_account as to_account ON tb_transactions.to_account_id = to_account.bank_id
                        LEFT JOIN 
                    tb_user as from_user ON from_account.tb_user_person_id = from_user.person_id
                        LEFT JOIN 
                    tb_user as to_user ON to_account.tb_user_person_id = to_user.person_id
                        WHERE from_user.person_id = ?";

        return $sql;
    }

    public static function GET_TRANSFERS_BY_ID() : string 
    {
        $sql = "SELECT 
                    from_user.first_name as sender_name,
                    from_account.bank_name as from_bank_name,
                    amount,
                    to_user.first_name as receiver_name,
                    to_account.bank_name as to_bank_name
                FROM
                    tb_transactions
                        INNER JOIN
                    tb_bank_account as from_account ON tb_transactions.from_account_id = from_account.bank_id
                        INNER JOIN 
                    tb_bank_account as to_account ON tb_transactions.to_account_id = to_account.bank_id
                        LEFT JOIN 
                    tb_user as from_user ON from_account.tb_user_person_id = from_user.person_id
                        LEFT JOIN 
                    tb_user as to_user ON to_account.tb_user_person_id = to_user.person_id
                        WHERE from_user.person_id = ? AND transfer_id = ?";

        return $sql;
    }
}
