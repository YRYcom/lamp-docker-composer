ifneq (,$(wildcard ./.env))
    include .env
    export
endif

SUPPORTED_COMMANDS := artisan composer yarn
SUPPORTS_MAKE_ARGS := $(findstring $(firstword $(MAKECMDGOALS)), $(SUPPORTED_COMMANDS))
ifneq "$(SUPPORTS_MAKE_ARGS)" ""
  COMMAND_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  COMMAND_ARGS := $(subst :,\:,$(COMMAND_ARGS))
  $(eval $(COMMAND_ARGS):;@:)
endif

help:             ##Afficher l'aide sur le fichier
	@cat Makefile | grep "##." | sed '2d;s/##//;s/://'
start:            ##Démarrer l'instance Docker
	@sudo docker-compose --env-file .env -f ./docker/docker-compose.yml up -d --force-recreate
build-docker:     ##Build l'instance Docker
	@sudo docker-compose -f ./docker/docker-compose.yml up --build
stop:             ##Arreter l'instance Docker
	@sudo docker-compose -f ./docker/docker-compose.yml down
exec:             ##Bash sur l'instance docker php
	@sudo docker exec -it --user www-data "$(LAMP_DOCKER_NAME)_php" bash
composer:         ##Installation des composants et librairies php du projet : install, update [package_name], clearcache, dumpautoload
	@sudo docker exec -it --user www-data "$(LAMP_DOCKER_NAME)_php" bash -c "sh ./docker/init-ssh.sh && sh ./docker/composer.sh $(COMMAND_ARGS)"
yarn:             ##Compiler les assets, options : install, build, dev
	@sudo docker exec -it --user www-data "$(LAMP_DOCKER_NAME)_php" bash -c "sh ./docker/init-ssh.sh && yarn $(COMMAND_ARGS)"
create-laravel:   ##Initialisation projet laravel
	@sudo docker exec -it --user www-data "$(LAMP_DOCKER_NAME)_php" bash -c "rm -Rf /tmp/project"
	@sudo docker exec -it --user www-data "$(LAMP_DOCKER_NAME)_php" bash -c "composer create-project --prefer-dist laravel/laravel /tmp/project"
	@sudo docker exec -it --user www-data "$(LAMP_DOCKER_NAME)_php" bash -c "cp -R /tmp/project/* /usr/share/nginx/html/"
	@sudo docker exec -it --user www-data "$(LAMP_DOCKER_NAME)_php" bash -c "cat /tmp/project/.env >> /usr/share/nginx/html/.env"
	@sudo docker exec -it --user www-data "$(LAMP_DOCKER_NAME)_php" bash -c "rm -Rf /tmp/project"
	@sudo docker exec -it --user www-data "$(LAMP_DOCKER_NAME)_php" bash -c "php artisan key:generate"
	@sudo docker exec -it --user www-data "$(LAMP_DOCKER_NAME)_php" bash -c "php artisan config:clear"
	@rm ./README.md
