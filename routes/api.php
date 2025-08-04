<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get('/products/list/{page}', [\App\Http\Controllers\ProductController::class, 'productList']);
Route::get('/products/get-by-id/{id}', [\App\Http\Controllers\ProductController::class, 'productById']);
Route::get('/products/get-by-chpu/{chpu}', [\App\Http\Controllers\ProductController::class, 'productByChpu']);
