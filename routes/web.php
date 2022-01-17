<?php

use Illuminate\Support\Facades\Route;

// Administrador
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/logout', function() {
    Auth::logout();

    return view('auth.login');
})->name('logout');

Route::name('admin.')->prefix('admin')->group(function() {
    Route::resource('users', UserController::class);
});