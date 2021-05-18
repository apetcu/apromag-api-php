<?php

use App\Http\Routes\Social\SocialController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'web'], function () {
    Route::prefix('social')->namespace('Social')->group(function () {
        Route::get('redirect', [SocialController::class, 'redirect']);
        Route::get('callback', [SocialController::class, 'callback']);
    });
});