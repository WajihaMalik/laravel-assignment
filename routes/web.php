<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('/category-list', [CategoryController::class, 'getCategories'])->name('category.list');
    Route::get('/category/{slug}', [CategoryController::class, 'showCategories'])->name('category.show');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::post('/product/{id}/feedback', [ProductController::class, 'feedback'])->name('product.feedback');
});

require __DIR__.'/auth.php';
