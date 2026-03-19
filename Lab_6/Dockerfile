# Используем образ, где уже есть PHP и Nginx
FROM richarvey/nginx-php-fpm:latest

# Переменные окружения для настройки образа
ENV PHP_ERROR_LOG /var/log/php/error.log
ENV NGINX_ERROR_LOG /var/log/nginx/error.log
ENV NGINX_ACCESS_LOG /var/log/nginx/access.log
ENV RUN_SCRIPTS 1
ENV XDEBUG_OFF 1

# Копируем исходный код в контейнер
COPY ./www /var/www/html

WORKDIR /var/www/html

# Устанавливаем Composer и зависимости
# Используем curl для загрузки установщика composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && composer install --no-dev --optimize-autoloader

# Исправляем права доступа (стандартный пользователь в этом образе www-data)
# Добавляем || true, чтобы сборка не прерывалась, если пользователь немного отличается
RUN chown -R www-data:www-data /var/www/html || true