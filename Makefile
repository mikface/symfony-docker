DOCKER_COMPOSE=docker compose
DOCKER_RUN=${DOCKER_COMPOSE} exec -u $(shell id -u):$(shell id -g) frankenphp
DIR_BASENAME=$(shell basename $(PWD) | awk '{print tolower($$0)}')
.PHONY: build
build: build-container build-db fix-rights

.PHONY: build-container
build-container:
	bash shell/up.sh

.PHONY: build-db
build-db:
	docker exec -it ${DIR_BASENAME}-frankenphp-1 bash shell/db.sh

.PHONY: fix-rights
fix-rights:
	docker exec -it ${DIR_BASENAME}-frankenphp-1 bash shell/fix-rights.sh $(shell whoami)

.PHONY: clean-database
clean-database:
	${DOCKER_COMPOSE} down
	bash shell/remove-db.sh

.PHONY: fix
fix:
	${DOCKER_RUN} vendor/bin/php-cs-fixer fix

.PHONY: cs
cs:
	${DOCKER_RUN} vendor/bin/php-cs-fixer check -vvv

.PHONY: phpstan
phpstan:
	${DOCKER_RUN} vendor/bin/phpstan analyse --memory-limit 1G

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
	bash shell/git.sh

.PHONY: bash-php
bash-php:
	${DOCKER_RUN} /bin/bash
