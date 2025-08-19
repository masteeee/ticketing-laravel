#!/bin/sh
set -e

composer install
php artisan key:generate --force
php artisan storage:link

exec php-fpm 