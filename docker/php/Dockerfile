FROM php:7.3.28-fpm

# Install system packages for PHP extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions \
        zip \
        curl \
        bcmath \
        exif \
        gd \
        iconv \
        intl \
        mbstring \
        opcache \
        pdo_pgsql \
        imagick \
        mongodb \
        xdebug \
        memcached \
        amqp \
        redis \
        json \
        xml \
        sockets

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer


# Application environment
WORKDIR /var/www/app