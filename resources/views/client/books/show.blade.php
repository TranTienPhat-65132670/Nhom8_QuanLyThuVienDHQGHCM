@extends('layout.client')

@section('title', $book->book_name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 space-y-8">
    
    <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="flex flex-col items-center">
            <div class="w-full max-w-[240px] h-[340px] rounded-xl overflow-hidden shadow-xs border border-slate-100">
                @if($book->book_image)
                    <img src="{{ str_starts_with($book->book_image, 'book/') ? asset($book->book_image) : asset('storage/' . $book->book_image) }}" 
                         onerror="this.onerror=null; this.src='{{ asset('images/default-book.png') }}';"
                         alt="{{ $book->book_name }}" class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('images/default-book.png') }}" 
                         alt="{{ $book->book_name }}" class="w-full h-full object-cover">
                @endif
            </div>

            <div class="mt-4 text-center">
                @if($book->status == 0)
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-rose-100 text-rose-700 border border-rose-200">
                        <i class="fa-solid fa-ban mr-1"></i> Tạm ngưng phục vụ
                    </span>
                @elseif($book->available_quantity > 0)
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                        <i class="fa-solid fa-circle-check mr-1"></i> Sẵn sàng mượn ({{ $book->available_quantity }} cuốn)
                    </span>
                @else
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                        <i class="fa-solid fa-clock mr-1"></i> Tạm thời hết sách
                    </span>
                @endif
            </div>
        </div>

        <div class="md:col-span-2 space-y-5">
            <div>
                <span class="text-[11px] font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md">
                    {{ $book->category->category_name ?? 'Chưa phân loại' }}
                </span>
                <h1 class="text-xl font-bold text-slate-800 mt-2">{{ $book->book_name }}</h1>
                <p class="text-xs text-slate-500 mt-1">Tác giả: <strong class="text-slate-700">{{ $book->author }}</strong></p>
            </div>

            <div class="grid grid-cols-2 gap-4 p-4 bg-slate-50 rounded-xl text-xs">
                <div><span class="text-slate-500">Mã ISBN:</span> <strong class="text-slate-800 font-mono block mt-0.5">{{ $book->isbn }}</strong></div>
                <div><span class="text-slate-500">Ngôn ngữ:</span> <strong class="text-slate-800 block mt-0.5">{{ $book->language ?? 'Tiếng Việt' }}</strong></div>
                <div><span class="text-slate-500">Số trang:</span> <strong class="text-slate-800 block mt-0.5">{{ $book->page_count ? $book->page_count . ' trang' : 'Đang cập nhật' }}</strong></div>
                <div><span class="text-slate-500">Cơ sở thư viện:</span> <strong class="text-blue-600 font-bold block mt-0.5">{{ $book->location ?? 'Thư viện Trung tâm DHQG-HCM' }}</strong></div>
            </div>

            <div>
                <h3 class="text-xs font-bold text-slate-800 mb-1">Tóm Tắt Nội Dung</h3>
                <p class="text-xs text-slate-600 leading-relaxed bg-white p-3.5 rounded-xl border border-slate-200">
                    {{ $book->description ?? 'Chưa có nội dung tóm tắt cho cuốn sách này.' }}
                </p>
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                @if($book->status == 0)
                    <button disabled class="px-5 py-2.5 bg-slate-200 text-slate-400 text-xs font-bold rounded-xl cursor-not-allowed">
                        <i class="fa-solid fa-ban mr-1"></i> Sách Tạm Ngưng Phục Vụ
                    </button>
                @elseif($book->available_quantity > 0)
                    <button type="button" data-book-id="{{ $book->book_id }}" 
                            class="btn-borrow px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-bookmark"></i> Đặt Mượn Sách
                    </button>
                @else
                    <button disabled class="px-5 py-2.5 bg-slate-200 text-slate-400 text-xs font-bold rounded-xl cursor-not-allowed">
                        Hết Sách Trực Tiếp
                    </button>
                @endif

                <button type="button" data-book-id="{{ $book->book_id }}" 
                        class="btn-favorite px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold rounded-xl transition flex items-center gap-2 cursor-pointer">
                    <i class="fa-regular fa-heart"></i> Yêu Thích
                </button>
            </div>
        </div>
    </div>

    <!-- Danh Sách Sách Liên Quan -->
    @if(isset($relatedBooks) && $relatedBooks->isNotEmpty())
        <div class="space-y-4">
            <h2 class="text-sm font-bold text-slate-800">Sách Cùng Chuyên Ngành</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($relatedBooks as $related)
                    <a href="{{ route('client.books.show', $related->slug ?? $related->book_id) }}" class="bg-white p-3 rounded-xl border border-slate-200 hover:shadow-xs transition group">
                        <div class="h-36 bg-slate-100 rounded-lg overflow-hidden mb-2">
                            @if($related->book_image)
                                <img src="{{ str_starts_with($related->book_image, 'book/') ? asset($related->book_image) : asset('storage/' . $related->book_image) }}" 
                                     onerror="this.onerror=null; this.src='{{ asset('images/default-book.png') }}';"
                                     alt="{{ $related->book_name }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                            @else
                                <img src="{{ asset('images/default-book.png') }}" 
                                     alt="{{ $related->book_name }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                            @endif
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