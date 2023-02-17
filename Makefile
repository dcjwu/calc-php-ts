start:
	docker-compose up -d --force-recreate

stop:
	docker-compose stop

.PHONY: start stop