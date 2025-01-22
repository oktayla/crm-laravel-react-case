<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::controller(CustomerController::class)
    ->prefix('customers')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/', 'index')->middleware('permission:view customers');
        Route::post('/', 'store')->middleware('permission:create customers');

        Route::get('statistics', 'statistics')->middleware('permission:view customers');
        Route::get('search', 'search')->middleware('permission:view customers');

        Route::get('{id}', 'show')->middleware('permission:view customers');
        Route::put('{id}', 'update')->middleware('permission:edit customers');
        Route::delete('{id}', 'destroy')->middleware('permission:delete customers');

        Route::get('{id}/orders', 'orders')->middleware('permission:view orders');
        Route::get('{id}/invoices', 'invoices')->middleware('permission:view invoices');

        Route::get('customers', 'export')->middleware('permission:view customers');
    });
