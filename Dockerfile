# 1. Use PHP 8.2 with Apache
FROM php:8.2-apache

# 2. Install system dependencies (Unzip, Git, Node.js, NPM)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm

# 3. Install PHP Extensions required by Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 4. Enable Apache Mod Rewrite (Required for Laravel routes)
RUN a2enmod rewrite

# 5. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Set working directory
WORKDIR /var/www/html

# 7. Copy project files into the container
COPY . .

# 8. Install PHP Dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 9. Install Node Dependencies & BUILD ASSETS (This fixes your error)
RUN npm install
RUN npm run build

# 10. Set Permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 11. Point Apache to the 'public' folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 12. Expose Port 80
EXPOSE 80

# 13. Copy and Run the Entrypoint Script
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
CMD ["/usr/local/bin/entrypoint.sh"]