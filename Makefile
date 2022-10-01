
install:
	composer install

project:
	php -S localhost:8080 $(file)/public/index.php
