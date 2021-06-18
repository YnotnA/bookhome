FROM php:8.0-fpm

RUN apt-get update

RUN apt-get install -y git wget unzip

# extensions
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install opcache

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# php.ini
COPY ./docker/php/php.ini /usr/local/etc/php/
