<!-- Top Bar thông tin VNULIB -->
<div class="bg-teal-900 text-teal-100 text-[11px] py-1.5 px-4 border-b border-teal-800 hidden sm:block">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center gap-4">
            <span><i class="fa-solid fa-phone mr-1.5 text-teal-400"></i> (028) 37242181</span>
            <span><i class="fa-solid fa-envelope mr-1.5 text-teal-400"></i> support.library@vnuhcm.edu.vn</span>
            <span class="hidden md:inline"><i class="fa-solid fa-clock mr-1.5 text-teal-400"></i> Thứ 2 - Thứ 7: 07:30 -
                20:30</span>
        </div>
    </div>
</div>

<!-- Header chính -->
<header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">

        <!-- Logo & Thương hiệu -->
        <a href="{{ route('client_index') }}" class="flex items-center gap-3 group">
            <div
                class="w-10 h-10 rounded-xl bg-white p-1 shadow-md border border-slate-100 flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                <img src="{{ asset('images/icon_web.png') }}" alt="Logo ĐHQG-HCM" class="w-full h-full object-contain">
            </div>
            <div class="flex flex-col">
                <span
                    class="font-black text-slate-900 text-base leading-tight tracking-tight uppercase group-hover:text-teal-700 transition">
                    Thư Viện ĐHQG-HCM
                </span>
                <span class="text-[11px] text-teal-700 font-semibold tracking-wider uppercase">
                    Cổng Thông Tin Độc Giả
                </span>
            </div>
        </a>

        <!-- Navigation Desktop -->
        <nav class="hidden lg:flex items-center gap-6 text-xs font-bold text-slate-600 uppercase tracking-wider">
            <a href="{{ route('client_index') }}"
                class="hover:text-teal-600 transition text-teal-700 flex items-center gap-1.5">
                <i class="fa-solid fa-house text-sm"></i> Trang Chủ
            </a>
            <a href="{{ route('client.books.index') }}" 
            class="{{ request()->routeIs('client.books.*') ? 'text-blue-600 font-bold' : 'text-slate-600' }} hover:text-blue-600 transition">
                Tra Cứu Sách
            </a>
            <a href="#" class="hover:text-teal-600 transition flex items-center gap-1.5">
                <i class="fa-solid fa-book-bookmark text-sm"></i> Dịch Vụ Mượn Trả
            </a>
            <a href="#" class="hover:text-teal-600 transition flex items-center gap-1.5">
                <i class="fa-solid fa-scale-balanced text-sm"></i> Nội Qui
            </a>
            <a href="#" class="hover:text-teal-600 transition flex items-center gap-1.5">
                <i class="fa-solid fa-circle-info text-sm"></i> Hướng Dẫn
            </a>
        </nav>

        <!-- Khu vực Tài Khoản & Mobile Menu Button -->
        <div class="flex items-center gap-3">
            @if ($currentUser)
                <!-- TRẠNG THÁI: ĐÃ ĐĂNG NHẬP -->
                <div class="hidden sm:flex items-center gap-3">
                    <div class="flex flex-col text-right">
                        <span class="text-xs font-bold text-slate-800">
                            MSSV: {{ $currentUser->student_code }}
                        </span>
                        <span class="text-[10px] font-semibold text-emerald-600 flex items-center justify-end gap-1">
                            <i class="fa-solid fa-circle text-[6px]"></i>
                            {{ $currentUser->role === 'admin' ? 'Quản Trị Viên' : 'Độc Giả Thư Viện' }}
                        </span>
                    </div>

                    @if ($currentUser->role === 'admin')
                        <a href="{{ route('admin_index') }}"
                            class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold shadow-sm transition flex items-center gap-1.5">
                            <i class="fa-solid fa-user-shield text-amber-400"></i>
                            <span>Trang Admin</span>
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Đăng xuất khỏi hệ thống"
                            class="px-3.5 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-red-200/60 cursor-pointer">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Đăng Xuất</span>
                        </button>
                    </form>
                </div>
            @else
                <!-- TRẠNG THÁI: CHƯA ĐĂNG NHẬP (GUEST) -->
                <a href="{{ route('login') }}"
                    class="hidden sm:flex px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl text-xs uppercase tracking-wider transition shadow-md shadow-teal-600/20 items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-user-lock"></i>
                    <span>Đăng Nhập</span>
                </a>
            @endif

            <!-- Nút Toggle Mobile Menu (Hamburger Icon) -->
            <button onclick="toggleMobileNav()" type="button"
                class="lg:hidden p-2.5 rounded-xl text-slate-700 hover:bg-slate-100 transition focus:outline-none border border-slate-200">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>

    </div>
