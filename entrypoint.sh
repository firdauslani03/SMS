#!/bin/bash

# 1. Run database migrations
php artisan migrate --force

# 2. Clear caches to avoid old config issues
php artisan optimize:clear

# 3. Start Apache (this keeps the server running)
exec apache2-foreground