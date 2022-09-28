<?php

// Реализуйте вывод массива $links в виде набора ссылок.
//  Каждый элемент этого массива представляет собой ассоциативный 
// массив с двумя ключами: name и url. Имя должно стать текстом ссылки, 
// а адрес значением свойства href.

$links = [
    ['url' => 'https://google.com', 'name' => 'Google'],
    ['url' => 'https://yandex.com', 'name' => 'Yandex'],
    ['url' => 'https://bingo.com', 'name' => 'Bingo']
];

?>

<?php foreach ($links as $link) : ?>
    <div>
        <a href=<?= $link['url'] ?>><?= $link['name'] ?></a>
    </div>
<?php endforeach; ?>