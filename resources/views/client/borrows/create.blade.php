@extends('layout.client')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-file-lines text-rose-500"></i> Xác nhận thông tin phiếu mượn
            </h1>
            <p class="text-gray-500 text-sm mt-1">Kiểm tra danh sách sách, điền ngày hẹn trả và số lượng muốn mượn</p>
        </div>

        <form action="{{ route('client.borrow.store') }}" method="POST"
            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
            @csrf

            <!-- THÔNG TIN CHUNG (Chỉ còn Ngày hẹn trả và Ghi chú) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Ngày hẹn trả</label>
                    <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                        class="w-full text-sm border border-gray-300 rounded-lg p-2 bg-white focus:outline-none focus:border-rose-500"
                        required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Ghi chú phiếu mượn (`borrow_note`)</label>
                    <input type="text" name="borrow_note" placeholder="Nhập ghi chú cho thủ thư (nếu có)..."
                        class="w-full text-sm border border-gray-300 rounded-lg p-2 bg-white focus:outline-none focus:border-rose-500">
                </div>
            </div>

            <!-- DANH SÁCH SÁCH VÀ SỐ LƯỢNG -->
            <div class="overflow-x-auto mb-6">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 border-b border-gray-100 font-semibold">
                            <th class="py-3 px-4">Hình ảnh</th>
                            <th class="py-3 px-4">Tên sách</th>
                            <th class="py-3 px-4">Tác giả</th>
                            <th class="py-3 px-4">Kho còn</th>
                            <th class="py-3 px-4 text-center">Số lượng mượn</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($books as $book)
                            @php
                                $available = $book->available_quantity ?? 0;
                                $maxQty = min(3, $available);
                            @endphp
                            <tr>
                                <input type="hidden" name="book_ids[]" value="{{ $book->book_id }}">

                                <td class="py-3 px-4 w-16">
                                    <img src="{{ asset($book->book_image ?? 'images/default-book.png') }}"
                                        alt="{{ $book->book_name }}" class="w-10 h-14 object-cover rounded shadow-sm">
                                </td>
                                <td class="py-3 px-4 font-semibold text-gray-800">
                                    {{ $book->book_name }}
                                </td>
                                <td class="py-3 px-4 text-gray-600">
                                    {{ $book->author }}
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">
                                        {{ $available }} quyển
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <select name="quantities[{{ $book->book_id }}]"
                                        class="w-20 text-center text-sm border border-gray-300 rounded-lg py-1.5 px-2 bg-white focus:outline-none focus:border-rose-500 font-semibold">
                                        @for ($i = 1; $i <= $maxQty; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Nút hành động -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <a href="{{ route('client.books.favorites') }}"
                    class="px-4 py-2 bg-gray-100 text-gray-600 font-medium text-sm rounded-lg hover:bg-gray-200 transition">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-rose-600 text-white font-semibold rounded-lg hover:bg-rose-700 transition shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-check"></i> Xác nhận tạo phiếu mượn
                </button>
            </div>
        </form>
    </div>
@endsection
