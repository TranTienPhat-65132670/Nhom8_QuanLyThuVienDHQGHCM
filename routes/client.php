<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:member'])->group(function () {
  Route::get('/', [ClientController::class, 'index'])->name('client_index');

  // nội quy thư viện
  Route::get('/rule', [ClientController::class, 'rule'])->name('rule');

  // hướng dẫn
  Route::get('/guide', [ClientController::class, 'guide'])->name('guide');
});
