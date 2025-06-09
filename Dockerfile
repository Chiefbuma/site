# Dockerfile
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Add dependencies for PHP intl extension
RUN apt-get update && apt-get install -y libicu-dev
RUN docker-php-ext-install intl

    # Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing app files
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Expose port (not needed for fpm directly, nginx handles it)
EXPOSE 9000
