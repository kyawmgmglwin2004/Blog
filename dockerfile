# FROM php:8.2-apache

# # Install required PHP extensions
# RUN apt-get update && apt-get install -y \
#     libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
#     && docker-php-ext-install pdo_mysql zip

# # Enable Apache Rewrite Module
# RUN a2enmod rewrite

# # Set working directory
# WORKDIR /var/www/html

# # Copy Laravel project files
# COPY . .

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Install Laravel dependencies
# RUN composer install --no-dev --optimize-autoloader

# # Set permission
# RUN chmod -R 775 storage bootstrap/cache \
#     && chown -R www-data:www-data /var/www/html

# # Set Document Root to public
# RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# EXPOSE 80

FROM richarvey/nginx-php-fpm:latest

COPY . .

#Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS1
ENV REAL_IP_HEADER 1

#Laravel config
ENV LARAVEL_ENV production
ENV LARAVEL_DEBUG false
ENV LOG_CHANNEL stderr

#Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMU ["/start.sh"]
