<?php

use App\Http\Routes\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth.role:ADMIN']], function () {
    Route::prefix('users')->namespace('User')->group(function () {
        Route::get('', [UserController::class, 'getAll']);
        Route::get('/{id}', [UserController::class, 'getById']);

        Route::put('/{id}/status', [UserController::class, 'setStatus']);
        Route::put('/{id}', [UserController::class, 'updateUser']);

    });
});