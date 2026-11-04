<?php

namespace App\Http\Controllers;

use App\Mail\NewsPostPublishedMail;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class NewsPostController extends Controller
{
    public function index()
    {
        $posts = $this->postsQuery()
            ->orderByDesc('post.created_at')
            ->paginate(10);

        return view('admin.news.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.news.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['required', 'image', 'max:5120'],
        ]);

        $author = DB::table('user')
            ->where('user_id', session('user_id'))
            ->first(['user_id']);

        abort_unless($author, 403, 'Không tìm thấy tài khoản người đăng.');

        $now = now();
        $imagePath = $request->file('image')->store('news', 'public');
        if ($imagePath === false) {
            throw new RuntimeException('Không thể lưu ảnh bài viết.');
        }

        $postId = DB::table('post')->insertGetId([
            'user_id' => $author->user_id,
            'title' => $validated['title'],
            'body' => $validated['content'],
            'image_path' => $imagePath,
            'status' => 1,
            'slug' => $this->uniqueSlug($validated['title']),
            'created_at' => $now,
            'updated_at' => $now,
        ], 'post_id');

        $post = $this->postsQuery()->where('post.post_id', $postId)->firstOrFail();
        $recipients = DB::table('user')
            ->where('role', 'member')
            ->whereNotNull('email')
            ->where('email', '<>', '')
            ->distinct()
            ->pluck('email');

        if (config('mail.default') === 'log') {
            return redirect()->route('admin.news.edit', $postId)
                ->with('warning', 'Bài viết đã được đăng nhưng email chưa được gửi vì MAIL_MAILER đang là log. Hãy cấu hình SMTP trong .env.');
        }

        $sentCount = 0;
        try {
            foreach ($recipients as $email) {
                Mail::to($email)->send(new NewsPostPublishedMail($post));
                $sentCount++;
            }
        } catch (Throwable $exception) {
            Log::error('Không thể gửi email thông báo bài viết.', [
                'post_id' => $postId,
                'sent_count' => $sentCount,
                'exception' => $exception,
            ]);

            return redirect()->route('admin.news.edit', $postId)
                ->with('warning', "Bài viết đã được đăng nhưng không gửi được email đến toàn bộ độc giả (đã gửi {$sentCount}/".count($recipients).'). Hãy kiểm tra cấu hình email.');
        }

        return redirect()->route('admin.news.index')
            ->with('success', "Đã đăng bài và gửi email đến {$sentCount} độc giả.");
    }

    public function edit(int $id)
    {
        $post = $this->postsQuery()->where('post.post_id', $id)->firstOrFail();

        return view('admin.news.form', compact('post'));
    }

    public function update(Request $request, int $id)
    {
        $post = DB::table('post')->where('post_id', $id)->first();
        abort_unless($post, 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $imagePath = $post->image_path;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
            if ($imagePath === false) {
                throw new RuntimeException('Không thể lưu ảnh bài viết.');
            }
        }

        DB::table('post')->where('post_id', $id)->update([
            'title' => $validated['title'],
            'body' => $validated['content'],
            'image_path' => $imagePath,
            'slug' => $this->uniqueSlug($validated['title'], $id),
            'updated_at' => now(),
        ]);

        if ($imagePath !== $post->image_path && $post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        return redirect()->route('admin.news.index')->with('success', 'Đã cập nhật bài viết.');
    }

    public function destroy(int $id)
    {
        $post = DB::table('post')->where('post_id', $id)->first();
        abort_unless($post, 404);

        DB::table('post')->where('post_id', $id)->delete();

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        return redirect()->route('admin.news.index')->with('success', 'Đã xóa bài viết.');
    }

    public function publicIndex()
    {
        $posts = $this->postsQuery()
            ->where('post.status', 1)
            ->orderByDesc('post.created_at')
            ->paginate(9);

        return view('news.index', compact('posts'));
    }

    public function show(int $id)
    {
        $post = $this->postsQuery()
            ->where('post.post_id', $id)
            ->where('post.status', 1)
            ->first();

        abort_unless($post, 404);

        return view('news.show', compact('post'));
    }

    private function postsQuery(): Builder
    {
        return DB::table('post')
            ->leftJoin('user', 'post.user_id', '=', 'user.user_id')
            ->select([
                'post.*',
                'post.post_id as id',
                'post.body as content',
                'post.created_at as published_at',
                'user.student_name as author_name',
            ]);
    }

    private function uniqueSlug(string $title, ?int $exceptPostId = null): string
    {
        $base = Str::limit(Str::slug($title), 90, '');
        $base = $base !== '' ? $base : 'tin-tuc';

        do {
            $slug = $base.'-'.Str::lower(Str::random(8));
            $query = DB::table('post')->where('slug', $slug);

            if ($exceptPostId !== null) {
                $query->where('post_id', '<>', $exceptPostId);
            }
        } while ($query->exists());

        return $slug;
    }
}
