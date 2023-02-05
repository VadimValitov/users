FROM php:8.2-fpm

RUN apt-get update && apt-get upgrade -y && apt-get autoremove -y && apt-get install -y \
    ca-certificates \
    curl \
    zlib1g-dev \
    git \
--no-install-recommends

ENV TIMEZONE Etc/UTC
RUN rm -f /etc/localtime && ln -s /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
        && echo "${TIMEZONE}" > /etc/timezone

RUN docker-php-ext-install pdo_mysql

COPY ./docker/php/config/date.ini /usr/local/etc/php/conf.d/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

COPY . .

RUN composer install
