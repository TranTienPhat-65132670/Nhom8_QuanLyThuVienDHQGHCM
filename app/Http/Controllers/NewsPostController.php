<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsPostController extends Controller
{
    public function index()
    {
        $posts = $this->postsQuery()
            ->orderByDesc('post.created_at')
            ->paginate(6);

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
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'content.required' => 'Vui lòng nhập nội dung bài viết.',
        ]);

        $author = DB::table('user')
            ->where('user_id', session('user_id'))
            ->first(['user_id']);

        abort_unless($author, 403, 'Không tìm thấy tài khoản người đăng.');

        $postId = DB::table('post')->insertGetId([
            'user_id' => $author->user_id,
            'title' => $validated['title'],
            'body' => $validated['content'],
            'status' => 1,
            'slug' => $this->uniqueSlug($validated['title']),
            'created_at' => now(),
            'updated_at' => now(),
        ], 'post_id');

        return redirect()->route('admin.news.index')
            ->with('success', 'Đã đăng bài viết.');
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
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'content.required' => 'Vui lòng nhập nội dung bài viết.',
        ]);

        DB::table('post')->where('post_id', $id)->update([
            'title' => $validated['title'],
            'body' => $validated['content'],
            'slug' => $this->uniqueSlug($validated['title'], $id),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Đã cập nhật bài viết.');
    }

    public function destroy(int $id)
    {
        $post = DB::table('post')->where('post_id', $id)->first();
        abort_unless($post, 404);

        DB::table('post')->where('post_id', $id)->delete();

        return redirect()->route('admin.news.index')->with('success', 'Đã xóa bài viết.');
    }

    public function publicIndex(Request $request)
    {
        $dateToRules = ['nullable', 'date'];

        if ($request->filled('date_from')) {
            $dateToRules[] = 'after_or_equal:date_from';
        }

        $filters = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => $dateToRules,
        ], [
            'date_from.date' => 'Ngày bắt đầu không hợp lệ.',
            'date_to.date' => 'Ngày kết thúc không hợp lệ.',
            'date_to.after_or_equal' => 'Ngày kết thúc phải từ ngày bắt đầu trở đi.',
        ]);

        $query = $this->postsQuery()->where('post.status', 1);

        if (! empty($filters['date_from'])) {
            $query->whereDate('post.created_at', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->whereDate('post.created_at', '<=', $filters['date_to']);
        }

        $posts = $query
            ->orderByDesc('post.created_at')
            ->paginate(6)
            ->withQueryString();

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
            $slug = $base . '-' . Str::lower(Str::random(8));
            $query = DB::table('post')->where('slug', $slug);

            if ($exceptPostId !== null) {
                $query->where('post_id', '<>', $exceptPostId);
            }
        } while ($query->exists());

        return $slug;
    }
}
