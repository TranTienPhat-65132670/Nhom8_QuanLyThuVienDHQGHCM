@extends('layout.client')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Tiêu đề và Thanh tìm kiếm -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-heart text-rose-500"></i> Sách yêu thích của tôi
                </h1>
                <p class="text-gray-500 text-sm mt-1">Chọn tối đa 5 cuốn sách có sẵn để tạo phiếu mượn nhanh chóng</p>
            </div>

            <!-- Form tìm kiếm -->
            <form action="{{ route('client.books.favorites') }}" method="GET" class="flex items-center gap-2">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </span>
                    <input type="text" name="keyword" value="{{ request('keyword') }}"
                        placeholder="Tìm theo tên sách, tác giả..."
                        class="w-full sm:w-72 pl-9 pr-4 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:outline-none focus:border-rose-500 transition">
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition">
                    Tìm kiếm
                </button>
                @if (request('keyword'))
                    <a href="{{ route('client.books.favorites') }}"
                        class="px-3 py-2 bg-gray-100 text-gray-600 text-sm rounded-lg hover:bg-gray-200 transition"
                        title="Xóa tìm kiếm">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </form>
        </div>

        <!-- Form bọc bảng -->
        <form id="borrowForm" action="{{ route('client.borrow.create') }}" method="POST">
            @csrf

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @if ($favorites->isEmpty())
                    <div class="text-center py-16">
                        <i class="fa-regular fa-heart text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium">Chưa có cuốn sách yêu thích nào trong danh sách.</p>
                        <a href="{{ route('client.books.index') }}"
                            class="inline-block mt-4 px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 text-sm font-medium transition">
                            Khám phá kho sách ngay
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 border-b border-gray-100 font-semibold">
                                    <th class="py-3.5 px-4 w-12 text-center">Chọn</th>
                                    <th class="py-3.5 px-4">Hình ảnh</th>
                                    <th class="py-3.5 px-4">Tên sách</th>
                                    <th class="py-3.5 px-4">Tác giả</th>
                                    <th class="py-3.5 px-4">Trạng thái kho</th>
                                    <th class="py-3.5 px-4 text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($favorites as $book)
                                    <tr class="hover:bg-gray-50/60 transition">
                                        <td class="py-4 px-4 text-center">
                                            @if (($book->available_quantity ?? 0) > 0)
                                                <!-- Chỉ hiện checkbox nếu còn sách -->
                                                <input type="checkbox" name="book_ids[]" value="{{ $book->book_id }}"
                                                    class="book-checkbox rounded border-gray-300 text-rose-600 focus:ring-rose-500 cursor-pointer">
                                            @else
                                                <!-- Hết sách thì ẩn checkbox hoặc để trống -->
                                                <span class="text-gray-300" title="Sách đã hết, không thể chọn mượn">
                                                    <i class="fa-solid fa-ban"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 w-16">
                                            <img src="{{ asset($book->book_image ?? 'images/default-book.png') }}"
                                                alt="{{ $book->book_name }}"
                                                class="w-10 h-14 object-cover rounded shadow-sm">
                                        </td>
                                        <td class="py-4 px-4 font-semibold text-gray-800">
                                            <a href="{{ route('client.books.show', $book->slug) }}"
                                                class="hover:text-rose-600 transition">
                                                {{ $book->book_name }}
                                            </a>
                                        </td>
                                        <td class="py-4 px-4 text-gray-600">
                                            {{ $book->author }}
                                        </td>
                                        <td class="py-4 px-4">
                                            @if (($book->available_quantity ?? 0) > 0)
                                                <span
                                                    class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">
                                                    Còn sách ({{ $book->available_quantity }})
                                                </span>
                                            @else
                                                <span
                                                    class="px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-700">
                                                    Hết sách
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <!-- Nút chi tiết -->
                                                <a href="{{ route('client.books.show', $book->slug) }}"
                                                    class="inline-flex items-center gap-1 text-xs font-medium text-blue-600 hover:text-blue-700 bg-blue-50 px-3 py-1.5 rounded-md transition">
                                                    Chi tiết
                                                </a>

                                                <!-- Nút Bỏ thích -->
                                                <form action="{{ route('client.books.favorite', $book->book_id) }}"
                                                    method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1 text-xs font-medium text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-md transition"
                                                        title="Bỏ thích">
                                                        <i class="fa-solid fa-heart-crack"></i> Bỏ thích
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer: Phân trang bên trái, Nút tạo phiếu mượn bên phải -->
                    <div
                        class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">

                        <!-- BÊN TRÁI: PHÂN TRANG THỦ CÔNG CÓ DẤU ... -->
                        @if ($totalPages > 1)
                            <div class="flex flex-col gap-1 w-full md:w-auto">
                                <div class="flex items-center gap-1 flex-wrap">
                                    <!-- Nút Previous -->
                                    @if ($currentPage > 1)
                                        <a href="{{ route('client.books.favorites', ['page' => $currentPage - 1, 'keyword' => request('keyword')]) }}"
                                            class="px-3 py-1.5 text-sm font-medium bg-white border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                                            <i class="fa-solid fa-chevron-left text-xs"></i> Trước
                                        </a>
                                    @else
                                        <span
                                            class="px-3 py-1.5 text-sm font-medium bg-gray-100 border border-gray-200 rounded-lg text-gray-400 cursor-not-allowed">
                                            <i class="fa-solid fa-chevron-left text-xs"></i> Trước
                                        </span>
                                    @endif

                                    <!-- Thuật toán hiển thị các trang và dấu ... -->
                                    @php
                                        $linkLimit = 1;
                                        $range = [];
                                        for ($i = 1; $i <= $totalPages; $i++) {
                                            if (
                                                $i == 1 ||
                                                $i == $totalPages ||
                                                ($i >= $currentPage - $linkLimit && $i <= $currentPage + $linkLimit)
                                            ) {
                                                $range[] = $i;
                                            }
                                        }
                                        $paginatedPages = [];
                                        $last = 0;
                                        foreach ($range as $i) {
                                            if ($last) {
                                                if ($i - $last == 2) {
                                                    $paginatedPages[] = $last + 1;
                                                } elseif ($i - $last > 2) {
                                                    $paginatedPages[] = '...';
                                                }
                                            }
                                            $paginatedPages[] = $i;
                                            $last = $i;
                                        }
                                    @endphp

                                    @foreach ($paginatedPages as $page)
                                        @if ($page === '...')
                                            <span class="px-3 py-1.5 text-sm text-gray-400">...</span>
                                        @else
                                            <a href="{{ route('client.books.favorites', ['page' => $page, 'keyword' => request('keyword')]) }}"
                                                class="px-3 py-1.5 text-sm font-medium rounded-lg border transition {{ $page == $currentPage ? 'bg-rose-600 text-white border-rose-600 shadow-sm' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    <!-- Nút Next -->
                                    @if ($currentPage < $totalPages)
                                        <a href="{{ route('client.books.favorites', ['page' => $currentPage + 1, 'keyword' => request('keyword')]) }}"
                                            class="px-3 py-1.5 text-sm font-medium bg-white border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                                            Sau <i class="fa-solid fa-chevron-right text-xs"></i>
                                        </a>
                                    @else
                                        <span
                                            class="px-3 py-1.5 text-sm font-medium bg-gray-100 border border-gray-200 rounded-lg text-gray-400 cursor-not-allowed">
                                            Sau <i class="fa-solid fa-chevron-right text-xs"></i>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    Trang <span class="font-semibold text-gray-700">{{ $currentPage }}</span> / <span
                                        class="font-semibold text-gray-700">{{ $totalPages }}</span>
                                </div>
                            </div>
                        @else
                            <div></div>
                        @endif

                        <!-- BÊN PHẢI: NÚT TẠO PHIẾU MƯỢN -->
                        <div class="w-full md:w-auto text-right">
                            <button type="submit"
                                class="w-full md:w-auto px-6 py-2.5 bg-rose-600 text-white font-semibold rounded-lg hover:bg-rose-700 transition flex items-center justify-center gap-2 shadow-sm">
                                <i class="fa-solid fa-file-circle-plus"></i>
                                <span class="whitespace-nowrap">Tạo phiếu mượn các sách đã chọn (<span
                                        id="selectedCount">0</span>/5)</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Script xử lý giới hạn 5 cuốn và lưu trạng thái qua các trang -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const STORAGE_KEY = 'selected_borrow_books';
            const MAX_BOOKS = 5;

            function getSelectedBooks() {
                return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
            }

            function saveSelectedBooks(books) {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(books));
            }

            function updateCounter() {
                let selected = getSelectedBooks();
                const counterEl = document.getElementById('selectedCount');
                if (counterEl) {
                    counterEl.textContent = selected.length;
                }
            }

            const checkboxes = document.querySelectorAll('.book-checkbox');
            let selectedBooks = getSelectedBooks();

            checkboxes.forEach(cb => {
                if (selectedBooks.includes(cb.value)) {
                    cb.checked = true;
                }

                cb.addEventListener('change', function(e) {
                    let currentSelected = getSelectedBooks();

                    if (this.checked) {
                        if (currentSelected.length >= MAX_BOOKS) {
                            e.preventDefault();
                            this.checked = false;
                            alert('Bạn chỉ được chọn tối đa 5 cuốn sách cho một phiếu mượn!');
                            return;
                        }
                        if (!currentSelected.includes(this.value)) {
                            currentSelected.push(this.value);
                        }
                    } else {
                        currentSelected = currentSelected.filter(id => id !== this.value);
                    }

                    saveSelectedBooks(currentSelected);
                    updateCounter();
                });
            });

            updateCounter();

            const form = document.getElementById('borrowForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    let allSelected = getSelectedBooks();

                    if (allSelected.length === 0) {
                        e.preventDefault();
                        alert('Vui lòng chọn ít nhất một cuốn sách để tạo phiếu mượn!');
                        return;
                    }

                    if (allSelected.length > MAX_BOOKS) {
                        e.preventDefault();
                        alert('Bạn chỉ được chọn tối đa 5 cuốn sách!');
                        return;
                    }

                    form.querySelectorAll('input.hidden-book-id').forEach(el => el.remove());

                    allSelected.forEach(id => {
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'book_ids[]';
                        input.value = id;
                        input.className = 'hidden-book-id';
                        form.appendChild(input);
                    });

                    localStorage.removeItem(STORAGE_KEY);
                });
            }
        });
    </script>
@endsection
