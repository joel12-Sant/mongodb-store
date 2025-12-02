FROM php:8.1-apache

# Dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y libzip-dev unzip libpng-dev git && \
    docker-php-ext-install pdo pdo_mysql

# Instalar extensión mongodb
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Copiar composer (desde la imagen oficial de composer)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar el código de la aplicación (build context = apache-php)
COPY app/ /var/www/html/

# Instalar dependencias PHP del composer.json que está en app/
RUN composer install --no-dev --optimize-autoloader

# Ajustar permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
