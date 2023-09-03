<?php

use App\Http\Controllers\Api\V1\CartItemApiController;
use App\Http\Controllers\Api\V1\CommentApiController;
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

Route::prefix('v1')->group(function () {

    // # comment section
    Route::prefix('comments')->middleware(['auth:sanctum'])->group(function () {
        Route::post('/store/{product}', [CommentApiController::class, 'store']);
        Route::post('/reply/{comment}', [CommentApiController::class, 'reply']);
    });

    // # product section
    Route::prefix('products')->middleware(['auth:sanctum'])->group(function () {
        Route::post('/store', [ProductApiController::class, 'store']);
        Route::delete('/destroy/{product}', [ProductApiController::class, 'destroy']);
    });

    // # cart item section
    Route::prefix('cart-items')->middleware(['auth:sanctum'])->group(function () {
        Route::post('/store/{product}', [CartItemApiController::class, 'store']);
    });
});
