<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('landing.dashboard');
    })->name('dashboard');

    Route::get('/shopping-list/create', [App\Http\Controllers\ShoppingListController::class, 'create'])->name('shopping-list.create');
    Route::post('/shopping-list', [App\Http\Controllers\ShoppingListController::class, 'store'])->name('shopping-list.store');
    Route::get('/shopping-list/{list}/edit', [App\Http\Controllers\ShoppingListController::class, 'edit'])->name('shopping-lists.edit')->where('id', '[0-9]+');
    Route::put('/shopping-list/{list}', [App\Http\Controllers\ShoppingListController::class, 'update'])->name('shopping-lists.update')->where('id', '[0-9]+');
    Route::delete('/shopping-list/{list}', [App\Http\Controllers\ShoppingListController::class, 'destroy'])->name('shopping-lists.destroy')->where('id', '[0-9]+');
    Route::post('/shopping-list/{list}/toggle-item', [App\Http\Controllers\ShoppingListController::class, 'toggleItem'])->name('shopping-lists.toggle-item')->where('id', '[0-9]+');
    Route::post('/shopping-list/{list}/mark-complete', [App\Http\Controllers\ShoppingListController::class, 'markComplete'])->name('shopping-lists.mark-complete')->where('id', '[0-9]+');
    Route::post('/shopping-list/{list}/add-item', [App\Http\Controllers\ShoppingListController::class, 'addItem'])->name('shopping-lists.add-item')->where('id', '[0-9]+');
    Route::post('/shopping-list/{list}/duplicate', [App\Http\Controllers\ShoppingListController::class, 'duplicate'])->name('shopping-lists.duplicate')->where('id', '[0-9]+');
    Route::get('/shopping-list', [App\Http\Controllers\ShoppingListController::class, 'index'])->name('shopping-lists.index');
    Route::get('/shopping-list/{list}', [App\Http\Controllers\ShoppingListController::class, 'show'])->name('shopping-lists.show')->where('id', '[0-9]+');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
    Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/product/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');

    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
});

require __DIR__.'/auth.php';