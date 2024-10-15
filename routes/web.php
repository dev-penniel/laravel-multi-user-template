<?php

use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Normal User
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'user'])->name('dashboard');

//Admin User
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('admin.dashboard');

//Super Admin User
Route::get('/super-admin/dashboard', function () {
    return view('super-admin.dashboard');
})->middleware(['auth', 'verified', 'super-admin'])->name('super-admin.dashboard');

// Users routes
Route::resource('users', UserController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified', 'super-admin']);

// Super admin updates user password
Route::patch('/users/{user}/update-password', [PasswordChangeController::class, 'update'])->name('users.update-password');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
