@extends('layout.admin')

@section('title', 'Chỉnh Sửa Khoản Phạt')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">

        <!-- Nút quay lại & Tiêu đề -->
        <div class="mb-6">
            <a href="{{ route('admin.fines.index') }}"
                class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition flex items-center gap-1.5 mb-2">
                <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách khoản phạt
            </a>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-rose-600"></i> Chỉnh sửa khoản phạt: #{{ $fine->fine_id }}
            </h1>
            <p class="text-xs text-gray-500 mt-1">Cập nhật thông tin và mức tiền phạt quy định.</p>
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

        <!-- Form chỉnh sửa -->
        <div class="bg-white rounded-2xl shadow-xs border border-gray-100 p-6">
            <form action="{{ route('admin.fines.update', $fine->fine_id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Tên khoản phạt -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1.5">
                        Tên khoản phạt <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" name="fine_name" value="{{ old('fine_name', $fine->fine_name) }}" required
                        class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 transition">
                </div>

                <!-- Số tiền phạt -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1.5">
                        Số tiền phạt (VNĐ) <span class="text-rose-600">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" name="fine_amount" value="{{ old('fine_amount', $fine->fine_amount) }}"
                            min="0" step="1000" required
                            class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 transition pr-16">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">VNĐ</span>
                    </div>
                </div>

                <!-- Mô tả chi tiết -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1.5">
                        Mô tả chi tiết quy định
                    </label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 transition">{{ old('description', $fine->description) }}</textarea>
                </div>

                <!-- Nút hành động -->
                <div class="pt-4 border-t border-gray-100 flex items-center gap-3">
                    <button type="submit"
                        class="px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm rounded-xl transition shadow-xs flex items-center gap-2">
                        <i class="fa-solid fa-check"></i> Cập nhật thay đổi
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
