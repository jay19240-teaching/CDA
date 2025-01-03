# use PHP 8.2
FROM php:8.3-apache
ARG MODE=test

# Install common php extension dependencies
RUN apt-get update && apt-get install -y \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Set the working directory
COPY . /var/www/app
WORKDIR /var/www/app

COPY .env.${MODE} .env
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

RUN chown -R www-data:www-data /var/www/app \
    && chmod -R 775 /var/www/app/storage

# install composer
COPY --from=composer:2.6.5 /usr/bin/composer /usr/local/bin/composer

# copy composer.json to workdir & install dependencies
COPY composer.json ./
RUN composer install
RUN php artisan storage:link