<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;

Route::middleware(['check.login', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin_index');

    Route::resource('admin/categories', CategoryController::class);

    Route::resource('admin/books', BookController::class);
});