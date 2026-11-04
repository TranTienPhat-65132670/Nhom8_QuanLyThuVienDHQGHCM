@extends('layout.admin')

@section('title', 'Quản lý tin tức')

@section('content')
    <div class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Bài viết tin tức</h2>
                <p class="mt-1 text-sm text-slate-500">Quản lý tin tức và thông báo của thư viện.</p>
            </div>
            <a href="{{ route('admin.news.create') }}"
                class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition">
                <i class="fa-solid fa-plus mr-2"></i>Đăng bài mới
            </a>
        </div>

        @foreach (['success' => 'green', 'warning' => 'amber'] as $type => $color)
            @if (session($type))
                <div
                    class="rounded-xl border border-{{ $color }}-200 bg-{{ $color }}-50 p-4 text-sm text-{{ $color }}-800 shadow-xs">
                    {{ session($type) }}
                </div>
            @endif
        @endforeach

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            @forelse ($posts as $post)
                <article
                    class="flex flex-col gap-4 border-b border-slate-100 p-5 last:border-0 sm:flex-row items-start sm:items-center justify-between hover:bg-slate-50/50 transition">
                    <div class="min-w-0 flex-1">
                        <h3 class="text-base font-bold text-slate-900">{{ $post->title }}</h3>
                        <p class="mt-1 text-xs text-slate-500">
                            Người đăng: <span class="font-semibold text-slate-700">{{ $post->author_name }}</span> ·
                            {{ \Illuminate\Support\Carbon::parse($post->published_at)->format('d/m/Y H:i') }}
                        </p>
                        <p class="mt-2 line-clamp-2 text-xs text-slate-600 leading-relaxed">{{ $post->content }}</p>
                    </div>
                    <div class="flex shrink-0 items-center gap-2">
                        <a href="{{ route('news.show', $post->id) }}" target="_blank"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">Xem</a>
                        <a href="{{ route('admin.news.edit', $post->id) }}"
                            class="rounded-lg border border-blue-200 px-3 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-50 transition">Sửa</a>
                        <form action="{{ route('admin.news.destroy', $post->id) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-50 transition">Xóa</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="p-8 text-center text-sm text-slate-500">Chưa có bài viết nào.</p>
            @endforelse
        </div>

        <!-- PHÂN TRANG THỦ CÔNG TÙY CHỈNH BẰNG TAILWIND -->
        @if ($posts->hasPages())
            <div
                class="flex flex-col sm:flex-row items-center justify-between px-6 py-4 bg-white border border-slate-200 rounded-2xl shadow-sm gap-4">
                <div class="text-xs text-slate-500">
                    Hiển thị từ <span class="font-bold text-slate-700">{{ $posts->firstItem() ?? 0 }}</span> đến <span
                        class="font-bold text-slate-700">{{ $posts->lastItem() ?? 0 }}</span> trong tổng số <span
                        class="font-bold text-slate-700">{{ $posts->total() }}</span> bài viết
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
                                class="px-3 py-1.5 text-xs font-bold text-white bg-blue-600 border border-blue-600 rounded-lg shadow-xs">
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
    </div>
@endsection
