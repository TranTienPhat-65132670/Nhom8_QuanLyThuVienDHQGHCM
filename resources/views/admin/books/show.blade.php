@extends('layout.admin')

@section('title', 'Chi Tiết Sách - #' . $book->book_id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Chi Tiết Sách</h1>
            <p class="text-xs text-slate-500 mt-1">Mã định danh hệ thống: #{{ $book->book_id }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('books.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Quay lại kho
            </a>
            <a href="{{ route('books.edit', $book->book_id) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                <i class="fa-solid fa-pen-to-square mr-1"></i> Chỉnh sửa
            </a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-3 flex flex-col items-center">
            <div class="w-48 h-64 rounded-xl overflow-hidden shadow-xs border border-slate-200 bg-slate-100 relative">
                @if($book->book_image)
                    <img src="{{ str_starts_with($book->book_image, 'book/') ? asset($book->book_image) : asset('storage/' . $book->book_image) }}" 
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/300x400?text=Anh+Loi';"
                         alt="{{ $book->book_name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 gap-2">
                        <i class="fa-solid fa-book text-4xl"></i>
                        <span class="text-xs">Chưa có bìa</span>
                    </div>
                @endif
            </div>

            <div>
                @if($book->status == 1 && $book->available_quantity > 0)
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold">
                        <i class="fa-solid fa-circle-check mr-1"></i> Đang phục vụ (Còn sách)
                    </span>
                @elseif($book->status == 1 && $book->available_quantity <= 0)
                    <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold">
                        <i class="fa-solid fa-circle-exclamation mr-1"></i> Đang phục vụ (Tạm hết)
                    </span>
                @else
                    <span class="px-3 py-1 bg-rose-100 text-rose-800 rounded-full text-xs font-bold">
                        <i class="fa-solid fa-ban mr-1"></i> Tạm ngưng phục vụ
                    </span>
                @endif
            </div>
        </div>

        <div class="md:col-span-2 space-y-4 text-xs">
            <div>
                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-bold rounded-lg">
                    {{ $book->category->category_name ?? 'Chưa phân loại' }}
                </span>
                <h2 class="text-lg font-black text-slate-900 mt-2">{{ $book->book_name }}</h2>
                <p class="text-slate-500 mt-1">Tác giả: <strong class="text-slate-700">{{ $book->author }}</strong></p>
            </div>

            <div class="grid grid-cols-2 gap-3 p-4 bg-slate-50 rounded-xl border border-slate-100">
                <div><span class="text-slate-400 block">Mã ISBN:</span> <strong class="text-slate-800 font-mono">{{ $book->isbn }}</strong></div>
                <div><span class="text-slate-400 block">Ngôn ngữ:</span> <strong class="text-slate-800">{{ $book->language ?? 'Tiếng Việt' }}</strong></div>
                <div><span class="text-slate-400 block">Số trang:</span> <strong class="text-slate-800">{{ $book->page_count ? $book->page_count . ' trang' : 'Chưa rõ' }}</strong></div>
                <div><span class="text-slate-400 block">Khu vực thư viện:</span> <strong class="text-blue-600">{{ $book->location }}</strong></div>
                <div><span class="text-slate-400 block">Tổng số lượng trong kho:</span> <strong class="text-slate-800">{{ $book->total_quantity }} cuốn</strong></div>
                <div><span class="text-slate-400 block">Số lượng sẵn sàng cho mượn:</span> <strong class="text-emerald-600 font-bold">{{ $book->available_quantity }} cuốn</strong></div>
                <div><span class="text-slate-400 block">Số lượng đang cho mượn:</span> <strong class="text-amber-600 font-bold">{{ $book->total_quantity - $book->available_quantity }} cuốn</strong></div>
                <div><span class="text-slate-400 block">Đường dẫn tĩnh (Slug):</span> <code class="text-slate-600 font-mono">{{ $book->slug }}</code></div>
            </div>

            <div>
                <span class="font-bold text-slate-700 block mb-1">Tóm tắt nội dung:</span>
                <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $book->description ?: 'Chưa có tóm tắt nội dung cho cuốn sách này.' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection