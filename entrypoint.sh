#!/bin/bash

# Wait for the database to be ready
echo "Waiting for the database to be ready..."
while ! mysqladmin ping -h"laravel_db" -u"laravel_user" -p"your_mysql_password" --silent; do
    echo "Database is not ready yet. Retrying in 1 second..."
    sleep 1
done

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Check if the database has already been seeded
SEEDED_FILE=/var/www/storage/app/database_seeded
if [ ! -f "$SEEDED_FILE" ]; then
    echo "Seeding the database..."
    php artisan db:seed --force

    # Create a file to indicate that the database has been seeded
    touch $SEEDED_FILE
    echo "Database seeding completed."
else
    echo "Database has already been seeded. Skipping seeding."
fi

echo "Installing npm dependencies..."
npm install

# Run npm dev server
echo "Starting npm dev server..."
npm run dev &

# Start the application
echo "Starting the application..."
php-fpm
