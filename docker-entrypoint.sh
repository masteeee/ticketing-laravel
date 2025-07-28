#!/bin/sh
set -e

composer install
php artisan key:generate --force
php artisan migrate --force
php artisan storage:link
php artisan db:seed --force

exec php-fpm 