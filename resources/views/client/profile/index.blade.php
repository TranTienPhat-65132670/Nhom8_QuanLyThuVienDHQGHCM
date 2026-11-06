@extends('layout.client')
@section('title', 'Hồ sơ cá nhân')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <!-- Thông báo Flash Message -->
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-xl shadow-sm flex items-center gap-2 text-sm font-medium">
            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Cột trái: Thẻ thư viện điện tử & Đổi mật khẩu -->
        <div class="space-y-6">
            <!-- Thẻ độc giả ĐHQG-HCM -->
            <div class="bg-gradient-to-br from-teal-800 to-teal-950 text-white p-6 rounded-2xl shadow-lg border border-teal-700">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] font-bold uppercase tracking-wider bg-teal-600/40 border border-teal-400/30 px-3 py-1 rounded-full text-teal-100">
                        Thẻ Độc Giả Điện Tử
                    </span>
                    <i class="fa-solid fa-id-card-clip text-2xl text-teal-300"></i>
                </div>
                <h2 class="text-xl font-black tracking-tight">{{ $user->student_name }}</h2>
                <div class="mt-3 space-y-1 text-xs text-teal-100">
                    <p>Tài khoản đăng nhập: <strong class="text-white">15000{{ $user->student_code }}</strong></p>
                    <p>Mã số sinh viên: <strong class="text-white">{{ $user->student_code }}</strong></p>
                    <p>Email: <strong class="text-white">{{ $user->email }}</strong></p>
                </div>
                <div class="mt-5 pt-4 border-t border-teal-700/60 flex justify-between items-center text-xs">
                    @if($user->status == 1)
                        <span class="flex items-center gap-1.5 text-emerald-300 font-semibold">
                            <i class="fa-solid fa-circle text-[6px]"></i> Thẻ đang hoạt động
                        </span>
                    @else
                        <span class="flex items-center gap-1.5 text-rose-300 font-semibold">
                            <i class="fa-solid fa-circle-xmark text-[12px]"></i> Thẻ tạm khóa
                        </span>
                    @endif
                    <a href="{{ route('client.books.favorites') }}" class="text-teal-200 hover:text-white font-semibold flex items-center gap-1 transition">
                        <i class="fa-solid fa-heart text-rose-400"></i> Tủ sách yêu thích
                    </a>
                </div>
            </div>

            <!-- Form Đổi mật khẩu -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-shield-halved text-teal-600"></i> Đổi mật khẩu bảo mật
                </h3>
                <form action="{{ route('client.profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Mật khẩu hiện tại <span class="text-rose-500">*</span></label>
                        <input type="password" name="current_password" required placeholder="Nhập mật khẩu đang dùng"
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                        @error('current_password')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Mật khẩu mới <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" required placeholder="Ít nhất 8 ký tự, 1 chữ hoa, 1 số"
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                        @error('password')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Xác nhận mật khẩu mới <span class="text-rose-500">*</span></label>
                        <input type="password" name="password_confirmation" required placeholder="Nhập lại mật khẩu mới"
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                    </div>

                    <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 rounded-xl text-xs uppercase tracking-wider transition cursor-pointer">
                        Cập nhật mật khẩu
                    </button>
                </form>
            </div>
        </div>

        <!-- Cột phải: Cập nhật hồ sơ & Theo dõi mượn trả -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Form Cập nhật thông tin cá nhân -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-user-pen text-teal-600"></i> Thông tin Hồ sơ Cá nhân
                </h3>
                <form action="{{ route('client.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Mã số sinh viên (Cố định)</label>
                            <input type="text" value="{{ $user->student_code }}" disabled
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 text-sm cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Họ và tên độc giả <span class="text-rose-500">*</span></label>
                            <input type="text" name="student_name" value="{{ old('student_name', $user->student_name) }}" required
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                            @error('student_name')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Địa chỉ Email (Nhận OTP) <span class="text-rose-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                            @error('email')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Số điện thoại liên hệ</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="09xxxxxxxx (10-11 chữ số)"
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                            @error('phone')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider transition shadow-md shadow-teal-600/20 cursor-pointer">
                            <i class="fa-solid fa-floppy-disk mr-1.5"></i> Lưu thông tin
                        </button>
                    </div>
                </form>
            </div>

            <!-- Cảnh báo phí phạt chưa đóng (nếu có) -->
            @if($unpaidFines->count() > 0)
                <div class="bg-rose-50 border border-rose-200 p-5 rounded-2xl">
                    <h4 class="font-bold text-rose-700 text-xs uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-triangle-exclamation"></i> Khoản phạt chưa thanh toán ({{ $unpaidFines->count() }})
                    </h4>
                    <ul class="space-y-1.5 text-sm text-rose-600">
                        @foreach($unpaidFines as $fine)
                            <li class="flex justify-between border-b border-rose-100 pb-1">
                                <span>Phiếu mượn #{{ $fine->borrow_id }}: {{ $fine->fine_name }}</span>
                                <span class="font-bold">{{ number_format($fine->fine_amount, 0, ',', '.') }} đ</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Lịch sử mượn sách gần đây -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-clock-rotate-left text-teal-600"></i> Phiếu mượn sách gần đây
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b text-slate-500 text-xs uppercase">
                                <th class="pb-2.5">Mã phiếu</th>
                                <th class="pb-2.5">Ngày mượn</th>
                                <th class="pb-2.5">Hạn trả</th>
                                <th class="pb-2.5 text-right">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($borrowHistory as $bh)
                                <tr>
                                    <td class="py-3 font-semibold text-slate-800">#{{ $bh->borrow_id }}</td>
                                    <td class="py-3 text-slate-600">{{ $bh->borrow_datetime }}</td>
                                    <td class="py-3 text-slate-600">{{ $bh->due_date }}</td>
                                    <td class="py-3 text-right">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-teal-50 text-teal-700">
                                            {{ $bh->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-400 text-xs">Bạn chưa có lịch sử mượn sách nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sách đang đặt trước -->
            @if($reservations->count() > 0)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-calendar-check text-teal-600"></i> Sách đang đặt trước
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b text-slate-500 text-xs uppercase">
                                    <th class="pb-2.5">Tên sách</th>
                                    <th class="pb-2.5">Ngày đặt</th>
                                    <th class="pb-2.5">Hết hạn giữ</th>
                                    <th class="pb-2.5 text-right">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($reservations as $res)
                                    <tr>
                                        <td class="py-3 font-medium">
                                            <a href="{{ route('client.books.show', $res->slug) }}" class="text-teal-700 hover:underline">
                                                {{ $res->book_name }}
                                            </a>
                                        </td>
                                        <td class="py-3 text-slate-600">{{ $res->reservation_date }}</td>
                                        <td class="py-3 text-slate-600">{{ $res->expired_date }}</td>
                                        <td class="py-3 text-right">
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">
                                                {{ $res->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection