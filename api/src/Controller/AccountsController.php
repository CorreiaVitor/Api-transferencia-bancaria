<?php

namespace App\Controller;

use App\Http\Request;
use App\Http\Response;
use App\Service\AccountsService;
use App\Util\MessageUtil;

class AccountsController
{

    private $service;

    public function __construct()
    {
        $this->service = new AccountsService;
    }

    public function store()
    {
        $body = Request::body();
        $auth = Request::authorization();

        $service = $this->service->create($body, $auth);

        if (isset($service['error']))
            return Response::json($service, 400);

        elseif (isset($service['dbError']))
            return Response::json($service, 500);

        return Response::json(
            MessageUtil::success('Account registered successfully'),
            201
        );
    }
}
