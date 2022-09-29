<?php

// Подключение автозагрузки через composer
require dirname(__DIR__) . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\Container;

$container = new Container();
$container->set('renderer', function () {
    // Параметром передается базовая директория, в которой будут храниться шаблоны
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});
$app = AppFactory::createFromContainer($container);
$app->addErrorMiddleware(true, true, true);

// $users = ['mike', 'mishel', 'adel', 'keks', 'kamila'];

$app->get('/', function ($request, $response) {
    $response->getBody()->write('Welcome to Slim!');
    return $response;
});

$app->get('/users/new', function ($request, $response) {
    $id = uniqid();
    $params = [
        'user' => ['id' => $id, 'name' => '', 'email' => ''],
        'errors' => []
    ];
    return $this->get('renderer')->render($response, "users/new.phtml", $params);
});


$app->get('/users', function ($request, $response) use ($users) {
    $term = $request->getQueryParam('term');
    $fileUsers = json_decode(file_get_contents('project-third/data.json'), true);
    if (!empty($fileUsers)) {
        foreach ($fileUsers as ['name' => $name]) {
            $users[] = $name;
        }
    }
    if ($term) {
        $users = array_filter($users, fn ($user) => strpos($user, $term) !== false);
    }

    $params = [
        'users' => $users,
        'fileUsers' => $fileUsers,
        'term' => $term
    ];
    return $this->get('renderer')->render($response, 'users/index.phtml', $params);
});


$app->post('/users', function ($request, $response) {

    $user = $request->getParsedBodyParam('user');
    $validator = new Validator();
    $errors = $validator->validate($user);

    if (count($errors) === 0) {
        $fileUser = [];
        if (file_exists('project-third/data.json') && filesize('project-third/data.json')) {
            $fileUser = json_decode(file_get_contents('project-third/data.json'), true);
        }
        $fileUser[] = $user;
        $jsonData = json_encode($fileUser);
        file_put_contents('project-third/data.json', $jsonData);
        return $response->withRedirect('/users', 302);
    }

    $params = [
        'user' => $user,
        'errors' => $errors
    ];
    return $this->get('renderer')->render($response, "users/new.phtml", $params);
});
$app->run();



class Validator
{
    public function validate(array $user)
    {
        $errors = [];
        if (empty($user['name'])) {
            $errors['name'] = "name is not filled in!";
        }
        if (empty($user['email'])) {
            $errors['email'] = "email is not filled in!";
        }
        return $errors;
    }
}
