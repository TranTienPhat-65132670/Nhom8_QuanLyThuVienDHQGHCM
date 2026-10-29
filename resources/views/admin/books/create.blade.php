@extends('layout.admin')

@section('title', 'Thêm Sách Mới')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Thêm Sách Vào Kho</h1>
        </div>
        <a href="{{ route('books.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
            <i class="fa-solid fa-arrow-left mr-1"></i> Quay lại
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <div class="lg:col-span-7">
            <form id="bookForm" action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                @csrf
                
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100 font-bold text-slate-800 text-sm">
                    <i class="fa-solid fa-square-plus text-blue-600"></i> Nhập Thông Tin Sách Mới
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
                            <input type="text" id="input_isbn" name="isbn" value="{{ old('isbn') }}" placeholder="VD: 978-604-0-12345-6"
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
                            <input type="text" id="input_language" name="language" value="{{ old('language', 'Tiếng Việt') }}" placeholder="VD: Tiếng Việt"
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
                            <input type="text" id="input_book_name" name="book_name" value="{{ old('book_name') }}" placeholder="Nhập tên sách..."
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
                            <input type="text" id="input_author" name="author" value="{{ old('author') }}" placeholder="Nhập tên tác giả..."
                                   class="w-full pl-9 pr-3.5 py-2 text-xs border @error('author') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
                        </div>
                        @error('author')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- DANH MỤC SÁCH (CUSTOM DROPDOWN CÓ THANH CUỘN & TÌM KIẾM) -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            DANH MỤC SÁCH <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative" id="category-select-wrapper">
                            <!-- Input ẩn gửi lên controller -->
                            <input type="hidden" name="category_id" id="input_category_id" value="{{ old('category_id') }}">

                            <!-- Button hiển thị danh mục đã chọn -->
                            <button type="button" id="category-dropdown-btn" 
                                    class="w-full pl-9 pr-3.5 py-2 text-xs text-left border @error('category_id') border-red-500 @else border-slate-200 @enderror rounded-xl bg-white flex justify-between items-center focus:border-blue-500 focus:outline-hidden cursor-pointer relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-layer-group"></i>
                                </span>
                                <span id="selected-category-label" class="text-slate-700 font-medium truncate">
                                    -- Chọn danh mục --
                                </span>
                                <i class="fa-solid fa-chevron-down text-slate-400 text-[10px] transition-transform duration-200 ml-2" id="dropdown-arrow"></i>
                            </button>

                            <!-- Frame danh mục giới hạn chiều cao max-h-52 & có thanh cuộn -->
                            <div id="category-dropdown-menu" 
                                 class="hidden absolute z-50 left-0 right-0 mt-1 bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden transition-all">
                                
                                <div class="p-2 border-b border-slate-100 bg-slate-50">
                                    <input type="text" id="category-search-input" placeholder="Nhập để tìm danh mục..." 
                                           class="w-full px-3 py-1.5 text-xs border border-slate-200 rounded-lg focus:outline-hidden focus:border-blue-500 bg-white">
                                </div>

                                <ul id="category-options-list" class="max-h-52 overflow-y-auto divide-y divide-slate-50 text-xs text-slate-700">
                                    <li data-value="" class="category-item px-3.5 py-2.5 hover:bg-slate-100 cursor-pointer text-slate-400 flex justify-between items-center">
                                        <span>-- Chọn danh mục --</span>
                                    </li>
                                    @foreach($categories as $cat)
                                        <li data-value="{{ $cat->category_id }}" 
                                            class="category-item px-3.5 py-2.5 hover:bg-blue-50 hover:text-blue-600 cursor-pointer flex justify-between items-center transition {{ old('category_id') == $cat->category_id ? 'bg-blue-50 text-blue-600 font-bold' : '' }}">
                                            <span>{{ $cat->category_name }}</span>
                                            @if(old('category_id') == $cat->category_id)
                                                <i class="fa-solid fa-check text-blue-600 text-xs"></i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @error('category_id')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- SỐ LƯỢNG -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            SỐ LƯỢNG <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </span>
                            <input type="number" id="input_total_quantity" name="total_quantity" value="{{ old('total_quantity', 10) }}" placeholder="Tối thiểu 10 cuốn"
                                   class="w-full pl-9 pr-3.5 py-2 text-xs border @error('total_quantity') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
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
                            <input type="number" id="input_page_count" name="page_count" value="{{ old('page_count') }}" placeholder="VD: 250"
                                   class="w-full pl-9 pr-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
                        </div>
                        @error('page_count')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- KHU VỰC -->
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            KHU VỰC <span class="text-rose-500">*</span>
                        </label>
                        <select id="input_location" name="location" class="w-full px-3.5 py-2 text-xs border @error('location') border-red-500 @else border-slate-200 @enderror rounded-xl focus:border-blue-500 focus:outline-hidden">
                            <option value="Thư viện Trung tâm DHQG-HCM" {{ old('location') == 'Thư viện Trung tâm DHQG-HCM' ? 'selected' : '' }}>
                                Thư viện Trung tâm DHQG-HCM
                            </option>
                            <option value="Ký túc xá Khu B Đại học Quốc gia TP.HCM" {{ old('location') == 'Ký túc xá Khu B Đại học Quốc gia TP.HCM' ? 'selected' : '' }}>
                                Ký túc xá Khu B Đại học Quốc gia TP.HCM
                            </option>
                        </select>
                        @error('location')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ẢNH BÌA SÁCH -->
                    <div class="md:col-span-2 space-y-2 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700">
                            <i class="fa-solid fa-cloud-arrow-up text-blue-600 mr-1"></i> ẢNH BÌA SÁCH
                        </label>
                        <input type="file" name="book_image" id="input_book_image" accept="image/*"
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        @error('book_image')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            TÓM TẮT NỘI DUNG 
                        </label>
                        <textarea id="input_description" name="description" rows="4" placeholder="Nhập nội dung giới thiệu tóm tắt cuốn sách..."
                                  class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('books.index') }}" class="px-5 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">Hủy Bỏ</a>
                    <button type="submit" class="px-5 py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs transition cursor-pointer flex items-center gap-1.5">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Đăng Sách
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-5 lg:sticky lg:top-6 space-y-3">
            <!-- Header Preview -->
            <div class="flex items-center justify-between text-xs font-bold text-slate-600 px-1">
                <span class="flex items-center gap-1.5">
                    <i class="fa-regular fa-eye text-blue-600"></i> XEM TRƯỚC THẺ SÁCH
                </span>
                <span class="px-2.5 py-0.5 bg-amber-100 text-amber-800 text-[10px] font-bold rounded-full">
                    Đang soạn thảo
                </span>
            </div>

            <!-- Card Xem Trước -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden transition-all duration-300">
                <!-- Khung Ảnh Bìa với Badge Thể Loại Overlaid -->
                <div class="w-full h-60 bg-slate-800 relative overflow-hidden flex items-center justify-center">
                    <img id="preview_img" 
                         src="https://via.placeholder.com/600x400?text=Chua+Chon+Anh" 
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/600x400?text=Chua+Chon+Anh';"
                         alt="Preview" class="w-full h-full object-cover">
                    
                    <span id="preview_category" class="absolute top-3 right-3 px-3 py-1 bg-blue-600/90 backdrop-blur-xs text-white text-[11px] font-bold rounded-full shadow-md">
                        Chưa chọn thể loại
                    </span>
                </div>

                <!-- Chi Tiết Nội Dung Card -->
                <div class="p-5 space-y-3">
                    <!-- ISBN Tag -->
                    <div>
                        <span id="preview_isbn" class="px-2 py-0.5 bg-slate-100 text-slate-600 font-mono text-[10px] font-bold rounded-md">
                            ---
                        </span>
                    </div>

                    <!-- Tên Sách -->
                    <h3 id="preview_title" class="text-base font-bold text-slate-900 leading-snug">
                        Tên sách chưa nhập
                    </h3>

                    <!-- Tác Giả -->
                    <p id="preview_author" class="text-xs text-slate-600">
                        Chưa có tác giả
                    </p>

                    <!-- Mô Tả Tóm Tắt -->
                    <p id="preview_description" class="text-xs text-slate-500 line-clamp-3 leading-relaxed italic">
                        Mô tả tóm tắt sách...
                    </p>

                    <!-- Trạng Thái Kho -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Trạng thái kho:</span>
                        <span id="preview_stock" class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-full border border-emerald-200">
                            Sẵn có: 10 quyển
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputIsbn = document.getElementById('input_isbn');
        const inputTitle = document.getElementById('input_book_name');
        const inputAuthor = document.getElementById('input_author');
        const inputQuantity = document.getElementById('input_total_quantity');
        const inputDescription = document.getElementById('input_description');
        const inputImage = document.getElementById('input_book_image');

        const previewIsbn = document.getElementById('preview_isbn');
        const previewTitle = document.getElementById('preview_title');
        const previewAuthor = document.getElementById('preview_author');
        const previewCategory = document.getElementById('preview_category');
        const previewStock = document.getElementById('preview_stock');
        const previewDescription = document.getElementById('preview_description');
        const previewImg = document.getElementById('preview_img');

        const wrapper = document.getElementById('category-select-wrapper');
        const btn = document.getElementById('category-dropdown-btn');
        const menu = document.getElementById('category-dropdown-menu');
        const arrow = document.getElementById('dropdown-arrow');
        const searchInput = document.getElementById('category-search-input');
        const optionsList = document.getElementById('category-options-list');
        const hiddenInput = document.getElementById('input_category_id');
        const label = document.getElementById('selected-category-label');
        const items = optionsList ? optionsList.querySelectorAll('.category-item') : [];

        if (hiddenInput && hiddenInput.value && items.length > 0) {
            items.forEach(item => {
                if (item.getAttribute('data-value') === hiddenInput.value) {
                    label.textContent = item.querySelector('span') ? item.querySelector('span').textContent : item.textContent.trim();
                }
            });
        }

        if (btn) {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const isHidden = menu.classList.contains('hidden');
                if (isHidden) {
                    menu.classList.remove('hidden');
                    arrow.classList.add('rotate-180');
                    searchInput.focus();
                } else {
                    closeDropdown();
                }
            });
        }

        function closeDropdown() {
            if (menu) menu.classList.add('hidden');
            if (arrow) arrow.classList.remove('rotate-180');
            if (searchInput) searchInput.value = '';
            items.forEach(item => item.style.display = 'flex');
        }

        items.forEach(item => {
            item.addEventListener('click', function () {
                const val = this.getAttribute('data-value');
                const text = this.querySelector('span') ? this.querySelector('span').textContent : this.textContent.trim();

                hiddenInput.value = val;
                label.textContent = text;

                items.forEach(i => {
                    i.classList.remove('bg-blue-50', 'text-blue-600', 'font-bold');
                    const icon = i.querySelector('.fa-check');
                    if (icon) icon.remove();
                });

                if (val !== '') {
                    this.classList.add('bg-blue-50', 'text-blue-600', 'font-bold');
                    this.insertAdjacentHTML('beforeend', '<i class="fa-solid fa-check text-blue-600 text-xs"></i>');
                }

                closeDropdown();
                updatePreview();
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const keyword = this.value.toLowerCase().trim();
                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(keyword) ? 'flex' : 'none';
                });
            });
        }

        document.addEventListener('click', function (e) {
            if (wrapper && !wrapper.contains(e.target)) {
                closeDropdown();
            }
        });

        function updatePreview() {
            previewIsbn.innerText = inputIsbn.value.trim() || '---';
            previewTitle.innerText = inputTitle.value.trim() || 'Tên sách chưa nhập';
            previewAuthor.innerText = inputAuthor.value.trim() || 'Chưa có tác giả';

            if (hiddenInput.value && label.textContent.trim() !== '-- Chọn danh mục --') {
                previewCategory.innerText = label.textContent.trim();
            } else {
                previewCategory.innerText = 'Chưa chọn thể loại';
            }

            const qty = inputQuantity.value || 0;
            previewStock.innerText = 'Sẵn có: ' + qty + ' quyển';

            previewDescription.innerText = inputDescription.value.trim() || 'Mô tả tóm tắt sách...';
        }

        [inputIsbn, inputTitle, inputAuthor, inputQuantity, inputDescription].forEach(input => {
            if (input) {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
                input.addEventListener('keyup', updatePreview);
            }
        });

        // Live preview ảnh bìa
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

        // Chạy khởi tạo lần đầu
        updatePreview();
    });
</script>
@endsection