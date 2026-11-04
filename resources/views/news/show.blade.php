@extends('layout.client')

@section('title', $post->title)

@section('content')
    <article class="mx-auto max-w-4xl px-4 py-12 sm:px-6">
        <a href="{{ route('news.index') }}" class="text-sm font-semibold text-teal-700 hover:underline">
            <i class="fa-solid fa-arrow-left mr-1"></i>Tất cả tin tức
        </a>
        <p class="mt-8 text-sm text-slate-500">
            {{ \Illuminate\Support\Carbon::parse($post->published_at)->format('d/m/Y H:i') }}
            · Người đăng: {{ $post->author_name }}
        </p>
        <h1 class="mt-3 text-3xl font-black leading-tight text-slate-900 sm:text-4xl">{{ $post->title }}</h1>
        @if ($post->image_path)
            <img src="{{ asset('storage/'.$post->image_path) }}" alt="{{ $post->title }}"
                class="mt-8 max-h-[32rem] w-full rounded-2xl object-cover">
        @endif
        <div class="mt-8 whitespace-pre-line text-base leading-8 text-slate-700">{{ $post->content }}</div>
    </article>
@endsection
