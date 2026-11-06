@extends('layout.client')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-list text-rose-500"></i> Quản lý phiếu mượn sách
                </h1>
                <p class="text-gray-500 text-sm mt-1">Theo dõi trạng thái các phiếu mượn của bạn</p>
            </div>
        </div>

        @php
            // Ánh xạ khóa tiếng Anh trong CSDL sang tên tiếng Việt và cấu hình màu sắc giao diện
            $tabs = [
                'pending' => [
                    'label' => 'Chờ duyệt',
                    'db_status' => 'pending',
                    'badge' => 'bg-amber-100 text-amber-700',
                ],
                'borrowing' => [
                    'label' => 'Đang mượn',
                    'db_status' => 'borrowing',
                    'badge' => 'bg-blue-100 text-blue-700',
                ],
                'returned' => [
                    'label' => 'Đã trả',
                    'db_status' => 'returned',
                    'badge' => 'bg-emerald-100 text-emerald-700',
                ],
                'overdue' => ['label' => 'Quá hạn', 'db_status' => 'overdue', 'badge' => 'bg-rose-100 text-rose-700'],
                'rejected' => [
                    'label' => 'Bị từ chối',
                    'db_status' => 'rejected',
                    'badge' => 'bg-gray-100 text-gray-700',
                ],
            ];
            $currentTab = request('tab', 'pending');
        @endphp

        <!-- THANH 5 TAB NAVIGATION -->
        <div class="flex overflow-x-auto gap-2 border-b border-gray-200 mb-6 pb-2">
            @foreach ($tabs as $key => $tab)
                @php
                    $count = $borrows->where('status', $tab['db_status'])->count();
                    $isActive = $currentTab === $key;
                @endphp
                <a href="{{ route('client.borrow.index', ['tab' => $key]) }}"
                    class="px-4 py-2 text-sm font-semibold rounded-lg whitespace-nowrap transition flex items-center gap-2 {{ $isActive ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                    <span>{{ $tab['label'] }}</span>
                    <span
                        class="px-2 py-0.5 text-xs rounded-full {{ $isActive ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600' }}">
                        {{ $count }}
                    </span>
                </a>
            @endforeach
        </div>

        <!-- NỘI DUNG HIỂN THỊ THEO TAB -->
        @php
            $activeDbStatus = $tabs[$currentTab]['db_status'] ?? 'pending';
            $filteredBorrows = $borrows->where('status', $activeDbStatus);
        @endphp

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            @if ($filteredBorrows->isEmpty())
                <div class="text-center py-16">
                    <i class="fa-regular fa-folder-open text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 font-medium">Không có phiếu mượn nào ở trạng thái
                        "{{ $tabs[$currentTab]['label'] }}".</p>
                </div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach ($filteredBorrows as $borrow)
                        @php
                            $itemDetails = $details[$borrow->borrow_id] ?? collect();
                            // Xác định hiển thị badge tiếng Việt dựa vào status trong CSDL
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
                        <div
                            class="p-6 hover:bg-gray-50/50 transition flex flex-col md:flex-row items-start md:items-center justify-between gap-4">

                            <div class="space-y-3 flex-1">
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-gray-800 text-base">{{ $borrow->borrow_id }}</span>
                                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $badgeClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 flex-wrap">
                                    @foreach ($itemDetails as $detail)
                                        <div
                                            class="flex items-center gap-2 bg-gray-50 px-2.5 py-1.5 rounded-lg border border-gray-100">
                                            <img src="{{ asset($detail->book_image ?? 'images/default-book.png') }}"
                                                alt="" class="w-7 h-9 object-cover rounded shadow-sm">
                                            <div class="text-xs">
                                                <p class="font-semibold text-gray-800 line-clamp-1 max-w-[180px]">
                                                    {{ $detail->book_name }}</p>
                                                <p class="text-gray-500">SL: {{ $detail->quantity }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="text-xs text-gray-500 flex flex-wrap gap-4">
                                    <span>Ngày mượn: <strong
                                            class="text-gray-700">{{ date('d/m/Y', strtotime($borrow->borrow_datetime)) }}</strong></span>
                                    <span>Hẹn trả: <strong
                                            class="text-gray-700">{{ date('d/m/Y', strtotime($borrow->due_date)) }}</strong></span>
                                    @if ($borrow->borrow_note)
                                        <span>Ghi chú: <strong
                                                class="text-gray-700">{{ $borrow->borrow_note }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <div class="w-full md:w-auto text-right">
                                <a href="{{ route('client.borrow.show', $borrow->borrow_id) }}"
                                    class="inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition">
                                    <i class="fa-solid fa-eye text-xs"></i> Xem chi tiết
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
