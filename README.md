# Backend Food App

Project backend untuk food app

## Cara Instal Project Ini

```console
git clone repository ini
cd foodapilaravel
composer install
php -r "file_exists('.env') || copy('.env.example', '.env');"
php artisan package:discover --ansi
php artisan key:generate
php artisan migrate
php artisan serve
```
