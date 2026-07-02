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

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.index.edit');
Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
Route::put('/products/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/product/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');

Route::get('/shopping-list', [App\Http\Controllers\ShoppingListController::class, 'index'])->name('shopping-lists.index');
Route::get('/shopping-list/create', [App\Http\Controllers\ShoppingListController::class, 'create'])->name('shopping-list.create');
Route::post('/shopping-list', [App\Http\Controllers\ShoppingListController::class, 'store'])->name('shopping-list.store');

// Additional aliases for routes used in views
Route::get('/shopping-list/{list}', [App\Http\Controllers\ShoppingListController::class, 'show'])->name('shopping-lists.show')->where('id', '[0-9]+');
Route::get('/shopping-list/{list}/edit', [App\Http\Controllers\ShoppingListController::class, 'edit'])->name('shopping-lists.edit')->where('id', '[0-9]+');
Route::put('/shopping-list/{list}', [App\Http\Controllers\ShoppingListController::class, 'update'])->name('shopping-lists.update')->where('id', '[0-9]+');
Route::delete('/shopping-list/{list}', [App\Http\Controllers\ShoppingListController::class, 'destroy'])->name('shopping-lists.destroy')->where('id', '[0-9]+');
Route::post('/shopping-list/{list}/mark-complete', [App\Http\Controllers\ShoppingListController::class, 'markComplete'])->name('shopping-lists.mark-complete')->where('id', '[0-9]+');

// Profile routes (Laravel scaffolding)
Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

// Simple login redirect (first page after login)
Route::get('/login', function () {
    if(session()->has('user')) {
        return redirect()->intended('/');
    }
    return view('landing.login-page');
})->name('login');

require __DIR__.'/auth.php';