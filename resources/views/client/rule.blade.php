@extends('layout.client')

@section('title', 'Nội Quy Thư Viện')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">

        <!-- Tiêu đề trang -->
        <div class="mb-6 border-b border-slate-200 pb-4">
            <h1 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-scale-balanced text-teal-600"></i> Nội Quy Thư Viện ĐHQG-HCM
            </h1>
            <p class="text-xs text-slate-500 mt-1">Quy định chung dành cho sinh viên, giảng viên và bạn đọc khi sử dụng thư
                viện.</p>
        </div>

        <!-- Hộp lưu ý nhanh -->
        <div class="bg-teal-50 border border-teal-200 rounded-xl p-4 mb-6 text-xs text-teal-900">
            <span class="font-bold">Lưu ý:</span> Bạn đọc bắt buộc phải xuất trình thẻ sinh viên (hoặc mã QR trên ứng dụng)
            khi ra vào thư viện và mượn tài liệu.
        </div>

        <!-- Nội dung các điều khoản (Thiết kế dạng danh sách đơn giản) -->
        <div class="space-y-6 text-xs text-slate-700 leading-relaxed">

            <!-- Mục 1 -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
                <h2 class="font-bold text-slate-900 text-sm mb-2 flex items-center gap-2">
                    <span
                        class="w-6 h-6 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center text-xs">1</span>
                    Quy định ra vào và xuất trình thẻ
                </h2>
                <ul class="list-disc pl-5 space-y-1.5 text-slate-600">
                    <li>Xuất trình thẻ sinh viên hoặc mã định danh độc giả khi vào cổng.</li>
                    <li>Tuyệt đối không cho người khác mượn thẻ hoặc sử dụng thẻ của người khác.</li>
                    <li>Gửi balo, túi xách và đồ dùng cá nhân đúng nơi quy định trước khi vào khu vực kho sách.</li>
                </ul>
            </div>

            <!-- Mục 2 -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
                <h2 class="font-bold text-slate-900 text-sm mb-2 flex items-center gap-2">
                    <span
                        class="w-6 h-6 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center text-xs">2</span>
                    Trật tự và văn hóa trong phòng đọc
                </h2>
                <ul class="list-disc pl-5 space-y-1.5 text-slate-600">
                    <li>Giữ trật tự chung, để điện thoại ở chế độ rung hoặc im lặng.</li>
                    <li>Không hút thuốc, không ăn uống hoặc mang đồ ăn có mùi vào khu vực đọc sách.</li>
                    <li>Giữ gìn không gian sạch sẽ, sắp xếp lại ghế và tài liệu tại chỗ sau khi đọc xong.</li>
                </ul>
            </div>

            <!-- Mục 3 -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
                <h2 class="font-bold text-slate-900 text-sm mb-2 flex items-center gap-2">
                    <span
                        class="w-6 h-6 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center text-xs">3</span>
                    Quy định mượn trả tài liệu
                </h2>
                <ul class="list-disc pl-5 space-y-1.5 text-slate-600">
                    <li>Sinh viên được mượn tối đa 05 quyển sách về nhà trong thời gian 14 ngày.</li>
                    <li>Tài liệu dạng tra cứu, luận văn, tạp chí chỉ được phục vụ đọc tại chỗ.</li>
                    <li>Thực hiện trả hoặc gia hạn sách đúng thời hạn để tránh bị phạt quá hạn.</li>
                </ul>
            </div>

            <!-- Mục 4 -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs">
                <h2 class="font-bold text-slate-900 text-sm mb-2 flex items-center gap-2">
                    <span
                        class="w-6 h-6 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center text-xs">4</span>
                    Bảo quản tài sản chung
                </h2>
                <ul class="list-disc pl-5 space-y-1.5 text-slate-600">
                    <li>Không làm rách, viết vẽ, bôi bẩn hoặc làm hư hại sách và tài sản của thư viện.</li>
                    <li>Trường hợp làm mất hoặc hư hỏng tài liệu phải bồi thường theo quy định hiện hành.</li>
                </ul>
            </div>

        </div>

        <!-- Nút quay lại trang chủ -->
        <div class="mt-8 text-center">
            <a href="{{ route('client_index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition">
                <i class="fa-solid fa-arrow-left"></i> Quay lại trang chủ
            </a>
        </div>

    </div>
@endsection
