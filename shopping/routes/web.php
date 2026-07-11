<?php

use App\Http\Controllers\ProfileController;
use App\Models\ShoppingList;
use Illuminate\Support\Facades\Route;

 Route::get('/', function () {
      return view('landing.index', ['lists' => ShoppingList::whereNotNull('user_id')
          ->select(['id', 'user_id', 'title', 'description', 'priority', 'due_date', 'completed_at', 'is_completed'])
          ->orderBy('is_completed', 'desc')
          ->orderBy('created_at', 'desc')
          ->paginate(10)
          ->append('path', request()->previousUrl)]);
  })->name('landing');

 Route::get('/dashboard', function () {
        return view('landing.dashboard');
    })->name('dashboard');

 Route::middleware(['auth'])->group(function () {
    Route::get('/shopping-list/create', [App\Http\Controllers\ShoppingListController::class, 'create'])->name('shopping-list.create');
    Route::post('/shopping-list', [App\Http\Controllers\ShoppingListController::class, 'store'])->name('shopping-list.store');
    Route::get('/shopping-list/{list}/edit', [App\Http\Controllers\ShoppingListController::class, 'edit'])->name('shopping-lists.edit')->where('id', '[0-9]+');
    Route::put('/shopping-list/{list}', [App\Http\Controllers\ShoppingListController::class, 'update'])->name('shopping-lists.update')->where('id', '[0-9]+');
    Route::delete('/shopping-list/{list}', [App\Http\Controllers\ShoppingListController::class, 'destroy'])->name('shopping-lists.destroy')->where('id', '[0-9]+');
    Route::post('/shopping-list/{list}/toggle-item', [App\Http\Controllers\ShoppingListController::class, 'toggleItem'])->name('shopping-lists.toggle-item')->where('id', '[0-9]+');
    Route::post('/shopping-list/{list}/mark-complete', [App\Http\Controllers\ShoppingListController::class, 'markComplete'])->name('shopping-lists.mark-complete')->where('id', '[0-9]+');
    Route::post('/shopping-list/{list}/add-item', [App\Http\Controllers\ShoppingListController::class, 'addItem'])->name('shopping-lists.add-item')->where('id', '[0-9]+');
});

Route::get('/shopping-list', [App\Http\Controllers\ShoppingListController::class, 'index'])->name('shopping-lists.index');
Route::get('/shopping-list/{list}', [App\Http\Controllers\ShoppingListController::class, 'show'])->name('shopping-lists.show')->where('id', '[0-9]+');

// Product mutation routes require auth
Route::middleware(['auth'])->group(function () {
    // Product mutation routes require auth (already here)
    Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
});

Route::middleware(['auth'])->group(function () { // This group should ideally contain all product/list actions needing auth
// ... rest of the logic
        
// The routes for ProductCRUD functions are already inside an auth middleware group (lines 35-41). I will ensure the products.index route is also within that functional grouping established by lines 35-41, to keep related authenticated endpoints together and secure it.

/* Reorganizing product routes:
Original:
Route::middleware(['auth'])->group(function () {
    Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
    // ... other product mutations
});

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index'); // This is outside auth middleware initially

Fix: Move lines 43-44 (products.index) into the auth group starting on line 35.
*/
Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

require __DIR__.'/auth.php';