@extends('layout.admin')

@section('title', 'Thêm Khoản Phạt')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">

        <!-- Nút quay lại & Tiêu đề -->
        <div class="mb-6">
            <a href="{{ route('admin.fines.index') }}"
                class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition flex items-center gap-1.5 mb-2">
                <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách khoản phạt
            </a>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-circle-plus text-rose-600"></i> Thêm khoản phạt mới
            </h1>
            <p class="text-xs text-gray-500 mt-1">Tạo mới định mức hoặc loại vi phạm nội quy thư viện.</p>
        </div>

        <!-- Hiển thị lỗi validation nếu có -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-2xl shadow-xs">
                <p class="font-bold mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-triangle-exclamation"></i> Vui lòng kiểm tra lại thông tin:
                </p>
                <ul class="list-disc pl-5 space-y-1 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form thêm mới -->
        <div class="bg-white rounded-2xl shadow-xs border border-gray-100 p-6">
            <form action="{{ route('admin.fines.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Tên khoản phạt -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1.5">
                        Tên khoản phạt <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" name="fine_name" value="{{ old('fine_name') }}"
                        placeholder="Ví dụ: Trả sách quá hạn, Làm rách sách, Mất sách..."
                        class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 transition">
                </div>

                <!-- Số tiền phạt -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1.5">
                        Số tiền phạt (VNĐ) <span class="text-rose-600">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" name="fine_amount" value="{{ old('fine_amount') }}" placeholder="Ví dụ: 10000"
                            class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 transition pr-16">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">VNĐ</span>
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">Nhập số tiền nguyên (ví dụ: 10000 tương ứng 10.000 VNĐ).</p>
                </div>

                <!-- Mô tả chi tiết -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1.5">
                        Quy định
                    </label>
                    <textarea name="description" rows="4" placeholder="Nhập chi tiết điều khoản áp dụng mức phạt này..."
                        class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 transition">{{ old('description') }}</textarea>
                </div>

                <!-- Nút hành động -->
                <div class="pt-4 border-t border-gray-100 flex items-center gap-3">
                    <button type="submit"
                        class="px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm rounded-xl transition shadow-xs flex items-center gap-2">
                        <i class="fa-solid fa-check"></i> Lưu khoản phạt
                    </button>
                    <a href="{{ route('admin.fines.index') }}"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-xl transition">
                        Hủy bỏ
                    </a>
                </div>
            </form>
        </div>

    </div>
@endsection
