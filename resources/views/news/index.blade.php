@extends('layout.client')

@section('title', 'Tin tức thư viện')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8">
            <p class="text-sm font-bold uppercase tracking-widest text-teal-700">Cập nhật từ thư viện</p>
            <h1 class="mt-2 text-3xl font-black text-slate-900">Tin tức & thông báo</h1>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    @if ($post->image_path)
                        <img src="{{ asset('storage/'.$post->image_path) }}" alt="{{ $post->title }}"
                            class="h-52 w-full object-cover">
                    @endif
                    <div class="p-5">
                        <p class="text-xs font-medium text-slate-500">
                            {{ \Illuminate\Support\Carbon::parse($post->published_at)->format('d/m/Y') }}
                            · {{ $post->author_name }}
                        </p>
                        <h2 class="mt-2 text-xl font-bold text-slate-900">{{ $post->title }}</h2>
                        <p class="mt-3 line-clamp-3 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $post->content }}</p>
                        <a href="{{ route('news.show', $post->id) }}"
                            class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-teal-700 hover:text-teal-900">
                            Đọc tiếp <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
            @empty
                <p class="col-span-full rounded-2xl bg-white p-8 text-center text-slate-500">Hiện chưa có tin tức mới.</p>
            @endforelse
        </div>

        <div class="mt-8">{{ $posts->links() }}</div>
    </section>
@endsection
