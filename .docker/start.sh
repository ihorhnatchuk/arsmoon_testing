#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
timeout=${QUEUE_TIMEOUT}
env=${APP_ENV:-production}


if [ "$role" = "app" ]; then

    # chown -R www-data:www-data /app
    # chmod -R 0777 storage/logs

    ## Make Composer Install on app:alpine
    if [ ! -d "/app/vendor" ]
    then
        composer install \
                  --ignore-platform-reqs \
                  --no-interaction \
                  --no-plugins \
                  --prefer-dist

    else
        printf "Vendor Exists: Updating\n"

        #check production for update packages
        if [ "$env" == "production" ]
        then
          composer update \
                  --ignore-platform-reqs \
                  --no-interaction \
                  --no-plugins \
                  --prefer-dist

        fi

    fi
    
    exec php-fpm

else
    printf "Could not match the container role %s\n" "$role"
    exit 1
fi
