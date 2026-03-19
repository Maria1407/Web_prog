FROM richarvey/nginx-php-fpm:latest

ENV PHP_ERROR_LOG /var/log/php/error.log
ENV NGINX_ERROR_LOG /var/log/nginx/error.log
ENV NGINX_ACCESS_LOG /var/log/nginx/access.log
ENV RUN_SCRIPTS 1
ENV XDEBUG_OFF 1

COPY ./www /var/www/html

WORKDIR /var/www/html


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && composer install --no-dev --optimize-autoloader


RUN chown -R www-data:www-data /var/www/html || true