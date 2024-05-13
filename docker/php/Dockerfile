FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y curl \
    && apt-get install -y openssl \
    && apt-get install -y zip \
    && apt-get install -y unzip \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/app

RUN rm -rf /var/www/*

COPY . /var/www/app

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-interaction

RUN php bin/console cache:clear