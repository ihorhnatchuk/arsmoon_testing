#
# Application
#
FROM php:8.0.3-fpm-alpine

RUN rm -f /etc/apk/repositories &&\
    echo "http://dl-cdn.alpinelinux.org/alpine/v3.12/main" >> /etc/apk/repositories && \
    echo "http://dl-cdn.alpinelinux.org/alpine/v3.12/community" >> /etc/apk/repositories

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions opcache exif mysqli pdo \
    pdo_mysql sockets json intl gd xml zip bz2 pcntl bcmath

WORKDIR /app

# Arguments defined in docker-compose.yml
ARG GROUP_ID=football_user
ARG USER=football_user



RUN apk add --no-cache bash mysql-client

COPY ./.docker/php/fpm_www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./.docker/php/php.ini /usr/local/etc/php/
COPY ./.docker/start.sh /usr/local/bin/start
COPY ./.docker/wait-for-it.sh /usr/local/bin/wait-for-it

RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer && \
    composer self-update --preview

RUN addgroup -g 1000 -S $GROUP_ID; \
    adduser -u 1000 -D -S -G $GROUP_ID $USER

# change current user to www
USER $USER