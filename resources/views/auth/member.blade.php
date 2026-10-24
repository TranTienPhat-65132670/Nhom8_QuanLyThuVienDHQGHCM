@extends('layout.client')

@section('title', 'Trang Chủ - Thư Viện ĐHQGHCM')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-10">

    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-xs relative overflow-hidden">
        <div class="relative z-10 space-y-3 max-w-2xl">
            <span class="px-3 py-1 bg-white/20 text-white text-[11px] font-semibold rounded-full backdrop-blur-md">
                Chào mừng bạn đến với Thư viện
            </span>
            <h1 class="text-2xl md:text-3xl font-extrabold leading-tight">
                Tra Cứu & Khám Phá Hàng Ngàn Đầu Sách Học Liệu
            </h1>
            <p class="text-blue-100 text-xs md:text-sm">
                Tìm kiếm giáo trình, tài liệu tham khảo chuyên ngành dễ dàng và nhanh chóng.
            </p>
            <div class="pt-2">
                <a href="{{ route('client.books.index') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-blue-700 hover:bg-blue-50 text-xs font-bold rounded-xl transition shadow-xs">
                    <i class="fa-solid fa-magnifying-glass"></i> Tra Cứu Sách Ngay
                </a>
            </div>
        </div>
    </div>

    <!-- Khối Sách Mới Về Thư Viện -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-fire text-rose-500"></i> Sách Mới Về Thư Viện
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Những ấn phẩm học liệu vừa được bổ sung vào kho</p>
            </div>
            <a href="{{ route('client.books.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition flex items-center gap-1">
                Xem tất cả <i class="fa-solid fa-angle-right text-[10px]"></i>
            </a>
        </div>

        @if(!isset($latestBooks) || $latestBooks->isEmpty())
            <div class="text-center py-10 bg-white rounded-2xl border border-slate-200 text-xs text-slate-400">
                Chưa có sách mới nào được thêm gần đây.
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($latestBooks as $book)
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-md transition flex flex-col justify-between group">
                        <div>
                            <!-- Bìa sách -->
                            <div class="h-44 bg-slate-100 relative overflow-hidden">
                                <img src="{{ $book->book_image ? asset('storage/' . $book->book_image) : asset('images/default-book.png') }}" 
                                     alt="{{ $book->book_name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                
                                <span class="absolute top-2 right-2 px-2 py-0.5 text-[9px] font-bold rounded-full {{ $book->available_quantity > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $book->available_quantity > 0 ? 'Còn ' . $book->available_quantity : 'Hết' }}
                                </span>
                            </div>

                            <!-- Thông tin -->
                            <div class="p-3 space-y-1.5">
                                <span class="text-[9px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">
                                    {{ $book->category->category_name ?? 'Khác' }}
                                </span>
                                <h3 class="font-bold text-slate-800 text-xs line-clamp-2 leading-snug group-hover:text-blue-600 transition">
                                    <a href="{{ route('client.books.show', $book->slug) }}">{{ $book->book_name }}</a>
                                </h3>
                                <p class="text-[10px] text-slate-500 truncate"><i class="fa-regular fa-user mr-1"></i>{{ $book->author }}</p>
                            </div>
                        </div>

                        <div class="p-3 pt-0">
                            <a href="{{ route('client.books.show', $book->slug) }}" 
                               class="block text-center w-full py-1.5 bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 text-[11px] font-semibold rounded-lg transition">
                                Chi tiết
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection