FROM php:7.4-fpm-alpine

RUN apk add --update \
    make \
    curl \
    nodejs \
    nodejs-npm \
    yarn

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions \
    mysqli \
    pdo_mysql
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    ln -s $(composer config --global home) /root/composer
ENV PATH=$PATH:/root/composer/vendor/bin COMPOSER_ALLOW_SUPERUSER=1

ADD ./docker/php/php.ini /etc/php/conf.d/
ADD ./docker/php/php.ini /etc/php/cli/conf.d/
ADD ./docker/php/php.ini /usr/local/etc/php
ADD ./docker/php/php-fpm.conf /etc/php/php-fpm.d/


RUN mkdir -p /var/www/youtube-api.s4g.miage.dev/var/cache/dev
RUN chmod ugo+w -R /var/www/youtube-api.s4g.miage.dev/var/cache/dev

RUN mkdir -p /var/www/youtube-api.s4g.miage.dev/var/log
RUN chmod ugo+w -R /var/www/youtube-api.s4g.miage.dev/var/log

WORKDIR /var/www/youtube-api.s4g.miage.dev
COPY ./symfony/ /var/www/youtube-api.s4g.miage.dev
RUN composer install
RUN rm vendor/php-amqplib/rabbitmq-bundle/RabbitMq/Producer.php
COPY ./symfony/bundle/Producer.php /var/www/youtube-api.s4g.miage.dev/vendor/php-amqplib/rabbitmq-bundle/RabbitMq

EXPOSE 9000

CMD ["php-fpm", "-F"]
