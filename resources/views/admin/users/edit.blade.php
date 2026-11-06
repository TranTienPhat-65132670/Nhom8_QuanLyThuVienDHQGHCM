@extends('layout.admin')
@section('title', 'Chỉnh sửa tài khoản')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-5 rounded-xl shadow-sm border border-slate-200">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Chỉnh sửa Tài khoản: {{ $user->student_name }}</h1>
            <p class="text-sm text-slate-500 mt-0.5">Mã đăng nhập: <span class="font-semibold text-slate-700">15000{{ $user->student_code }}</span></p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-slate-600 hover:text-slate-900 flex items-center gap-1.5 bg-slate-100 px-3.5 py-2 rounded-lg">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <form action="{{ route('admin.users.update', $user->user_id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Mã số sinh viên (Gốc) <span class="text-rose-500">*</span></label>
                    <input type="text" name="student_code" value="{{ old('student_code', $user->student_code) }}"
                        class="w-full px-3.5 py-2 rounded-lg border @error('student_code') border-rose-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    @error('student_code')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Họ và tên <span class="text-rose-500">*</span></label>
                    <input type="text" name="student_name" value="{{ old('student_name', $user->student_name) }}"
                        class="w-full px-3.5 py-2 rounded-lg border @error('student_name') border-rose-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    @error('student_name')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-3.5 py-2 rounded-lg border @error('email') border-rose-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    @error('email')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Số điện thoại</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full px-3.5 py-2 rounded-lg border @error('phone') border-rose-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    @error('phone')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Vai trò</label>
                    <select name="role" class="w-full px-3.5 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                        <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>Độc giả (Member)</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Trạng thái thẻ</label>
                    <select name="status" class="w-full px-3.5 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                        <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Khóa tài khoản</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Đặt lại mật khẩu mới (Để trống nếu giữ nguyên)</label>
                    <input type="password" name="password" placeholder="Nhập mật khẩu mới nếu muốn cấp lại cho độc giả..."
                        class="w-full px-3.5 py-2 rounded-lg border @error('password') border-rose-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    @error('password')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium">Hủy</a>
                <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium shadow-sm">
                    <i class="fa-solid fa-check mr-1"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection