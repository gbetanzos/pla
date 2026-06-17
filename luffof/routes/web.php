<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'bpCount' => App\Models\BloodPressure::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Blood Pressure Routes
    Route::get('/bp', [BpController::class, 'index'])->name('bp.index');
    Route::get('/bp/create', [BpController::class, 'create'])->name('bp.create');
    Route::post('/bp', [BpController::class, 'store'])->name('bp.store');
    Route::get('/bp/{bp}', [BpController::class, 'show'])->name('bp.show');
    Route::get('/bp/{bp}/edit', [BpController::class, 'edit'])->name('bp.edit');
    Route::patch('/bp/{bp}', [BpController::class, 'update'])->name('bp.update');
    Route::delete('/bp/{bp}', [BpController::class, 'destroy'])->name('bp.destroy');
});

require __DIR__.'/auth.php';
