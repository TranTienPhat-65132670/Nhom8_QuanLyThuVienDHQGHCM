<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/client.php';

Route::get('/test-db', function () {
  try {
    $hashed_password = password_hash('12345678A', PASSWORD_DEFAULT);

    DB::table('user')->insert([
      'user_id' => 'ff9a6e0b-a45e-4df4-bfec-5126d82e64fb',
      'student_code' => '87654321',
      'student_name' => 'Trần Minh Trí',
      'email' => 'tranminhtri@ntu.edu.vn',
      'hashed_password' => $hashed_password,
    ]);

    echo "Thêm thành công";
  } catch (\Exception $e) {
    return "❌ Lỗi: " . $e->getMessage();
  }
});
