@extends('layout.admin')

@section('title', 'Chỉnh Sửa Sách - ' . $book->book_name)

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Cập Nhật Thông Tin Sách</h1>
            <p class="text-xs text-slate-500 mt-1">Mã định danh hệ thống: #{{ $book->book_id }}</p>
        </div>
        <a href="{{ route('books.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
            <i class="fa-solid fa-arrow-left mr-1"></i> Quay lại kho
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Cột Form Nhập Liệu -->
        <div class="lg:col-span-7">
            <form id="bookForm" action="{{ route('books.update', $book->book_id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                @csrf
                @method('PUT')
                
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100 font-bold text-slate-800 text-sm">
                    <i class="fa-solid fa-pen-to-square text-amber-600"></i> Chỉnh Sửa Chi Tiết Ấn Phẩm
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- ISBN -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            ISBN <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-barcode"></i>
                            </span>
                            <input type="text" id="input_isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" placeholder="VD: 978-604-0-12345-6"
                                   class="w-full pl-9 pr-3.5 py-2 text-xs border @error('isbn') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
                        </div>
                        @error('isbn')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NGÔN NGỮ -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            NGÔN NGỮ
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-globe"></i>
                            </span>
                            <input type="text" id="input_language" name="language" value="{{ old('language', $book->language ?? 'Tiếng Việt') }}" placeholder="VD: Tiếng Việt"
                                   class="w-full pl-9 pr-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
                        </div>
                        @error('language')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- TÊN SÁCH -->
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            TÊN SÁCH <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-book"></i>
                            </span>
                            <input type="text" id="input_book_name" name="book_name" value="{{ old('book_name', $book->book_name) }}" placeholder="Nhập tên sách..."
                                   class="w-full pl-9 pr-3.5 py-2 text-xs border @error('book_name') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
                        </div>
                        @error('book_name')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- TÁC GIẢ -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            TÁC GIẢ <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-user-pen"></i>
                            </span>
                            <input type="text" id="input_author" name="author" value="{{ old('author', $book->author) }}" placeholder="Nhập tên tác giả..."
                                   class="w-full pl-9 pr-3.5 py-2 text-xs border @error('author') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
                        </div>
                        @error('author')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- DANH MỤC SÁCH -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            DANH MỤC SÁCH <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-layer-group"></i>
                            </span>
                            <select id="input_category_id" name="category_id" class="w-full pl-9 pr-3.5 py-2 text-xs border @error('category_id') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->category_id }}" {{ old('category_id', $book->category_id) == $cat->category_id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- SỐ LƯỢNG -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            TỔNG SỐ LƯỢNG <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </span>
                            <input type="number" id="input_total_quantity" name="total_quantity" value="{{ old('total_quantity', $book->total_quantity) }}" placeholder="Tối thiểu 10 cuốn"
                                   class="w-full pl-9 pr-3.5 py-2 text-xs border @error('total_quantity') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
                        </div>
                        <div class="text-[11px] text-slate-500 mt-1 flex items-center gap-2">
                            <span class="text-emerald-600 font-bold">Khả dụng: {{ $book->available_quantity }}</span>
                            <span>|</span>
                            <span class="text-amber-600 font-bold">Đang mượn: {{ $book->total_quantity - $book->available_quantity }} cuốn</span>
                        </div>
                        @error('total_quantity')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- SỐ TRANG -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            SỐ TRANG
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-file-lines"></i>
                            </span>
                            <input type="number" id="input_page_count" name="page_count" value="{{ old('page_count', $book->page_count) }}" placeholder="VD: 250"
                                   class="w-full pl-9 pr-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
                        </div>
                        @error('page_count')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- KHU VỰC THƯ VIỆN -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            KHU VỰC THƯ VIỆN <span class="text-rose-500">*</span>
                        </label>
                        <select id="input_location" name="location" class="w-full px-3.5 py-2 text-xs border @error('location') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
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

                    <!-- TRẠNG THÁI SÁCH -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            TRẠNG THÁI SÁCH <span class="text-rose-500">*</span>
                        </label>
                        <select id="input_status" name="status" class="w-full px-3.5 py-2 text-xs border @error('status') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
                            <option value="1" {{ old('status', $book->status) == 1 ? 'selected' : '' }}>1 - Đang lưu hành (Cho phép mượn)</option>
                            <option value="0" {{ old('status', $book->status) == 0 ? 'selected' : '' }}>0 - Tạm ngưng phục vụ</option>
                        </select>
                        @error('status')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ÁNH BÌA SÁCH -->
                    <div class="md:col-span-2 space-y-2 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700">
                            <i class="fa-solid fa-cloud-arrow-up text-blue-600 mr-1"></i> ÁNH BÌA SÁCH (Tải ảnh mới nếu muốn thay đổi)
                        </label>
                        <input type="file" name="book_image" id="input_book_image" accept="image/*"
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        <p class="text-[11px] text-slate-400">Nếu không tải ảnh mới, hệ thống sẽ tự động giữ lại ảnh bìa hiện tại.</p>
                        @error('book_image')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- TÓM TẮT NỘI DUNG -->
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            TÓM TẮT NỘI DUNG
                        </label>
                        <textarea id="input_description" name="description" rows="4" placeholder="Nhập một vài dòng giới thiệu tóm tắt về nội dung cuốn sách..."
                                  class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">{{ old('description', $book->description) }}</textarea>
                        @error('description')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('books.index') }}" class="px-5 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">Hủy Bỏ</a>
                    <button type="submit" class="px-5 py-2.5 text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-xs transition cursor-pointer flex items-center gap-1.5">
                        <i class="fa-solid fa-floppy-disk"></i> Cập Nhật Sách
                    </button>
                </div>
            </form>
        </div>

        <!-- XEM TRƯỚC THẺ SÁCH (PREVIEW) -->
        <div class="lg:col-span-5 lg:sticky lg:top-6 space-y-3">
            <div class="flex items-center justify-between text-xs font-bold text-slate-600 px-1">
                <span class="flex items-center gap-1.5">
                    <i class="fa-regular fa-eye text-blue-600"></i> XEM TRƯỚC THẺ SÁCH (PREVIEW)
                </span>
                <span id="preview_status_badge" class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800">
                    Đang chỉnh sửa
                </span>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden transition-all duration-300">
                <div class="w-full h-60 bg-slate-800 relative overflow-hidden flex items-center justify-center">
                    @php
                        $initialImage = $book->book_image 
                            ? (str_starts_with($book->book_image, 'book/') ? asset($book->book_image) : asset('storage/' . $book->book_image))
                            : 'https://via.placeholder.com/600x400?text=Chua+Co+Anh';
                    @endphp
                    <img id="preview_img" 
                         src="{{ $initialImage }}" 
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/600x400?text=Chua+Co+Anh';"
                         alt="Preview" class="w-full h-full object-cover">
                    
                    <span id="preview_category" class="absolute top-3 right-3 px-3 py-1 bg-blue-600/90 backdrop-blur-xs text-white text-[11px] font-bold rounded-full shadow-md">
                        {{ $book->category->category_name ?? 'Chưa chọn danh mục' }}
                    </span>
                </div>

                <div class="p-5 space-y-3">
                    <div>
                        <span id="preview_isbn" class="px-2 py-0.5 bg-slate-100 text-slate-600 font-mono text-[10px] font-bold rounded-md">
                            {{ $book->isbn }}
                        </span>
                    </div>

                    <h3 id="preview_title" class="text-base font-bold text-slate-900 leading-snug">
                        {{ $book->book_name }}
                    </h3>

                    <p id="preview_author" class="text-xs text-slate-600">
                        {{ $book->author }}
                    </p>

                    <p id="preview_description" class="text-xs text-slate-500 line-clamp-3 leading-relaxed italic">
                        {{ $book->description ?: 'Mô tả tóm tắt sách...' }}
                    </p>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Trạng thái kho:</span>
                        <span id="preview_stock" class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-full border border-emerald-200">
                            Sẵn có: {{ $book->available_quantity }} quyển
                        </span>
                    </div>
                </div>
            </div>

            <p class="text-[11px] text-slate-400 text-center flex items-center justify-center gap-1.5 pt-1">
                <i class="fa-solid fa-circle-info"></i> Thay đổi thông tin bên trái để xem trước hiển thị ngay lập tức.
            </p>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputIsbn = document.getElementById('input_isbn');
        const inputTitle = document.getElementById('input_book_name');
        const inputAuthor = document.getElementById('input_author');
        const inputCategory = document.getElementById('input_category_id');
        const inputQuantity = document.getElementById('input_total_quantity');
        const inputStatus = document.getElementById('input_status');
        const inputDescription = document.getElementById('input_description');
        const inputImage = document.getElementById('input_book_image');

        const previewIsbn = document.getElementById('preview_isbn');
        const previewTitle = document.getElementById('preview_title');
        const previewAuthor = document.getElementById('preview_author');
        const previewCategory = document.getElementById('preview_category');
        const previewStock = document.getElementById('preview_stock');
        const previewDescription = document.getElementById('preview_description');
        const previewImg = document.getElementById('preview_img');
        const previewStatusBadge = document.getElementById('preview_status_badge');

        function updatePreview() {
            previewIsbn.innerText = inputIsbn.value.trim() || '---';
            previewTitle.innerText = inputTitle.value.trim() || 'Tên sách chưa nhập';
            previewAuthor.innerText = inputAuthor.value.trim() || 'Chưa có tác giả';

            if (inputCategory.selectedIndex > 0 && inputCategory.options[inputCategory.selectedIndex].value !== "") {
                previewCategory.innerText = inputCategory.options[inputCategory.selectedIndex].text;
            } else {
                previewCategory.innerText = 'Chưa chọn danh mục';
            }

            const qty = inputQuantity.value || 0;
            previewStock.innerText = 'Tổng trong kho: ' + qty + ' quyển';

            if (inputStatus.value == '0') {
                previewStatusBadge.className = 'px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-rose-100 text-rose-800';
                previewStatusBadge.innerText = 'Tạm ngưng phục vụ';
            } else {
                previewStatusBadge.className = 'px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800';
                previewStatusBadge.innerText = 'Đang lưu hành';
            }

            previewDescription.innerText = inputDescription.value.trim() || 'Mô tả tóm tắt sách sẽ xuất hiện tại đây khi bạn nhập liệu vào ô bên cạnh...';
        }

        [inputIsbn, inputTitle, inputAuthor, inputCategory, inputQuantity, inputStatus, inputDescription].forEach(input => {
            if (input) {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
                input.addEventListener('keyup', updatePreview);
            }
        });

        if (inputImage) {
            inputImage.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        updatePreview();
    });
</script>
@endsection