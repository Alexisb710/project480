#!/bin/bash

set -e  # Exit on any error

# --- Configuration ---
APP_DIR="/var/www/html/project480"
DEPLOY_DIR="/tmp/deployment"
LOG_FILE="/var/log/deploy_laravel.log"
AWS_REGION="us-west-1"
# PARAMETER_PATH="/project480/prod" # The path prefix for the parameters in Parameter Store
ENV_FILE="$APP_DIR/.env"
BACKUP_ENV_FILE="/tmp/env_backup"
# --- End Configuration ---

exec > >(tee -a "$LOG_FILE") 2>&1
echo "Starting deployment script..."
echo "Checking if deployment directory exists and contains files..."

if [ ! -d "$DEPLOY_DIR" ]; then
  echo "ERROR: Deployment directory $DEPLOY_DIR does not exist!"
  exit 1
fi

ls -la "$DEPLOY_DIR"

if [ -f "$ENV_FILE" ]; then
    echo "Found existing .env file — backing it up"
    cp "$ENV_FILE" "$BACKUP_ENV_FILE"
else
    echo "No existing .env file found — nothing to back up"
fi

# Clean up existing app directory
# echo "Removing existing app directory: $APP_DIR"
# rm -rf "$APP_DIR"

echo "Creating new app directory and copying files..."
mkdir -p "$APP_DIR"
rsync -av --exclude='.env' "$DEPLOY_DIR/" "$APP_DIR/"
echo "Files copied using rsync."

# --- Restore .env if backup exists ---
if [ -f "$BACKUP_ENV_FILE" ]; then
    echo "✅ Restoring .env from backup"
    cp "$BACKUP_ENV_FILE" "$ENV_FILE"
else
    echo "⚠️  No .env backup to restore"
fi

cd "$APP_DIR"

# --- Start .env file creation ---
# echo "Creating .env file from .env.example..."

# if [ ! -f ".env.example" ]; then
#     echo "ERROR: .env.example not found in $APP_DIR!"
#     exit 1
# fi

# cp .env.example .env
# echo "Copied .env.example to .env"

# --- Start .env file creation ---
echo "Checking if .env file exists"

if [ -f "$ENV_FILE" ]; then
    echo "$ENV_FILE already exists — skipping overwrite."
else
    echo "Creating .env file from .env.example..."

    if [ ! -f "$APP_DIR/.env.example" ]; then
        echo "ERROR: .env.example not found in $APP_DIR!"
        exit 1
    fi

    cp "$APP_DIR/.env.example" "$ENV_FILE"
    echo "Copied .env.example to $ENV_FILE"
fi


# # Define function for updating .env to avoid repetition
# update_env_var() {
#     local key=$1
#     local value=$2
#     # Use '#' as delimiter for sed, safer for values with '/'
#     # Escape basic special characters for sed (&, /, \)
#     local escaped_value=$(echo "$value" | sed -e 's/[\/&]/\\&/g' -e 's/\\/\\\\/g')
#     # Check if key exists in the file before attempting replacement
#     if grep -q "^${key}=" .env; then
#       sed -i "s#^${key}=.*#${key}=${escaped_value}#" .env
#       echo "Updated ${key} in .env"
#     else
#       echo "WARN: Key ${key} not found in .env.example template, skipping update."
#     fi
# }

# echo "Fetching parameters from Parameter Store path: $PARAMETER_PATH"
# # Fetch SecureStrings with decryption, handle potential errors
# PARAMETERS_JSON=$(aws ssm get-parameters-by-path --path "$PARAMETER_PATH" --with-decryption --query "Parameters" --output json --region "$AWS_REGION")

# if [ -z "$PARAMETERS_JSON" ] || [ "$PARAMETERS_JSON" == "null" ] || [ "$PARAMETERS_JSON" == "[]" ]; then
#     echo "ERROR: Failed to fetch parameters from Parameter Store or no parameters found at path $PARAMETER_PATH!"
#     # Attempt to show raw output for debugging if jq is available
#     if command -v jq &> /dev/null; then
#         echo "Raw output (if any): $(aws ssm get-parameters-by-path --path "$PARAMETER_PATH" --with-decryption --output json --region "$AWS_REGION" || echo 'Error running command')"
#     fi
#     exit 1
# fi
# echo "Parameters fetched successfully."

# echo "Populating .env file from parameters..."
# # Use jq to iterate through the JSON array from get-parameters-by-path
# # Output format: [{"Name": "/path/key", "Type": "SecureString", "Value": "value"}, ...]
# echo "$PARAMETERS_JSON" | jq -c '.[]' | while IFS= read -r parameter_line; do
#     # Extract full name and value
#     param_name=$(echo "$parameter_line" | jq -r '.Name')
#     param_value=$(echo "$parameter_line" | jq -r '.Value')

#     # Extract the short key name (e.g., 'db_password' from '/project480/prod/db_password')
#     param_key_short=$(basename "$param_name")
#     # Convert the short key name to upper case to match .env convention (e.g., DB_PASSWORD)
#     param_key_upper=$(echo "$param_key_short" | tr '[:lower:]' '[:upper:]')

#     # Update the .env file using the upper-case key name
#     # The update_env_var function will handle the sed replacement
#     update_env_var "$param_key_upper" "$param_value"
# done
# echo ".env population attempt complete."

# ============================

# # Laravel setup
# echo "Running Laravel setup..."
# export COMPOSER_ALLOW_SUPERUSER=1

# chown -R www-data:www-data /var/www/html/project480
# git config --global --add safe.directory /var/www/html/project480

# cd "$APP_DIR"
# # /usr/local/bin/composer install --no-dev --optimize-autoloader
# # Clean old vendor and cache
# echo "Cleaning vendor and cache..."
# rm -rf /var/www/html/project480/vendor
# rm -f /var/www/html/project480/bootstrap/cache/*.php
# timeout 240 composer install --no-dev --optimize-autoloader --no-interaction --no-scripts
# chown -R www-data:www-data /var/www/html/project480

# ============================
# echo "Generating APP_KEY..."
# php artisan key:generate --force # Generates and automatically adds/updates APP_KEY in .env
# echo "APP_KEY generated."
# --- End .env file creation and population ---

# Permissions
# echo "Setting permissions..."
# chown -R www-data:www-data .
# chmod 640 .env
# chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data /var/www/html/project480

# # php artisan migrate --force
# php artisan config:clear
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache

# # Restart Apache - Remove this because it was likely causing CodeDeploy to fail
# echo "Restarting Apache server..."
# systemctl restart apache2

echo "Deployment script finished successfully."
