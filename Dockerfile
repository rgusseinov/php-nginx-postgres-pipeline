FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_pgsql pgsql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy only composer files first (for caching)
COPY ./app/composer.json ./app/composer.lock ./app/

# Install dependencies
RUN cd app && composer install --no-dev --optimize-autoloader

# Copy the rest of the application
COPY ./app ./app
