@extends('layout.auth')

@section('title', 'Đăng Nhập')

@section('content')
    <div
        class="relative min-h-screen flex justify-center p w-full overflow-hidden bg-linear-to-br from-teal-50 via-teal-100/70 to-emerald-200/60">
        {{-- background --}}
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute top-1/4 left-1/3 w-96 h-96 bg-white/80 rounded-full blur-3xl opacity-70"></div>
            <div class="absolute bottom-10 right-10 w-125 h-125 bg-emerald-300/50 rounded-full blur-3xl opacity-60">
            </div>
            <div class="absolute bottom-5 left-10 w-100 h-100 bg-teal-200/60 rounded-full blur-3xl opacity-60"></div>
        </div>

        {{-- content --}}
        <div class="relative z-10 p-8 w-full max-w-md">
            {{-- title --}}
            <div class="text-center mb-8">
                <div
                    class="flex mx-auto items-center justify-center w-20 h-20 rounded-2xl bg-white shadow-lg shadow-teal-600/20 border border-slate-100 overflow-hidden mb-3">
                    <img src="images/icon_web.png" alt="Logo Đại học" class="w-16 h-16 object-contain">
                </div>
                <h1 class="text-3xl font-bold text-slate-900">Thư Viện Đại Học Quốc Gia Hồ Chí Minh</h1>
                <p class="text-base text-teal-700 font-medium tracking-wide uppercase mt-1">cổng thông tin mượn trả tài
                    liệu</p>
            </div>

            {{-- form đăng nhập --}}
            <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                @csrf

                {{-- MSSV --}}
                <div>
                    <label class="block font-semibold text-slate-600 mb-1.5">
                        Mã số sinh viên
                    </label>
                    <div class="relative">
                        <input type="text" name="student_code" maxlength="13" value="{{ old('student_code') }}"
                            class="w-full px-4 py-3 bg-white/90 border border-slate-200 rounded-xl text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition shadow-sm"
                            placeholder="Nhập mã số sinh viên"
                            {{ !$errors->any() && !session('error') ? 'autofocus' : '' }}>
                    </div>
                    @error('student_code')
                        <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mật khẩu -->
                <div>
                    <label class="block font-semibold text-slate-600 mb-1.5">
                        Mật khẩu
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 pr-10 bg-white/90 border border-slate-200 rounded-xl text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 transition shadow-sm"
                            placeholder="••••••••" {{ $errors->any() || session('error') ? 'autofocus' : '' }}>
                        <button type="button" onclick="togglePassword('password', 'eye-icon')"
                            class="absolute hover:text-teal-600 cursor-pointer right-0 inset-y-0 pr-3.5 flex items-center">
                            <i id="eye-icon" class="fa-solid fa-eye text-base"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Quên mật khẩu -->
                <div class="flex items-center justify-end">
                    <a href="{{ route('password.forgot') }}"
                        class="text-xs font-medium cursor-pointer text-teal-800 hover:text-teal-700 hover:underline transition">
                        Quên mật khẩu?
                    </a>
                </div>

                <button type="submit"
                    class="w-full py-3 px-4 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl shadow-lg shadow-teal-600/25 transition duration-200 cursor-pointer">
                    ĐĂNG NHẬP
                </button>
                <button type="submit"
                    onclick="document.querySelector('input[name=\'student_code\']').value = '1500012345678'; document.querySelector('input[name=\'password\']').value = '12345678A'; this.form.submit();"
                    class="w-full py-3 px-4 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl shadow-lg shadow-teal-600/25 transition duration-200 cursor-pointer">
                    ĐĂNG NHẬP NHANH
                </button>
            </form>
        </div>

    </div>
@endsection
