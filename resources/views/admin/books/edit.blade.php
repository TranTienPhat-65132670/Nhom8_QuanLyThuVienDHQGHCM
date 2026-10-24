@extends('layout.admin')

@section('title', 'Chỉnh Sửa Sách')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Cập Nhật Thông Tin Sách</h1>
            <p class="text-xs text-slate-500 mt-1">Mã sách: #{{ $book->book_id }}</p>
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

    <form action="{{ route('books.update', $book->book_id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tên Sách <span class="text-rose-500">*</span></label>
                <input type="text" name="book_name" value="{{ old('book_name', $book->book_name) }}" required
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tác Giả <span class="text-rose-500">*</span></label>
                <input type="text" name="author" value="{{ old('author', $book->author) }}" required
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Danh Mục Sách <span class="text-rose-500">*</span></label>
                <select name="category_id" required class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}" {{ old('category_id', $book->category_id) == $cat->category_id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Mã ISBN <span class="text-rose-500">*</span></label>
                <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" required
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Ngôn Ngữ</label>
                <input type="text" name="language" value="{{ old('language', $book->language) }}"
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tổng Số Lượng Sách <span class="text-rose-500">*</span></label>
                <input type="number" name="total_quantity" value="{{ old('total_quantity', $book->total_quantity) }}" min="1" required
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
                <span class="text-[11px] text-slate-400">Hiện tại khả dụng: {{ $book->available_quantity }} cuốn</span>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Số Trang</label>
                <input type="number" name="page_count" value="{{ old('page_count', $book->page_count) }}"
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Vị Trí Kệ Sách</label>
                <input type="text" name="location" value="{{ old('location', $book->location) }}"
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Trạng Thái Sách</label>
                <select name="status" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
                    <option value="available" {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>Đang lưu hành (Sẵn sàng)</option>
                    <option value="unavailable" {{ old('status', $book->status) == 'unavailable' ? 'selected' : '' }}>Tạm ngưng phục vụ</option>
                </select>
            </div>

            <div class="md:col-span-2 flex items-start gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                @if($book->book_image)
                    <div>
                        <span class="block text-[11px] font-semibold text-slate-500 mb-1">Bìa hiện tại:</span>
                        <img src="{{ asset('storage/' . $book->book_image) }}" alt="Bìa" class="w-16 h-24 object-cover rounded shadow-xs">
                    </div>
                @endif
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Thay Đổi Ảnh Bìa (Để trống nếu không đổi)</label>
                    <input type="file" name="book_image" accept="image/*"
                           class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tóm Tắt Nội Dung Sách</label>
                <textarea name="description" rows="4"
                          class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">{{ old('description', $book->description) }}</textarea>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('books.index') }}" class="px-5 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">Hủy Bỏ</a>
            <button type="submit" class="px-5 py-2.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-xs transition">
                <i class="fa-solid fa-floppy-disk mr-1.5"></i> Cập Nhật Sách
            </button>
        </div>
    </form>
</div>
@endsection