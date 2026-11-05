<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClientController::class, 'index'])->name('client.index');

// Tra cứu danh sách sách & lọc
Route::get('/tra-cuu-sach', [ClientController::class, 'books'])->name('client.books.index');

// Xem chi tiết từng cuốn sách qua slug
Route::get('/sach/{slug}', [ClientController::class, 'showBook'])->name('client.books.show');

Route::get('/rule', [ClientController::class, 'rule'])->name('rule');
Route::get('/guide', [ClientController::class, 'guide'])->name('guide');

// route cần đăng nhập
Route::middleware(['check.login'])->group(function () {
    // sách yêu thích
    Route::post('/sach/{id}/yeu-thich', [ClientController::class, 'addToFavourite'])->name('client.books.favorite');
    Route::get('/sach-yeu-thich', [ClientController::class, 'favoriteBooks'])->name('client.books.favorites');

    // Hồ sơ độc giả & Đổi mật khẩu
    Route::get('/ho-so', [ProfileController::class, 'index'])->name('client.profile.index');
    Route::put('/ho-so/cap-nhat', [ProfileController::class, 'update'])->name('client.profile.update');
    Route::put('/ho-so/doi-mat-khau', [ProfileController::class, 'changePassword'])->name('client.profile.password');
});