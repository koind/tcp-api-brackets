init:
	composer install

build:
	docker build --pull --file=Dockerfile --build-arg tcp_ip=${TCP_IP} --tag tcp-api-brackets .

up:
	docker run -d --name tcp-api-brackets tcp-api-brackets

down:
	docker stop tcp-api-brackets
	docker rm tcp-api-brackets