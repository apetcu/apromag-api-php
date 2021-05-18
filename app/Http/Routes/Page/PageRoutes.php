<?php

use App\Http\Routes\Page\PageController;
use Illuminate\Support\Facades\Route;

Route::prefix('pages')->namespace('Page')->group(function () {
    Route::get('', [PageController::class, 'getAll']);
    Route::get('/{id}', [PageController::class, 'getById']);
    
    
    Route::post('/{id}', [PageController::class, 'update'])->middleware('auth.role:ADMIN');
});
