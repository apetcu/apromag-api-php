<?php

use App\Http\Routes\Account\AccountController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth.role:VENDOR,CUSTOMER']], function () {
    Route::prefix('account')->namespace('Account')->group(function () {
        Route::get('', [AccountController::class, 'details']);
        Route::put('', [AccountController::class, 'updateDetails']);


        // Vendor routes
        Route::post('/vendor/profilePicture', [AccountController::class, 'updateProfilePicture'])->middleware('auth.role:VENDOR');
        Route::post('/vendor/images', [AccountController::class, 'addVendorImages'])->middleware('auth.role:VENDOR');
        Route::post('/vendor/deleteImage', [AccountController::class, 'deleteImage'])->middleware('auth.role:VENDOR');
        Route::post('/vendor/details', [AccountController::class, 'updateVendorDetails'])->middleware('auth.role:VENDOR');
        Route::get('/vendor/orderSummary', [AccountController::class, 'getOrderSummary'])->middleware('auth.role:VENDOR');
        Route::get('/vendor/products', [AccountController::class, 'getVendorProducts'])->middleware('auth.role:VENDOR');
        Route::get('/vendor/orders', [AccountController::class, 'getVendorOrders'])->middleware('auth.role:VENDOR');

        Route::post('/vendor/products', [AccountController::class, 'addProduct'])->middleware('auth.role:VENDOR,ADMIN');
        Route::post('/vendor/products/{id}', [AccountController::class, 'updateProduct'])->middleware('auth.role:VENDOR,ADMIN');
        Route::delete('/vendor/products/{id}', [AccountController::class, 'deleteProduct'])->middleware('auth.role:VENDOR,ADMIN');

        Route::delete('/vendor/products/{productId}/image/{imageId}', [AccountController::class, 'deleteProductImage'])->middleware('auth.role:VENDOR,ADMIN');

        // Customer routes
        Route::get('/orders', [AccountController::class, 'getCustomerOrders']);
        Route::get('/orders/{id}', [AccountController::class, 'getCustomerOrder']);

        Route::post('/change-password', [AccountController::class, 'changePassword'])->middleware('auth.role:VENDOR,CUSTOMER,ADMIN');
        Route::post('/change-email', [AccountController::class, 'changeEmail'])->middleware('auth.role:VENDOR,CUSTOMER,ADMIN');
        // https://medium.com/@victorighalo/custom-password-reset-in-laravel-21e57816989f
        // TODO: Password reset route + email (Using AccountController in controllers)
        // TODO: Email change route + email
    });
});