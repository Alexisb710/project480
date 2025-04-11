#!/bin/bash

set -e  # Exit on any error

APP_DIR="/var/www/html/project480"
DEPLOY_DIR="/tmp/deployment"
LOG_FILE="/var/log/deploy_laravel.log"

exec > >(tee -a "$LOG_FILE") 2>&1
echo "Starting deployment script..."

# Clean up existing app
rm -rf $APP_DIR

# Create directory
mkdir -p $APP_DIR

# Copy new build contents to app directory
cp -r $DEPLOY_DIR/* $APP_DIR

cd $APP_DIR

# Permissions
chown -R www-data:www-data .
chmod -R 775 storage bootstrap/cache

# Laravel setup
/usr/local/bin/composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart Apache
systemctl restart apache2

echo "Deployment script finished."
