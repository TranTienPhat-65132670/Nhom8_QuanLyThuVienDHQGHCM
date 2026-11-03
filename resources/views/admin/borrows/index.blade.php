@extends('layout.admin')

@section('title', 'Quản Lý Mượn / Trả')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">

        <!-- Tiêu đề & Ô Tìm Kiếm -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-rose-600"></i> Quản lý yêu cầu mượn sách
                </h1>
                <p class="text-gray-500 text-sm mt-1">Duyệt và theo dõi tiến độ phiếu mượn của độc giả</p>
            </div>

            <!-- Form tìm kiếm -->
            <form action="{{ route('admin.borrows.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-auto">
                <input type="hidden" name="status" value="{{ $status }}">
                <div class="relative w-full md:w-72">
                    <input type="text" name="search" value="{{ $keyword }}"
                        placeholder="Nhập mã phiếu, tên, email..."
                        class="w-full text-sm pl-9 pr-4 py-2 border border-gray-300 rounded-xl bg-white focus:outline-none focus:border-rose-500 shadow-xs">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-xs"></i>
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl transition shadow-xs">
                    Tìm
                </button>
                @if (!empty($keyword))
                    <a href="{{ route('admin.borrows.index', ['status' => $status]) }}"
                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-semibold rounded-xl transition"
                        title="Xóa tìm kiếm">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </form>
        </div>

        @php
            $statuses = [
                'pending' => 'Chờ duyệt',
                'borrowing' => 'Đang mượn',
                'returned' => 'Đã trả',
                'overdue' => 'Quá hạn',
                'rejected' => 'Bị từ chối',
            ];
        @endphp

        <!-- Thanh 5 Tab lọc trạng thái có hiển thị số lượng -->
        <div class="flex gap-2 border-b border-gray-200 mb-6 pb-2 overflow-x-auto">
            @foreach ($statuses as $key => $label)
                @php
                    $count = $statusCounts[$key] ?? 0;
                    $isActive = $status === $key;
                @endphp
                <a href="{{ route('admin.borrows.index', ['status' => $key, 'search' => $keyword]) }}"
                    class="px-4 py-2 text-sm font-semibold rounded-xl whitespace-nowrap transition flex items-center gap-2 {{ $isActive ? 'bg-rose-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                    <span>{{ $label }}</span>
                    <span
                        class="px-2 py-0.5 text-xs rounded-full {{ $isActive ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600' }}">
                        {{ $count }}
                    </span>
                </a>
            @endforeach
        </div>

        <!-- Bảng danh sách yêu cầu mượn -->
        <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
            @if ($borrows->isEmpty())
                <div class="text-center py-16">
                    <i class="fa-regular fa-folder-open text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 font-medium">Không tìm thấy yêu cầu mượn nào.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr
                                class="bg-gray-50 text-gray-600 border-b border-gray-100 font-semibold text-xs uppercase tracking-wider">
                                <th class="py-3.5 px-4">Mã phiếu</th>
                                <th class="py-3.5 px-4">Người mượn</th>
                                <th class="py-3.5 px-4">Sách đăng ký</th>
                                <th class="py-3.5 px-4">Ngày hẹn trả</th>
                                <th class="py-3.5 px-4 text-center">Trạng thái</th>
                                <th class="py-3.5 px-4 text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($borrows as $borrow)
                                @php
                                    $itemDetails = $details[$borrow->borrow_id] ?? collect();
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
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-4 font-bold text-gray-800">
                                        {{ $borrow->borrow_id }}
                                    </td>
                                    <td class="py-4 px-4">
                                        <p class="font-semibold text-gray-800">{{ $borrow->user_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $borrow->user_email }}</p>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="space-y-1">
                                            @foreach ($itemDetails as $detail)
                                                <div class="text-xs text-gray-700 flex items-center gap-1.5">
                                                    <span class="font-semibold">• {{ $detail->book_name }}</span>
                                                    <span class="text-gray-400">(SL: {{ $detail->quantity }})</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-gray-600">
                                        {{ date('d/m/Y', strtotime($borrow->due_date)) }}
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $badgeClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.borrows.show', $borrow->borrow_id) }}"
                                                class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg transition"
                                                title="Xem chi tiết">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            @if ($borrow->status === 'pending')
                                                <form
                                                    action="{{ route('admin.borrows.updateStatus', $borrow->borrow_id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="borrowing">
                                                    <button type="submit"
                                                        class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition shadow-xs">
                                                        Duyệt
                                                    </button>
                                                </form>
                                                <form
                                                    action="{{ route('admin.borrows.updateStatus', $borrow->borrow_id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit"
                                                        class="px-3 py-1.5 bg-rose-100 hover:bg-rose-200 text-rose-700 text-xs font-semibold rounded-lg transition">
                                                        Từ chối
                                                    </button>
                                                </form>
                                            @elseif($borrow->status === 'borrowing')
                                                <form
                                                    action="{{ route('admin.borrows.updateStatus', $borrow->borrow_id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="returned">
                                                    <button type="submit"
                                                        class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition shadow-xs">
                                                        Nhận trả sách
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- THANH PHÂN TRANG TỰ LÀM (CUSTOM PAGINATION UI) -->
                @if ($pagination['total_pages'] > 1)
                    <div
                        class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-xs text-gray-500">
                            Hiển thị trang <span class="font-bold text-gray-800">{{ $pagination['current_page'] }}</span> /
                            <span class="font-bold text-gray-800">{{ $pagination['total_pages'] }}</span> (Tổng <span
                                class="font-bold text-gray-800">{{ $pagination['total'] }}</span> phiếu)
                        </p>

                        <div class="flex items-center gap-1">
                            <!-- Nút Trang trước -->
                            @if ($pagination['has_prev'])
                                <a href="{{ route('admin.borrows.index', ['page' => $pagination['prev_page'], 'status' => $status, 'search' => $keyword]) }}"
                                    class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-100 transition">
                                    <i class="fa-solid fa-chevron-left"></i> Trang trước
                                </a>
                            @else
                                <span
                                    class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-gray-100 text-gray-400 border border-gray-100 cursor-not-allowed">
                                    <i class="fa-solid fa-chevron-left"></i> Trang trước
                                </span>
                            @endif

                            <!-- Số trang -->
                            @for ($i = 1; $i <= $pagination['total_pages']; $i++)
                                @if ($i == 1 || $i == $pagination['total_pages'] || abs($i - $pagination['current_page']) <= 1)
                                    <a href="{{ route('admin.borrows.index', ['page' => $i, 'status' => $status, 'search' => $keyword]) }}"
                                        class="px-3 py-1.5 text-xs font-semibold rounded-lg transition {{ $i == $pagination['current_page'] ? 'bg-rose-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                                        {{ $i }}
                                    </a>
                                @elseif(
                                    ($i == 2 && $pagination['current_page'] > 3) ||
                                        ($i == $pagination['total_pages'] - 1 && $pagination['current_page'] < $pagination['total_pages'] - 2))
                                    <span class="px-2 py-1.5 text-xs text-gray-400">...</span>
                                @endif
                            @endfor

                            <!-- Nút Trang sau -->
                            @if ($pagination['has_next'])
                                <a href="{{ route('admin.borrows.index', ['page' => $pagination['next_page'], 'status' => $status, 'search' => $keyword]) }}"
                                    class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-100 transition">
                                    Trang sau <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            @else
                                <span
                                    class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-gray-100 text-gray-400 border border-gray-100 cursor-not-allowed">
                                    Trang sau <i class="fa-solid fa-chevron-right"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
