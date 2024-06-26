#!/bin/bash

# Check if the .env file exists
if [ ! -f /var/www/html/.env ]; then
  echo "Creating .env file from example..."
  cp /var/www/html/.env.example /var/www/html/.env
fi

# Run Composer install if vendor folder is not present
if [ ! -d /var/www/html/vendor ]; then
  echo "Running composer install..."
  composer install
fi

# Run migrations if the migrations folder is empty
if [ -z "$(ls -A /var/www/html/database/migrations)" ]; then
  echo "Running migrations..."
  php artisan migrate
fi

exec "$@"
