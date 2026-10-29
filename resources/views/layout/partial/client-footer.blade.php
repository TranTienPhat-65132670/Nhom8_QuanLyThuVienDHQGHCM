<!-- Footer Client Thư Viện ĐHQG-HCM -->
<footer class="bg-slate-950 text-slate-400 pt-12 pb-8 border-t border-slate-800 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">

            <!-- Cột 1: Thương hiệu -->
            <div class="space-y-3 sm:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white p-1 shadow-md flex items-center justify-center shrink-0">
                        <img src="{{ asset('images/icon_web.png') }}" alt="Logo ĐHQG" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="font-extrabold text-white text-sm uppercase leading-tight">Thư Viện Trung Tâm</h3>
                        <p class="text-[10px] text-teal-400 font-bold uppercase tracking-wider">ĐHQG-HCM</p>
                    </div>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Hệ thống phục vụ nhu cầu học tập, giảng dạy và nghiên cứu khoa học cho toàn thể cán bộ, giảng viên
                    và sinh viên ĐHQG-HCM.
                </p>
            </div>

            <!-- Cột 2: Dịch vụ độc giả -->
            <div>
                <h4
                    class="text-white font-bold text-xs mb-4 uppercase tracking-wider border-l-2 border-teal-500 pl-2.5">
                    Dịch Vụ Độc Giả
                </h4>
                <ul class="space-y-2.5 text-xs font-medium">
                    <li><a href="#" class="hover:text-teal-400 transition flex items-center gap-1.5"><i
                                class="fa-solid fa-angle-right text-[10px] text-teal-500"></i> Tra cứu tài liệu</a>
                    </li>
                    <li><a href="#" class="hover:text-teal-400 transition flex items-center gap-1.5"><i
                                class="fa-solid fa-angle-right text-[10px] text-teal-500"></i> Mượn trả tài liệu</a>
                    </li>
                    <li><a href="#" class="hover:text-teal-400 transition flex items-center gap-1.5"><i
                                class="fa-solid fa-angle-right text-[10px] text-teal-500"></i> Xem thông tin mới</a>
                    </li>
                </ul>
            </div>

            <!-- Cột 3: Project Info -->
            <div>
                <h4
                    class="text-white font-bold text-xs mb-4 uppercase tracking-wider border-l-2 border-teal-500 pl-2.5">
                    Dự Án Thư Viện ĐHQG-HCM Nhóm 8
                </h4>
                <div class="space-y-3 text-xs leading-relaxed">
                    <p class="grid grid-cols-[25px_1fr] items-center">
                        <i class="fa-solid fa-laptop-code text-teal-400 mt-1 shrink-0"></i>
                        <span>Laravel Framework & Tailwind CSS</span>
                    </p>
                    <p class="grid grid-cols-[25px_1fr] items-center">
                        <i class="fa-solid fa-database text-teal-400 shrink-0"></i>
                        <span>Cơ sở dữ liệu MySQL</span>
                    </p>
                    <p class="grid grid-cols-[25px_1fr] items-center">
                        <i class="fa-solid fa-shield-halved text-teal-400 shrink-0"></i>
                        <span>Tích hợp nhiều middleware bảo mật</span>
                    </p>
                </div>
            </div>

            <!-- Cột 4: Liên hệ -->
            <div>
                <h4
                    class="text-white font-bold text-xs mb-4 uppercase tracking-wider border-l-2 border-teal-500 pl-2.5">
                    Thông Tin Liên Hệ
                </h4>
                <div class="space-y-3 text-xs leading-relaxed">
                    <p class="flex items-start gap-2.5">
                        <i class="fa-solid fa-location-dot text-teal-400 mt-1 shrink-0"></i>
                        <span>Đường Võ Trường Toản, Khu đô thị ĐHQG-HCM, Khu phố 9, Phường Linh Xuân, TP.HCM</span>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <i class="fa-solid fa-envelope text-teal-400 shrink-0"></i>
                        <span>cenlib@vnuhcm.edu.vn</span>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <i class="fa-solid fa-phone text-teal-400 shrink-0"></i>
                        <span>0855.066.247</span>
                    </p>
                </div>
            </div>

        </div>

        <!-- Bản quyền -->
        <div
            class="border-t border-slate-900 pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-3">
            <p>&copy; 2026 VNU-HCM Library System. Tất cả quyền được bảo lưu.</p>
            <p class="font-semibold text-slate-400">Phát triển phục vụ đồ án học phần sinh viên ĐHQG-HCM</p>
        </div>

    </div>
</footer>
