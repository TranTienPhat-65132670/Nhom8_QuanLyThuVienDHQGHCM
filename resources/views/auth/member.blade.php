@extends('layout.client')

@section('title', 'Trang Chủ - Thư Viện ĐHQGHCM')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-10">

        <div class="relative w-full bg-slate-900 rounded-2xl overflow-hidden shadow-lg">
            <div class="swiper main-banner-swiper w-full h-56 sm:h-72 md:h-88 lg:h-95">
                <div class="swiper-wrapper">
                    <!-- Slide 1 -->
                    <div class="swiper-slide w-full h-full shrink-0 relative overflow-hidden">
                        <img src="{{ asset('images/slide1.jpg') }}" class="w-full h-full object-cover">
                    </div>
                    <!-- Slide 2 -->
                    <div class="swiper-slide w-full h-full shrink-0 relative overflow-hidden">
                        <img src="{{ asset('images/slide2.jpg') }}" class="w-full h-full object-cover">
                    </div>
                    <!-- Slide 3 -->
                    <div class="swiper-slide w-full h-full shrink-0 relative overflow-hidden">
                        <img src="{{ asset('images/slide3.jpg') }}" class="w-full h-full object-cover">
                    </div>
                </div>
                <!-- Indicator -->
                <div class="swiper-pagination"></div>
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
                <a href="{{ route('client.books.index') }}"
                    class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition flex items-center gap-1">
                    Xem tất cả <i class="fa-solid fa-angle-right text-[10px]"></i>
                </a>
            </div>

            @if (!isset($latestBooks) || $latestBooks->isEmpty())
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
                        @foreach ($latestBooks as $book)
                            <div
                                class="w-44 md:w-52 flex-none bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-md transition flex flex-col justify-between group/card">
                                <div>
                                    <div class="h-48 bg-slate-100 relative overflow-hidden">
                                        @php
                                            $defaultSvg =
                                                "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='500' viewBox='0 0 400 500'><rect width='100%' height='100%' fill='%23f1f5f9'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-size='16' font-weight='bold' fill='%2394a3b8'>Chưa Có Ảnh Bìa</text></svg>";
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
                                            alt="{{ $book->book_name }}" draggable="false"
                                            class="w-full h-full object-cover group-hover/card:scale-105 transition duration-300">

                                        <span
                                            class="absolute top-2 right-2 px-2 py-0.5 text-[9px] font-bold rounded-full {{ $book->available_quantity > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                            {{ $book->available_quantity > 0 ? 'Còn ' . $book->available_quantity : 'Hết' }}
                                        </span>
                                    </div>

                                    <div class="p-3 space-y-1.5">
                                        <span class="text-[9px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">
                                            {{ $book->category->category_name ?? 'Khác' }}
                                        </span>
                                        <h3
                                            class="font-bold text-slate-800 text-xs line-clamp-2 leading-snug group-hover/card:text-blue-600 transition">
                                            <a href="{{ route('client.books.show', $book->slug ?? $book->book_id) }}"
                                                draggable="false">{{ $book->book_name }}</a>
                                        </h3>
                                        <p class="text-[10px] text-slate-500 truncate"><i
                                                class="fa-regular fa-user mr-1"></i>{{ $book->author }}</p>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Cột Trái (2 phần): Thông báo thư viện -->
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-900 text-sm uppercase flex items-center gap-2">
                        <i class="fa-solid fa-bullhorn text-teal-600"></i> Thông Báo Thư Viện Mới Nhất
                    </h3>
                    <a href="#" class="text-xs font-bold text-teal-600 hover:underline">Xem tất cả</a>
                </div>

                <div class="space-y-3">
                    <div
                        class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100 flex items-start gap-3 hover:bg-teal-50/30 transition">
                        <span
                            class="px-2.5 py-1 bg-teal-100 text-teal-800 font-bold text-[10px] rounded-lg shrink-0 mt-0.5">
                            27/10
                        </span>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800 hover:text-teal-600 cursor-pointer transition">
                                Thông báo dịch vụ mượn sách liên thư viện giữa các trường thành viên ĐHQG-HCM
                            </h4>
                            <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">
                                Nhằm hỗ trợ tối đa cho sinh viên trong quá trình thực hiện đồ án tốt nghiệp...
                            </p>
                        </div>
                    </div>

                    <div
                        class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100 flex items-start gap-3 hover:bg-teal-50/30 transition">
                        <span
                            class="px-2.5 py-1 bg-emerald-100 text-emerald-800 font-bold text-[10px] rounded-lg shrink-0 mt-0.5">
                            15/10
                        </span>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800 hover:text-teal-600 cursor-pointer transition">
                                Mở rộng thời gian phục vụ phòng đọc tự học phục vụ kỳ thi giữa học kỳ
                            </h4>
                            <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">
                                Thư viện Trung tâm thông báo điều chỉnh thời gian phục vụ từ 07:00 đến 21:30 hàng ngày...
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột Phải (1 phần): Trạng thái tài khoản độc giả / Giờ mở cửa -->
            <div
                class="bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800 text-white p-6 rounded-2xl shadow-lg flex flex-col justify-between">
                <div>
                    <h3
                        class="font-bold text-sm uppercase tracking-wider mb-4 flex items-center gap-2 border-b border-slate-800 pb-3">
                        <i class="fa-solid fa-user-check text-teal-400"></i> Thông Tin Độc Giả
                    </h3>

                    @if (isset($currentUser) && $currentUser)
                        <div class="space-y-3 text-xs text-slate-300">
                            <div class="flex justify-between py-1.5 border-b border-slate-800/80">
                                <span class="text-slate-400">Mã sinh viên:</span>
                                <strong class="text-white font-mono">{{ $currentUser->student_code }}</strong>
                            </div>
                            <div class="flex justify-between py-1.5 border-b border-slate-800/80">
                                <span class="text-slate-400">Quyền hạn:</span>
                                <span
                                    class="px-2 py-0.5 bg-teal-500/20 text-teal-300 font-bold rounded text-[10px] uppercase">
                                    {{ $currentUser->role }}
                                </span>
                            </div>
                            <div class="flex justify-between py-1.5 border-b border-slate-800/80">
                                <span class="text-slate-400">Trạng thái thẻ:</span>
                                <span class="text-emerald-400 font-bold"><i class="fa-solid fa-circle text-[8px] mr-1"></i>
                                    Hoạt động</span>
                            </div>
                            <div class="flex justify-between py-1.5">
                                <span class="text-slate-400">Sách đang giữ:</span>
                                <span class="text-amber-400 font-bold">0 quyển</span>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4 text-slate-400">
                            <i class="fa-solid fa-user-lock text-3xl mb-2 text-slate-600 block"></i>
                            <p class="text-xs mb-3">Bạn đang truy cập dưới quyền Khách.</p>
                            <a href="{{ route('login') }}"
                                class="inline-block px-4 py-2 bg-teal-600 hover:bg-teal-500 text-white font-bold text-xs rounded-xl transition shadow-md">
                                Đăng Nhập Hệ Thống
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Thông tin giờ phục vụ -->
                <div class="mt-6 pt-4 border-t border-slate-800 text-[11px] text-slate-400 space-y-1">
                    <p class="font-bold text-slate-300 uppercase tracking-wider mb-1"><i
                            class="fa-solid fa-clock text-teal-400 mr-1"></i> Giờ Phục Vụ</p>
                    <p>• Thứ 2 - Thứ 7: 08:00 - 18:00</p>
                </div>
            </div>

        </div>
    </div>

    <script>
        function scrollBookSlider(direction) {
            const slider = document.getElementById('bookSlider');
            if (!slider) return;
            const scrollAmount = 320;
            slider.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
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

            slider.addEventListener('mouseleave', () => {
                isDown = false;
            });
            slider.addEventListener('mouseup', () => {
                isDown = false;
            });

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
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    @push('scripts')
        <script>
            const swiper = new Swiper('.main-banner-swiper', {
                loop: true,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                },
                speed: 800,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
        </script>
    @endpush
@endsection
