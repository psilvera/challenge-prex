FROM php:8.2-fpm

# dependencias y extensiones
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql zip

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

