<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('/', [ClientController::class, 'index'])->name('client.index');

// Tra cứu danh sách sách & lọc
Route::get('/tra-cuu-sach', [ClientController::class, 'books'])->name('client.books.index');

// Xem chi tiết từng cuốn sách qua slug
Route::get('/sach/{slug}', [ClientController::class, 'showBook'])->name('client.books.show');
