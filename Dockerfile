# FROM php:8.2.0-apache
# WORKDIR /var/www/html


# RUN a2enmod rewrite

# RUN apt-get update -y && apt-get install -y\
# libicu-dev\
# libmariadb-dev\
# unzip zip\
# zlibig-dev\
# lippng-dev\
# libjpeg-dev\
# libfreetype6-dev\
# libjpeg62-turbo-dev
# #
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# RUN docker-php-ext-install intl pdo pdo_mysql gd

# RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
# && docker-php-ext-install -j$(nproc) gd

FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
