./fix-permissions.sh
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan optimize:clear
