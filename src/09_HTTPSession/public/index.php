<?php

namespace App\HTTPSession;

require_once dirname(__DIR__) . "/../../vendor/autoload.php";

// Реализуйте маршрут /companies, по которому отдаётся список компаний в виде json. 
// Компании отдаются не все сразу, а только соответствующие текущей запрошенной странице. 
// По умолчанию выдаётся 5 результатов на запрос.

use Slim\Factory\AppFactory;
use Faker\Factory;

class Generator
{
    public static function generate($count)
    {
        $numbers = range(1, 100);
        shuffle($numbers);
        $faker = Factory::create();
        $faker->seed(1);
        $companies = [];
        for ($i = 0; $i < $count; $i++) {
            $companies[] = [
                'id' => $numbers[$i],
                'name' => $faker->company,
                'phone' => $faker->phoneNumber
            ];
        }
        return $companies;
    }
}

$companies = Generator::generate(100);

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    return $response->write('go to the /companies');
});

// BEGIN (write your solution here)
$app->get('/companies', function ($request, $response) use ($companies) {
    $page = $request->getQueryParam('page', 1);
    $per = $request->getQueryParam('per', 5);

    $offset = ($page - 1) * $per;
    $result = array_slice($companies, $offset, $per);

    return $response->withJson($result);
});
// END

$app->run();


