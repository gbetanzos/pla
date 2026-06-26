FROM ubuntu:24.04
ENV DEBIAN_FRONTEND=noninteractive

# Install essential dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl ca-certificates git openssh-client sudo bash jq \
    && rm -rf /var/lib/apt/lists/* 
# Install PHP 8.3 and Laravel 11 prerequisites
RUN apt-get update && apt-get install -y --no-install-recommends \
    php8.3 \
    php8.3-cli \
    php8.3-bcmath \
    php8.3-curl \
    php8.3-gd \
    php8.3-mbstring \
    php8.3-zip \
    php8.3-xml \
    php8.3-intl \
    php8.3-xmlrpc \
    php8.3-dom \
    php8.3-msgpack \
    php8.3-sqlite3 \
    php8.3-imap \
    php8.3-imagick \
    libmagickwand-dev \
    curl \
    composer \
    && rm -rf /var/lib/apt/lists/*

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
