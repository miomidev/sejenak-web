# Stage 1: Build Frontend Assets (Vite + TailwindCSS)
FROM node:20-alpine AS assets-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Application Runtime (PHP-FPM + Nginx)
FROM php:8.3-fpm-alpine

# Install system dependencies & PHP extensions needed by Laravel
RUN apk add --no-cache \
    nginx \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    libzip-dev \
    unzip \
    git \
    bash \
    postgresql-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip gd bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy source code into container
COPY . .

# Copy compiled assets from Stage 1
COPY --from=assets-builder /app/public/build ./public/build

# Install PHP dependencies (including dev for seeders/Faker)
RUN composer install --optimize-autoloader

# PHP upload configuration
RUN echo "upload_max_filesize=10M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=12M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit=256M" >> /usr/local/etc/php/conf.d/uploads.ini

# Set permissions for storage, bootstrap/cache, and nginx temp dir
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/lib/nginx

# Copy internal Nginx configuration
COPY ./docker/nginx.conf /etc/nginx/nginx.conf

# Expose port
EXPOSE 80

# Run PHP-FPM and Nginx together
CMD php-fpm -D && php artisan storage:link --force && nginx -g 'daemon off;'
