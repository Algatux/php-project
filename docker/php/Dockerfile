FROM php:8.1.4-fpm-alpine3.14

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && set -ex \
    && apk --no-cache add postgresql-dev icu-dev \
    && docker-php-ext-install -j$(nproc)  intl pdo pgsql pdo_pgsql opcache
RUN pear update-channels \
    && pecl install redis \
    &&  rm -rf /tmp/pear \
    && docker-php-ext-enable redis


