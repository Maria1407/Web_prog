FROM php:8.5-fpm

RUN apt-get update && apt-get install -y \
    zip unzip git \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY ./code /var/www/html/code
COPY ./tests /var/www/html/tests
COPY ./composer.json /var/www/html/

CMD ["php-fpm"]