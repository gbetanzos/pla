<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingListController;

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

// Shopping Lists
Route::get('/shopping-lists', [ShoppingListController::class, 'index'])->name('shopping-lists.index');
Route::get('/shopping-lists/create', [ShoppingListController::class, 'create'])->name('shopping-lists.create');
Route::post('/shopping-lists', [ShoppingListController::class, 'store'])->name('shopping-lists.store');
Route::get('/shopping-lists/{list}', [ShoppingListController::class, 'show'])->name('shopping-lists.show');
Route::get('/shopping-lists/{list}/edit', [ShoppingListController::class, 'edit'])->name('shopping-lists.edit');
Route::put('/shopping-lists/{list}', [ShoppingListController::class, 'update'])->name('shopping-lists.update');
Route::delete('/shopping-lists/{list}', [ShoppingListController::class, 'destroy'])->name('shopping-lists.destroy');
Route::post('/shopping-lists/{list}/items/{item_id}/toggle', [ShoppingListController::class, 'toggleItem'])->name('shopping-lists.toggle-item');

// Home redirects
Route::get('/', function () { return redirect()->route('shopping-lists.index'); });
