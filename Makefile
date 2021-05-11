#.PHONY: help

help:           ## Show this help.
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'


current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

# 👌 Main targets

build: start deps ## Build docker container, composer install and up containers

deps: composer-install

# 🐘 Composer

composer-install: CMD=install
composer-update: CMD=update

# Usage example (add a new dependency): `make composer CMD="require --dev symfony/var-dumper ^4.2"`
composer composer-install composer-update:
	@docker exec -it reading-progress-php composer $(CMD)


# 🕵️ Clear cache
# OpCache: Restarts the unique process running in the PHP FPM container
# Nginx: Reloads the server

reload:
	@docker-compose exec php-fpm kill -USR2 1
	@docker-compose exec nginx nginx -s reload

# 🐳 Docker Compose
start: ## up docker containers
	@docker-compose -f local/docker-compose.yaml up -d

start-ci:
	docker-compose build --build-arg SSH_PRIVATE_KEY="$(cat ~/.ssh/amelendres)"
	docker-composer up


restart: ## restart your containers
	make stop
	@docker-compose -f local/docker-compose.yaml up --build -d

stop: CMD=stop

destroy: CMD=down

sh:   ##  enter into container
	@docker exec -it reading-progress-php sh


# Usage: `make doco CMD="ps --services"`
# Usage: `make doco CMD="build --parallel --pull --force-rm --no-cache"`
doco stop destroy:
	@docker-compose -f local/docker-compose.yaml $(CMD)

rebuild: ## rebuild your containers (LONG TIME - take your coffe)
	docker-compose -f local/docker-compose.yaml build --pull --force-rm --no-cache
	make start
	make deps


# 🗄️ Data Base (AVOID in production)
db: ## create database and load fixtures
		@docker exec -it reading-progress-php make init-db
		@docker exec -it reading-progress-php make load-fixtures

dbrefresh: ## rebuild database and load fixtures
		@docker exec -it reading-progress-php make regenerate-db

init-db:
		bin/console d:d:c 
		bin/console d:s:u --force
		
load-fixtures:		
	    bin/console d:f:l -n

regenerate-db: delete-db init-db load-fixtures

delete-db:
		bin/console d:d:d --force