# 1. Use PHP 8.2 with Apache
FROM php:8.2-apache

# 2. Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    nodejs \
    npm

# 3. Install PHP Extensions
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip

# 4. Enable Apache Mod Rewrite (Required for Laravel)
RUN a2enmod rewrite

# 5. Fix AH00558 Warning globally
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# 6. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Set working directory
WORKDIR /var/www/html

# 8. Copy project files
COPY . .

# 9. CRITICAL FIX: Copy our custom Apache Config (Fixes 404)
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# 10. Install PHP Dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 11. Install Node Dependencies & BUILD ASSETS
RUN npm install
RUN npm run build

# 12. Set Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 13. Expose Port 80
EXPOSE 80

# 14. Copy and Run the Entrypoint Script
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
CMD ["/usr/local/bin/entrypoint.sh"]