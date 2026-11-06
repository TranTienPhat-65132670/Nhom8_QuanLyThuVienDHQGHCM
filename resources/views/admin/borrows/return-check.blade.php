@extends('layout.admin')

@section('title', 'Kiểm tra trả sách & Phạt')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <div>
            <a href="{{ route('admin.borrows.index') }}"
                class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition flex items-center gap-1.5 mb-2">
                <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách phiếu mượn
            </a>
            <h1 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-clipboard-check text-rose-600"></i> Kiểm tra tình trạng trả sách (Phiếu
                #{{ $borrow->borrow_id }})
            </h1>
            <p class="text-xs text-slate-500 mt-1">Mỗi dòng dưới đây tương ứng với 1 cuốn sách độc lập. Vui lòng kiểm tra
                tình trạng từng quyển và chọn mức phạt tương ứng nếu có vi phạm.</p>
        </div>

        <form action="{{ route('admin.borrows.processReturn', $borrow->borrow_id) }}" method="POST" id="returnForm">
            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-4 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
                    <span class="font-bold text-xs uppercase text-slate-700">Chi tiết từng cuốn sách cần kiểm tra</span>
                    <span class="text-xs font-semibold text-slate-500">Tổng số lượng kiểm tra: {{ $details->count() }}
                        quyển</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead
                            class="bg-slate-100/70 text-slate-700 uppercase font-bold text-[11px] border-b border-slate-200">
                            <tr>
                                <th class="py-3.5 px-4 w-12 text-center">STT</th>
                                <th class="py-3.5 px-4">Tên sách & Bản số</th>
                                <th class="py-3.5 px-4 w-80">Mức độ / Lỗi vi phạm (cho riêng quyển này)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($details as $index => $item)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-4 text-center font-bold text-slate-400">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-14 bg-slate-100 rounded-lg overflow-hidden shrink-0 flex items-center justify-center border border-slate-200">
                                                @if (!empty($item->book_image))
                                                    <img src="{{ asset($item->book_image) }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <i class="fa-solid fa-book text-slate-400"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-800 text-sm leading-snug">
                                                    {{ $item->book_name }}</h4>
                                                <p class="text-[11px] text-teal-600 font-semibold mt-0.5">
                                                    Quyển số {{ $item->item_index }} (Mã sách: #{{ $item->book_id }})
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <!-- Truyền key kết hợp book_id và item_index để phân biệt rõ từng cuốn -->
                                        <select name="fines[{{ $item->book_id }}_{{ $item->item_index }}]"
                                            class="fine-select w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:border-rose-500 bg-white">
                                            <option value="">-- Bình thường (Không bị phạt) --</option>
                                            @foreach ($finesList as $fine)
                                                <option value="{{ $fine->fine_id }}">
                                                    {{ $fine->fine_name }} ({{ number_format($fine->fine_amount) }} VNĐ)
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cụm nút bấm chuyển đổi tự động -->
            <div class="flex items-center justify-end gap-3 mt-6">
                <a href="{{ route('admin.borrows.index') }}"
                    class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition">
                    Hủy bỏ
                </a>

                <!-- Nút hiển thị khi KHÔNG có lỗi phạt nào -->
                <button type="submit" id="btnNoFine"
                    class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl transition shadow-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> Xác nhận trả sách (Không bị phạt)
                </button>

                <!-- Nút hiển thị khi CHỌN ÍT NHẤT 1 lỗi phạt -->
                <button type="submit" id="btnWithFine"
                    class="hidden px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs rounded-xl transition shadow-xs flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation"></i> Xác nhận trả sách & Lập phiếu phạt
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selects = document.querySelectorAll('.fine-select');
            const btnNoFine = document.getElementById('btnNoFine');
            const btnWithFine = document.getElementById('btnWithFine');

            function evaluateFines() {
                let hasFine = false;
                selects.forEach(select => {
                    if (select.value !== "") {
                        hasFine = true;
                    }
                });

                if (hasFine) {
                    btnNoFine.classList.add('hidden');
                    btnWithFine.classList.remove('hidden');
                } else {
                    btnNoFine.classList.remove('hidden');
                    btnWithFine.classList.add('hidden');
                }
            }

            selects.forEach(select => {
                select.addEventListener('change', evaluateFines);
            });
        });
    </script>
@endsection
