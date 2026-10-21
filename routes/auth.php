<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// khi người dùng bấm nút quay lại khi đổi mật khẩu
Route::get('/auth/cancel-reset', [AuthController::class, 'cancelReset'])->name('auth.cancel-reset');

// đăng nhập
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// quên mật khẩu
Route::middleware(['redirect.if.auth'])->group(function () {
  Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.forgot');
  Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.forgot.submit');

  Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('verify-otp');

  Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
  Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});
