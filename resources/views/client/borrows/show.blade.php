@extends('layout.client')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        @php
            // Ánh xạ trạng thái tiếng Anh sang tiếng Việt và cấu hình màu badge
            $badgeClass = 'bg-gray-100 text-gray-700';
            $statusLabel = 'Không xác định';

            switch ($borrow->status) {
                case 'pending':
                    $badgeClass = 'bg-amber-100 text-amber-700';
                    $statusLabel = 'Chờ duyệt';
                    break;
                case 'borrowing':
                    $badgeClass = 'bg-blue-100 text-blue-700';
                    $statusLabel = 'Đang mượn';
                    break;
                case 'returned':
                    $badgeClass = 'bg-emerald-100 text-emerald-700';
                    $statusLabel = 'Đã trả';
                    break;
                case 'overdue':
                    $badgeClass = 'bg-rose-100 text-rose-700';
                    $statusLabel = 'Quá hạn';
                    break;
                case 'rejected':
                    $badgeClass = 'bg-gray-100 text-gray-700';
                    $statusLabel = 'Bị từ chối';
                    break;
            }
        @endphp

        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-file-invoice text-rose-500"></i> Chi tiết phiếu mượn: {{ $borrow->borrow_id }}
                </h1>
                <p class="text-gray-500 text-sm mt-1">Trạng thái:
                    <span class="font-semibold px-2.5 py-0.5 rounded-full text-xs {{ $badgeClass }}">
                        {{ $statusLabel }}
                    </span>
                </p>
            </div>

            <a href="{{ route('client.borrow.index') }}"
                class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200 transition">
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <!-- Thông tin chung -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="text-gray-500 block">Ngày mượn:</span>
                    <span
                        class="font-semibold text-gray-800">{{ date('d/m/Y', strtotime($borrow->borrow_datetime)) }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block">Ngày hẹn trả:</span>
                    <span class="font-semibold text-gray-800">{{ date('d/m/Y', strtotime($borrow->due_date)) }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block">Ghi chú:</span>
                    <span class="font-semibold text-gray-800">{{ $borrow->borrow_note ?? 'Không có' }}</span>
                </div>
            </div>
        </div>

        <!-- Bảng danh sách sách -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="p-4 bg-gray-50 border-b border-gray-100 font-semibold text-sm text-gray-700">
                Danh sách sách đăng ký mượn
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-100 font-medium text-xs bg-gray-50/50">
                            <th class="py-3 px-4">Hình ảnh</th>
                            <th class="py-3 px-4">Tên sách</th>
                            <th class="py-3 px-4">Tác giả</th>
                            <th class="py-3 px-4 text-center">Số lượng mượn</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($details as $item)
                            <tr>
                                <td class="py-3 px-4 w-16">
                                    <img src="{{ asset($item->book_image ?? 'images/default-book.png') }}"
                                        alt="{{ $item->book_name }}" class="w-10 h-14 object-cover rounded shadow-sm">
                                </td>
                                <td class="py-3 px-4 font-semibold text-gray-800">
                                    {{ $item->book_name }}
                                </td>
                                <td class="py-3 px-4 text-gray-600">
                                    {{ $item->author }}
                                </td>
                                <td class="py-3 px-4 text-center font-semibold text-gray-800">
                                    {{ $item->quantity }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Nút hủy phiếu (Chỉ hiện khi trạng thái CSDL là 'pending' - Chờ duyệt) -->
        @if ($borrow->status === 'pending')
            <div class="flex justify-end">
                <form action="{{ route('client.borrow.cancel', $borrow->borrow_id) }}" method="POST"
                    onsubmit="return confirm('Bạn có chắc chắn muốn hủy phiếu mượn này không?');">
                    @csrf
                    <button type="submit"
                        class="px-5 py-2.5 bg-rose-50 text-rose-600 hover:bg-rose-100 font-semibold text-sm rounded-lg transition flex items-center gap-2 border border-rose-200">
                        <i class="fa-solid fa-ban"></i> Hủy phiếu mượn này
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection
