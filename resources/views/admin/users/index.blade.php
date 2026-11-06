@extends('layout.admin')
@section('title', 'Quản lý tài khoản & độc giả')

@section('content')
<div class="space-y-6">
    <!-- Tiêu đề & Nút thêm mới -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl shadow-sm border border-slate-200">
        <div>
            <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-users text-blue-600"></i> Quản lý Tài khoản & Hồ sơ Độc giả
            </h1>
            <p class="text-sm text-slate-500 mt-1">Quản lý danh sách sinh viên, phân quyền và trạng thái thẻ thư viện</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2.5 rounded-lg transition shadow-sm">
            <i class="fa-solid fa-user-plus"></i> Thêm tài khoản mới
        </a>
    </div>

    <!-- Thông báo Flash Message -->
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded-lg shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Bộ lọc & Tìm kiếm -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
        <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-5 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="keyword" value="{{ request('keyword') }}"
                    placeholder="Tìm theo MSSV, họ tên, email, SĐT..."
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
            </div>

            <div class="md:col-span-3">
                <select name="role" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    <option value="">-- Tất cả vai trò --</option>
                    <option value="member" {{ request('role') === 'member' ? 'selected' : '' }}>Độc giả (Member)</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <select name="status" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    <option value="">-- Trạng thái --</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Đang hoạt động</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Đã khóa</option>
                </select>
            </div>

            <div class="md:col-span-2 flex gap-2">
                <button type="submit" class="flex-1 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium py-2 px-3 rounded-lg transition">
                    Lọc
                </button>
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-600 px-3 py-2 rounded-lg text-sm transition" title="Đặt lại">
                    <i class="fa-solid fa-rotate-right"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Bảng danh sách tài khoản -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold">Mã định danh / MSSV</th>
                        <th class="py-3.5 px-4 font-semibold">Họ và tên</th>
                        <th class="py-3.5 px-4 font-semibold">Liên hệ</th>
                        <th class="py-3.5 px-4 font-semibold text-center">Vai trò</th>
                        <th class="py-3.5 px-4 font-semibold text-center">Trạng thái</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4">
                                <span class="font-semibold text-slate-800 block">15000{{ $u->student_code }}</span>
                                <span class="text-xs text-slate-400">Gốc: {{ $u->student_code }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-800">
                                {{ $u->student_name }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="text-slate-700"><i class="fa-regular fa-envelope text-slate-400 mr-1.5"></i>{{ $u->email }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">
                                    <i class="fa-solid fa-phone text-slate-400 mr-1.5"></i>{{ $u->phone ?? 'Chưa cập nhật' }}
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($u->role === 'admin')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                        <i class="fa-solid fa-user-shield"></i> Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                        <i class="fa-solid fa-user-graduate"></i> Độc giả
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($u->status == 1)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Hoạt động
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Đã khóa
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Xem hồ sơ -->
                                    <a href="{{ route('admin.users.show', $u->user_id) }}" class="p-2 text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Xem chi tiết hồ sơ">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <!-- Sửa -->
                                    <a href="{{ route('admin.users.edit', $u->user_id) }}" class="p-2 text-slate-600 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Chỉnh sửa">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <!-- Khóa / Mở khóa -->
                                    @if($u->user_id !== session('user_id'))
                                        <form action="{{ route('admin.users.toggle-status', $u->user_id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="p-2 {{ $u->status == 1 ? 'text-slate-600 hover:text-orange-600 hover:bg-orange-50' : 'text-emerald-600 hover:bg-emerald-50' }} rounded-lg transition"
                                                title="{{ $u->status == 1 ? 'Khóa tài khoản' : 'Mở khóa tài khoản' }}">
                                                <i class="fa-solid {{ $u->status == 1 ? 'fa-lock' : 'fa-lock-open' }}"></i>
                                            </button>
                                        </form>
                                        <!-- Xóa mềm -->
                                        <form action="{{ route('admin.users.destroy', $u->user_id) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản độc giả này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-600 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Xóa tài khoản">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-500">
                                <i class="fa-regular fa-folder-open text-3xl mb-2 block text-slate-400"></i>
                                Không tìm thấy tài khoản độc giả nào phù hợp.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        @if($users->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $users->links('components.custom-pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection