FROM composer:latest

RUN mkdir /var/www/.cache && chown www-data:www-data /var/www/.cache
