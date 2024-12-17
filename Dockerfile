FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libicu-dev \
    g++ \
    supervisor \
    libssl-dev \
    pkg-config \
    nodejs \
    npm && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd pdo_mysql mbstring exif pcntl bcmath intl

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY --chown=www-data:www-data laravel-horizon /var/www/html

# Copy .env.example to .env
COPY --chown=www-data:www-data laravel-horizon/.env.example /var/www/html/.env

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader --working-dir=/var/www/html

# Generate Laravel application key
RUN php /var/www/html/artisan key:generate

# Install Laravel Horizon (specify compatible version)
RUN composer require laravel/horizon:^5.7 --working-dir=/var/www/html

# Install Laravel Horizon
RUN php /var/www/html/artisan horizon:install

# Copy Supervisor configuration
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port 9000 and start Supervisor
EXPOSE 9000
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]