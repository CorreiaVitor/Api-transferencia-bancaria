<?php

namespace App\Util;

class ValidationUtil
{
    public static function validateFields(array $fields)
    {
        foreach ($fields as $key => $field) {

            $trim = trim($field);

            if (empty($field)) {
                throw new \Exception("The field {$key} is required");
            }

            $fields[$key] = $trim;
        }

        //Se vim com a chave first_name significa que é um cadastro
        if (isset($fields['first_name'])) {
            $hasUppercase = preg_match('/[A-Z]/', $fields['password']);

            // No momento, apenas duas validações estão sendo feitas, mas outras serão adicionadas futuramente.
            if (strlen($fields['password']) < 8) {
                throw new \Exception("Password must be at least 8 characters long. ");
            } elseif (!$hasUppercase) {
                throw new \Exception("The password must contain at least one uppercase letter.");
            }
        }

        return $fields;
    }

    public static function passwordHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function passwordVerify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function errorBD($code)
    {
        $msg = "";

        switch ($code) {
            case '2013':
                $msg = "Database connection lost while executing the query.";
                break;
            default:
                $msg = "Database error: {$code[1]}";
                break;
        }

        return MessageUtil::dbError($msg);
    }
}