</header>

<!-- Mobile Navigation Drawer (Sidebar di động) -->
<div id="mobile-nav-drawer"
    class="fixed inset-y-0 right-0 z-50 w-72 bg-white shadow-2xl flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out lg:hidden">

    <!-- Top Mobile Drawer -->
    <div class="p-5 border-b border-slate-200 flex items-center justify-between bg-teal-900 text-white">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/icon_web.png') }}" alt="Logo"
                class="w-7 h-7 object-contain bg-white rounded-md p-0.5">
            <span class="font-bold text-sm uppercase tracking-wide">Menu Thư Viện</span>
        </div>
        <button onclick="toggleMobileNav()" class="text-teal-200 hover:text-white p-1 cursor-pointer">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <!-- Thông tin người dùng trên mobile -->
    <div class="p-4 bg-slate-50 border-b border-slate-200">
        @if ($currentUser)
            <div class="flex items-center justify-between mb-3">
                <div>
                    <div class="text-xs font-bold text-slate-800">MSSV: {{ $currentUser->student_code }}</div>
                    <div class="text-[10px] text-emerald-600 font-semibold">
                        {{ $currentUser->role === 'admin' ? 'Quản Trị Viên' : 'Độc Giả' }}</div>
                </div>
                @if ($currentUser->role === 'admin')
                    <a href="{{ route('admin_index') }}"
                        class="px-3 py-1.5 bg-slate-900 text-white rounded-lg text-xs font-bold">Admin</a>
                @endif
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full py-2 bg-red-100 text-red-600 rounded-lg text-xs font-bold hover:bg-red-200 transition">
                    <i class="fa-solid fa-right-from-bracket mr-1"></i> Đăng Xuất
                </button>
            </form>
        @else
            <a href="{{ route('login') }}"
                class="block w-full text-center py-2.5 bg-teal-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-md">
                <i class="fa-solid fa-user-lock mr-1.5"></i> Đăng Nhập Tài Khoản
            </a>
        @endif
    </div>

    <!-- Các Navigation Links Mobile -->
    <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto text-xs font-bold uppercase tracking-wider text-slate-700">
        <a href="{{ route('client_index') }}"
            class="flex items-center gap-3 p-3 rounded-xl bg-teal-50 text-teal-700 font-black">
            <i class="fa-solid fa-house w-5 text-center text-sm"></i>
            <span>Trang Chủ</span>
        </a>
        <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-100 transition">
            <i class="fa-solid fa-magnifying-glass w-5 text-center text-sm text-teal-600"></i>
            <span>Tra Cứu OPAC</span>
        </a>
        <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-100 transition">
            <i class="fa-solid fa-database w-5 text-center text-sm text-teal-600"></i>
            <span>Cơ Sở Dữ Liệu</span>
        </a>
        <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-100 transition">
            <i class="fa-solid fa-book-bookmark w-5 text-center text-sm text-teal-600"></i>
            <span>Dịch Vụ Mượn Trả</span>
        </a>
        <a href="#" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-100 transition">
            <i class="fa-solid fa-circle-info w-5 text-center text-sm text-teal-600"></i>
            <span>Hướng Dẫn</span>
        </a>
    </nav>

    <!-- Footer Mobile Drawer -->
    <div class="p-4 border-t border-slate-200 text-center text-[10px] text-slate-400">
        Thư Viện ĐHQG-HCM &copy; 2026
    </div>
</div>

<!-- Overlay làm mờ nền khi mở Mobile Drawer -->
<div id="mobile-nav-overlay" onclick="toggleMobileNav()"
    class="fixed inset-0 bg-slate-900/50 z-40 hidden transition-opacity lg:hidden"></div>

<script>
    function toggleMobileNav() {
        const drawer = document.getElementById('mobile-nav-drawer');
        const overlay = document.getElementById('mobile-nav-overlay');

        drawer.classList.toggle('translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>
