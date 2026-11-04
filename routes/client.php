<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsPostController;
use Illuminate\Support\Facades\Route;

Route::get('/tin-tuc', [NewsPostController::class, 'publicIndex'])->name('news.index');
Route::get('/tin-tuc/{id}', [NewsPostController::class, 'show'])->name('news.show');
