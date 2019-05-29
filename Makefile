init:
	composer install

build:
	docker build --pull --tag tcp-api-brackets .

up:
	docker run -d --name tcp-api-brackets tcp-api-brackets

down:
	docker stop tcp-api-brackets
	docker rm tcp-api-brackets