sudo ./fix-permissions.sh
cp .env.example .env
composer install --ignore-platform-reqs
php artisan key:generate
cp .env .env.testing
php artisan migrate --seed
php artisan passport:install
php artisan optimize:clear
