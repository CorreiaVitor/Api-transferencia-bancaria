<?php

namespace App\Http;

use App\Util\MessageUtil;

class Request
{

    public static function methodHttp(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function body()
    {
        $json = json_decode(file_get_contents("php://input"), true) ?? [];

        $data = match (self::methodHttp()) {
            'GET' => $_GET,
            'POST', 'PUT', 'DELETE' => $json,
        };

        return $data;
    }

}