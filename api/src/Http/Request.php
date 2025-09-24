<?php

namespace App\Http;

use App\Util\MessageUtil;

class Request
{

    public static function methodHttp(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

}