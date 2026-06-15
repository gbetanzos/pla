# Build stage
FROM ubuntu:22.04 AS base
USER root
ARG DEBIAN_FRONTEND=noninteractive

LABEL maintainer="hseldon"

RUN apt-get update && apt-get install -y \
    apt-utils \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install PHP 8.3
RUN apt-get update && apt-get install -y \
    software-properties-common \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update

RUN apt-get install -y \
    php8.3-cli \
    php8.3-common \
    php8.3-mpi \
    php8.3-mysql \
    php8.3-pgsql \
    php8.3-sqlite3 \
    php8.3-mbstring \
    php8.3-xml \
    php8.3-curl \
    php8.3-zip \
    php8.3-bcmath \
    php8.3-gd \
    php8.3-intl \
    php8.3-readline \
    php8.3-xmlrpc \
    php8.3-soap \
    php8.3-zip \
    php8.3-opcache \
    php8.3-pdo_dblib \
    libpng-dev \
    libonig-dev \
    libxpm-dev \
    libfreetype6-dev \
    libjpeg-dev \
    libgif-dev \
    libwebp-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application code
COPY --chown=www-data:www-data . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install Node.js dependencies and build frontend
RUN npm install && npm run build

# Switch to non-root user
USER www-data

EXPOSE 80

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]