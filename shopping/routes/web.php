<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingListController;

// Products (plural for multiple, single for show/edit)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

// Shopping Lists
Route::get('/shopping-list', [ShoppingListController::class, 'index'])->name('shopping-list.index');
Route::get('/shopping-list/create', [ShoppingListController::class, 'create'])->name('shopping-list.create');
Route::post('/shopping-list', [ShoppingListController::class, 'store'])->name('shopping-list.store');
Route::get('/shopping-list/{list}', [ShoppingListController::class, 'show'])->name('shopping-list.show');
Route::get('/shopping-list/{list}/edit', [ShoppingListController::class, 'edit'])->name('shopping-list.edit');
Route::put('/shopping-list/{list}', [ShoppingListController::class, 'update'])->name('shopping-list.update');
Route::post('/shopping-list/{list}/toggle', [ShoppingListController::class, 'toggle'])->name('shopping-list.toggle');
Route::post('/shopping-list/{list}/mark-complete', [ShoppingListController::class, 'markComplete'])->name('shopping-list.mark-complete');
Route::post('/shopping-list/{list}/mark-complete', [ShoppingListController::class, 'markComplete'])->name('shopping-list.mark-complete');
Route::delete('/shopping-list/{list}', [ShoppingListController::class, 'destroy'])->name('shopping-list.destroy');

// Home
Route::get('/', function () {
    $lists = ShoppingList::whereNotNull('user_id')->orderBy('created_at', 'desc')->paginate(10);
    foreach ($lists as $list) {
        $list->load('items');
    }
    return view('shopping-lists.index', compact('lists'));
});
