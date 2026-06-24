<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingListController;
use App\Models\ShoppingList;

// Products (plural for multiple, single for show/edit)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::post('/product', [ProductController::class, 'store'])->name('product.store');

// Shopping Lists
Route::get('/shopping-lists', [ShoppingListController::class, 'index'])->name('shopping-lists.index');
Route::get('/shopping-lists/create', [ShoppingListController::class, 'create'])->name('shopping-lists.create');
Route::post('/shopping-lists', [ShoppingListController::class, 'store'])->middleware('auth')->name('shopping-lists.store');
Route::get('/shopping-lists/{list}', [ShoppingListController::class, 'show'])->name('shopping-lists.show');
Route::get('/shopping-lists/{list}/edit', [ShoppingListController::class, 'edit'])->name('shopping-lists.edit');
Route::put('/shopping-lists/{list}', [ShoppingListController::class, 'update'])->name('shopping-lists.update');
Route::post('/shopping-lists/{list}/toggle', [ShoppingListController::class, 'toggle'])->name('shopping-lists.toggle');
Route::post('/shopping-lists/{list}/mark-complete', [ShoppingListController::class, 'markComplete'])->name('shopping-lists.mark-complete');
Route::delete('/shopping-lists/{list}', [ShoppingListController::class, 'destroy'])->name('shopping-lists.destroy');

// Home
Route::get('/', function () {
    $lists = ShoppingList::whereNotNull('user_id')->orderBy('created_at', 'desc')->paginate(10);
    foreach ($lists as $list) {
        $list->load('items');
    }
    return view('shopping-lists.index', compact('lists'));
});
