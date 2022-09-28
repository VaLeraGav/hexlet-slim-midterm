<?php

namespace App;

require dirname(__DIR__) . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\Container;

// http://localhost:8080/users/nick
$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

$app = AppFactory::createFromContainer($container);
$app->addErrorMiddleware(true, true, true);

$app->get('/users/{id}', function ($request, $response, $args) {
    $params = ['id' => $args['id'], 'nickname' => 'user-' . $args['id']];
    return $this->get('renderer')->render($response, 'users/show.phtml', $params);
});

//----------------------------------

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
//----------------------------------

$app->run();
