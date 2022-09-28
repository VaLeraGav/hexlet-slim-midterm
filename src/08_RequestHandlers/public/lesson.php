<?php

require_once dirname(__DIR__) . "/../../vendor/autoload.php";

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/', function ($request, $response) {
    return $response->write('GET /');
});

$app->get('/companies', function ($request, $response) {
    return $response->write('GET /companies');
});

$app->post('/companies', function ($request, $response) {
    return $response->write('POST /companies');
});
// После запуска этого кода, формируется роутер,
//  который содержит в себе три маршрута:
// GET /
// GET /companies
// POST /companies
$app->run();
