<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// khi người dùng bấm nút quay lại khi đổi mật khẩu
Route::get('/auth/cancel-reset', [AuthController::class, 'cancelReset'])->name('cancel-reset');

// đăng nhập
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/login', [AuthController::class, 'login'])->name('login');


// quên mật khẩu
Route::middleware(['redirect.if.auth'])->group(function () {
  Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('showForgotPasswordForm');
  Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');

  Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('verify-otp');

  Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('showResetPasswordForm');
  Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
});


// đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['check.login'])->group(function () {
  Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AuthController::class, 'admin'])->name('admin');
  });
  Route::middleware(['role:member'])->group(function () {
    Route::get('/member', [AuthController::class, 'member'])->name('member');
  });
});
