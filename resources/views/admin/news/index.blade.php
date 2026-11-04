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
                class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                <i class="fa-solid fa-plus mr-2"></i>Đăng bài mới
            </a>
        </div>

        @foreach (['success' => 'green', 'warning' => 'amber'] as $type => $color)
            @if (session($type))
                <div class="rounded-xl border border-{{ $color }}-200 bg-{{ $color }}-50 p-4 text-sm text-{{ $color }}-800">
                    {{ session($type) }}
                </div>
            @endif
        @endforeach

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            @forelse ($posts as $post)
                <article class="flex flex-col gap-4 border-b border-slate-100 p-5 last:border-0 sm:flex-row">
                    @if ($post->image_path)
                        <img src="{{ asset('storage/'.$post->image_path) }}" alt="{{ $post->title }}"
                            class="h-28 w-full rounded-xl object-cover sm:w-40">
                    @endif
                    <div class="min-w-0 flex-1">
                        <h3 class="text-lg font-bold text-slate-900">{{ $post->title }}</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Người đăng: {{ $post->author_name }} · {{ \Illuminate\Support\Carbon::parse($post->published_at)->format('d/m/Y H:i') }}
                        </p>
                        <p class="mt-3 line-clamp-2 whitespace-pre-line text-sm text-slate-600">{{ $post->content }}</p>
                    </div>
                    <div class="flex shrink-0 items-center gap-2">
                        <a href="{{ route('news.show', $post->id) }}" target="_blank"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">Xem</a>
                        <a href="{{ route('admin.news.edit', $post->id) }}"
                            class="rounded-lg border border-blue-200 px-3 py-2 text-sm text-blue-700 hover:bg-blue-50">Sửa</a>
                        <form action="{{ route('admin.news.destroy', $post->id) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="rounded-lg border border-red-200 px-3 py-2 text-sm text-red-700 hover:bg-red-50">Xóa</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="p-8 text-center text-sm text-slate-500">Chưa có bài viết nào.</p>
            @endforelse
        </div>

        {{ $posts->links() }}
    </div>
@endsection
