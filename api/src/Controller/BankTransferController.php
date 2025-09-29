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

    public function moneyTransfer() 
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

}