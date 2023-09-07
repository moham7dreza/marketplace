<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Project run structure

- Step 1 : create database with name marketplace or every thing you want and modify it in .env.example file
- Step 2 : Enter your database user and password in .env.example file
- Step 3 : Run install.sh file for setup project
- Step 4 : Run command : php artisan serve
- Step 5 : Run command : php artisan queue:work
- Step 6 : Run command : php artisan app:submit-order for run process
- Step 7 : Remove your database user and password from .env.example file before pushing
- Step 8 : Run command : composer test for run all tests

## submit-order command description

- Step 1 : user try to add items to cart
- Step 2 : user select delivery method for shipping products
- Step 3 : user submit order with unchecked status
- Step 4 : find user order and try to pay order amount
- Step 5 : set order status to confirmed and payment status to paid
- Step 6 : after successful payment delete user cart items
- Step 7 : add cart items to order items and update each item amount according to delivery amount
- Step 8 : find system admin and send email to it about submitted order
- Step 9 : display details to user in each step
- Step 10 : display overall report to user

## Services

- Custom image service for upload images using image intervention
- Custom message service for easily send emails or sms and more for users

## Work history

- write tests for api with php pest
- write with passport for auth
- work with spatie role permission
- work with event listener and jobs
- work with laravel mail with markdown
- work with observers
- work with commands
- work with gates for authorization
- work with enums and traits
