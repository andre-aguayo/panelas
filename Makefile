create-env:
	cp ./.env.example ./.env

key-generate:
	php artisan key:generate

install:	
	composer install 
	yarn install
	yarn build

first-up:
	make up
	make migrate

migrate:
	./vendor/bin/sail artisan migrate --seed

up: 
	./vendor/bin/sail up -d

fast-init:
	make create-env
	make install
	make key-generate
	make first-up

test: 
	./vendor/bin/sail test