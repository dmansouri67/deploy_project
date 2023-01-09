<?php

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Middlewares\CorsMiddleware;
use Tuupola\Middleware\JwtAuthentication;

return function (App $app) {
    
    $app->options('/{routes:.+}', function (Request $request, Response $response, $args) {
        return $response;
    });

    $app->add(CorsMiddleware::class);

    $options = [
        "attribute" => "token",
        "header" => "Authorization",
        "regexp" => "/Bearer\s+(.*)$/i",
        "secure" => false,
        "algorithm" => ["HS256"],
        "secret" => $_ENV[JWT_SECRET],
        "path" => ["/Order"],
        "ignore" => ["/User/Login"],
        "error" => function ($response, $arguments) {
            var_dump($arguments);
            $data = array("ERREUR" => "Connexion", "Erreur" => "JWT Non valide");
            $response = $response->withStatus(401);
            return $response->withHeader("Content-Type", "application/json")->getBody()->write(json_encode($data));
        }
    ];

    $app->add(new JwtAuthentication($options));

    $app->group('/Product', function (Group $group) {
        $group->get('/Products', "\App\Controllers\ProductController:getProducts");
        $group->get('/{Reference}', "\App\Controllers\ProductController:getProduct");
    });

    $app->group('/User', function(Group $group) {
        $group->post('/Register', "App\Controllers\UserController:postRegister");
        $group->post('/Login', "App\Controllers\UserController:postLogin");
    });

    $app->group('/Order', function(Group $group) {
        $group->post('/Buy', "App\Controllers\OrderController:postBuy");
        $group->get('/Orders', "App\Controllers\OrderController:getOrders");
    });
};