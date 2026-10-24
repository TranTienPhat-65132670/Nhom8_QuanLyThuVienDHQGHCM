@extends('layout.client')

@section('title', $book->book_name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 space-y-8">
    
    <!-- Khối Thông Tin Sách Chi Tiết -->
    <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Ảnh Bìa -->
        <div class="flex flex-col items-center">
            <div class="w-full max-w-[240px] h-[340px] rounded-xl overflow-hidden shadow-xs border border-slate-100">
                <img src="{{ $book->book_image ? asset('storage/' . $book->book_image) : asset('images/default-book.png') }}" 
                     alt="{{ $book->book_name }}" class="w-full h-full object-cover">
            </div>
            <div class="mt-4 text-center">
                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $book->available_quantity > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                    {{ $book->available_quantity > 0 ? 'Sẵn sàng mượn (' . $book->available_quantity . ' cuốn)' : 'Tạm thời hết sách' }}
                </span>
            </div>
        </div>

        <!-- Thông tin chi tiết & Vị trí kệ -->
        <div class="md:col-span-2 space-y-5">
            <div>
                <span class="text-[11px] font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md">
                    {{ $book->category->category_name ?? 'Chưa phân loại' }}
                </span>
                <h1 class="text-xl font-bold text-slate-800 mt-2">{{ $book->book_name }}</h1>
                <p class="text-xs text-slate-500 mt-1">Tác giả: <strong class="text-slate-700">{{ $book->author }}</strong></p>
            </div>

            <!-- Bảng thông tin kỹ thuật & vị trí -->
            <div class="grid grid-cols-2 gap-4 p-4 bg-slate-50 rounded-xl text-xs">
                <div><span class="text-slate-500">Mã ISBN:</span> <strong class="text-slate-800 block mt-0.5">{{ $book->isbn }}</strong></div>
                <div><span class="text-slate-500">Ngôn ngữ:</span> <strong class="text-slate-800 block mt-0.5">{{ $book->language }}</strong></div>
                <div><span class="text-slate-500">Số trang:</span> <strong class="text-slate-800 block mt-0.5">{{ $book->page_count ?? 'Đang cập nhật' }}</strong></div>
                <div><span class="text-slate-500">Vị trí kệ sách:</span> <strong class="text-blue-600 font-bold block mt-0.5">{{ $book->location ?? 'Chưa xếp kệ' }}</strong></div>
            </div>

            <!-- Tóm tắt nội dung -->
            <div>
                <h3 class="text-xs font-bold text-slate-800 mb-1">Tóm Tắt Nội Dung</h3>
                <p class="text-xs text-slate-600 leading-relaxed bg-white p-3.5 rounded-xl border border-slate-200">
                    {{ $book->description ?? 'Chưa có nội dung tóm tắt cho cuốn sách này.' }}
                </p>
            </div>

            <!-- Thao tác -->
            <div class="flex gap-3 pt-2">
                @if($book->available_quantity > 0)
                    <button type="button" data-book-id="{{ $book->book_id }}" 
                            class="btn-borrow px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-2">
                        <i class="fa-solid fa-bookmark"></i> Đặt Mượn Sách
                    </button>
                @else
                    <button disabled class="px-5 py-2.5 bg-slate-200 text-slate-400 text-xs font-bold rounded-xl cursor-not-allowed">
                        Hết Sách Trực Tiếp
                    </button>
                @endif

                <button type="button" data-book-id="{{ $book->book_id }}" 
                        class="btn-favorite px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold rounded-xl transition flex items-center gap-2">
                    <i class="fa-regular fa-heart"></i> Yêu Thích
                </button>
            </div>
        </div>
    </div>

    <!-- Danh Sách Sách Liên Quan -->
    @if($relatedBooks->isNotEmpty())
        <div class="space-y-4">
            <h2 class="text-sm font-bold text-slate-800">Sách Cùng Chuyên Ngành</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($relatedBooks as $related)
                    <a href="{{ route('client.books.show', $related->slug) }}" class="bg-white p-3 rounded-xl border border-slate-200 hover:shadow-xs transition group">
                        <div class="h-36 bg-slate-100 rounded-lg overflow-hidden mb-2">
                            <img src="{{ $related->book_image ? asset('storage/' . $related->book_image) : asset('images/default-book.png') }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition">
                        </div>
                        <h4 class="text-xs font-bold text-slate-800 line-clamp-1 group-hover:text-blue-600">{{ $related->book_name }}</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $related->author }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection