APP_NAME=symfony

ifndef APP_ENV
APP_ENV=dev
endif

# Use Docker unless NO_DOCKER is "truthy" or if we're inside a Docker container already
ifeq (, $(or $(filter-out 0 false, ${NO_DOCKER}), $(wildcard /.dockerenv)))
USING_DOCKER=1
endif

ifeq (${USING_DOCKER}, 1)
DOCKER_COMPOSE=docker-compose
DOCKER_RUN=${DOCKER_COMPOSE} exec -u $(shell id -u):$(shell id -g) php
endif

.PHONY: build
build:
	sh up.sh ${APP_NAME}
	docker exec -it symfony-docker_php_1 sh db.sh

.PHONY: clean-database
clean-database:
	sudo docker volume rm symfony-docker_db_app

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
