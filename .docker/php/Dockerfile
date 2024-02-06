# Use the official PHP 8.3 image
FROM php:8.3-fpm


# Set working directory
WORKDIR /var/www/html



# Copy the rest of the application code to the container
# COPY . .


# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql pdo_pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# ENV COMPOSER_ALLOW_SUPERUSER 1

# Copy the composer.json and composer.lock files to the container
# COPY composer.json composer.lock ./


# Install application dependencies
# RUN composer install --no-interaction --no-scripts --no-autoloader

# Generate autoloader
# RUN composer dump-autoload --optimize

# Expose port 9000 and start PHP-FPM server
# EXPOSE 9000
EXPOSE 8000

# RUN php artisan serve --host 0.0.0.0
CMD ["php-fpm"]
