<?php

namespace App\DynamicRoutes;

require_once dirname(__DIR__) . "/../../vendor/autoload.php";

// Реализуйте Маршрут /companies/{id}, по которому отдается json представление компании. 
// Компания извлекается из списка $companies. Каждая компания представлена ассоциативным
//  массивом у которого есть текстовый (то есть тип данных - строка) ключ id:

use Slim\Factory\AppFactory;
use Faker\Factory;

$companies = Generator::generate(100);

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response, $args) {
    return $response->write('open something like (you can change id): /companies/5');
});

// BEGIN (write your solution here)
$app->get('/companies/{id}', function ($request, $response, $args) use ($companies) {
    $id = $args['id'];
    $company = collect($companies)->firstWhere('id', $id);
    if(!$company){
        return $response->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('Page not found');
    }
    return  $response->withJson($company);
});

$app->run();

//------------------------------------------------------------
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
