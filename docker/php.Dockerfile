FROM php:8.3-fpm


RUN sed -i "s/\/deb.debian.org/\/mirror.yandex.ru/g" /etc/apt/sources.list.d/debian.sources \
      && apt-get update && apt-get install -y \
      bzip2 \
      libbz2-dev \
      libonig-dev \
      libzip-dev \
      libmagickwand-dev \
      && docker-php-ext-install -j$(nproc) bcmath bz2 exif gettext mbstring pdo_mysql sockets zip \
      && pecl install imagick \
      && docker-php-ext-enable imagick \
      && pecl install redis \
      && docker-php-ext-enable redis

WORKDIR /var/www/html

COPY ./etc/php/php.ini /usr/local/etc/php/php.ini
