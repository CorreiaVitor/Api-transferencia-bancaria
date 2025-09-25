<?php

namespace App\Util;

class MessageUtil
{
    public static function dbError(string $msg) : array
    {
        return ["dbError" => true, "message" => $msg];
    }

    public static function success(string | array $msg) : array
    {
        return ["error" => false, "success" => true, "message" => $msg];
    }

    public static function successJwt(string $jwt) : array
    {
        return ["error" => false, "success" => true, "message" => $jwt];
    }

    public static function error(string $msg) : array
    {
        return ["error" => true, "success" => false, "message" => $msg];
    }

    public static function unauthorized(string $msg) : array
    {
        return ["error" => true, "success" => false, "message" => $msg];
    }

}