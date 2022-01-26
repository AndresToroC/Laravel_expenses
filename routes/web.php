<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\SocialiteProfileController;

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

// Rutas de administrador
Route::middleware('auth')->name('admin.')->prefix('admin')->group(function() {
    Route::resource('users', UserController::class);
    Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::get('usersDownload', [UserController::class, 'downloadFile'])->name('users.download');
});

// Rutas para autenticacion con Github, google, facebook, etc
Route::get('auth/{provider}/login', [SocialiteProfileController::class, 'login'])->name('socialite.login');
Route::get('auth/{provider}/callback', [SocialiteProfileController::class, 'callback'])->name('socialite.callback');
