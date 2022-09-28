<?php

namespace App;

require dirname(__DIR__) . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\Container;

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

$app = AppFactory::createFromContainer($container);
$app->addErrorMiddleware(true, true, true);


$users = ['mike', 'mishel', 'adel', 'keks', 'kamila'];

$app->get('/', function ($request, $response) {
    return $response->write('Welcome to Slim!');
});

// project после урока


// $app->get('/users', function ($request, $response) use ($users) {
//     $name = $request->getQueryParam('name');
//     $filteredUsers = array_filter($users, function ($user) use ($name) {
//         return strpos($user, $name) !== false;
//     });
//     $params = [
//         'users' => $filteredUsers
//     ];
//     return $this->get('renderer')->render($response, 'users/index.phtml', $params);
// });

// $app->get('/users/{id}', function ($request, $response, $args) {
//     $params = ['id' => $args['id'], 'nickname' => 'user-' . $args['id']];
//     return $this->get('renderer')->render($response, 'users/show.phtml', $params);
// });


$app->run();


