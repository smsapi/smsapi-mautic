.PHONY: help

USERID=$(shell id -u)

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help

help:
	docker-compose exec -u www-data mautic ./app/console

login:
	docker-compose exec -u www-data mautic bash

rebuild-env:
	sudo rm -Rf ./volumes
	docker-compose up -d -V --build
	make copy

command:
	docker-compose exec mautic ./app/console

copy:
	rsync -r --verbose --exclude 'volumes' ./* volumes/app/plugins/MauticSmsapiBundle

change-owner:
	sudo chmod -R 775 ./volumes/app

execute-campaigns:
	make copy
	docker-compose exec -u www-data mautic ./app/console mautic:segments:rebuild
	docker-compose exec -u www-data mautic ./app/console mautic:campaigns:update
	docker-compose exec -u www-data mautic ./app/console mautic:campaigns:trigger

cache:
	docker-compose exec -u www-data  mautic php -d memory_limit=12800M ./app/console cache:clear

seed:
	docker-compose exec -u www-data  mautic php -d memory_limit=12800M ./app/console mautic:install:data

