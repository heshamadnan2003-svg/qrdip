# ===============================
# PHP + Apache
# ===============================
FROM php:8.2-apache

# ===============================
# System dependencies
# ===============================
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl

# ===============================
# PHP extensions
# ===============================
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# ===============================
# Enable Apache mod_rewrite
# ===============================
RUN a2enmod rewrite

# ===============================
# Set working directory
# ===============================
WORKDIR /var/www/html

# ===============================
# Copy project files
# ===============================
COPY . .

# ===============================
# Install Composer
# ===============================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ===============================
# Install dependencies
# ===============================
RUN composer install --no-dev --optimize-autoloader

# ===============================
# Laravel permissions
# ===============================
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# ===============================
# Apache config for Laravel
# ===============================
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# ===============================
# Expose port
# ===============================
EXPOSE 80

# ===============================
# Start Apache
# ===============================
CMD ["apache2-foreground"]
