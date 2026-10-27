@extends('layout.admin')

@section('title', 'Quản Lý Học Liệu & Sách')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Kho Sách Thư Viện</h1>
            <p class="text-xs text-slate-500 mt-1">Quản lý toàn bộ đầu sách trong hệ thống</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('client.books.index') }}" target="_blank" 
               class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl flex items-center gap-1.5 transition border border-slate-200">
                <i class="fa-solid fa-arrow-up-right-from-square text-slate-500"></i> Xem Trang Độc Giả
            </a>
            <a href="{{ route('books.create') }}" 
               class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl flex items-center gap-2 shadow-sm transition">
                <i class="fa-solid fa-plus"></i> Thêm Sách Mới
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('books.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm theo tên sách, tác giả, ISBN..."
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>
            <div>
                <select name="category_id" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
                    <option value="">-- Tất cả danh mục --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}" {{ request('category_id') == $cat->category_id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold rounded-xl flex items-center gap-1.5 transition">
                    <i class="fa-solid fa-magnifying-glass"></i> Tìm Kiếm
                </button>
                <a href="{{ route('books.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl flex items-center gap-1.5 transition">
                    Làm Mới
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                    <th class="p-4 w-20 text-center">Bìa</th>
                    <th class="p-4">Tên Sách</th>
                    <th class="p-4 text-center w-36">Số Lượng</th>
                    <th class="p-4 text-center w-36">Trạng Thái</th>
                    <th class="p-4 text-right w-36">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                @forelse($books as $book)
                    <tr class="hover:bg-slate-50/80 transition">
                        <!-- 1. Cột Ảnh Bìa -->
                        <td class="p-4 text-center">
                            @if($book->book_image)
                                <img src="{{ str_starts_with($book->book_image, 'book/') ? asset($book->book_image) : asset('storage/' . $book->book_image) }}" 
                                     alt="Bìa" class="w-12 h-16 object-cover rounded shadow-xs mx-auto">
                            @else
                                <div class="w-12 h-16 bg-slate-100 rounded flex items-center justify-center text-slate-400 mx-auto">
                                    <i class="fa-solid fa-book"></i>
                                </div>
                            @endif
                        </td>

                        <!-- 2. Cột Tên Sách -->
                        <td class="p-4">
                            <span class="font-bold text-slate-900 text-sm block">{{ $book->book_name }}</span>
                            <span class="text-slate-400 text-[11px] block mt-0.5">Mã ISBN: {{ $book->isbn }}</span>
                        </td>

                        <!-- 3. Cột Số Lượng -->
                        <td class="p-4 text-center">
                            <span class="font-bold text-emerald-600">{{ $book->available_quantity }}</span> / 
                            <span class="text-slate-500">{{ $book->total_quantity }}</span>
                        </td>

                        <!-- 4. Cột Trạng Thái -->
                        <td class="p-4 text-center">
                            @if($book->available_quantity > 0)
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full text-[10px] font-bold">Còn Sách</span>
                            @else
                                <span class="px-2.5 py-1 bg-rose-100 text-rose-800 rounded-full text-[10px] font-bold">Hết Sách</span>
                            @endif
                        </td>

                        <!-- 5. Cột Thao Tác -->
                        <td class="p-4 text-right space-x-1">
                            <a href="{{ route('client.books.show', $book->slug) }}" target="_blank" 
                               class="p-2 hover:bg-blue-50 text-blue-600 rounded-lg inline-block transition" title="Xem trên trang Độc giả">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                            <a href="{{ route('books.edit', $book->book_id) }}" 
                               class="p-2 hover:bg-amber-50 text-amber-600 rounded-lg inline-block transition" title="Sửa">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('books.destroy', $book->book_id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa cuốn sách này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 hover:bg-rose-50 text-rose-600 rounded-lg transition" title="Xóa">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">Không tìm thấy cuốn sách nào trong kho.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-slate-100">
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection