@extends('layout.client')

@section('title', 'Sách Yêu Thích Của Tôi')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-8">

        <!-- Tiêu đề trang & Thanh Tra Cứu -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-heart text-rose-500"></i> Tra Cứu Sách Yêu Thích
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">Tìm kiếm trong danh sách các ấn phẩm bạn đã lưu lại</p>
                </div>
                <a href="{{ route('client.books.index') }}"
                    class="px-4 py-2 bg-slate-100 hover@extends('layout.client')

@section('title', 'Sách Yêu Thích Của Tôi')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">
    
    <!-- Tiêu đề trang & Thanh Tra Cứu -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-heart text-rose-500"></i> Tra Cứu Sách Yêu Thích
                </h1>
                <p class="text-xs text-slate-500 mt-1">Tìm kiếm trong danh sách các ấn phẩm bạn đã lưu lại</p>
            </div>
            <a href="{{ route('client.books.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition flex items-center gap-1.5 self-start sm:self-auto">
                <i class="fa-solid fa-book-open"></i> Tra cứu toàn bộ thư viện
            </a>
        </div>

        <!-- Form Tra Cứu Trong Mục Yêu Thích -->
        <form action="{{ route('client.books.favorites') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="keyword" value="{{ request('keyword') }}" 
                       placeholder="Nhập tên sách, tác giả hoặc mã ISBN cần tìm trong mục yêu thích..." 
                       class="w-full pl-9 pr-4 py-2.5 text-xs border border-slate-200 rounded-xl focus:border-rose-500 focus:outline-hidden">
            </div>

            <div class="flex gap-2 shrink-0">
                <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl transition cursor-pointer flex items-center gap-1.5">
                    <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
                </button>
                @if (request()->filled('keyword'))
                    <a href="{{ route('client.books.favorites') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition flex items-center">
                        Xóa lọc
                    </a>
                @endif
            </div>
        </form>
    </div>

    @if ($books->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl border border-slate-200 space-y-3">
            <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto text-2xl">
                <i class="fa-regular fa-heart"></i>
            </div>
            @if (request()->filled('keyword'))
                <h3 class="font-bold text-slate-800 text-sm">Không tìm thấy sách yêu thích phù hợp</h3>
                <p class="text-slate-500 text-xs">Không có kết quả nào trùng khớp với từ khóa "<strong>{{ request('keyword') }}</strong>" trong danh sách yêu thích của bạn.</p>
                <a href="{{ route('client.books.favorites') }}" class="inline-block px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                    Xem tất cả sách yêu thích
                </a>
            @else
                <h3 class="font-bold text-slate-800 text-sm">Chưa có cuốn sách yêu thích nào</h3>
                <p class="text-slate-500 text-xs">Hãy khám phá kho sách của thư viện và nhấn "Yêu thích" các ấn phẩm bạn quan tâm nhé!</p>
                <a href="{{ route('client.books.index') }}" class="inline-block px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                    Khám Phá Thư Viện
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($books as $book)
                @php
                    $defaultSvg = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='500' viewBox='0 0 400 500'><rect width='100%' height='100%' fill='%23f1f5f9'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-size='18' font-weight='bold' fill='%2394a3b8'>Chưa Có Ảnh Bìa</text></svg>";

                    $imgUrl = $defaultSvg;

                    if (!empty($book->book_image)) {
                        $cleanPath = ltrim($book->book_image, '/');

                        if (str_starts_with($cleanPath, 'http')) {
                            $imgUrl = $cleanPath;
                        } elseif (file_exists(public_path($cleanPath))) {
                            $imgUrl = asset($cleanPath);
                        } else {
                            $imgUrl = asset('storage/' . $cleanPath);
                        }
                    }
                @endphp
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="h-56 bg-slate-100 overflow-hidden relative">
                            <img src="{{ $imgUrl }}" 
                                 onerror="this.onerror=null; this.src='{{ $defaultSvg }}';" 
                                 alt="{{ $book->book_name }}" 
                                 class="w-full h-full object-cover">
                            
                            <span class="absolute top-3 right-3 px-2.5 py-1 text-[10px] font-bold rounded-full {{ $book->available_quantity > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                {{ $book->available_quantity > 0 ? 'Còn ' . $book->available_quantity . ' cuốn' : 'Hết sách' }}
                            </span>
                        </div>

                        <div class="p-4 space-y-2">
                            <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">
                                {{ $book->category->category_name ?? 'Khác' }}
                            </span>
                            <h3 class="font-bold text-slate-800 text-xs line-clamp-2 hover:text-blue-600">
                                <a href="{{ route('client.books.show', $book->slug ?? $book->book_id) }}">{{ $book->book_name }}</a>
                            </h3>
                            <p class="text-[11px] text-slate-500"><i class="fa-regular fa-user mr-1"></i>{{ $book->author }}</p>
                        </div>
                    </div>

                    <div class="p-4 pt-0">
                        <a href="{{ route('client.books.show', $book->slug ?? $book->book_id) }}" 
                           class="block text-center w-full py-2 bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 text-xs font-semibold rounded-xl transition">
                            Xem Chi Tiết
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $books->links('components.custom-pagination') }}
        </div>
    @endif
