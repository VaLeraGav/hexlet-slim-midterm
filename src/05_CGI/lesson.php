<?php

// Подробнее о работе функции можно прочитать в документации
header('Cache-control: private, max-age=0');

echo date('Y');

// echo 'hello';
// /* Этот пример приведёт к ошибке. Обратите внимание
// header('Location: http://www.example.com/');

// http://localhost:8080/?key=value&key2=value2
echo "<pre>";
print_r($_SERVER);
echo "</pre>";

print_r($_GET);
