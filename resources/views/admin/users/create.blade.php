@extends('layout.admin')
@section('title', 'Thêm tài khoản mới')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-5 rounded-xl shadow-sm border border-slate-200">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Thêm Tài khoản Mới</h1>
            <p class="text-sm text-slate-500 mt-0.5">Tạo thẻ thư viện cho sinh viên hoặc tài khoản quản trị viên</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-slate-600 hover:text-slate-900 flex items-center gap-1.5 bg-slate-100 px-3.5 py-2 rounded-lg">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Mã số sinh viên -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Mã số sinh viên (MSSV) <span class="text-rose-500">*</span></label>
                    <input type="text" name="student_code" value="{{ old('student_code') }}" placeholder="VD: 12345678 (hoặc 1500012345678)"
                        class="w-full px-3.5 py-2 rounded-lg border @error('student_code') border-rose-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    <p class="text-xs text-slate-400 mt-1">Khi đăng nhập sẽ dùng định dạng: 15000 + MSSV</p>
                    @error('student_code')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Họ và tên -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Họ và tên <span class="text-rose-500">*</span></label>
                    <input type="text" name="student_name" value="{{ old('student_name') }}" placeholder="Nhập đầy đủ họ và tên"
                        class="w-full px-3.5 py-2 rounded-lg border @error('student_name') border-rose-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    @error('student_name')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="sinhvien@dhqg.edu.vn"
                        class="w-full px-3.5 py-2 rounded-lg border @error('email') border-rose-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    @error('email')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Số điện thoại -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Số điện thoại</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="09xxxxxxxx (Không bắt buộc)"
                        class="w-full px-3.5 py-2 rounded-lg border @error('phone') border-rose-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    @error('phone')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Vai trò -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Vai trò hệ thống <span class="text-rose-500">*</span></label>
                    <select name="role" class="w-full px-3.5 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                        <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>Độc giả / Sinh viên (Member)</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                    </select>
                </div>

                <!-- Mật khẩu khởi tạo -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Mật khẩu khởi tạo <span class="text-rose-500">*</span></label>
                    <input type="password" name="password" placeholder="Tối thiểu 8 ký tự, 1 chữ hoa, 1 số"
                        class="w-full px-3.5 py-2 rounded-lg border @error('password') border-rose-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    @error('password')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-medium">Hủy</a>
                <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium shadow-sm">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Lưu tài khoản
                </button>
            </div>
        </form>
    </div>
</div>
@endsection