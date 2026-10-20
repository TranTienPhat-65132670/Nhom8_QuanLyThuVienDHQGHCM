@extends('layout.auth')

@section('title', 'Đặt Lại Mật Khẩu')

@section('content')
    <div
        class="relative min-h-screen flex justify-center items-center w-full overflow-hidden bg-linear-to-br from-teal-50 via-teal-100/70 to-emerald-200/60">

        {{-- Background blur effect --}}
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute top-1/4 left-1/3 w-96 h-96 bg-white/80 rounded-full blur-3xl opacity-70"></div>
            <div class="absolute bottom-10 right-10 w-125 h-125 bg-emerald-300/50 rounded-full blur-3xl opacity-60">
            </div>
        </div>

        {{-- Main Form Container --}}
        <div class="relative z-10 p-8 w-full max-w-md">

            {{-- Tiêu đề --}}
            <div class="text-center mb-8">
                <div
                    class="flex mx-auto items-center justify-center w-20 h-20 rounded-2xl bg-white shadow-lg shadow-teal-600/20 border border-slate-100 overflow-hidden mb-3">
                    <img src="images/icon_web.png" alt="Logo Đại học" class="w-16 h-16 object-contain">
                </div>
                <h1 class="text-3xl font-bold text-slate-900">Tạo Mật Khẩu Mới</h1>
                <p class="text-base text-teal-700 font-medium tracking-wide uppercase mt-1">
                    Bước 3: Đặt lại mật khẩu
                </p>
            </div>

            {{-- Form Đặt Lại Mật Khẩu --}}
            <form action="{{ route('reset-password') }}" method="POST" class="space-y-5">
                @csrf

                <p class="text-sm text-slate-600 text-center mb-4">
                    Tài khoản: <strong class="text-teal-700">{{ session('student_code') }}</strong><br>
                    Vui lòng tạo mật khẩu mới an toàn cho tài khoản của bạn.
                </p>

                {{-- Mật khẩu mới --}}
                <div>
                    <label class="block font-semibold text-slate-600 mb-1.5">Mật khẩu mới</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-3 bg-white/90 border border-slate-200 rounded-xl text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm pr-10"
                            placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)" autocomplete="off" autofocus>
                        <button type="button" onclick="togglePassword('password', 'eyeIcon1')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-teal-600 cursor-pointer">
                            <i class="fa-solid fa-eye" id="eyeIcon1"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Xác nhận mật khẩu mới --}}
                <div>
                    <label class="block font-semibold text-slate-600 mb-1.5">Xác nhận mật khẩu mới</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-3 bg-white/90 border border-slate-200 rounded-xl text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm pr-10"
                            placeholder="Nhập lại mật khẩu mới" autocomplete="off">
                        <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-teal-600 cursor-pointer">
                            <i class="fa-solid fa-eye" id="eyeIcon2"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nút Submit --}}
                <button type="submit"
                    class="w-full py-3 px-4 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl shadow-lg shadow-teal-600/25 transition duration-200 cursor-pointer">
                    ĐỔI MẬT KHẨU
                </button>
            </form>

            {{-- Quay lại đăng nhập --}}
            <div class="text-center mt-6">
                <a href="{{ route('cancel-reset') }}"
                    class="text-xs font-semibold text-teal-800 hover:text-teal-700 hover:underline transition inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại đăng nhập
                </a>
            </div>

        </div>
    </div>
@endsection
