<?php

use App\Http\Routes\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->namespace('Auth')->group(function () {
     Route::post('/login', [AuthController::class, 'login']);
     Route::post('/register', [AuthController::class, 'register']);
     Route::post('/password-reset', [AuthController::class, 'passwordReset']);
     Route::post('/password-reset/{token}', [AuthController::class, 'passwordResetWithToken']);
});
