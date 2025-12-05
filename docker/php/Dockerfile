FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev

RUN docker-php-ext-install intl pdo pdo_mysql mbstring zip exif pcntl bcmath

ARG UID=1000
ARG GID=1000

RUN usermod -u ${UID} www-data && groupmod -g ${GID} www-data

USER www-data

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
