FROM php:8.2-apache

RUN a2enmod rewrite

RUN apt update && apt install -y unzip libzip-dev

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

EXPOSE 80

RUN useradd -s /bin/bash php

USER php

