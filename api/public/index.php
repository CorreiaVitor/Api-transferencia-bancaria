<?php

use App\Core\Core;
use App\Http\Router;
use Dotenv\Dotenv;

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/src/routes/main.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

Core::dispatch(Router::routes());

