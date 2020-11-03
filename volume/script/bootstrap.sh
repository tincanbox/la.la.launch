#!/bin/bash
set -e

# REQ.
cd /var/www
if [ ! -e /var/www/service ]; then
    composer global require laravel/installer
    ~/.composer/vendor/bin/laravel new service
fi


# Install
cd /var/www/service 
composer require laravel/jetstream
php artisan jetstream:install inertia --teams

# Mig
cp -f /var/www/build/service/.env /var/www/service/.env
php artisan migrate

# Init
npm install && npm run dev
