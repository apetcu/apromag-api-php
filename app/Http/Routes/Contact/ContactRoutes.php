<?php

use App\Http\Routes\Contact\ContactController;
use Illuminate\Support\Facades\Route;

Route::prefix('contact')->namespace('Contact')->group(function () {
    Route::post('', [ContactController::class, 'sendMessage']);
});
