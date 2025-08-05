FROM php:8.2-fpm

RUN apt-get update \
 && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
 && docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 8000

CMD ["sh", "-c", "\
    composer install --no-interaction && \
    php artisan key:generate --force && \
    php artisan migrate &&\
    php artisan serve --host=0.0.0.0 --port=8000 \
"]
