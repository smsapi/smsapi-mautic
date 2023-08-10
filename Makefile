.PHONY: help

USERID=www-data

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := help

mautic-execute-campaigns:
	docker-compose exec -u $(USERID) mautic ./bin/console mautic:segments:rebuild
	docker-compose exec -u $(USERID) mautic ./bin/console mautic:campaigns:update
	docker-compose exec -u $(USERID) mautic ./bin/console mautic:campaigns:trigger

mautic-clear-cache:
	docker-compose exec -u $(USERID) mautic php -d memory_limit=12800M ./bin/console cache:clear

mautic-seed:
	docker-compose exec -u $(USERID) mautic php -d memory_limit=12800M ./bin/console mautic:install:data

docker-up:
	docker-compose up -d

docker-bash:
	docker-compose exec -u $(USERID) mautic bash

docker-clear-data:
	docker-compose down | true
	docker volume rm smsapi-mautic_database | true


update-smsapi-lib:
	curl -L -O https://github.com/smsapi/smsapi-php-client/archive/master.zip
	unzip -o "master.zip"
	rm -fr "smsapi-php-client" "master.zip"
	mv "smsapi-php-client-master" "smsapi-php-client"
	docker run --rm --interactive --tty --volume ./smsapi-php-client:/app composer dumpautoload -a


