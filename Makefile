DOCKER_COMPOSE=docker-compose
DOCKER_RUN=${DOCKER_COMPOSE} exec -u $(shell id -u):$(shell id -g) php

.PHONY: build
build: build-container build-db

.PHONY: build-container
build-container:
	sh shell/up.sh

.PHONY: build-db
build-db:
	docker exec -it $(shell basename $(PWD))_php_1 sh shell/db.sh

.PHONY: clean-database
clean-database:
	${DOCKER_COMPOSE} down
	sh shell/remove-db.sh

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

.PHONY: reinit-git
reinit-git:
	sh shell/git.sh
