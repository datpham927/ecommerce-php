echo "Running composer"
composer install --no-dev --working-dir=/var/www/html

echo "Create app key"
php artisan key:generate --force

echo "Caching config..."
php artisan config:cache
php artisan view:clear

echo "Caching routes..."
php artisan route:cache

echo "Building assets with npm..."
if ! npm run build; then
    echo "NPM build failed!"
    exit 1
fi

echo "Checking database connection..."
if php artisan migrate --pretend; then
    echo "Database connection is working."
else
    echo "Database connection failed!"
    echo "Error: $(php artisan migrate --pretend 2>&1)"
    exit 1
fi

echo "Running migrations..."
php artisan migrate --force

echo "Seeding the database..."
php artisan db:seed
