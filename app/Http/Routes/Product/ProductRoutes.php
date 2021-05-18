<?php

use App\Http\Routes\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->namespace('Product')->group(function () {
    Route::get('', [ProductController::class, 'getAll']);
    Route::get('/{id}', [ProductController::class, 'getById']);

    Route::post('', [ProductController::class, 'addProduct'])->middleware('auth.role:VENDOR,ADMIN');
    Route::post('/{id}', [ProductController::class, 'updateProduct'])->middleware('auth.role:VENDOR,ADMIN');
    Route::delete('/{id}', [ProductController::class, 'deleteProduct'])->middleware('auth.role:VENDOR,ADMIN');
    
});
