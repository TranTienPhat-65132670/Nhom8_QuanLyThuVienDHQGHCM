@extends('layout.client')

@section('title', 'Tra Cứu Sách Thư Viện')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">
    <div class="bg-white p-6 rounded-2xl shadow-xs border border-slate-200">
        <form action="{{ route('client.books.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <input type="text" name="keyword" value="{{ request('keyword') }}" 
                       placeholder="Nhập tên sách, tác giả, ISBN..." 
                       class="w-full px-4 py-2.5 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
            </div>

            <div>
                <select name="category" class="w-full px-4 py-2.5 text-xs border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-hidden">
                    <option value="">-- Tất cả danh mục --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}" {{ request('category') == $cat->category_id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2.5 rounded-xl transition cursor-pointer">
                    <i class="fa-solid fa-magnifying-glass mr-1"></i> Tìm kiếm
                </button>
                <a href="{{ route('client.books.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition flex items-center">
                    Xóa
                </a>
            </div>
        </form>
    </div>

    @if($books->isEmpty())
        <div class="text-center py-12 bg-white rounded-2xl border border-slate-200">
            <p class="text-slate-500 text-xs">Không tìm thấy cuốn sách nào phù hợp trong thư viện.</p>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($books as $book)
                @php
                    $defaultSvg = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='500' viewBox='0 0 400 500'><rect width='100%' height='100%' fill='%23f1f5f9'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-size='18' font-weight='bold' fill='%2394a3b8'>Chưa Có Ảnh Bìa</text></svg>";

                    $imgUrl = $defaultSvg;

                    if (!empty($book->book_image)) {
                        $cleanPath = ltrim($book->book_image, '/');

                        if (str_starts_with($cleanPath, 'http')) {
                            $imgUrl = $cleanPath;
                        } elseif (file_exists(public_path($cleanPath))) {
                            $imgUrl = asset($cleanPath);
                        } else {
                            $imgUrl = asset('storage/' . $cleanPath);
                        }
                    }
                @endphp
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="h-56 bg-slate-100 overflow-hidden relative">
                            <img src="{{ $imgUrl }}" 
                                 onerror="this.onerror=null; this.src='{{ $defaultSvg }}';" 
                                 alt="{{ $book->book_name }}" 
                                 class="w-full h-full object-cover">
                            
                            <span class="absolute top-3 right-3 px-2.5 py-1 text-[10px] font-bold rounded-full {{ $book->available_quantity > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                {{ $book->available_quantity > 0 ? 'Còn ' . $book->available_quantity . ' cuốn' : 'Hết sách' }}
                            </span>
                        </div>

                        <div class="p-4 space-y-2">
                            <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">
                                {{ $book->category->category_name ?? 'Khác' }}
                            </span>
                            <h3 class="font-bold text-slate-800 text-xs line-clamp-2 hover:text-blue-600">
                                <a href="{{ route('client.books.show', $book->slug ?? $book->book_id) }}">{{ $book->book_name }}</a>
                            </h3>
                            <p class="text-[11px] text-slate-500"><i class="fa-regular fa-user mr-1"></i>{{ $book->author }}</p>
                        </div>
                    </div>

                    <div class="p-4 pt-0">
                        <a href="{{ route('client.books.show', $book->slug ?? $book->book_id) }}" 
                           class="block text-center w-full py-2 bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 text-xs font-semibold rounded-xl transition">
                            Xem Chi Tiết
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $books->links('components.custom-pagination') }}
        </div>
    @endif
</div>
@endsection