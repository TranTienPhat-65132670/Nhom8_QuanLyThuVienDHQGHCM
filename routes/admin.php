<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;

Route::middleware(['check.login', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin_index');

    Route::resource('admin/categories', CategoryController::class);

    Route::resource('admin/books', BookController::class);

    Route::prefix('admin/borrows')->name('admin.borrows.')->group(function () {
        Route::get('/', [AdminController::class, 'borrowIndex'])->name('index'); // Trỏ đến borrowIndex
        Route::get('/{id}', [AdminController::class, 'show'])->name('show');
        Route::post('/{id}/update-status', [AdminController::class, 'updateStatus'])->name('updateStatus');
    });

    // làm logic để hệ thống tự kiểm tra và cập nhật nếu phiếu quá hạn và làm logic phạt tiền
});
