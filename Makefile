start:
	docker-compose up

stop:
	docker-compose stop

ssh:
	docker exec -it ml-laravel /bin/bash

ssh-db:
	docker exec -it ml-postgres /bin/bash

logs:
	docker logs -f --tail 100 ml-laravel

apply-env:
	docker-compose exec app cp .env.example .env

composer-install:
	docker-compose exec app composer install

migrate:
	docker-compose exec app php artisan migrate

migrate-fresh:
	docker-compose exec app php artisan migrate:fresh

db-seed:
	docker-compose exec app php artisan db:seed

test:
	docker-compose exec app php artisan test

serve:
	docker-compose exec app php artisan serve --host 0.0.0.0
