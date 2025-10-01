<?php

namespace App\Controller;

use App\Http\Request;
use App\Http\Response;
use App\Model\BankTransfer;
use App\Service\BankTransferService;
use App\Util\MessageUtil;

class BankTransferController
{

    private $service;

    public function __construct()
    {
        $this->service = new BankTransferService;
    }

    public function Transfers(): mixed
    {
        //Dados da requisição
        $body = Request::body();

        //id do usuário vem pelo jwt
        $user_id = Request::authorization()['id'];

        $service = $this->service->moneyTransfer($user_id, $body);

        if (isset($service['error']))
            return Response::json($service, 400);

        elseif (isset($service['dbError']))
            return Response::json($service, 500);

        return Response::json(
            MessageUtil::success('Bank transaction completed successfully.'),
            201
        );
    }

    public function index(): mixed
    {
        $authentication = Request::authorization();

        $service = $this->service->index($authentication);

        if (isset($service['error']))
            return Response::json($service, 400);

        elseif (isset($service['unauthorized']))
            return Response::json($service, 401);

        elseif (isset($service['dbError']))
            return Response::json($service, 500);

        return Response::json($service);
    }

    public function show(array $data)
    {
        $authentication = Request::authorization();
        $id = intval($data[0]);

        $service = $this->service->show($authentication, $id);

        if (isset($service['error']))
            return Response::json($service, 400);

        elseif (isset($service['unauthorized']))
            return Response::json($service, 401);

        elseif (isset($service['dbError']))
            return Response::json($service, 500);

        return Response::json($service);
    }
}
