<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;

Route::middleware(['check.login', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin_index');

    Route::resource('admin/categories', CategoryController::class);

    Route::resource('admin/books', BookController::class);

    // Quản lý tài khoản & độc giả
    Route::patch('admin/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::resource('admin/users', UserController::class)->names('admin.users');
});