./fix-permissions.sh
cp .env.example .env
composer install
php artisan key:generate
cp .env .env.testing
php artisan passport:install
php artisan migrate --seed
php artisan optimize:clear
php artisan serve
