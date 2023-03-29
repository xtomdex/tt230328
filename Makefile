up: docker-up
down: docker-down
restart: docker-down docker-up
docker-init: docker-down-clear docker-pull docker-up
app-init: app-composer-install app-migrations app-fixtures
init: docker-init app-init

docker-up:
	docker-compose up -d --build

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

app-composer-install:
	docker-compose run --rm composer install --no-scripts

app-migrations:
	docker-compose run --rm php-cli php ./bin/console doctrine:migrations:migrate --no-interaction

app-fixtures:
	docker-compose run --rm php-cli php ./bin/console doctrine:fixtures:load --no-interaction