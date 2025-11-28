FROM php:8.5-fpm

# Установим зависимости и расширения
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    git \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Установка PHP Redis расширения
RUN pecl install redis \
    && docker-php-ext-enable redis

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Права на файлы
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

WORKDIR /var/www
