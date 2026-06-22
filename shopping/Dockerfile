FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_sqlite zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Set working directory
WORKDIR /var/www/shopping

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate application key if .env doesn't exist
RUN if [ ! -f .env ]; then cp .env.example .env || true; fi && \
    php artisan key:generate

# Create entrypoint script
RUN printf '%s\n' \
'#!/bin/sh' \
'pkill -f "artisan serve" 2>/dev/null || true' \
'cd /var/www/shopping' \
'php artisan serve --host=0.0.0.0 --port=8000' > /usr/local/bin/docker-entrypoint.sh && \
chmod +x /usr/local/bin/docker-entrypoint.sh

# Set default command
CMD ["/usr/local/bin/docker-entrypoint.sh"]
