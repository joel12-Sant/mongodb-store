FROM php:8.1-apache

RUN apt-get update && apt-get install -y libzip-dev unzip libpng-dev && \
    docker-php-ext-install pdo pdo_mysql

RUN pecl install mongodb && docker-php-ext-enable mongodb

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
