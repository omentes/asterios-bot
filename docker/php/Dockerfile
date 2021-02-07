FROM php:7.4.3-fpm-alpine3.11

# Copy the php config file
COPY ./docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

# Copy the application code
COPY . /app

RUN apk update && apk add --no-cache \
    build-base shadow vim curl supervisor \
    php7 \
    php7-fpm \
    php7-common \
    php7-pdo \
    php7-pdo_mysql \
    php7-mysqli \
    php7-mcrypt \
    php7-mbstring \
    php7-xml \
    php7-simplexml \
    php7-openssl \
    php7-json \
    php7-phar \
    php7-zip \
    php7-gd \
    php7-dom \
    php7-session \
    php7-zlib \
    php7-redis \
    php7-session

## Add and Enable PHP-PDO Extenstions
#RUN docker-php-ext-install pdo pdo_mysql
#RUN docker-php-ext-enable pdo_mysql

## Redis
#RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
#        && pecl install redis \
#        && docker-php-ext-enable redis.so


# Install PHP Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Remove Cache
RUN rm -rf /var/cache/apk/*

# Add UID '1000' to www-data
RUN usermod -u 1000 www-data

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /app

# setup supervisor
ADD docker/supervisor/asterios.conf /etc/supervisor/conf.d/asterios.conf
ADD docker/supervisor/supervisord.conf /etc/supervisord.conf

VOLUME ["/app"]

WORKDIR /app

RUN composer install

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

