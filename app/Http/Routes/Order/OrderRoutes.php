<?php

use App\Http\Routes\Order\OrderController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth.role:VENDOR,CUSTOMER,ADMIN']], function () {
    Route::prefix('orders')->namespace('Order')->group(function () {
        Route::post('', [OrderController::class, 'save']);
        Route::get('/sendTestEmail', [OrderController::class, 'sendTestEmail']);

        Route::get('', [OrderController::class, 'getAll']);
        Route::get('/{id}', [OrderController::class, 'getById']);
        
        Route::post('/{id}/status', [OrderController::class, 'updateStatus'])->middleware('auth.role:VENDOR');
       
        Route::get('/{id}/status/history', [OrderController::class, 'getStatusHistory']);
        // Todo: create order and send email to both
    });
});
