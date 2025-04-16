#!/bin/bash

set -e  # Exit on any error

APP_DIR="/var/www/html/project480"
DEPLOY_DIR="/tmp/deployment"
LOG_FILE="/var/log/deploy_laravel.log"

exec > >(tee -a "$LOG_FILE") 2>&1
echo "Starting deployment script..."
echo "Checking if deployment directory exists and contains files..."

if [ ! -d "$DEPLOY_DIR" ]; then
  echo "ERROR: Deployment directory $DEPLOY_DIR does not exist!"
  exit 1
fi

ls -la "$DEPLOY_DIR"

# Clean up existing app directory
echo "Removing existing app directory: $APP_DIR"
rm -rf "$APP_DIR"

# Copy raw files into app directory (assumes artifacts are extracted raw)
echo "Creating new app directory and copying files..."
mkdir -p "$APP_DIR"

# cp -r "$DEPLOY_DIR"/* "$APP_DIR"
rsync -av "$DEPLOY_DIR/" "$APP_DIR/"

cd "$APP_DIR"

# Permissions
echo "Setting permissions..."
chown -R www-data:www-data .
chmod -R 775 storage bootstrap/cache

# Laravel setup
echo "Running Laravel setup..."
/usr/local/bin/composer install --no-dev --optimize-autoloader
# php artisan migrate --force
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart Apache
echo "Restarting Apache server..."
systemctl restart apache2

echo "Deployment script finished successfully."
