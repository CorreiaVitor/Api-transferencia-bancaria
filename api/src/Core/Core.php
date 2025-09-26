<?php

//Roteador simples para despachar rotas. Ainda estou aprimorando meus conhecimentos e pretendo melhorá-lo no futuro.
namespace App\Core;


use App\Http\Request;
use App\Http\Response;

class Core
{

    public static function namespace(): string
    {
        return "App\\Controller\\";
    }

    public static function dispatch(array $routes)
    {
        $url = '/' . filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
        $url = rtrim($url, '/') ?: '/';

        $urlMatched = false;   // Alguma rota bateu pela URL
        $methodMatched = false; // Alguma rota bateu URL + método

        foreach ($routes as $route) {

            // Verifica se o método HTTP da requisição atual (ex: GET, POST) bate com o método esperado da rota.
            // Se não bater, ignora essa rota e passa para a próxima (continue).
            // Se nenhuma rota bater, nada será retornado 
            // o que normalmente é tratado fora do foreach, com uma resposta 404 ou 405.
            if (Request::methodHttp() !== $route['method']) continue;

            // Verifica o método
            $methodMatched = true;

            $pattern = '#^' . preg_replace('/{[\w]+}/', '([\d]+)', $route['path']) . '$#';

            //Verifica se a URL atual bate com o padrão da rota.
            // Se não bater, pula para a próxima rota.
            if (!preg_match($pattern, $url, $matches)) continue;

            $urlMatched = true; // achamos uma URL que bateu

            // Remove o primeiro match (a URL inteira)
            array_shift($matches);

            // Executa rota
            $controller = self::namespace() . $route['controller'];
            $action = $route['action'];

            return (new $controller)->$action($matches);
        }

        // Nenhuma rota bateu
        if (!$urlMatched && $methodMatched) {
            $controller = self::namespace() . 'NotFoundController';
            return (new $controller)->index();
        }

        // URL bateu mas método não → 405
        if (!$methodMatched) {
            Response::json([
                "error"   => true,
                "success" => false,
                "message" => "Method Not Allowed"
            ], 405);
            return;
        }
    }
}
