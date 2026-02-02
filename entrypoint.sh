#!/bin/bash

# 1. Run database migrations (This runs as Root and might create root-owned logs)
php artisan migrate --force

# 2. Clear caches
php artisan optimize:clear

# 3. CRITICAL FIX: Give ownership of storage back to the web user (www-data)
# This fixes the "Permission denied" error in laravel.log
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 4. Start Apache
exec apache2-foreground