<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\NewsPostController;
use Illuminate\Support\Facades\Route;

Route::middleware(['check.login', 'role:admin'])->group(function () {
  Route::get('/admin', [AdminController::class, 'index'])->name('admin_index');

  Route::prefix('admin/tin-tuc')->name('admin.news.')->controller(NewsPostController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/tao-moi', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{id}/sua', 'edit')->name('edit');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
  });
});
