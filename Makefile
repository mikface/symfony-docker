DOCKER_COMPOSE=docker-compose
DOCKER_RUN=${DOCKER_COMPOSE} exec -u $(shell id -u):$(shell id -g) php

.PHONY: build
build:
	sh shell/up.sh

.PHONY: clean-database
clean-database:
	${DOCKER_COMPOSE} down
	docker volume rm $(shell basename $(PWD))_db_app

.PHONY: fix
fix:
	${DOCKER_RUN} vendor/bin/phpcbf

.PHONY: cs
cs:
	${DOCKER_RUN} vendor/bin/phpcs

.PHONY: phpstan
phpstan:
	${DOCKER_RUN} vendor/bin/phpstan analyse

.PHONY: down
down:
	${DOCKER_COMPOSE} down

.PHONY: add-user
add-user:
	${DOCKER_RUN} bin/console app:user:create

.PHONY: list-users
list-users:
	${DOCKER_RUN} bin/console app:user:list
