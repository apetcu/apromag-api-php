<?php

use App\Http\Routes\Shipping\ShippingController;
use Illuminate\Support\Facades\Route;

Route::prefix('shipping')->namespace('Shipping')->group(function () {
     Route::get('locations', [ShippingController::class, 'getLocations']);
     Route::post('preferences', [ShippingController::class, 'updatePreferences'])->middleware('auth.role:VENDOR');

    Route::post('locations', [ShippingController::class, 'create'])->middleware('auth.role:ADMIN');
    Route::put('locations/{id}', [ShippingController::class, 'update'])->middleware('auth.role:ADMIN');
    Route::delete('locations/{id}', [ShippingController::class, 'delete'])->middleware('auth.role:ADMIN');


});

