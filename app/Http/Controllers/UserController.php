<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Danh sách tài khoản + Tìm kiếm & Lọc
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('keyword')) {
            $kw = trim($request->keyword);
            // Nếu admin gõ tìm kiếm có tiền tố 15000 thì cắt ra để tìm chính xác
            $kwCode = str_starts_with($kw, '15000') ? substr($kw, 5) : $kw;

            $query->where(function ($q) use ($kw, $kwCode) {
                $q->where('student_code', 'LIKE', "%{$kwCode}%")
                    ->orWhere('student_name', 'LIKE', "%{$kw}%")
                    ->orWhere('email', 'LIKE', "%{$kw}%")
                    ->orWhere('phone', 'LIKE', "%{$kw}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    // Giao diện thêm mới tài khoản
    public function create()
    {
        return view('admin.users.create');
    }

    // Xử lý lưu tài khoản mới
    public function store(Request $request)
    {
        // Tự động cắt tiền tố 15000 nếu Admin nhập vào để khớp với logic đăng nhập của Phát
        $rawCode = trim($request->student_code);
        if (str_starts_with($rawCode, '15000') && strlen($rawCode) > 5) {
            $rawCode = substr($rawCode, 5);
        }
        $request->merge([
            'student_code' => $rawCode,
            'phone'        => $request->filled('phone') ? trim($request->phone) : null,
        ]);

        $validated = $request->validate([
            'student_code' => ['required', 'numeric', 'digits_between:1,10', 'unique:user,student_code'],
            'student_name' => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:100', 'unique:user,email'],
            'phone'        => ['nullable', 'regex:/^[0-9]{10,11}$/', 'unique:user,phone'],
            'role'         => ['required', 'in:admin,member'],
            'password'     => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/\d/'],
        ], [
            'student_code.numeric' => "Mã số sinh viên phải là số",
            'student_code.required' => 'Mã số không được bỏ trống!',
            'student_code.unique'   => 'Mã số sinh viên này đã tồn tại!',
            'password.required' => "Không được bỏ trống!",
            'student_name.required' => "Không được bỏ trống!",
            'email.required' => "Không được bỏ trống!",
            'email.unique'          => 'Email này đã tồn tại trong hệ thống!',
            'phone.unique'          => 'Số điện thoại này đã tồn tại!',
            'password.regex'        => 'Mật khẩu phải có ít nhất 8 ký tự, gồm 1 chữ hoa và 1 chữ số!',
        ]);

        User::create([
            'student_code'    => $validated['student_code'],
            'student_name'    => $validated['student_name'],
            'email'           => $validated['email'],
            'phone'           => $validated['phone'],
            'role'            => $validated['role'],
            'status'          => 1,
            'hashed_password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Thêm tài khoản độc giả thành công!');
    }

    // 4. Xem chi tiết hồ sơ độc giả & lịch sử mượn trả (dành cho Admin)
    public function show($id)
    {
        $user = User::where('user_id', $id)->firstOrFail();

        $borrows = DB::table('borrow')
            ->where('user_id', $id)
            ->orderBy('borrow_datetime', 'desc')
            ->get();

        return view('admin.users.show', compact('user', 'borrows'));
    }

    // Giao diện chỉnh sửa tài khoản
    public function edit($id)
    {
        $user = User::where('user_id', $id)->firstOrFail();
        return view('admin.users.edit', compact('user'));
    }

    // Xử lý cập nhật tài khoản
    public function update(Request $request, $id)
    {
        $user = User::where('user_id', $id)->firstOrFail();

        $rawCode = trim($request->student_code);
        if (str_starts_with($rawCode, '15000') && strlen($rawCode) > 5) {
            $rawCode = substr($rawCode, 5);
        }
        $request->merge([
            'student_code' => $rawCode,
            'phone'        => $request->filled('phone') ? trim($request->phone) : null,
        ]);

        $validated = $request->validate([
            'student_code' => ['required', 'numeric', 'digits_between:1,10', Rule::unique('user', 'student_code')->ignore($id, 'user_id')],
            'student_name' => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:100', Rule::unique('user', 'email')->ignore($id, 'user_id')],
            'phone'        => ['nullable', 'regex:/^[0-9]{10,11}$/', Rule::unique('user', 'phone')->ignore($id, 'user_id')],
            'role'         => ['required', 'in:admin,member'],
            'status'       => ['required', 'in:0,1'],
            'password'     => ['nullable', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/\d/'],
        ]);

        $dataToUpdate = [
            'student_code' => $validated['student_code'],
            'student_name' => $validated['student_name'],
            'email'        => $validated['email'],
            'phone'        => $validated['phone'],
            'role'         => $validated['role'],
            'status'       => $validated['status'],
        ];

        // Ngăn Admin tự hạ quyền hoặc tự khóa tài khoản của chính mình
        if ($id === session('user_id')) {
            if ($validated['status'] == 0 || $validated['role'] !== 'admin') {
                return back()->with('error', 'Bạn không thể tự hạ quyền hoặc tự khóa tài khoản của chính mình!');
            }
        }

        // Nếu Admin có nhập mật khẩu mới thì mới cập nhật mật khẩu
        if ($request->filled('password')) {
            $dataToUpdate['hashed_password'] = Hash::make($validated['password']);
        }

        $user->update($dataToUpdate);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật thông tin tài khoản thành công!');
    }

    // Khóa / Mở khóa nhanh trạng thái tài khoản
    public function toggleStatus($id)
    {
        if ($id === session('user_id')) {
            return back()->with('error', 'Bạn không thể tự khóa tài khoản của chính mình!');
        }

        $user = User::where('user_id', $id)->firstOrFail();
        $user->update(['status' => $user->status == 1 ? 0 : 1]);

        $msg = $user->status == 1 ? 'Đã mở khóa tài khoản!' : 'Đã khóa tài khoản độc giả!';
        return back()->with('success', $msg);
    }

    // Xóa mềm tài khoản (Soft Delete)
    public function destroy($id)
    {
        if ($id === session('user_id')) {
            return back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
        }

        $user = User::where('user_id', $id)->firstOrFail();
        $user->update(['status' => 0]);
        $user->delete(); // Gán thời gian hiện tại vào cột deleted_at nhờ trait SoftDeletes

        return redirect()->route('admin.users.index')->with('success', 'Đã xóa tài khoản độc giả!');
    }
}
