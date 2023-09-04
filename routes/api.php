<?php

use App\Http\Controllers\Api\V1\CartItemApiController;
use App\Http\Controllers\Api\V1\CommentApiController;
use App\Http\Controllers\Api\V1\FilterApiController;
use App\Http\Controllers\Api\V1\ImageApiController;
use App\Http\Controllers\Api\V1\LoginApiController;
use App\Http\Controllers\Api\V1\OrderApiController;
use App\Http\Controllers\Api\V1\PaymentApiController;
use App\Http\Controllers\Api\V1\ProductApiController;
use App\Http\Controllers\Api\V1\RegisterApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {

    Route::middleware(['auth:api'])->group(function () {

        // # comment section
        Route::prefix('comments')->group(function () {
            Route::post('/store/{product}', [CommentApiController::class, 'store']);
            Route::post('/reply/{comment}', [CommentApiController::class, 'reply']);
        });

        // # product section
        Route::prefix('products')->group(function () {
            Route::post('/store', [ProductApiController::class, 'store']);
            Route::get('/index', [ProductApiController::class, 'index']);
            Route::delete('/destroy/{product}', [ProductApiController::class, 'destroy']);
        });

        // # cart item section
        Route::prefix('cart-items')->group(function () {
            Route::post('/store/{product}', [CartItemApiController::class, 'store']);
        });

        // # order section
        Route::prefix('orders')->group(function () {
            Route::post('/store', [OrderApiController::class, 'store']);
        });

        // # payment section
        Route::prefix('payments')->group(function () {
            Route::post('/store', [PaymentApiController::class, 'store']);
        });

        // # image section
        Route::prefix('images')->group(function () {
            Route::post('/store/{product}', [ImageApiController::class, 'store']);
        });
    });

    // # auth section
    Route::post('register', [RegisterApiController::class, 'index']);
    Route::post('login', [LoginApiController::class, 'index']);
    Route::get('logout', [LoginApiController::class, 'logout'])->middleware('auth');
});
