<?php

namespace App;

require dirname(__DIR__) . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\Container;

// project после урока 13
// список пользователей и сортировка по ней

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

$app->get('/users', function ($request, $response) use ($users) {
    $name = $request->getQueryParam('name');
    if (empty($name)) {
        // $searchUser = [];
        $searchUser = $users;
    } else {
        $searchUser = array_filter($users, function ($user) use ($name) {
            return strpos($user, $name) !== false;
        });
    }
    $params = [
        'users' => $users,
        'searchUser' => $searchUser
    ];
    return $this->get('renderer')->render($response, 'users/index.phtml', $params);
});

$app->get('/users/{id}', function ($request, $response, $args) {
    $params = ['id' => $args['id'], 'nickname' => 'user-' . $args['id']];
    return $this->get('renderer')->render($response, 'users/show.phtml', $params);
});

// $app->get('/users', function ($request, $response) use ($users) {
//     $term = $request->getQueryParam('name');

//     $fileUsers = json_decode(file_get_contents('data.json'), true);
//     if (!empty($fileUsers)) {
//         foreach ($fileUsers as ['name' => $name]) {
//             $users[] = $name;
//         }
//     }
//     if ($term) {
//         $users = array_filter($users, fn ($user) => strpos($user, $term) !== false);
//     }
//     $params = [
//         'users' => $users,
//         'fileUsers' => $fileUsers,
//         'term' => $term
//     ];
//     return $this->get('renderer')->render($response, 'users/index.phtml', $params);
// });



$app->run();
