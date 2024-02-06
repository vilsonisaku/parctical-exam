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

composer-install:
	docker-compose exec app composer install

run-laravel:
	docker-compose exec app php artisan serve --host 0.0.0.0
