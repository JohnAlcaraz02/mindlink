# ----------------------------------------
# 1) Build stage – install composer deps
# ----------------------------------------
FROM php:8.2-apache AS build

# Install system deps
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Enable Apache Rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set workdir
WORKDIR /var/www/html

# Copy everything
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# ----------------------------------------
# 2) Build front-end assets (if using Vite)
# ----------------------------------------
FROM node:18 AS front
WORKDIR /app
COPY . .
RUN npm install
RUN npm run build

# ----------------------------------------
# 3) Final Runtime Image
# ----------------------------------------
FROM php:8.2-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Enable Apache Rewrite
RUN a2enmod rewrite

# Set workdir
WORKDIR /var/www/html

# Copy Laravel app from build stage
COPY --from=build /var/www/html /var/www/html

# Copy built assets from front-end stage
COPY --from=front /app/public/build /var/www/html/public/build

# Fix permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
