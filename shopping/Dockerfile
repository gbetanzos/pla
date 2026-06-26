FROM ubuntu:24.04
ENV DEBIAN_FRONTEND=noninteractive

# Install essential dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl ca-certificates git openssh-client sudo bash jq yarn \
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

# Create database directory and SQLite file
RUN mkdir -p database && touch database/database.sqlite

# Install Node.js and npm, then build assets
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    rm -rf /var/lib/apt/lists/*

# Install npm dependencies and build assets
RUN if [ -f package.json ]; then \
    npm install --omit=dev && \
    npm run build; \
fi

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Check if .env exists, if not create from example
RUN if [ ! -f .env ]; then cp .env.example .env || true; fi

# Generate application key if .env doesn't exist
RUN if [ ! -f .env ]; then cp .env.example .env || true; fi && \
    if [ -f .env ]; then php artisan key:generate; else php artisan key:generate --force; fi

# Create storage and log directories with proper permissions
RUN mkdir -p storage/logs storage/framework/storage && \
    touch storage/logs/laravel.log && \
    chown -R 1000:1000 storage/

# Add health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=40s --retries=3 \
    CMD curl -f http://localhost:8000/ || exit 1

# Create entrypoint script
RUN printf '%s\n' \
'#!/bin/sh' \
'pkill -f "artisan serve" 2>/dev/null || true' \
'cd /var/www/shopping' \
'mkdir -p database && touch database/database.sqlite' \
'php artisan migrate:fresh --seed --force 2>&1' \
'php artisan serve --host=0.0.0.0 --port=8000' > /usr/local/bin/docker-entrypoint.sh && \
chmod +x /usr/local/bin/docker-entrypoint.sh

# Set default command
CMD ["/usr/local/bin/docker-entrypoint.sh"]
