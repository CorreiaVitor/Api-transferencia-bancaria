<?php

namespace App\Http;

class Router
{

    private static $route;

    public static function get(string $route, $handler): void
    {
        self::$route[] = [
            "path" => $route,
            "controller" => (!is_string($handler)) ? $handler : strstr($handler, ':', true),
            "action" => (!is_string($handler)) ?: str_replace(':', '', strstr($handler, ':', false)),
            "method" => 'GET'
        ];
    }

    public static function post(string $route, $handler): void
    {
        self::$route[] = [
            "path" => $route,
            "controller" => (!is_string($handler)) ? $handler : strstr($handler, ':', true),
            "action" => (!is_string($handler)) ?: str_replace(':', '', strstr($handler, ':', false)),
            "method" => 'POST'
        ];
    }

    public static function put(string $route, $handler): void
    {
        self::$route[] = [
            "path" => $route,
            "controller" => (!is_string($handler)) ? $handler : strstr($handler, ':', true),
            "action" => (!is_string($handler)) ?: str_replace(':', '', strstr($handler, ':', false)),
            "method" => 'PUT'
        ];
    }

    public static function delete(string $route, mixed $handler): void
    {
        self::$route[] = [
            "path" => $route,
            "controller" => (!is_string($handler)) ? $handler : strstr($handler, ':', true),
            "action" => (!is_string($handler)) ?: str_replace(':', '', strstr($handler, ':', false)),
            "method" => 'DELETE'
        ];
    }

    public static function routes(): array
    {
        return self::$route;
    }
}
