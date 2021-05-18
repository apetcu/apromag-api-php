<?php

use App\Http\Routes\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth.role:ADMIN']], function () {
    Route::prefix('admin')->namespace('Account')->group(function () {
        Route::get('statistics', [AdminController::class, 'getStatistics']);
        Route::get('analytics', [AdminController::class, 'getAnalytics']);
        
        
        Route::get('products', [AdminController::class, 'getProducts']);
        Route::get('products/{id}', [AdminController::class, 'getProductById']);
        Route::post('products/{id}/changeStatus', [AdminController::class, 'setProductStatus']);

        
        Route::get('vendors', [AdminController::class, 'getVendors']);
        Route::get('vendors/{id}', [AdminController::class, 'getVendorById']);

    });
});