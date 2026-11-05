@extends('layout.admin')
@section('title', 'Chi tiết hồ sơ độc giả')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between bg-white p-5 rounded-xl shadow-sm border border-slate-200">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Hồ sơ Độc giả: {{ $user->student_name }}</h1>
            <p class="text-sm text-slate-500">UUID: {{ $user->user_id }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user->user_id) }}" class="text-sm bg-amber-500 hover:bg-amber-600 text-white px-3.5 py-2 rounded-lg font-medium">
                <i class="fa-solid fa-pen-to-square mr-1"></i> Chỉnh sửa
            </a>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-slate-600 hover:text-slate-900 bg-slate-100 px-3.5 py-2 rounded-lg">
                <i class="fa-solid fa-arrow-left mr-1"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Thẻ thông tin cá nhân -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-4">
            <h2 class="font-bold text-slate-800 border-b pb-3">Thông tin Thẻ thư viện</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Mã đăng nhập:</span>
                    <span class="font-semibold text-slate-800">15000{{ $user->student_code }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">MSSV gốc:</span>
                    <span class="font-medium">{{ $user->student_code }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Email:</span>
                    <span class="font-medium">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Số điện thoại:</span>
                    <span class="font-medium">{{ $user->phone ?? 'Chưa cập nhật' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Vai trò:</span>
                    <span class="font-semibold uppercase text-blue-600">{{ $user->role }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Ngày tạo thẻ:</span>
                    <span>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Lịch sử mượn trả sách của độc giả này -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <h2 class="font-bold text-slate-800 border-b pb-3 mb-4">Lịch sử Mượn / Trả sách</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 border-b">
                            <th class="py-2.5 px-3">Mã phiếu</th>
                            <th class="py-2.5 px-3">Ngày mượn</th>
                            <th class="py-2.5 px-3">Hạn trả</th>
                            <th class="py-2.5 px-3">Ngày trả thực tế</th>
                            <th class="py-2.5 px-3">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($borrows as $b)
                            <tr>
                                <td class="py-2.5 px-3 font-medium">#{{ $b->borrow_id }}</td>
                                <td class="py-2.5 px-3">{{ $b->borrow_datetime }}</td>
                                <td class="py-2.5 px-3">{{ $b->due_date }}</td>
                                <td class="py-2.5 px-3">{{ $b->return_date ?? 'Chưa trả' }}</td>
                                <td class="py-2.5 px-3">
                                    <span class="px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">{{ $b->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400">Độc giả này chưa có lịch sử mượn sách.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection