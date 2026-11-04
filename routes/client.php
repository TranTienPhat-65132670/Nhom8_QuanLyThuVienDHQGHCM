<?php

use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\NewsPostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClientController::class, 'index'])->name('client.index');

// Tra cứu danh sách sách & lọc
Route::get('/tra-cuu-sach', [ClientController::class, 'books'])->name('client.books.index');

// Xem chi tiết từng cuốn sách qua slug
Route::get('/sach/{slug}', [ClientController::class, 'showBook'])->name('client.books.show');

Route::get('/rule', [ClientController::class, 'rule'])->name('rule');
Route::get('/guide', [ClientController::class, 'guide'])->name('guide');

Route::get('/tin-tuc', [NewsPostController::class, 'publicIndex'])->name('news.index');
Route::get('/tin-tuc/{id}', [NewsPostController::class, 'show'])->name('news.show');

// route cần đăng nhập
Route::middleware(['check.login'])->group(function () {
  // sách yêu thích
  Route::post('/sach/{id}/yeu-thich', [ClientController::class, 'addToFavourite'])->name('client.books.favorite');
  Route::get('/sach-yeu-thich', [ClientController::class, 'favoriteBooks'])->name('client.books.favorites');

  // route mượn trả sách
  Route::get('/phieu-muon-cua-toi', [BorrowController::class, 'index'])->name('client.borrow.index');
  Route::get('/phieu-muon/{id}', [BorrowController::class, 'show'])->name('client.borrow.show');
  Route::post('/borrow/create', [BorrowController::class, 'createBorrowView'])->name('client.borrow.create');
  Route::post('/borrow/store', [BorrowController::class, 'store'])->name('client.borrow.store');
  Route::post('/borrow/{id}/cancel', [BorrowController::class, 'cancelBorrow'])->name('client.borrow.cancel');

  // đặt mượn sách nhanh 1 cuốn khi nhấn đặt sách
  Route::post('/borrow/quick-create/{bookId}', [BorrowController::class, 'quickCreateBorrow'])->name('client.borrow.quickCreate');
});
