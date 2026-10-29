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

        <!-- SECTION 2: THÔNG BÁO & THÔNG TIN TÀI KHOẢN (BỐ CỤC GRID 2 CỘT) -->
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
