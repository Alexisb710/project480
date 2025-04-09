#!/bin/bash

APP_DIR="/var/www/html/project480"

# Clean up existing app
rm -rf $APP_DIR

# Unzip new build
mkdir -p $APP_DIR
unzip -o /tmp/deployment/project480.zip -d $APP_DIR

cd $APP_DIR

# Set correct permissions
chown -R www-data:www-data .
chmod -R 775 storage bootstrap/cache

# Laravel setup
composer install --no-dev --prefer-dist
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Restart Apache
systemctl restart apache2
