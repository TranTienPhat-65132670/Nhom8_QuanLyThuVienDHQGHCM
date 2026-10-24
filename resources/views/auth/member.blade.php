@extends('layout.client')

@section('title', 'Cổng Thông Tin Độc Giả')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-8">

        <!-- SECTION 1: SLIDESHOW BANNER -->
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

        <!-- SECTION 2: FORM TÌM KIẾM SÁCH (OPAC) -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                <h2
                    class="text-sm sm:text-base font-extrabold text-slate-800 uppercase flex items-center gap-2 tracking-wide">
                    <i class="fa-solid fa-magnifying-glass text-teal-600"></i> Tra Cứu Tài Liệu Thư Viện
                </h2>
                <span
                    class="text-[11px] font-semibold text-teal-700 bg-teal-50 px-2.5 py-1 rounded-lg border border-teal-100">
                    Cổng OPAC
                </span>
            </div>

            <form action="#" method="GET" class="flex flex-col md:flex-row items-center gap-3">
                <!-- Chọn trường thông tin tra cứu -->
                <div class="w-full md:w-56 shrink-0">
                    <select name="search_by"
                        class="w-full bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-700 font-semibold rounded-xl px-3.5 py-3 focus:outline-none focus:border-teal-600 focus:bg-white transition cursor-pointer">
                        <option value="all">Tất cả thông tin</option>
                        <option value="title">Tên cuốn sách</option>
                        <option value="author">Tác giả</option>
                        <option value="isbn">Mã sách / ISBN</option>
                        <option value="publisher">Nhà xuất bản</option>
                    </select>
                </div>

                <!-- Thanh nhập từ khóa chính -->
                <div class="relative flex-1 w-full">
                    <i class="fa-solid fa-keyboard absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" name="keyword" placeholder="Nhập tên sách, tên tác giả, chủ đề hoặc mã số ISBN..."
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-teal-600 focus:bg-white transition shadow-xs">
                </div>

                <!-- Nút Tìm kiếm -->
                <button type="submit"
                    class="w-full md:w-auto px-7 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl text-xs uppercase tracking-wider transition shadow-md hover:shadow-lg cursor-pointer flex items-center justify-center gap-2 shrink-0">
                    <i class="fa-solid fa-search"></i>
                    <span>Tìm Kiếm</span>
                </button>
            </form>
        </div>

        <!-- SECTION 3: LỐI VÀO NHANH DỊCH VỤ ĐỘC GIẢ -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="#"
                class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs hover:shadow-md hover:border-teal-500 transition group flex flex-col items-center text-center">
                <div
                    class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl font-bold mb-2 group-hover:bg-teal-600 group-hover:text-white transition">
                    <i class="fa-solid fa-book-bookmark"></i>
                </div>
                <span class="font-bold text-slate-800 text-xs group-hover:text-teal-600 transition">Sách Đang Mượn</span>
                <span class="text-[10px] text-slate-400 mt-0.5">Gia hạn & Quản lý</span>
            </a>

            <a href="#"
                class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs hover:shadow-md hover:border-teal-500 transition group flex flex-col items-center text-center">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold mb-2 group-hover:bg-emerald-600 group-hover:text-white transition">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <span class="font-bold text-slate-800 text-xs group-hover:text-emerald-600 transition">Lịch Sử Mượn</span>
                <span class="text-[10px] text-slate-400 mt-0.5">Nhật ký giao dịch</span>
            </a>

            <a href="#"
                class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs hover:shadow-md hover:border-teal-500 transition group flex flex-col items-center text-center">
                <div
                    class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl font-bold mb-2 group-hover:bg-cyan-600 group-hover:text-white transition">
                    <i class="fa-solid fa-laptop-code"></i>
                </div>
                <span class="font-bold text-slate-800 text-xs group-hover:text-cyan-600 transition">Học Liệu Số</span>
                <span class="text-[10px] text-slate-400 mt-0.5">Luận văn & CSDL</span>
            </a>

            <a href="#"
                class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs hover:shadow-md hover:border-teal-500 transition group flex flex-col items-center text-center">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold mb-2 group-hover:bg-amber-600 group-hover:text-white transition">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <span class="font-bold text-slate-800 text-xs group-hover:text-amber-600 transition">Thẻ Thư Viện Số</span>
                <span class="text-[10px] text-slate-400 mt-0.5">Mã QR quẹt thẻ</span>
            </a>
        </div>

        <!-- SECTION 4: THÔNG BÁO & THÔNG TIN TÀI KHOẢN (BỐ CỤC GRID 2 CỘT) -->
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
                    <p>• Thứ 2 - Thứ 6: 07:30 - 20:30</p>
                    <p>• Thứ 7: 08:00 - 17:00</p>
                </div>
            </div>

        </div>

    </div>
@endsection

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
