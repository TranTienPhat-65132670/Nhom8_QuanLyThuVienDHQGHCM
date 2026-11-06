<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Hiển thị trang Hồ sơ độc giả
    public function index()
    {
        $userId = session('user_id');
        $user = User::where('user_id', $userId)->firstOrFail();

        // Thống kê nhanh hoạt động của độc giả
        $borrowHistory = DB::table('borrow')
            ->where('user_id', $userId)
            ->orderBy('borrow_datetime', 'desc')
            ->take(5)
            ->get();

        $reservations = DB::table('book_reservation')
            ->join('book', 'book_reservation.book_id', '=', 'book.book_id')
            ->where('book_reservation.user_id', $userId)
            ->select('book_reservation.*', 'book.book_name', 'book.slug')
            ->orderBy('reservation_date', 'desc')
            ->get();

        $unpaidFines = DB::table('borrow_fine')
            ->join('borrow', 'borrow_fine.borrow_id', '=', 'borrow.borrow_id')
            ->join('fine', 'borrow_fine.fine_id', '=', 'fine.fine_id')
            ->where('borrow.user_id', $userId)
            ->where('borrow_fine.status', 0)
            ->select('borrow_fine.*', 'fine.fine_name', 'fine.fine_amount', 'borrow.borrow_datetime')
            ->get();

        return view('client.profile.index', compact('user', 'borrowHistory', 'reservations', 'unpaidFines'));
    }

    // Cập nhật thông tin cá nhân (Họ tên, Email, SĐT)
    public function update(Request $request)
    {
        $userId = session('user_id');

        // Chuẩn hóa phone rỗng thành null để không bị lỗi trùng lặp uq_phone trong SQL
        if ($request->filled('phone') === false) {
            $request->merge(['phone' => null]);
        }

        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:100', Rule::unique('user', 'email')->ignore($userId, 'user_id')],
            'phone'        => ['nullable', 'regex:/^[0-9]{10,11}$/', Rule::unique('user', 'phone')->ignore($userId, 'user_id')],
        ], [
            'student_name.required' => 'Họ và tên không được bỏ trống!',
            'email.required'        => 'Email không được bỏ trống!',
            'email.email'           => 'Email không đúng định dạng!',
            'email.unique'          => 'Email này đã được sử dụng bởi tài khoản khác!',
            'phone.regex'           => 'Số điện thoại phải gồm 10-11 chữ số!',
            'phone.unique'          => 'Số điện thoại này đã được sử dụng!',
        ]);

        User::where('user_id', $userId)->update($validated);

        return back()->with('success', 'Cập nhật hồ sơ cá nhân thành công!');
    }

    // Đổi mật khẩu khi đang đăng nhập (áp dụng đúng regex mật khẩu của Phát)
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'string', 'min:8', 'confirmed', 'regex:/[A-Z]/', 'regex:/\d/'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại!',
            'password.required'         => 'Vui lòng nhập mật khẩu mới!',
            'password.min'              => 'Mật khẩu mới phải có ít nhất 8 ký tự!',
            'password.confirmed'        => 'Xác nhận mật khẩu mới không khớp!',
            'password.regex'            => 'Mật khẩu phải chứa ít nhất 1 ký tự viết hoa và 1 chữ số!',
        ]);

        $userId = session('user_id');
        $user = User::where('user_id', $userId)->firstOrFail();

        if (!Hash::check($request->current_password, $user->hashed_password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác!']);
        }

        $user->update([
            'hashed_password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}