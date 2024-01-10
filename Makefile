build:  docker-compose build --no-cache --force-rm
stop:   docker-compose stop
up: sudo docker-compose up -d
composer-update:    docker-compose exec laravel-docker "composer update"
composer-install:   docker-compose exec laravel-docker "composer install"
composer-dump-autoload: docker-compose exec laravel-docker "composer dump-autoload"
migrate:    docker-compose exec laravel-docker "php artisan migrate"
data:   docker-compose exec laravel-docker "php artisan migrate"
start: ./commands.sh

compose: docker-compose start 

