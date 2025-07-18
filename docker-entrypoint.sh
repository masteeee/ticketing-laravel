#!/bin/sh
set -e

composer install
php artisan key:generate --force
php artisan migrate --force

exec php-fpm 