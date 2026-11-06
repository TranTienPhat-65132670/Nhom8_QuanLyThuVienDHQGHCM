@extends('layout.client')

@section('title', 'Sách Đã Đặt Trước Của Tôi')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8 space-y-6">
        <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div>
                <h1 class="text-lg font-bold text-slate-800">Danh Sách Sách Đặt Trước</h1>
                <p class="text-xs text-slate-500 mt-1">Quản lý và theo dõi các cuốn sách bạn đang chờ thư viện có sẵn.</p>
            </div>
            <span class="px-3 py-1 bg-amber-50 text-amber-700 font-bold text-xs rounded-full border border-amber-200">
                <i class="fa-regular fa-clock mr-1"></i> {{ $reservations->total() }} Đang Đặt
            </span>
        </div>

        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        @if ($reservations->isEmpty())
            <div class="text-center py-12 bg-white rounded-2xl border border-slate-200 space-y-3">
                <div
                    class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto text-xl">
                    <i class="fa-regular fa-bookmark"></i>
                </div>
                <p class="text-slate-600 font-medium text-xs">Bạn chưa đặt trước cuốn sách nào.</p>
                <a href="{{ route('client.books.index') }}"
                    class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition">
                    Tra Cứu Sách Ngay
                </a>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200">
                            <tr>
                                <th class="p-4">Sách</th>
                                <th class="p-4">Ngày Đặt</th>
                                <th class="p-4 text-center">Trạng Thái Kho</th>
                                <th class="p-4 text-right">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($reservations as $item)
                                @php
                                    $defaultSvg =
                                        "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='100' height='140'><rect width='100%' height='100%' fill='%23f1f5f9'/></svg>";
                                    $imgUrl = $defaultSvg;
                                    if (!empty($item->book_image)) {
                                        $cleanPath = ltrim($item->book_image, '/');
                                        if (str_starts_with($cleanPath, 'http')) {
                                            $imgUrl = $cleanPath;
                                        } elseif (file_exists(public_path($cleanPath))) {
                                            $imgUrl = asset($cleanPath);
                                        } else {
                                            $imgUrl = asset('books/' . $cleanPath);
                                        }
                                    }
                                @endphp
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $imgUrl }}"
                                                onerror="this.onerror=null; this.src='{{ $defaultSvg }}';"
                                                class="w-12 h-16 object-cover rounded-md border border-slate-200 shrink-0">
                                            <div>
                                                <a href="{{ route('client.books.show', $item->slug ?? $item->book_id) }}"
                                                    class="font-bold text-slate-800 hover:text-blue-600 line-clamp-1">
                                                    {{ $item->book_name }}
                                                </a>
                                                <p class="text-[11px] text-slate-500 mt-0.5"><i
                                                        class="fa-regular fa-user mr-1"></i>{{ $item->author }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item->reservation_date)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="p-4 text-center whitespace-nowrap">
                                        @if ($item->available_quantity > 0)
                                            <span
                                                class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[11px] font-bold rounded-full">
                                                <i class="fa-solid fa-circle-check mr-1"></i> Đã có sách (Còn
                                                {{ $item->available_quantity }})
                                            </span>
                                        @else
                                            <span
                                                class="px-2.5 py-1 bg-amber-100 text-amber-700 text-[11px] font-bold rounded-full">
                                                <i class="fa-solid fa-clock mr-1"></i> Đang chờ sách về
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right whitespace-nowrap space-x-2">
                                        @if ($item->available_quantity > 0)
                                            <form action="{{ route('client.borrow.quickCreate', $item->book_id) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-xs transition cursor-pointer">
                                                    <i class="fa-solid fa-bookmark mr-1"></i> Mượn Ngay
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('reservations.destroy', $item->reservation_id) }}"
                                            method="POST" class="inline-block"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn hủy đặt trước cuốn sách này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 font-semibold rounded-lg text-xs transition cursor-pointer">
                                                <i class="fa-solid fa-trash-can mr-1"></i> Hủy Đặt
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $reservations->links('components.custom-pagination') }}
            </div>
        @endif
    </div>
@endsection
