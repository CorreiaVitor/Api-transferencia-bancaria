<?php

namespace App\Controller;

use App\Http\Request;
use App\Http\Response;
use App\Service\UserService;
use App\Util\MessageUtil;

class UserController
{

    private $service;

    public function __construct()
    {
        $this->service = new UserService;
    }

    public function store()
    {
        $body = Request::body();

        $service = $this->service->create($body);

        if (isset($service['error']))
            return Response::json($service, 400);

        elseif (isset($service['dbError']))
            return Response::json($service, 500);

        return Response::json(
            MessageUtil::success('User registered successfully'),
            201
        );
    }

    public function show()
    {
        $authentication = Request::authorization();

        $service = $this->service->show($authentication);

        if (isset($service['error']))
            return Response::json($service, 400);

        elseif (isset($service['unauthorized']))
            return Response::json($service, 401);

        elseif (isset($service['dbError']))
            return Response::json($service, 500);

        return Response::json($service);
    }
}
