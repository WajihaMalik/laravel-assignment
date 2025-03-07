<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register-user', [UserAuthController::class, 'registerUser']);
Route::post('/login-user', [UserAuthController::class, 'loginUser']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserAuthController::class, 'getUsers']);
    Route::get('/categories', [CategoryController::class, 'getCategories']);
    Route::get('/products', [ProductController::class, 'getProducts']);
});