</div>
@endsection:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition flex items-center gap-1.5 self-start sm:self-auto">
                    <i class="fa-solid fa-book-open"></i> Tra cứu toàn bộ thư viện
                </a>
            </div>

            <!-- Form Tra Cứu Trong Mục Yêu Thích -->
            <form action="{{ route('client.books.favorites') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="keyword" value="{{ request('keyword') }}"
                        placeholder="Nhập tên sách, tác giả hoặc mã ISBN cần tìm trong mục yêu thích..."
                        class="w-full pl-9 pr-4 py-2.5 text-xs border border-slate-200 rounded-xl focus:border-rose-500 focus:outline-hidden">
                </div>

                <div class="flex gap-2 shrink-0">
                    <button type="submit"
                        class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl transition cursor-pointer flex items-center gap-1.5">
                        <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
                    </button>
                    @if (request()->filled('keyword'))
                        <a href="{{ route('client.books.favorites') }}"
                            class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition flex items-center">
                            Xóa lọc
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if ($books->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl border border-slate-200 space-y-3">
                <div
                    class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto text-2xl">
                    <i class="fa-regular fa-heart"></i>
                </div>
                @if (request()->filled('keyword'))
                    <h3 class="font-bold text-slate-800 text-sm">Không tìm thấy sách yêu thích phù hợp</h3>
                    <p class="text-slate-500 text-xs">Không có kết quả nào trùng khớp với từ khóa
                        "<strong>{{ request('keyword') }}</strong>" trong danh sách yêu thích của bạn.</p>
                    <a href="{{ route('client.books.favorites') }}"
                        class="inline-block px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                        Xem tất cả sách yêu thích
                    </a>
                @else
                    <h3 class="font-bold text-slate-800 text-sm">Chưa có cuốn sách yêu thích nào</h3>
                    <p class="text-slate-500 text-xs">Hãy khám phá kho sách của thư viện và nhấn "Yêu thích" các ấn phẩm bạn
                        quan tâm nhé!</p>
                    <a href="{{ route('client.books.index') }}"
                        class="inline-block px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                        Khám Phá Thư Viện
                    </a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($books as $book)
                    @php
                        $defaultSvg =
                            "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='500' viewBox='0 0 400 500'><rect width='100%' height='100%' fill='%23f1f5f9'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-size='18' font-weight='bold' fill='%2394a3b8'>Chưa Có Ảnh Bìa</text></svg>";

                        $imgUrl = $defaultSvg;

                        if (!empty($book->book_image)) {
                            $cleanPath = ltrim($book->book_image, '/');

                            if (str_starts_with($cleanPath, 'http')) {
                                $imgUrl = $cleanPath;
                            } elseif (file_exists(public_path($cleanPath))) {
                                $imgUrl = asset($cleanPath);
                            } else {
                                $imgUrl = asset('storage/' . $cleanPath);
                            }
                        }
                    @endphp
                    <div
                        class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="h-56 bg-slate-100 overflow-hidden relative">
                                <img src="{{ $imgUrl }}"
                                    onerror="this.onerror=null; this.src='{{ $defaultSvg }}';"
                                    alt="{{ $book->book_name }}" class="w-full h-full object-cover">

                                <span
                                    class="absolute top-3 right-3 px-2.5 py-1 text-[10px] font-bold rounded-full {{ $book->available_quantity > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $book->available_quantity > 0 ? 'Còn ' . $book->available_quantity . ' cuốn' : 'Hết sách' }}
                                </span>
                            </div>

                            <div class="p-4 space-y-2">
                                <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">
                                    {{ $book->category->category_name ?? 'Khác' }}
                                </span>
                                <h3 class="font-bold text-slate-800 text-xs line-clamp-2 hover:text-blue-600">
                                    <a
                                        href="{{ route('client.books.show', $book->slug ?? $book->book_id) }}">{{ $book->book_name }}</a>
                                </h3>
                                <p class="text-[11px] text-slate-500"><i
                                        class="fa-regular fa-user mr-1"></i>{{ $book->author }}</p>
                            </div>
                        </div>

                        <div class="p-4 pt-0">
                            <a href="{{ route('client.books.show', $book->slug ?? $book->book_id) }}"
                                class="block text-center w-full py-2 bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 text-xs font-semibold rounded-xl transition">
                                Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $books->links('components.custom-pagination') }}
            </div>
        @endif
    </div>
@endsection
