@extends('layout.admin')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-8">

        <!-- Nút quay lại & Tiêu đề -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <a href="{{ route('admin.borrows.index') }}"
                    class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition flex items-center gap-1.5 mb-2">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách phiếu mượn
                </a>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-file-invoice text-rose-600"></i> Chi tiết phiếu mượn: <span
                        class="text-rose-600">{{ $borrow->borrow_id }}</span>
                </h1>
            </div>

            <!-- Trạng thái phiếu mượn -->
            @php
                $badgeClass = 'bg-gray-100 text-gray-700';
                $statusLabel = $borrow->status;
                if ($borrow->status == 'pending') {
                    $badgeClass = 'bg-amber-100 text-amber-700';
                    $statusLabel = 'Chờ duyệt';
                } elseif ($borrow->status == 'borrowing') {
                    $badgeClass = 'bg-blue-100 text-blue-700';
                    $statusLabel = 'Đang mượn';
                } elseif ($borrow->status == 'returned') {
                    $badgeClass = 'bg-emerald-100 text-emerald-700';
                    $statusLabel = 'Đã trả';
                } elseif ($borrow->status == 'overdue') {
                    $badgeClass = 'bg-rose-100 text-rose-700';
                    $statusLabel = 'Quá hạn';
                } elseif ($borrow->status == 'rejected') {
                    $badgeClass = 'bg-gray-100 text-gray-700';
                    $statusLabel = 'Bị từ chối';
                }
            @endphp
            <span class="px-4 py-1.5 text-sm font-bold rounded-full {{ $badgeClass }}">
                {{ $statusLabel }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Cột thông tin chung (Bên trái) -->
            <div class="bg-white rounded-2xl shadow-xs border border-gray-100 p-6 space-y-4 md:col-span-1">
                <h2 class="text-base font-bold text-gray-800 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-rose-600"></i> Thông tin chung
                </h2>

                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase">Người mượn</p>
                    <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $borrow->user_name }}</p>
                    <p class="text-xs text-gray-500">{{ $borrow->user_email }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase">Ngày tạo phiếu</p>
                    <p class="text-sm font-medium text-gray-700 mt-0.5">
                        {{ date('d/m/Y H:i', strtotime($borrow->created_at)) }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase">Ngày hẹn trả</p>
                    <p class="text-sm font-bold text-rose-600 mt-0.5">{{ date('d/m/Y', strtotime($borrow->due_date)) }}</p>
                </div>

                @if ($borrow->return_date)
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase">Ngày trả thực tế</p>
                        <p class="text-sm font-medium text-emerald-600 mt-0.5">
                            {{ date('d/m/Y H:i', strtotime($borrow->return_date)) }}</p>
                    </div>
                @endif

                <!-- HIỂN THỊ NOTE CỦA PHIẾU MƯỢN -->
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase mb-1">Ghi chú từ người mượn</p>
                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 text-sm text-gray-600">
                        @if (!empty($borrow->borrow_note))
                            {{ $borrow->borrow_note }}
                        @else
                            <span class="text-gray-400 not-italic">Không có ghi chú nào.</span>
                        @endif
                    </div>
                </div>

                <!-- Form thao tác nhanh trạng thái ngay trong trang chi tiết -->
                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400 font-semibold uppercase mb-3">Thao tác đổi trạng thái</p>

                    @if ($borrow->status === 'pending')
                        <div class="flex gap-2">
                            <form action="{{ route('admin.borrows.updateStatus', $borrow->borrow_id) }}" method="POST"
                                class="flex-1">
                                @csrf
                                <input type="hidden" name="status" value="borrowing">
                                <button type="submit"
                                    class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-xs">
                                    Duyệt
                                </button>
                            </form>
                            <form action="{{ route('admin.borrows.updateStatus', $borrow->borrow_id) }}" method="POST"
                                class="flex-1">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit"
                                    class="w-full py-2 bg-rose-100 hover:bg-rose-200 text-rose-700 text-xs font-bold rounded-xl transition">
                                    Từ chối
                                </button>
                            </form>
                        </div>
                    @elseif($borrow->status === 'borrowing')
                        <form action="{{ route('admin.borrows.updateStatus', $borrow->borrow_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="returned">
                            <button type="submit"
                                class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition shadow-xs">
                                Xác nhận đã trả sách
                            </button>
                        </form>
                    @else
                        <p class="text-xs text-gray-500 italic text-center">Phiếu đã hoàn tất quy trình.</p>
                    @endif
                </div>
            </div>

            <!-- Cột danh sách sách trong phiếu (Bên phải) -->
            <div class="bg-white rounded-2xl shadow-xs border border-gray-100 p-6 md:col-span-2">
                <h2 class="text-base font-bold text-gray-800 border-b border-gray-100 pb-3 flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-books text-rose-600"></i> Danh sách sách đăng ký mượn
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr
                                class="bg-gray-50 text-gray-600 border-b border-gray-100 font-semibold text-xs uppercase tracking-wider">
                                <th class="py-3 px-3">Ảnh</th>
                                <th class="py-3 px-3">Tên sách & Tác giả</th>
                                <th class="py-3 px-3 text-center">Số lượng</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($details as $item)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-3 px-3">
                                        <img src="{{ asset($item->book_image) }}" alt="Book Image"
                                            class="w-12 h-16 object-cover rounded-lg shadow-xs border border-gray-200"
                                            onerror="this.onerror=null; this.src='{{ asset('images/default-book.png') }}';">
                                    </td>
                                    <td class="py-3 px-3">
                                        <p class="font-bold text-gray-800">{{ $item->book_name }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Tác giả:
                                            {{ $item->author ?? 'Đang cập nhật' }}</p>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <span class="px-2.5 py-1 bg-gray-100 font-bold text-gray-700 text-xs rounded-lg">
                                            {{ $item->quantity }} quyển
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
