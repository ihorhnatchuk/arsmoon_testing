#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
timeout=${QUEUE_TIMEOUT}
env=${APP_ENV:-production}

#if [ "$env" != "local" ]; then
#    printf "Caching configuration... \n"
#    (cd /app && php artisan config:cache && php artisan route:cache && php artisan view:cache)
#fi

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

        php artisan key:generate

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
    
elif [ "$role" = "worker" ]; then

    #wait-for-it localhost:80 -t 3 -- printf "Running the worker... \n"  && \
    #php artisan queue:work --verbose --tries=5 --timeout="$timeout"
    # printf "Running the worker...\n"
    supervisord -c /etc/supervisor.d/supervisor.ini

elif [ "$role" = "cron" ]; then

    printf "Running the cron...\n"
    # shellcheck disable=SC2160
    while [ true ]; do
        php artisan schedule:run --verbose --no-interaction &
        sleep 60
    done

else
    printf "Could not match the container role %s\n" "$role"
    exit 1
fi
