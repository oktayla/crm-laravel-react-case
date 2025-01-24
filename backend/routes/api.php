<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RecentActivityController;
use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/stats', [StatsController::class, 'show']);
        Route::get('/recent-activity', [RecentActivityController::class, 'getDashboardActivity']);
    });

    Route::controller(CustomerController::class)
        ->prefix('customers')
        ->group(function () {
            Route::get('/', 'index')->middleware('permission:view customers');
            Route::get('/{id}', 'show')->middleware('permission:view customers');
            Route::post('/', 'store')->middleware('permission:create customers');
            Route::get('/search', 'search')->middleware('permission:view customers');
        });

    Route::controller(OrderController::class)
        ->prefix('orders')
        ->group(function () {
            Route::get('/', 'index')->middleware('permission:view orders');
            Route::get('/{id}', 'show')->middleware('permission:view orders');
        });

    Route::post('logout', [AuthController::class, 'logout']);
});
