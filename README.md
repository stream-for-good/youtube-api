# Symfony5 Docker Development Stack
This is a lightweight stack based on Alpine Linux for running Symfony5 into Docker containers using docker-compose.  

### Prerequisites
* [Docker](https://www.docker.com/)

### Container
 - [nginx](https://hub.docker.com/_/nginx) 1.19.+
 - [php-fpm](https://hub.docker.com/_/php) 7.4.+
    - [composer](https://getcomposer.org/) 
    - [yarn](https://yarnpkg.com/lang/en/) and [node.js](https://nodejs.org/en/) (if you will use [Encore](https://symfony.com/doc/current/frontend/encore/installation.html) for managing JS and CSS)

### Installing

run command:
```
 make
```