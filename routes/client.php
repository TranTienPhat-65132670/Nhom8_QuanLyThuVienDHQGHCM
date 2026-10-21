<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

// nội quy thư viện
Route::get('/rule', [ClientController::class, 'rule'])->name('rule');

// hướng dẫn
Route::get('/guide', [ClientController::class, 'guide'])->name('guide');
