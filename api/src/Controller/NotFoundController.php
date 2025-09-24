<?php

namespace App\Controller;
use App\Http\Response;

class NotFoundController
{
    public static function index()
    {
        Response::json(
            [
                "error" => true,
                "success" => false,
                "message" => "Route not found."
            ],
            404
        );
    }
}