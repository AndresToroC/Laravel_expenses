<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\CategoryController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->group(function() {
    Route::put('user/{user}/salary/update', [SalaryController::class, 'salary']);
});

Route::get('categories', [CategoryController::class, 'categories']);
Route::get('subCategories', [CategoryController::class, 'subCategories']);