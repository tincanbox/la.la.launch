#!/bin/bash
set -e

# - - - - - - - - - - - - - - - - - -
# Service Bootstrap
#
# Initializes a service with latest
#
# - - - - - - - - - - - - - - - - - -

# REQ.
cd /var/www/service
if [ ! -e /var/www/service ]; then
    composer global require laravel/installer
    ~/.composer/vendor/bin/laravel new service
fi

php artisan config:clear
php artisan cache:clear

# Install
cd /var/www/service 
composer require laravel/jetstream
php artisan jetstream:install inertia --teams

# Mig
php artisan migrate

# Init
npm install && npm run dev