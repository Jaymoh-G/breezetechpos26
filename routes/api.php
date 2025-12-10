<?php

use App\Http\Controllers\Api\V1\AuthController;
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
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/profile', [AuthController::class, 'profile']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
    });
});

