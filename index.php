<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
    "users" => [
        "elephpant" => "I❤️PHP",
    ]
]));

$app->get('/api/hello', function (Request $request, Response $response) {
    $name = $request->getQueryParams()['name'];
    $time = date('r');
    $response->getBody()->write(sprintf("%s: Hello, %s!", $time, $name));
    return $response;
});

$app->get('/api/item', function (Request $request, Response $response) {
    $todo = file_get_contents('data.json');
    $response->getBody()->write($todo);
    $response = $response->withHeader('Content-Type', 'application/json');
    return $response;
});

$app->post('/api/item', function (Request $request, Response $response) {
    $todo = $request->getBody()->getContents();
    file_put_contents('data.json', $todo);
    $response = $response->withStatus(204);
    return $response;
});

$app->run();
