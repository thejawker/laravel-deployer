#!/bin/bash

# Setting up
cd "$(dirname "$0")"
php artisan down
TIMESTAMP=$(php -r "echo microtime(true);")
ERROR=0

# Pull from origin
GIT_OUTPUT=$(git pull 2>&1)
if [ $? -eq 0 ]
then
    GIT_OUTPUT=""
else
    ERROR=1
fi

if [ ${ERROR} -eq 0 ]
then
    composer install -n -o --prefer-dist
    yarn install && yarn run production

    # Migrating the database
    if [ -f artisan ]
    then
        php artisan migrate --force
    fi

    # Optimization
    php artisan config:cache
    php artisan route:cache
    php artisan view:clear
fi

# Post deploy
php artisan up
php artisan horizon:terminate
php artisan post-deploy ${TIMESTAMP} "${GIT_OUTPUT}"