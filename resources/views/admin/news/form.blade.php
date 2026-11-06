@extends('layout.admin')

@php($isEditing = isset($post))

@section('title', $isEditing ? 'Cập nhật tin tức' : 'Đăng tin tức')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">
        <div>
            <a href="{{ route('admin.news.index') }}" class="text-sm font-medium text-blue-700 hover:underline">
                <i class="fa-solid fa-arrow-left mr-1"></i>Quay lại danh sách
            </a>
            <h2 class="mt-3 text-2xl font-bold text-slate-900">{{ $isEditing ? 'Cập nhật bài viết' : 'Đăng bài viết mới' }}</h2>
        </div>

        @if (session('warning'))
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">{{ session('warning') }}</div>
        @endif

        <form action="{{ $isEditing ? route('admin.news.update', $post->id) : route('admin.news.store') }}"
            method="POST" class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            @if ($isEditing)
                @method('PUT')
            @endif

            <div>
                <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Tiêu đề</label>
                <input id="title" name="title" value="{{ old('title', $post->title ?? '') }}" required maxlength="255"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="content" class="mb-2 block text-sm font-semibold text-slate-700">Nội dung</label>
                <textarea id="content" name="content" rows="12" required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('content', $post->content ?? '') }}</textarea>
                @error('content')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.news.index') }}" class="rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-100">Hủy</a>
                <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                    {{ $isEditing ? 'Lưu thay đổi' : 'Đăng bài' }}
                </button>
            </div>
        </form>
    </div>
@endsection
