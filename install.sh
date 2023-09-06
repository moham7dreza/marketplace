./fix-permissions.sh
cp .env.example .env
composer install
php artisan key:generate
cp .env .env.testing
php artisan migrate --seed
php artisan passport:install
php artisan optimize:clear
php artisan serve
php artisan app:submit-order
