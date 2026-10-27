@extends('layout.admin')

@section('title', 'Chỉnh Sửa Sách')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Cập Nhật Thông Tin Sách</h1>
        </div>
        <a href="{{ route('books.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
            <i class="fa-solid fa-arrow-left mr-1"></i> Quay lại
        </a>
    </div>

    <form action="{{ route('books.update', $book->book_id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tên Sách <span class="text-rose-500">*</span></label>
                <input type="text" name="book_name" value="{{ old('book_name', $book->book_name) }}"
                       class="w-full px-3.5 py-2 text-xs border @error('book_name') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
                @error('book_name')
                    <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tác Giả <span class="text-rose-500">*</span></label>
                <input type="text" name="author" value="{{ old('author', $book->author) }}"
                       class="w-full px-3.5 py-2 text-xs border @error('author') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
                @error('author')
                    <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Danh Mục Sách <span class="text-rose-500">*</span></label>
                <select name="category_id" class="w-full px-3.5 py-2 text-xs border @error('category_id') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}" {{ old('category_id', $book->category_id) == $cat->category_id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Mã ISBN <span class="text-rose-500">*</span></label>
                <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}"
                       class="w-full px-3.5 py-2 text-xs border @error('isbn') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
                @error('isbn')
                    <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Ngôn Ngữ</label>
                <input type="text" name="language" value="{{ old('language', $book->language) }}"
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
                @error('language')
                    <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tổng Số Lượng Sách <span class="text-rose-500">*</span></label>
                <input type="number" name="total_quantity" value="{{ old('total_quantity', $book->total_quantity) }}"
                       class="w-full px-3.5 py-2 text-xs border @error('total_quantity') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
                <span class="text-[11px] text-slate-400">Hiện tại khả dụng: {{ $book->available_quantity }} cuốn</span>
                @error('total_quantity')
                    <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Số Trang</label>
                <input type="number" name="page_count" value="{{ old('page_count', $book->page_count) }}"
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
                @error('page_count')
                    <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Khu Vực Thư Viện<span class="text-rose-500">*</span></label>
                <select name="location" class="w-full px-3.5 py-2 text-xs border @error('location') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
                    <option value="Thư viện Trung tâm DHQG-HCM" {{ old('location', $book->location) == 'Thư viện Trung tâm DHQG-HCM' ? 'selected' : '' }}>
                        Thư viện Trung tâm DHQG-HCM
                    </option>
                    <option value="Ký túc xá Khu B Đại học Quốc gia TP.HCM" {{ old('location', $book->location) == 'Ký túc xá Khu B Đại học Quốc gia TP.HCM' ? 'selected' : '' }}>
                        Ký túc xá Khu B Đại học Quốc gia TP.HCM
                    </option>
                </select>
                @error('location')
                    <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Trạng Thái Sách</label>
                <select name="status" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
                    <option value="1" {{ old('status', $book->status) == '1' || old('status', $book->status) == 'available' ? 'selected' : '' }}>Đang lưu hành (Sẵn sàng)</option>
                    <option value="0" {{ old('status', $book->status) == '0' || old('status', $book->status) == 'unavailable' ? 'selected' : '' }}>Tạm ngưng phục vụ</option>
                </select>
            </div>

            <div class="md:col-span-2 space-y-3 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                <label class="block text-xs font-bold text-slate-800">
                    <i class="fa-solid fa-images text-blue-600 mr-1"></i> Ảnh Bìa Sách
                </label>

                @if($book->book_image)
                    <div class="flex items-center gap-3">
                        <span class="text-[11px] font-semibold text-slate-500">Bìa hiện tại:</span>
                        <img src="{{ str_starts_with($book->book_image, 'book/') ? asset($book->book_image) : asset('storage/' . $book->book_image) }}" 
                             alt="Bìa" class="w-12 h-16 object-cover rounded shadow-xs border border-slate-200">
                    </div>
                @endif

                <input type="hidden" name="selected_image" id="selected_image" value="{{ old('selected_image') }}">

                @if(count($galleryImages) > 0)
                    <div>
                        <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-2.5 max-h-44 overflow-y-auto p-2 bg-white rounded-xl border border-slate-200">
                            @foreach($galleryImages as $img)
                                <div onclick="selectGalleryImage('{{ $img }}', this)" 
                                     class="gallery-item cursor-pointer aspect-[3/4] rounded-lg overflow-hidden border-2 border-transparent hover:border-blue-400 transition relative p-0.5">
                                    <img src="{{ asset($img) }}" alt="Bìa" class="w-full h-full object-cover rounded">
                                    <div class="selected-check absolute inset-0 bg-blue-600/30 items-center justify-center text-white text-base hidden">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="pt-2 border-t border-slate-200">
                    <span class="text-[11px] font-semibold text-slate-500 block mb-1">Tải ảnh mới từ máy:</span>
                    <input type="file" name="book_image" id="book_image" accept="image/*"
                           class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                @error('book_image')
                    <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tóm Tắt Nội Dung Sách</label>
                <textarea name="description" rows="4"
                          class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">{{ old('description', $book->description) }}</textarea>
                @error('description')
                    <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                @enderror
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

<script>
    function selectGalleryImage(imagePath, element) {
        document.getElementById('selected_image').value = imagePath;
        document.querySelectorAll('.gallery-item').forEach(el => {
            el.classList.remove('border-blue-600');
            el.querySelector('.selected-check').classList.add('hidden');
            el.querySelector('.selected-check').classList.remove('flex');
        });
        element.classList.add('border-blue-600');
        element.querySelector('.selected-check').classList.remove('hidden');
        element.querySelector('.selected-check').classList.add('flex');
        document.getElementById('book_image').value = '';
    }
</script>
@endsection