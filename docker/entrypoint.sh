#!/bin/bash
set -e

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Seed database only if users table is empty (prevents duplicates)
echo "Checking if seeding is needed..."
USER_COUNT=$(php -r "
require '/var/www/html/vendor/autoload.php';
\$app = require_once '/var/www/html/bootstrap/app.php';
\$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
echo \App\Models\User::count();
" 2>/dev/null || echo "0")

if [ "$USER_COUNT" = "0" ]; then
    echo "Database is empty, seeding..."
    php artisan db:seed --force
else
    echo "Database has $USER_COUNT users, skipping seed..."
fi

# Cache configuration
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions (crucial for Render)
echo "Fixing permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Start Apache in foreground
echo "Starting Apache..."
exec apache2-foreground
