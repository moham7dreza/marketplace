<?php

use App\Http\Controllers\Api\V1\CartItemApiController;
use App\Http\Controllers\Api\V1\CommentApiController;
use App\Http\Controllers\Api\V1\ImageApiController;
use App\Http\Controllers\Api\V1\OrderApiController;
use App\Http\Controllers\Api\V1\PaymentApiController;
use App\Http\Controllers\Api\V1\ProductApiController;
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

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {

    // # comment section
    Route::prefix('comments')->group(function () {
        Route::post('/store/{product}', [CommentApiController::class, 'store']);
        Route::post('/reply/{comment}', [CommentApiController::class, 'reply']);
    });

    // # product section
    Route::prefix('products')->group(function () {
        Route::post('/store', [ProductApiController::class, 'store']);
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
