<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['check.login', 'role:admin'])->group(function () {
  Route::get('/admin', [AdminController::class, 'index'])->name('admin_index');
});
