docker-up:
	docker-compose up --build -d

docker-exec-php:
	docker exec -it travel-calculator_php_fpm_1 bash

docker-down:
	docker-compose down --remove-orphans

load-fixtures:
	bin/console --env=test doctrine:fixtures:load

create-database:
	bin/console --env=test doctrine:database:create

create-schema:
	bin/console --env=test doctrine:schema:create