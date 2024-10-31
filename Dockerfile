FROM php:8.2-apache

WORKDIR /var/www/project

RUN apt-get update \
    && apt-get install -y curl apt-transport-https ca-certificates gnupg \
    && apt-get update \
    && apt-get install -y git zip libicu-dev zlib1g-dev g++ libpng-dev

RUN docker-php-ext-install pdo pdo_mysql bcmath \
    && docker-php-ext-configure intl && docker-php-ext-install intl

RUN docker-php-ext-install gd

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install symfony-cli -y

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs
    

RUN a2enmod rewrite