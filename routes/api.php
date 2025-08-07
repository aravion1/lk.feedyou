<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/user/auth', [\App\Http\Controllers\UserController::class, 'auth']);
Route::prefix('products')->group(function () {
    $controller = \App\Http\Controllers\ProductController::class;
    Route::get('/list/{page}', [$controller, 'productList']);
    Route::get('/get-by-id/{id}', [$controller, 'productById']);
    Route::get('/get-by-chpu/{chpu}', [$controller, 'productByChpu']);
    Route::post('/create', [$controller, 'create']);
    Route::patch('/{id}', [$controller, 'updateProduct']);
    Route::delete('/{id}', [$controller, 'delete']);
});

