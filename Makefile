start:
	docker-compose up -d --force-recreate

stop:
	docker-compose stop

migrate:
	docker exec -it calc-php sh -c "symfony console doctrine:migrations:migrate"

migration:
	docker exec -it calc-php sh -c "symfony console make:migration"

.PHONY: start stop migrate migration