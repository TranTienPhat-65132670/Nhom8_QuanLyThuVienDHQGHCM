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
            <div class="relative group">
                <button type="button" onclick="scrollBookSlider(-1)" 
                        class="absolute -left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-white/90 hover:bg-white text-slate-700 hover:text-blue-600 rounded-full shadow-md border border-slate-200 flex items-center justify-center transition cursor-pointer opacity-0 group-hover:opacity-100">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <div id="bookSlider" 
                     class="flex gap-4 overflow-x-auto scroll-smooth no-scrollbar py-2 px-1 cursor-grab active:cursor-grabbing select-none">
                    @foreach($latestBooks as $book)
                        <div class="w-44 md:w-52 flex-none bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-md transition flex flex-col justify-between group/card">
                            <div>
                                <div class="h-48 bg-slate-100 relative overflow-hidden">
                                    @php
                                        $defaultSvg = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='500' viewBox='0 0 400 500'><rect width='100%' height='100%' fill='%23f1f5f9'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-size='16' font-weight='bold' fill='%2394a3b8'>Chưa Có Ảnh Bìa</text></svg>";
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
                                    <img src="{{ $imgUrl }}" 
                                         onerror="this.onerror=null; this.src='{{ $defaultSvg }}';" 
                                         alt="{{ $book->book_name }}" 
                                         draggable="false"
                                         class="w-full h-full object-cover group-hover/card:scale-105 transition duration-300">
                                    
                                    <span class="absolute top-2 right-2 px-2 py-0.5 text-[9px] font-bold rounded-full {{ $book->available_quantity > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                        {{ $book->available_quantity > 0 ? 'Còn ' . $book->available_quantity : 'Hết' }}
                                    </span>
                                </div>

                                <div class="p-3 space-y-1.5">
                                    <span class="text-[9px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">
                                        {{ $book->category->category_name ?? 'Khác' }}
                                    </span>
                                    <h3 class="font-bold text-slate-800 text-xs line-clamp-2 leading-snug group-hover/card:text-blue-600 transition">
                                        <a href="{{ route('client.books.show', $book->slug ?? $book->book_id) }}" draggable="false">{{ $book->book_name }}</a>
                                    </h3>
                                    <p class="text-[10px] text-slate-500 truncate"><i class="fa-regular fa-user mr-1"></i>{{ $book->author }}</p>
                                </div>
                            </div>

                            <div class="p-3 pt-0">
                                <a href="{{ route('client.books.show', $book->slug ?? $book->book_id) }}" 
                                   draggable="false"
                                   class="block text-center w-full py-1.5 bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 text-[11px] font-semibold rounded-lg transition">
                                    Chi tiết
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" onclick="scrollBookSlider(1)" 
                        class="absolute -right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-white/90 hover:bg-white text-slate-700 hover:text-blue-600 rounded-full shadow-md border border-slate-200 flex items-center justify-center transition cursor-pointer opacity-0 group-hover:opacity-100">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        @endif
    </div>

</div>

<script>
    function scrollBookSlider(direction) {
        const slider = document.getElementById('bookSlider');
        if (!slider) return;
        const scrollAmount = 320;
        slider.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const slider = document.getElementById('bookSlider');
        if (!slider) return;

        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });

        slider.addEventListener('mouseleave', () => { isDown = false; });
        slider.addEventListener('mouseup', () => { isDown = false; });

        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
        });
    });
</script>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection