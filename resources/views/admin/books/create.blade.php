@extends('layout.admin')

@section('title', 'Thêm Sách Mới')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Thêm Sách Vào Kho</h1>
            <p class="text-xs text-slate-500 mt-1">Nhập thông tin chi tiết của ấn phẩm mới</p>
        </div>
        <a href="{{ route('books.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
            <i class="fa-solid fa-arrow-left mr-1"></i> Quay lại
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl space-y-1">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tên Sách <span class="text-rose-500">*</span></label>
                <input type="text" name="book_name" value="{{ old('book_name') }}" required placeholder="VD: Lập Trình Hướng Đối Tượng với Java"
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tác Giả <span class="text-rose-500">*</span></label>
                <input type="text" name="author" value="{{ old('author') }}" required placeholder="VD: Nguyễn Văn A"
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Danh Mục Sách <span class="text-rose-500">*</span></label>
                <select name="category_id" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}" {{ old('category_id') == $cat->category_id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Mã ISBN <span class="text-rose-500">*</span></label>
                <input type="text" name="isbn" value="{{ old('isbn') }}" required placeholder="VD: 978-604-0-12345-6"
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Ngôn Ngữ</label>
                <input type="text" name="language" value="{{ old('language', 'Tiếng Việt') }}"
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tổng Số Lượng Sách <span class="text-rose-500">*</span></label>
                <input type="number" name="total_quantity" value="{{ old('total_quantity', 1) }}" min="1" required
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Số Trang</label>
                <input type="number" name="page_count" value="{{ old('page_count') }}" min="1"
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Vị Trí Kệ Sách</label>
                <input type="text" name="location" value="{{ old('location') }}" placeholder="VD: Tầng 2 - Kệ IT-04"
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Ảnh Bìa Sách</label>
                <input type="file" name="book_image" accept="image/*"
                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tóm Tắt Nội Dung Sách</label>
                <textarea name="description" rows="4" placeholder="Nội dung giới thiệu cuốn sách..."
                          class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('books.index') }}" class="px-5 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">Hủy Bỏ</a>
            <button type="submit" class="px-5 py-2.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs transition">
                <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Lưu Sách Vào Kho
            </button>
        </div>
    </form>
</div>
@endsection