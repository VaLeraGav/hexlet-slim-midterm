<?php

require_once dirname(__DIR__) . "/../../vendor/autoload.php";

use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    $response->getBody()->write('Hello, world!');
    return $response;
});


// curl -XPOST 'localhost:8080/users?page=4&per=3'
$app->post('/users', function ($request, $response) {
    $page = $request->getQueryParam('page', 1);
    $per = $request->getQueryParam('per', 10);

    $response->write($page);
    $response->write($per);

    return $response;
});

$app->run();