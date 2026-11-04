@extends('layout.client')

@section('title', 'Tin tức thư viện')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8">
            <p class="text-sm font-bold uppercase tracking-widest text-teal-700">Cập nhật từ thư viện</p>
            <h1 class="mt-2 text-3xl font-black text-slate-900">Tin tức & thông báo</h1>
        </div>

        <form method="GET" action="{{ route('news.index') }}"
            class="mb-8 flex flex-wrap items-end gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div>
                <label for="date_from" class="mb-1 block text-sm font-semibold text-slate-700">Từ ngày</label>
                <input id="date_from" name="date_from" type="date" value="{{ request('date_from') }}"
                    class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
            </div>
            <div>
                <label for="date_to" class="mb-1 block text-sm font-semibold text-slate-700">Đến ngày</label>
                <input id="date_to" name="date_to" type="date" value="{{ request('date_to') }}"
                    class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-100">
            </div>
            <button type="submit"
                class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800 transition">
                <i class="fa-solid fa-filter mr-1"></i>Lọc tin
            </button>
            @if (request()->filled('date_from') || request()->filled('date_to'))
                <a href="{{ route('news.index') }}"
                    class="px-2 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900">
                    Xóa bộ lọc
                </a>
            @endif
        </form>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <article
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm flex flex-col justify-between">
                    <div class="p-5">
                        <p class="text-xs font-medium text-slate-500">
                            {{ \Illuminate\Support\Carbon::parse($post->published_at)->format('d/m/Y') }}
                            · {{ $post->author_name }}
                        </p>
                        <h2 class="mt-2 text-xl font-bold text-slate-900">{{ $post->title }}</h2>
                        <p class="mt-3 line-clamp-3 whitespace-pre-line text-sm leading-6 text-slate-600">
                            {{ $post->content }}</p>
                    </div>
                    <div class="p-5 pt-0">
                        <a href="{{ route('news.show', $post->id) }}"
                            class="inline-flex items-center gap-2 text-sm font-bold text-teal-700 hover:text-teal-900">
                            Đọc tiếp <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
            @empty
                <p class="col-span-full rounded-2xl bg-white p-8 text-center text-slate-500">Hiện chưa có tin tức mới.</p>
            @endforelse
        </div>

        <!-- PHÂN TRANG THỦ CÔNG TÙY CHỈNH BẰNG TAILWIND -->
        @if ($posts->hasPages())
            <div
                class="flex flex-col sm:flex-row items-center justify-between px-6 py-4 bg-white border border-slate-200 rounded-2xl shadow-sm mt-8 gap-4">
                <div class="text-xs text-slate-500">
                    Hiển thị từ <span class="font-bold text-slate-700">{{ $posts->firstItem() ?? 0 }}</span> đến <span
                        class="font-bold text-slate-700">{{ $posts->lastItem() ?? 0 }}</span> trong tổng số <span
                        class="font-bold text-slate-700">{{ $posts->total() }}</span> kết quả
                </div>

                <div class="flex items-center gap-1 flex-wrap">
                    {{-- Nút Trang Trước --}}
                    @if ($posts->onFirstPage())
                        <span
                            class="px-3 py-1.5 text-xs font-semibold text-slate-300 bg-white border border-slate-200 rounded-lg cursor-not-allowed">
                            <i class="fa-solid fa-chevron-left mr-1"></i> Trước
                        </span>
                    @else
                        <a href="{{ $posts->previousPageUrl() }}"
                            class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-100 transition">
                            <i class="fa-solid fa-chevron-left mr-1"></i> Trước
                        </a>
                    @endif

                    {{-- Các nút số trang --}}
                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if ($page == $posts->currentPage())
                            <span
                                class="px-3 py-1.5 text-xs font-bold text-white bg-teal-700 border border-teal-700 rounded-lg shadow-xs">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-100 transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Nút Trang Sau --}}
                    @if ($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}"
                            class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-100 transition">
                            Sau <i class="fa-solid fa-chevron-right ml-1"></i>
                        </a>
                    @else
                        <span
                            class="px-3 py-1.5 text-xs font-semibold text-slate-300 bg-white border border-slate-200 rounded-lg cursor-not-allowed">
                            Sau <i class="fa-solid fa-chevron-right ml-1"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </section>
@endsection
