.PHONY: start
start:
	docker-compose -f docker-compose.yml up -d --force-recreate

.PHONY: stop
stop:
	docker-compose -f docker-compose.yml stop

.PHONY: migrate
migrate:
	docker exec -it calc-php sh -c "symfony console doctrine:migrations:migrate"

.PHONY: migration
migration:
	docker exec -it calc-php-test sh -c "symfony console make:migration"

.PHONY: test-unit
test-unit:
	docker exec -it calc-php sh -c "composer test tests/Unit"

.PHONY: test-env-up
test-env-up:
	docker-compose -f docker-compose.test.yml up -d

.PHONY: test-integration
test-integration:
	docker exec -it calc-php-test sh -c "symfony console doctrine:database:create --env=test --if-not-exists"
	docker exec -it calc-php-test sh -c "symfony console doctrine:migrations:migrate --env=test --no-interaction"
	docker exec -it calc-php-test sh -c "composer test tests/Integration"
	docker exec -it calc-php-test sh -c "symfony console doctrine:database:drop --env=test --force"
	docker-compose -f docker-compose.test.yml stop

