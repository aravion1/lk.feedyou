<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/public/product/list/{page}', [\App\Http\Controllers\ProductController::class, 'productList'])->middleware(
    \App\Http\Middleware\PublicAppMiddleware::class
);

Route::post('/user/auth', [\App\Http\Controllers\UserController::class, 'auth']);
Route::prefix('products')->group(function () {
    $controller = \App\Http\Controllers\ProductController::class;
    Route::get('/list/{page}', [$controller, 'productList']);
    Route::get('/get-by-id/{id}', [$controller, 'productById']);
    Route::get('/get-by-chpu/{chpu}', [$controller, 'productByChpu']);
    Route::post('/create', [$controller, 'create']);
    Route::post('/image', [$controller, 'deleteImage']);
    Route::post('/{id}', [$controller, 'updateProduct']);
    Route::delete('/{id}', [$controller, 'delete']);
})->middleware('auth:sanctum');

Route::prefix('/product_categories')->group(function() {
    $controller = \App\Http\Controllers\ProductCategoriesController::class;

    Route::post('/save', [$controller, 'save']);
    Route::get('/list', [$controller, 'all']);
    Route::delete('/{id}', [$controller, 'delete']);
})->middleware('auth:sanctum');

