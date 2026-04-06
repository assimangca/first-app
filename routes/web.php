// This is a test change on the develop branch//
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController; // 1. Added this import
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Added this: This creates all 7 routes for your Posts (index, create, store, etc.)
    Route::resource('posts', PostController::class);
});

require __DIR__ . '/auth.php';
