
install:
	composer install

index:
	php -S localhost:8080  src/$(file)/public/index.php

lesson:
	php -S localhost:8080  src/$(file)/public/lesson.php

project:
	php -S localhost:8080 $(file)/public/index.php
