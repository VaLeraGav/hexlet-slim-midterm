<?php

require dirname(__DIR__) . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    $response->getBody()->write('Welcome to Slim!');
    return $response;
});

$app->get('/users', function ($request, $response) {
    return $response->write('GET /users');
});

// curl --head -XPOST localhost:8080/users
$app->post('/users', function ($request, $response) {
    return $response->withStatus(302);
});

// http://localhost:8080/courses/5
$app->get('/courses/{id}', function ($request, $response, array $args) {
    $id = $args['id'];
    return $response->write("Course id: {$id}");
});


$app->run();
