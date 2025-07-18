FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim \
    optipng \
    pngquant \
    git \
    curl \
    unzip \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libmcrypt-dev \
    nano \
    libmagickwand-dev --no-install-recommends

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

WORKDIR /var/www
COPY . /var/www
COPY --chown=www-data:www-data . /var/www

EXPOSE 9000
CMD ["php-fpm"] 
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"] 