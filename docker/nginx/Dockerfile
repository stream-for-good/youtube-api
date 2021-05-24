FROM nginx:alpine

RUN adduser -S -G www-data www-data

ADD ./docker/nginx/nginx.conf /etc/nginx/
ADD ./docker/nginx/youtube-api.s4g.miage.dev.conf /etc/nginx/conf.d/default.conf
RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

EXPOSE 80
COPY ./symfony/ /var/www/youtube-api.s4g.miage.dev

CMD ["nginx"]