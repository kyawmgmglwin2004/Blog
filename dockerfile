FROM php:8.2-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql zip

# Enable Apache Rewrite Module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permission
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# Set Document Root to public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
