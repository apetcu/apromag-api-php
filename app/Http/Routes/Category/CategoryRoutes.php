<?php

use App\Http\Routes\Category\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->namespace('Category')->group(function () {
    Route::get('', [CategoryController::class, 'getAll']);
    Route::get('/{id}', [CategoryController::class, 'getById']);
    Route::get('/{id}/products', [CategoryController::class, 'getProducts']);

    Route::post('', [CategoryController::class, 'create'])->middleware('auth.role:ADMIN');
    Route::post('/{id}', [CategoryController::class, 'update'])->middleware('auth.role:ADMIN');
    Route::delete('/{id}', [CategoryController::class, 'delete'])->middleware('auth.role:ADMIN');


});
