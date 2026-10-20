<header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">

        <!-- Logo -->
        <a href="{{ route('client_index') }}" class="font-extrabold text-slate-900">Thư Viện ĐHQG-HCM</a>

        <!-- Khu vực tài khoản -->
        <div class="flex items-center gap-3">
            @if ($currentUser)
                <!-- TRẠNG THÁI: ĐÃ ĐĂNG NHẬP -->
                <div class="flex items-center gap-3">
                    <span class="text-sm font-semibold text-slate-700">
                        MSSV: {{ $currentUser->student_code }}
                    </span>

                    @if ($currentUser->role === 'admin')
                        <a class="px-3 py-2 bg-slate-900 text-white rounded-xl text-xs font-semibold">
                            Admin Dashboard
                        </a>
                    @else
                        <a class="px-3 py-2 bg-blue-600 text-white rounded-xl text-xs font-semibold">
                            Trang Thành Viên
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-3 py-2 bg-red-50 text-red-600 rounded-xl text-xs font-semibold hover:bg-red-100 transition">
                            Đăng xuất
                        </button>
                    </form>
                </div>
            @else
                <!-- TRẠNG THÁI: CHƯA ĐĂNG NHẬP (KHÁCH) -->
                <div>
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                        Đăng Nhập
                    </a>
                </div>
            @endif
        </div>

    </div>
</header>
