<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\AuthSanctumController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

RateLimiter::for('api', function (Request $request) {
    return [
        Limit::perMinute(60)->by($request->user()?->getAuthIdentifier() ?: $request->ip()),
    ];
});

Route::prefix('v1')->group(function () {
    Route::get('/health', fn () => response()->json([
        'success' => true,
        'message' => 'API is healthy',
        'data' => ['timestamp' => now()],
        'errors' => null,
    ]));

    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/register-tenant', [AuthController::class, 'registerTenant']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/profile', [AuthController::class, 'profile']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/products/{id}', [ProductController::class, 'show']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);
        Route::post('/products/{id}/images', [ProductController::class, 'storeImage']);
        Route::delete('/products/{productId}/images/{imageId}', [ProductController::class, 'destroyImage']);

        Route::post('/sales', [SaleController::class, 'store']);
        Route::post('/sales/complete', [SaleController::class, 'complete']);
        Route::get('/sales/today', [SaleController::class, 'indexToday']);
        Route::get('/sales/{id}', [SaleController::class, 'show']);
    });
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthSanctumController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthSanctumController::class, 'logout']);
        Route::get('/me', [AuthSanctumController::class, 'me']);
    });
});

// Public store endpoints by tenant slug
Route::prefix('store/{tenant}')->group(function () {
    Route::get('/products', [StoreController::class, 'products']);
    Route::get('/product/{slug}', [StoreController::class, 'product']);
    Route::post('/cart/add', [StoreController::class, 'addToCart']);
    Route::post('/checkout', [StoreController::class, 'checkout']);
    Route::post('/orders', [StoreController::class, 'createOrder']);
});

