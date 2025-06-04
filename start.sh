echo "Running compser"

compser install --no-dev --working-dir=./var/www/html
echo "Caching fonfig"
php artisan config:cache


echo "Caching routes"
php artisan route:cache

echo "Publishing cloudinary provider"
php artisan vendor:publish --provider="Cloudinary\CloudinaryLaravel\CloudinaryServiceProvider" --tag="cloudinary-laravel-config"

echo "Running migrations"
php artisan migrate --force