<h1>{{ $post->title }}</h1>

@if ($post->image_path)
    <p><img src="{{ asset('storage/'.$post->image_path) }}" alt="{{ $post->title }}" style="max-width: 100%; height: auto;"></p>
@endif

<p>{!! nl2br(e($post->content)) !!}</p>
<p>Người đăng: {{ $post->author_name }}</p>
<p><a href="{{ $newsUrl }}">Đọc tin trên website Thư viện</a></p>
