<?php

require_once dirname(__DIR__) . "/../../vendor/autoload.php";

// Реализуйте Slim приложение, в котором по адресу / отдается строчка Welcome to Hexlet!

use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->get('/', function ($request, $response) {
    return $response->write('Welcome to Hexlet!');
});
$app->run();
