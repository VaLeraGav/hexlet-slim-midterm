
install:
	composer install

index:
	php -S localhost:8080  src/$(file)/public/index.php

lesson:
	php -S localhost:8080  src/$(file)/public/lesson.php

start:
	php -S localhost:8080 -t project project/public/index.php
