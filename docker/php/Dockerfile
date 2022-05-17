FROM php:fpm-alpine3.15

ENV UID=1000
ENV GID=1000

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && set -ex \
    && apk --no-cache --virtual .build-deps add autoconf g++ libtool make \
    && apk --no-cache add postgresql-dev icu-dev\
    && docker-php-ext-install -j$(nproc) intl pdo pgsql pdo_pgsql opcache \
    && pear update-channels \
    && pecl install redis \
    && docker-php-ext-enable redis intl pdo pgsql pdo_pgsql opcache \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/pear \
    && apk del .build-deps

RUN addgroup -g ${GID} --system symfony
RUN adduser -G symfony --system -D -s /bin/sh -u ${UID} symfony

RUN sed -i "s/user = www-data/user = symfony/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = symfony/g" /usr/local/etc/php-fpm.d/www.conf