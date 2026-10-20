<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

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
