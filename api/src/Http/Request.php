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

    public static function authorization(): mixed
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization']))
            return MessageUtil::error("Sorry, no authorization header provided");

        $headersPatials = explode(' ', $headers['Authorization']);

        if (count($headersPatials) !== 2)
            return MessageUtil::error("Please, provide a valid authorization header.");


        return JWT::verifyToken($headersPatials[1]);
    }
}
