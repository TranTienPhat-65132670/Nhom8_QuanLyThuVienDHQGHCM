<!-- Header / Topbar -->
<header
    class="h-20 bg-white border-b border-slate-200 px-6 md:px-3 flex items-center justify-between sticky top-0 z-20 shadow-xs">
    <div class="flex items-center gap-4">
        <!-- Nút Toggle Sidebar -->
        <button onclick="toggleSidebar()"
            class="p-2.5 rounded-xl text-slate-600 hover:bg-slate-100 transition focus:outline-none">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>

        <div>
            <h1 class="text-base md:text-lg font-bold text-slate-800">@yield('title', 'Cổng Quản Trị Thư Viện ĐHQG-HCM')</h1>
            <p class="text-xs text-slate-500 hidden sm:block">Đại học Quốc gia Thành phố Hồ Chí Minh</p>
        </div>
    </div>

    <!-- Right Profile Info -->
    <div class="flex items-center gap-4 md:gap-5">
        <div class="flex items-center gap-3 pl-3 md:pl-4 border-l border-slate-200">
            <div
                class="w-9 h-9 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-sm shadow-md">
                AD
            </div>
            <div class="text-left hidden sm:block">
                <div class="text-sm font-bold text-slate-800">Quản Trị Viên</div>
                <div class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md inline-block">
                    {{ strtoupper(session('role', 'ADMIN')) }}
                </div>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="p-2.5 rounded-xl text-slate-500 hover:text-red-600 hover:bg-red-50 transition border border-slate-200 hover:border-red-200"
                title="Đăng xuất">
                <i class="fa-solid fa-right-from-bracket text-base"></i>
            </button>
        </form>
    </div>
</header>
