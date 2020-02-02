FROM composer:1.7 AS vendor
COPY database/ database/
COPY tests/ tests/
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --prefer-dist

FROM php:7.2-apache

RUN apt-get update
RUN a2enmod rewrite

RUN apt-get update && docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html
COPY ./.docker/vhost.conf /etc/apache2/sites-available/000-default.conf

COPY --from=vendor /app/vendor/ /var/www/html/vendor/

RUN chown -R www-data:www-data /var/www/html/storage \
    && ln -s /var/www/html/storage/app/public public/storage

WORKDIR /var/www/html
