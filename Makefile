build:
	docker build -f ./docker/php/Dockerfile . -t stream4good/youtube-api-php
	docker build -f ./docker/nginx/Dockerfile . -t stream4good/youtube-api-web
push:
	docker push stream4good/youtube-api-php
	docker push stream4good/youtube-api-web
run:
	docker-compose -f ./deployment/docker-compose.yml up -d
