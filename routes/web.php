<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/client.php';

Route::middleware(['role:member'])->group(function () {
  Route::get('/', [ClientController::class, 'index'])->name('client_index');
});

Route::get('/test-db', function () {
  try {
    $hashed_password = password_hash('test', PASSWORD_DEFAULT);

    DB::table('user')->insert([
      'user_id' => 'bef76426-139d-4462-a14d-fefb530c6888',
      'student_code' => '12345678',
      'hashed_password' => $hashed_password,
    ]);

    echo "Thêm thành công";
  } catch (\Exception $e) {
    return "❌ Lỗi: " . $e->getMessage();
  }
});
