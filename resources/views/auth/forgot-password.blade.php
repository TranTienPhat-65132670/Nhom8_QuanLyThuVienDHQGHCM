@extends('layout.auth')

@section('title', 'Đặt Lại Mật Khẩu')

@section('content')
    <div
        class="relative min-h-screen flex justify-center items-center w-full overflow-hidden bg-linear-to-br from-teal-50 via-teal-100/70 to-emerald-200/60">

        {{-- background blur --}}
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute top-1/4 left-1/3 w-96 h-96 bg-white/80 rounded-full blur-3xl opacity-70"></div>
            <div class="absolute bottom-10 right-10 w-125 h-125 bg-emerald-300/50 rounded-full blur-3xl opacity-60">
            </div>
        </div>

        {{-- content --}}
        <div class="relative z-10 p-8 w-full max-w-md">

            {{-- Tiêu đề --}}
            <div class="text-center mb-8">
                <div
                    class="flex mx-auto items-center justify-center w-20 h-20 rounded-2xl bg-white shadow-lg shadow-teal-600/20 border border-slate-100 overflow-hidden mb-3">
                    <img src="images/icon_web.png" alt="Logo Đại học" class="w-16 h-16 object-contain">
                </div>
                <h1 class="text-3xl font-bold text-slate-900">
                    {{ session('otp_sent') ? 'Xác Nhận OTP' : 'Khôi Phục Mật Khẩu' }}
                </h1>
                <p class="text-base text-teal-700 font-medium tracking-wide uppercase mt-1">
                    {{ session('otp_sent') ? 'Bước 2: Nhập mã xác thực' : 'Bước 1: Nhập thông tin' }}
                </p>
            </div>

            @if (!session('otp_sent'))
                {{-- ========== BƯỚC 1: NHẬP MSSV ============ --}}
                <form action="{{ route('forgot-password') }}" method="POST" class="space-y-5">
                    @csrf
                    <p class="text-sm text-slate-600 text-center mb-4">
                        Nhập mã số sinh viên để nhận mã OTP xác nhận.
                    </p>

                    <div>
                        <label class="block font-semibold text-slate-600 mb-1.5">Mã số sinh viên</label>
                        <input type="text" name="student_code" maxlength="8" value="{{ old('student_code') }}"
                            class="w-full px-4 py-3 bg-white/90 border border-slate-200 rounded-xl text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm"
                            placeholder="Nhập mã số sinh viên" autofocus autocomplete="off">
                        @error('student_code')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full py-3 px-4 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl shadow-lg shadow-teal-600/25 transition duration-200 cursor-pointer">
                        GỬI MÃ OTP
                    </button>
                </form>
            @else
                {{-- ================= BƯỚC 2: NHẬP OTP ================= --}}
                <form action="{{ route('verify-otp') }}" method="POST" class="space-y-5">
                    @csrf
                    <p class="text-sm text-slate-600 text-center mb-4">
                        Mã OTP đã được gửi tới hệ thống của MSSV:
                        <strong class="text-teal-700">
                            {{ session('student_code') }}
                        </strong>
                    </p>

                    <div>
                        <label class="block font-semibold text-slate-600 mb-1.5">Mã OTP xác nhận</label>
                        <input type="text" name="otp_code"
                            class="w-full px-4 py-3 bg-white/90 border border-slate-200 rounded-xl text-slate-800 text-center tracking-widest text-lg placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm"
                            placeholder="------" autofocus>
                        @error('otp_code')
                            <div class="text-xs mt-1 text-red-500 font-bold">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full py-3 px-4 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl shadow-lg shadow-teal-600/25 transition duration-200 cursor-pointer">
                        XÁC NHẬN & ĐỔI MẬT KHẨU
                    </button>

                    <div class="flex justify-between items-center text-xs mt-4">
                        <a href="{{ route('showForgotPasswordForm') }}"
                            class="text-teal-800 hover:underline font-semibold cursor-pointer">
                            <i class="fa-solid fa-arrow-left"></i> Nhập lại MSSV
                        </a>
                    </div>
                </form>
            @endif

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
