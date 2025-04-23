#!/bin/bash

set -e  # Exit on any error

# --- Configuration ---
APP_DIR="/var/www/html/project480"
DEPLOY_DIR="/tmp/deployment"
LOG_FILE="/var/log/deploy_laravel.log"
AWS_REGION="us-west-1"
PARAMETER_PATH="/project480/prod" # The path prefix for the parameters in Parameter Store
# --- End Configuration ---

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

echo "Creating new app directory and copying files..."
mkdir -p "$APP_DIR"
rsync -av "$DEPLOY_DIR/" "$APP_DIR/"
echo "Files copied using rsync."

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
ENV_FILE="$APP_DIR/.env"

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


# Define function for updating .env to avoid repetition
update_env_var() {
    local key=$1
    local value=$2
    # Use '#' as delimiter for sed, safer for values with '/'
    # Escape basic special characters for sed (&, /, \)
    local escaped_value=$(echo "$value" | sed -e 's/[\/&]/\\&/g' -e 's/\\/\\\\/g')
    # Check if key exists in the file before attempting replacement
    if grep -q "^${key}=" .env; then
      sed -i "s#^${key}=.*#${key}=${escaped_value}#" .env
      echo "Updated ${key} in .env"
    else
      echo "WARN: Key ${key} not found in .env.example template, skipping update."
    fi
}

echo "Fetching parameters from Parameter Store path: $PARAMETER_PATH"
# Fetch SecureStrings with decryption, handle potential errors
PARAMETERS_JSON=$(aws ssm get-parameters-by-path --path "$PARAMETER_PATH" --with-decryption --query "Parameters" --output json --region "$AWS_REGION")

if [ -z "$PARAMETERS_JSON" ] || [ "$PARAMETERS_JSON" == "null" ] || [ "$PARAMETERS_JSON" == "[]" ]; then
    echo "ERROR: Failed to fetch parameters from Parameter Store or no parameters found at path $PARAMETER_PATH!"
    # Attempt to show raw output for debugging if jq is available
    if command -v jq &> /dev/null; then
        echo "Raw output (if any): $(aws ssm get-parameters-by-path --path "$PARAMETER_PATH" --with-decryption --output json --region "$AWS_REGION" || echo 'Error running command')"
    fi
    exit 1
fi
echo "Parameters fetched successfully."

echo "Populating .env file from parameters..."
# Use jq to iterate through the JSON array from get-parameters-by-path
# Output format: [{"Name": "/path/key", "Type": "SecureString", "Value": "value"}, ...]
echo "$PARAMETERS_JSON" | jq -c '.[]' | while IFS= read -r parameter_line; do
    # Extract full name and value
    param_name=$(echo "$parameter_line" | jq -r '.Name')
    param_value=$(echo "$parameter_line" | jq -r '.Value')

    # Extract the short key name (e.g., 'db_password' from '/project480/prod/db_password')
    param_key_short=$(basename "$param_name")
    # Convert the short key name to upper case to match .env convention (e.g., DB_PASSWORD)
    param_key_upper=$(echo "$param_key_short" | tr '[:lower:]' '[:upper:]')

    # Update the .env file using the upper-case key name
    # The update_env_var function will handle the sed replacement
    update_env_var "$param_key_upper" "$param_value"
done
echo ".env population attempt complete."

echo "Generating APP_KEY..."
php artisan key:generate --force # Generates and automatically adds/updates APP_KEY in .env
echo "APP_KEY generated."
# --- End .env file creation and population ---

# Permissions
echo "Setting permissions..."
chown -R www-data:www-data .
chmod 640 .env
chmod -R 775 storage bootstrap/cache

# Laravel setup
echo "Running Laravel setup..."
export COMPOSER_ALLOW_SUPERUSER=1
# /usr/local/bin/composer install --no-dev --optimize-autoloader
composer install --no-dev --optimize-autoloader
# php artisan migrate --force
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart Apache
echo "Restarting Apache server..."
systemctl restart apache2

echo "Deployment script finished successfully."
