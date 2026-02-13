FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate optimized caches
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear

# Expose port (Render will assign PORT)
EXPOSE 10000

# Start Laravel server
CMD php artisan serve --host=0.0.0.0 --port=${PORT}
