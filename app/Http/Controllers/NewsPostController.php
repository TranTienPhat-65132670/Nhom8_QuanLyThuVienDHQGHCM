<?php

namespace App\Http\Controllers;

use App\Mail\NewsPostPublishedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Throwable;

class NewsPostController extends Controller
{
    public function index()
    {
        $posts = DB::table('news_posts')
            ->orderByDesc('published_at')
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
            ->first(['user_id', 'student_code']);

        if (!$author) {
            abort(403, 'Không tìm thấy tài khoản người đăng.');
        }

        $imagePath = $request->file('image')?->store('news', 'public');
        $publishedAt = now();

        $postId = DB::table('news_posts')->insertGetId([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image_path' => $imagePath,
            'author_id' => (string) $author->user_id,
            'author_name' => 'MSSV '.$author->student_code,
            'published_at' => $publishedAt,
            'created_at' => $publishedAt,
            'updated_at' => $publishedAt,
        ]);

        $post = DB::table('news_posts')->where('id', $postId)->first();
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
        $post = DB::table('news_posts')->find($id);

        abort_unless($post, 404);

        return view('admin.news.form', compact('post'));
    }

    public function update(Request $request, int $id)
    {
        $post = DB::table('news_posts')->find($id);
        abort_unless($post, 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $imagePath = $post->image_path;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        }

        DB::table('news_posts')->where('id', $id)->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image_path' => $imagePath,
            'updated_at' => now(),
        ]);

        if ($imagePath !== $post->image_path && $post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        return redirect()->route('admin.news.index')->with('success', 'Đã cập nhật bài viết.');
    }

    public function destroy(int $id)
    {
        $post = DB::table('news_posts')->find($id);
        abort_unless($post, 404);

        DB::table('news_posts')->where('id', $id)->delete();

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        return redirect()->route('admin.news.index')->with('success', 'Đã xóa bài viết.');
    }

    public function publicIndex()
    {
        $posts = DB::table('news_posts')
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('news.index', compact('posts'));
    }

    public function show(int $id)
    {
        $post = DB::table('news_posts')
            ->where('id', $id)
            ->whereNotNull('published_at')
            ->first();

        abort_unless($post, 404);

        return view('news.show', compact('post'));
    }
}
