<?php

namespace App;

//  работать если сделать отдельный проект, непонятная ошибка

require dirname(__DIR__) . '/vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\Container;

$users = \App\Generator::generate(100);

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    return $this->get('renderer')->render($response, 'index.phtml');
});

// BEGIN (write your solution here)
$app->get('/users', function ($request, $response) use ($users) {
    $params = ['users' => $users];
    return $this->get('renderer')->render($response, 'users/index.phtml', $params);
});

$app->get('/users/{id}', function ($request, $response, $args) use ($users) {
    $id = (int) $args['id'];
    $user = collect($users)->firstWhere('id', $id);
    $params = ['user' => $user];
    return $this->get('renderer')->render($response, 'users/show.phtml', $params);
});

// END










$app->run();
