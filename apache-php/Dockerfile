FROM php:8.1-apache

# Dependencias del sistema necesarias para compilar extensiones y SSL
RUN apt-get update && apt-get install -y \
    ca-certificates \
    libzip-dev \
    unzip \
    libpng-dev \
    libssl-dev \
    libsasl2-dev \
    pkg-config \
    git \
    build-essential \
    zlib1g-dev \
 && docker-php-ext-install pdo pdo_mysql \
 && rm -rf /var/lib/apt/lists/*

# Instalar extensión mongodb via pecl (ahora con libssl-dev presente)
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Copiar composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar el código de la aplicación (build context = apache-php)
COPY app/ /var/www/html/

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Ajustar permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
