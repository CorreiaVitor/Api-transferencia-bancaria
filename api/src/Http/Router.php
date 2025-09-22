<?php

namespace App\Http;

class Routes
{

    private static array $routers = [];

    public static function get(string $path, string $action): void
    {
        self::$routers[] =
            [
                "path" => $path,
                "action" => $action,
                "method" => "GET"
            ];
    }

    public static function post(string $path, $action): void
    {
        self::$routers[] =
            [
                "path" => $path,
                "action" => $action,
                "method" => "POST"
            ];
    }

    public static function put(string $path, string $action): void
    {
        self::$routers[] = [
            
            "path" => $path,
            "action" => $action,
            "method" => "PUT",
        ];
    }

    public static function delete(string $path, string $action): void
    {
        self::$routers[] = [
            "path" => $path,
            "action" => $action,
            "method" => "DELETE",
        ];
    }

    public static function routes() : array
    {
        return self::$routers;    
    }
}
