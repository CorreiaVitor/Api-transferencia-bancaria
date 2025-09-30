<?php

namespace App\Model;

use App\Model\SQL\BANK_TRANSFER_SQL;
use App\Util\DateUtil;
use App\Util\MessageUtil;
use Exception;
use PDO;



class BankTransfer extends Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = self::returnConnection();
    }

    public function fetchSenderAccountDetails(int $user_id): array | bool
    {
        // Detalha a conta do usuário que irá transferir o valor monetário
        $stmt = $this->conn->prepare(BANK_TRANSFER_SQL::FETCH_SENDER_ACCOUNT_DETAILS());
        $stmt->bindValue(1, $user_id, PDO::PARAM_INT);

        $stmt->execute();

        $user_from = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user_from;
    }

    public function fetchReceiverAccountDetails(array $data): array | bool
    {
        // Busca a conta que vai receber o valor monetário (a conta é encontrada pelo número da conta e o nome do banco).
        $stmt = $this->conn->prepare(BANK_TRANSFER_SQL::FETCH_RECEIVER_ACCOUNT_DETAILS());

        $stmt->bindValue(1, $data['account'], PDO::PARAM_STR);
        $stmt->bindValue(2, $data['bank'], PDO::PARAM_STR);

        $stmt->execute();

        $user_to = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user_to;
    }

    public function updateSenderBalance(array $data, array $user_to, int $user_id)
    {
        // Faz a alteração na conta do usuário que envia o valor monetário.
        $stmt = $this->conn->prepare(BANK_TRANSFER_SQL::UPDATE_SENDER_BALANCE());

        $stmt->bindValue(1, $data['amount']);
        $stmt->bindValue(2, $user_to['bank_id'], PDO::PARAM_INT);
        $stmt->bindValue(3, $user_id, PDO::PARAM_INT);

        $stmt->execute();

        $ret = $stmt->rowCount();

        return $ret;
    }

    public function updateReceiverBalance(array $data, $user_from)
    {
        // Faz a alteração na conta do usuário que envia o valor monetário.
        $stmt = $this->conn->prepare(BANK_TRANSFER_SQL::UPDATE_RECEIVER_BALANCE());

        $stmt->bindValue(1, $data['amount']);
        $stmt->bindValue(2, $user_from['bank_id'], PDO::PARAM_INT);
        $stmt->bindValue(3, $user_from['tb_user_person_id'], PDO::PARAM_INT);

        $stmt->execute();

        $ret = $stmt->rowCount();
        
        return $ret;
    }

    public function MoneyTransfer(int $user_id, array $data)
    {

        $user_from = $this->fetchSenderAccountDetails($user_id);

        // Verifica se o valor monetário é menor que o saldo vindo do banco de dados.
        if ($user_from['balance'] < $data['amount'])
            throw new Exception("Your account balance is low");

        try {

            // Inicia a transação.
            $this->conn->beginTransaction();

            // Busca a conta que vai receber o valor monetário (a conta é encontrada pelo número da conta e o nome do banco).
            $user_to = $this->fetchReceiverAccountDetails($data);

            // Verifica se a conta existe.
            if (!$user_to)
                throw new Exception("Bank account not found.");

            // Efetua a transferência no banco de dados.
            $stmt = $this->conn->prepare(BANK_TRANSFER_SQL::MAKE_TRANSFER());

            $i = 1;
            $stmt->bindValue($i++, $data['amount']);
            $stmt->bindValue($i++, $user_from['bank_id']);
            $stmt->bindValue($i++, $user_to['bank_id']);
            $stmt->bindValue($i++, DateUtil::currentDateTime());

            $transfer = $stmt->execute();

            // Caso a transação dê errado.
            if (!$transfer)
                throw new Exception("We couldn’t complete your bank transfer.");

            $update_sender_balance = $this->updateSenderBalance($data, $user_from, $user_id);

            if (!$update_sender_balance)
                throw new \Exception("The bank transaction failed. Please try again later.");

            $update_receiver_balance = $this->updateReceiverBalance($data, $user_to);

            if (!$update_receiver_balance)
                throw new \Exception("The bank transaction failed. Please try again again.");

            // Finaliza a transação com um commit.
            $this->conn->commit();

            return 'Bank transaction completed successfully.';
        } catch (Exception $ex) {
            // Se algo der errado, desfaz toda a operação sem alterar nada na conta do usuário.
            $this->conn->rollBack();
            return MessageUtil::error($ex->getMessage());
        }
    }
}
