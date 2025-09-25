<?php

namespace App\Controller;
use App\Http\Request;
use App\Http\Response;
use App\Service\AuthService;
use App\Service\UserService;
use App\Util\MessageUtil;

class AuthController
{

    private $service;

    public function __construct()
    {
        $this->service = new AuthService;
    }

    public function login()
    {
        $body = Request::body();

        $service = $this->service->auth($body);

        if (isset($service['error']))
            return Response::json(MessageUtil::error($service['message']), 400);

        elseif (isset($service['dbError']))
            return Response::json(MessageUtil::dbError($service['message']), 500);

        elseif (!$service)
            return Response::json(MessageUtil::error('Invalid login credentials.'), 400);


        Response::json(MessageUtil::success($service), 200);
    }
}