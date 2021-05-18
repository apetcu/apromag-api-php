<?php

use App\Http\Routes\Vendor\VendorController;
use Illuminate\Support\Facades\Route;

Route::prefix('vendors')->namespace('Vendor')->group(function () {
    Route::get('', [VendorController::class, 'getAll']);
    Route::get('/popular', [VendorController::class, 'getPopular']);
    Route::get('/latest', [VendorController::class, 'getLatest']);


    Route::get('/{id}', [VendorController::class, 'getById']);
    Route::get('/{id}/products', [VendorController::class, 'getProducts']);

    Route::put('/{id}/status', [VendorController::class, 'setStatus'])->middleware('auth.role:ADMIN');
});
