<?php

use App\Http\Routes\Cart\CartController;
use Illuminate\Support\Facades\Route;

Route::prefix('cart')->namespace('Cart')->group(function () {
    Route::post('/total', [CartController::class, 'total']);
});
