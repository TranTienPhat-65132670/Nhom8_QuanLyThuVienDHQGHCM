<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids, SoftDeletes;

    // Khai báo tên bảng và khóa chính theo file SQL
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Bảng `user` trong SQL chỉ có created_at và deleted_at, không có updated_at
    const UPDATED_AT = null;

    // Các cột cho phép thêm/sửa dữ liệu hàng loạt
    protected $fillable = [
        'student_code',
        'hashed_password',
        'student_name',
        'email',
        'phone',
        'role',
        'status',
    ];

    // Ẩn mật khẩu khi trả dữ liệu về dạng JSON/Array
    protected $hidden = [
        'hashed_password',
    ];

    // Ép kiểu dữ liệu và tự động băm mật khẩu
    protected function casts(): array
    {
        return [
            'hashed_password' => 'hashed',
            'status'          => 'integer',
            'created_at'      => 'datetime',
            'deleted_at'      => 'datetime',
        ];
    }

    // Chỉ định cho hệ thống Auth của Laravel biết cột mật khẩu tên là `hashed_password`
    public function getAuthPassword()
    {
        return $this->hashed_password;
    }

    // --- CÁC MỐI QUAN HỆ (RELATIONSHIPS) PHỤC VỤ HỒ SƠ ĐỘC GIẢ ---

    // Danh sách sách yêu thích (N-N với bảng book qua bảng trung gian favorite)
    public function favoriteBooks()
    {
        return $this->belongsToMany(Book::class, 'favorite', 'user_id', 'book_id');
    }
}