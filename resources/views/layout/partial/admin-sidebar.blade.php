<!-- Sidebar ĐHQG-HCM -->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-300 flex flex-col border-r border-slate-800 transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out">
    <!-- Brand / Logo VNU-HCM -->
    <div class="h-20 flex items-center justify-between px-5 bg-slate-950/60 border-b border-slate-800">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center overflow-hidden shadow-md bg-white p-1">
                <img src="images/icon_web.png" alt="logo" class="w-full h-full object-contain">
            </div>
            <div class="flex flex-col">
                <span class="font-extrabold text-sm text-white uppercase">Đại Học Hồ Chí
                    Minh</span>
                <span class="text-[11px] text-slate-400 font-medium tracking-wider">Hệ Thống Thư Viện</span>
            </div>
        </div>
        <!-- Nút đóng sidebar trên mobile -->
        <button onclick="toggleSidebar()" class="md:hidden text-slate-400 hover:text-white p-1">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <!-- Menu Items -->
    <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">
        <div class="px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-500">Tổng Quan</div>

        <a href="#"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold bg-blue-600 text-white shadow-lg shadow-blue-600/30">
            <i class="fa-solid fa-chart-pie text-base w-5 text-center"></i>
            <span>Dashboard</span>
        </a>

        <div class="pt-5 px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-500">Nghiệp Vụ Thư Viện
        </div>

        <a href="#"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition hover:bg-slate-800 hover:text-white text-slate-300">
            <i class="fa-solid fa-book-bookmark text-base w-5 text-center"></i>
            <span>Quản Lý Học Liệu & Sách</span>
        </a>

        <a href="#"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition hover:bg-slate-800 hover:text-white text-slate-300">
            <i class="fa-solid fa-arrows-rotate text-base w-5 text-center"></i>
            <span>Mượn / Trả Sách</span>
        </a>

        <a href="#"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition hover:bg-slate-800 hover:text-white text-slate-300">
            <i class="fa-solid fa-user-graduate text-base w-5 text-center"></i>
            <span>Sinh Viên & Độc Giả</span>
        </a>

        <div class="pt-5 px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-500">Hệ Thống</div>

        <a href="#"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition hover:bg-slate-800 hover:text-white text-slate-300">
            <i class="fa-solid fa-chart-line text-base w-5 text-center"></i>
            <span>Báo Cáo Thống Kê</span>
        </a>

        <!-- Quản Lý Danh Mục -->
        <a href="{{ route('categories.index') }}"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition hover:bg-slate-800 hover:text-white {{ request()->routeIs('categories.*') ? 'bg-blue-600 text-white' : 'text-slate-300' }}">
            <i class="fa-solid fa-layer-group text-base w-5 text-center"></i>
            <span>Quản Lý Danh Mục</span>
        </a>
        <!-- Quản Lý Sách -->
        <a href="{{ route('books.index') }}"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition hover:bg-slate-800 hover:text-white {{ request()->routeIs('books.*') ? 'bg-blue-600 text-white' : 'text-slate-300' }}">
            <i class="fa-solid fa-book-bookmark text-base w-5 text-center"></i>
            <span>Quản Lý Học Liệu & Sách</span>
        </a>
        <a href="{{ route('client.books.index') }}" target="_blank" 
            class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>Xem trang Độc giả</span>
        </a>
    </nav>

    <!-- Footer Sidebar -->
    <div class="p-4 bg-slate-950 border-t border-slate-800 text-xs text-slate-500 text-center">
        &copy; 2026 VNU-HCM Library
    </div>
</aside>

<!-- Overlay nền mờ khi mở sidebar trên mobile -->
<div id="sidebar-overlay" onclick="toggleSidebar()"
    class="fixed inset-0 bg-slate-900/50 z-30 hidden md:hidden transition-opacity"></div>
