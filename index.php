<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->get('/api/hello', function (Request $request, Response $response) {
    $name = $request->getQueryParams()['name'];
    $response->getBody()->write("Hello, {$name}!");
    return $response;
});

$app->run();
